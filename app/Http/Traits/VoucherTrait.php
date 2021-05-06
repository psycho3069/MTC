<?php


namespace App\Http\Traits;

use App\MISVoucher_I;
use App\Process;
use App\TransactionHead;
use App\Voucher;
use App\VoucherGroup;
use App\VoucherUpdateHistory;
use Illuminate\Support\Facades\DB;

trait VoucherTrait
{
    /*
     * Create only one Voucher group from MIS for a day
     * Create Voucher in AIS
     * Update Current balance
     * Create voucher in MIS
     * */

    public function createMISVoucher($ledgerHead, $softwareDate, $amount)
    {
        $voucherType = $ledgerHead->misHead->voucherType;

        $voucherGroup = $this->createMISVoucherGroupToAIS($softwareDate, $voucherType);
        $voucher = $this->createMISVoucherToAIS($ledgerHead, $voucherGroup, $amount);

        $misVoucher = new MISVoucher_I();
        $misVoucher->ledger_head_id = $ledgerHead->id;
        $misVoucher->mis_head_id = $ledgerHead->mis_head_id;
        $misVoucher->voucher_id = $voucher->id;
        $misVoucher->date_id = $voucher->date_id;
        $misVoucher->save();

        return $misVoucher;
    }


    public function createMISVoucherToAIS($ledgerHead, $voucherGroup, $amount)
    {
        $voucherData['credit_head_id'] = $ledgerHead->credit_head_id;
        $voucherData['debit_head_id'] = $ledgerHead->debit_head_id;
        $voucherData['amount'] = $amount;
        $voucherData['note'] = "";
        $voucher = $this->createAISVoucher($voucherGroup, $voucherData);
        $this->saveCurrentBalance($voucher, $voucher->amount, 0);

        return $voucher;
    }



    public function createMISVoucherGroupToAIS($softwareDate, $voucherType)
    {
        $voucherGroup = VoucherGroup::where('date_id', $softwareDate->id)
            ->where('type_id', $voucherType->id)
            ->first();

        if ($voucherGroup == null){
            $voucherGroup = new VoucherGroup();
            $voucherGroup->date_id = $softwareDate->id;
            $voucherGroup->user_id = auth()->id();
            $voucherGroup->type_id = $voucherType->id;
            $voucherGroup->note = $voucherType->name . " voucher";
            $voucherGroup->code = $this->generateVoucherCode($softwareDate, $voucherType);
            $voucherGroup->save();
        }

        return $voucherGroup;
    }



    public function updateVoucherAmount($voucher, $newAmount, $oldAmount, $note = null)
    {
        $this->saveCurrentBalance($voucher, $newAmount, $oldAmount);
        $this->createVoucherHistory($voucher, $newAmount, $oldAmount);

        $voucher->amount = $newAmount;
        $voucher->note = $note;
        $voucher->save();

        return $voucher;
    }


    public function deleteAISVoucher($voucher, $deleteNote)
    {
        $this->updateCurrentBalance($voucher,  0, $voucher->amount);
        $this->createVoucherHistory($voucher,0, $voucher->amount, $deleteNote);
        $voucher->delete();
    }



    public function createAISVoucherGroup($softwareDate, $voucherType, $note = null)
    {
        $voucherGroup = new VoucherGroup();
        $voucherGroup->date_id = $softwareDate->id;
        $voucherGroup->user_id = auth()->id();
        $voucherGroup->type_id = $voucherType->id;
        $voucherGroup->note = $note ?: "{$voucherType->name} voucher";
        $voucherGroup->code = $this->generateVoucherCode($softwareDate, $voucherType);
        $voucherGroup->save();

        return $voucherGroup;
    }


    public function createAISVoucher($voucherGroup, $voucherData)
    {
        $voucher = new Voucher();
        $voucher->v_group_id = $voucherGroup->id;
        $voucher->date_id = $voucherGroup->date_id;
        $voucher->credit_head_id = $voucherData['credit_head_id'];
        $voucher->debit_head_id = $voucherData['debit_head_id'];
        $voucher->amount = $voucherData['amount'];
        $voucher->note = $voucherData['note'];
        $voucher->save();

        return $voucher;
    }

    /*
     * Insert Current balance for a specific date
     * Update current balance if already exist
     * */
    public function saveCurrentBalance($voucher, $newAmount, $oldAmount)
    {
        $creditAccount = Process::firstOrNew([
                'thead_id' => $voucher->credit_head_id,
                'date_id' => $voucher->date_id
            ]);
        $creditAccount->credit += $newAmount - $oldAmount;
        $creditAccount->save();

        $debitAccount = Process::firstOrNew([
                'thead_id' => $voucher->debit_head_id,
                'date_id' => $voucher->date_id
            ]);
        $debitAccount->debit += $newAmount - $oldAmount;
        $debitAccount->save();
    }


    /*
     * Update current balance when updating a voucher
     * */
    public function updateCurrentBalance($voucher, $newAmount, $oldAmount)
    {
        $creditAccount = Process::where('thead_id', $voucher->credit_head_id)
            ->where('date_id', $voucher->date_id)
            ->first();
        $creditAccount->credit += $newAmount - $oldAmount;
        $creditAccount->save();


        $debitAccount = Process::where('thead_id', $voucher->debit_head_id)
            ->where('date_id', $voucher->date_id)
            ->first();
        $debitAccount->debit += $newAmount - $oldAmount;
        $debitAccount->save();
    }


    public function createVoucherHistory($voucher, $newAmount, $oldAmount, $deleteNote = null)
    {
        if ($oldAmount != $newAmount){
            $softwareDate = $this->getSoftwareDate();
            $voucherHistory = new VoucherUpdateHistory();
            $voucherHistory->voucher_id = $voucher->id;
            $voucherHistory->date_id = $softwareDate->id;
            $voucherHistory->user_id = auth()->id();
            $voucherHistory->amount = $voucher->amount;
            $voucherHistory->note = $deleteNote ?: $voucher->note;
            $voucherHistory->save();
        }
    }


    /*
     * Generate voucher code
     * */
    public function generateVoucherCode($softwareDate, $voucherType)
    {
        /*
         * Get the last voucher of the day to increase voucher number
         * */
        $voucherNumber = 1;
        $lastVoucher = DB::table('voucher_groups')
            ->where('date_id', '=', $softwareDate->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastVoucher){
            $voucherNumber = substr($lastVoucher->code,-2);
            $voucherNumber = $voucherNumber + 1;
        }

        if ($voucherNumber < 10){
            $voucherNumber = "0{$voucherNumber}";
        }

        $dateCode = date('-y-m-', strtotime($softwareDate->date));
        $code = $voucherType->short_name . $dateCode . $voucherNumber;
        return strtoupper($code);
    }



    /*
     * Return Debit and Credit account for voucher by type wise
     * */
    public function getVoucherAccounts($type_id)
    {
        $code = [1751,1802,1803,1804,1805,1806,1807,1808,1872,1873,1874,1875,1876,1880,1899];

        if ( $type_id == 1 ){
            $account['credit'] = TransactionHead::whereIn( 'code', $code )->get();
            $account['debit'] = TransactionHead::whereNotIn( 'code', $code )->get();
        }elseif ( $type_id == 2 ){
            $account['credit'] = TransactionHead::whereNotIn( 'code', $code )->get();
            $account['debit'] = TransactionHead::whereIn( 'code', $code )->get();
        }elseif ( $type_id == 3){
            $account['credit'] = TransactionHead::whereNotIn( 'code', $code )->get();
            $account['debit'] = $account['credit'];
        }elseif ( $type_id == 4){
            $account['credit'] = TransactionHead::whereIn( 'code', $code )->get();
            $account['debit'] = $account['credit'];
        }

        return $account;
    }
}
