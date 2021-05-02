<?php


namespace App\Http\Traits;


use App\MISHead;
use App\MISHeadChild_I;
use App\MISLedgerHead;
use App\PurchaseGroup;
use App\Unit;

trait StockTrait
{


    public function createLedgerHead($request)
    {
        $input = $request->all();
        $softwareStartDate = $this->getSoftwareStartDate();
        $headI = MISHeadChild_I::findOrFail($request->cat_id);
        $code = MISLedgerHead::withTrashed()
            ->orderBy('id', 'desc')
            ->value('code');

        $input['code'] = $code + 100;
        $input['credit_head_id'] = $headI->credit_head_id;
        $input['debit_head_id'] = $headI->debit_head_id;
        $ledgerHead = $headI->ledger()->create($input);
        $ledgerHead->currentStock()->create(['date_id' => $softwareStartDate->id]);

        return $ledgerHead;
    }


    public function createLedgerHeadCategory($request)
    {
        $misHead = MISHead::findOrFail($request->mis_head_id);

        $categoryI = new MISHeadChild_I();
        $categoryI->name = $request->name;
        $categoryI->mis_head_id = $request->mis_head_id;
        $categoryI->description = $request->description;
        $categoryI->credit_head_id = $misHead->credit_head_id;
        $categoryI->debit_head_id = $misHead->debit_head_id;
        $categoryI->save();

        return $categoryI;
    }



    /*
     * Delete a category or a ledgerHead
     * */
    public function deleteLedgerHead($request, $id)
    {
        $softwareStartDate = $this->getSoftwareStartDate();
        $i = 0; $operation = false;

        if ( !$request->type){
            $mis_head = MISHeadChild_I::find($id);
            $cat = '<b>'.$mis_head->name.'</b>';

            if ( $mis_head->ledger->isNotEmpty() ){
                foreach ( $mis_head->ledger as $item) {
                    if ( $item->purchases->isEmpty() && $item->deliveries->isEmpty()){
                        $item->currentStock()->where('date_id', $softwareStartDate->id)->delete();
                        $item->delete();
                        $i++;
                    }
                }
            }

            $operation = count($mis_head->ledger) == $i ? true : false;

            if ( $operation)
                $mis_head->delete();

            $operation ? session()->flash('success', $cat. ' has been removed from category list')
                : session()->flash('warning', 'Not all Items in category '.$cat.' is Empty');

            return 200;
        }

        if ( $request->type){
            $item = MISLedgerHead::find($id);
            if( $item->purchases->isEmpty() && $item->deliveries->isEmpty() && count($item->currentStock) == 1 ){
                $item->currentStock()->where('date_id', $softwareStartDate->id)->delete();
                $item->delete();
                $operation = true;
            }

            $operation ? session()->flash('success', '<b>'.$item->name.'</b> has been deleted successfully')
                : session()->flash('failed', '<b> Operation Unsuccessful. '.$item->name.'</b> Has Dependencies.');

            return 200;
        }
    }



    public function storeMISPurchase($request, $softwareDate)
    {
        $input = collect($request->input);

        $data = $request->except('input', '_token');
        $data['date_id'] = $softwareDate->id;
        $data['user_id'] = auth()->id();

        $p_group = PurchaseGroup::create($data);

        foreach ($input as $item) {
            $ledgerHead = MISLedgerHead::find($item['stock_id']);
            $unit = $this->getUnit($item['unit_id'], $ledgerHead->unit_type_id);
            $misVoucher = $this->createMISVoucher($ledgerHead, $softwareDate, $item['amount']);

            $item['mis_voucher_id'] = $misVoucher->id;
            $item['date_id'] = $softwareDate->id;
            $item['quantity_dr'] = $this->getUnitQuantity($item['quantity_dr'], $unit);

            $cr_stock = $ledgerHead->currentStock()->create($item);
            $item['current_stock_id'] = $cr_stock->id;
            $p_group->purchases()->create($item);
        }


        return $p_group;

    }


    public function updateMISPurchase($request, $purchaseGroup)
    {
        $input = $request->input;
        $note = 'Updated From Grocery Purchase- [id: '.$purchaseGroup->id .']';
        foreach ($input as $key => $item) {
            $purchase = $purchaseGroup->purchases->find($key);
            $purchase->update($item);
            $unit = $this->getUnit($item['unit_id']);
            $purchase->currentStock->update([ 'quantity_dr' => $this->getUnitQuantity($item['quantity_dr'], $unit)]);

            $aisVoucher = $purchase->misVoucher->voucher;
            if ($aisVoucher->amount != $item['amount']){
                $this->updateVoucherAmount($aisVoucher, $item['amount'], $purchase->amount, $note);
            }
        }

        return $purchaseGroup;
    }


    public function deleteMISPurchase($purchaseGroup)
    {
        foreach ($purchaseGroup->purchases as $purchase) {
            $aisVoucher = $purchase->misVoucher->voucher;

            $note = 'Deleted From Grocery Purchase - [id: '.$purchase->id. ']';
            $this->deleteAISVoucher($aisVoucher, $note);
            $purchase->misVoucher->delete();
            $purchase->currentStock->delete();
            $purchase->delete();
        }
        return $purchaseGroup->delete();
    }



    public function getUnitQuantity($quantity, $unit)
    {
        return $quantity / $unit->multiply_by;
    }



}
