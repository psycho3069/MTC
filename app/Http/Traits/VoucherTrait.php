<?php


namespace App\Http\Traits;

use App\Process;
use App\TransactionHead;
use App\VoucherGroup;
use App\VoucherUpdateHistory;
use Illuminate\Support\Facades\DB;

trait VoucherTrait
{


    /*
     * Insert Current balance for a specific date
     * Update current balance if already exist
     * */
    public function saveCurrentBalance($voucher, $softwareDate)
    {
        $creditAccount = Process::firstOrNew(
            [
                'thead_id' => $voucher->credit_head_id,
                'date_id' => $softwareDate->id
            ]
        );

        $creditAccount->credit += $voucher->amount;
        $creditAccount->save();

        $debitAccount = Process::firstOrNew(
            [
                'thead_id' => $voucher->debit_head_id,
                'date_id' => $softwareDate->id
            ]
        );

        $debitAccount->debit += $voucher->amount;
        $debitAccount->save();
    }


    /*
     * Update current balance when updating a voucher
     * */

    public function updateCurrentBalance($voucher, $oldAmount, $newAmount)
    {
        $creditAccount = Process::where('thead_id', $voucher->credit_head_id)
            ->where('date_id', $voucher->date_id)
            ->firstOrFail();
        $creditAccount->credit += $newAmount - $oldAmount;
        $creditAccount->save();


        $debitAccount = Process::where('thead_id', $voucher->debit_head_id)
            ->where('date_id', $voucher->date_id)
            ->firstOrFail();
        $debitAccount->debit += $newAmount - $oldAmount;
        $debitAccount->save();
    }


    public function createVoucherHistory($voucher, $oldAmount, $newAmount, $isDeleting = false)
    {
        if ($oldAmount != $newAmount){
            $softwareDate = $this->getSoftwareDate();
            $deleteNote = 'Deleted Voucher - [id: '.$voucher->id. ']';

            $voucherHistory = new VoucherUpdateHistory();
            $voucherHistory->voucher_id = $voucher->id;
            $voucherHistory->date_id = $softwareDate->id;
            $voucherHistory->user_id = auth()->id();
            $voucherHistory->amount = $voucher->amount;
            $voucherHistory->note = $isDeleting ? $deleteNote : $voucher->note;
            $voucherHistory->save();
        }
    }


    /*
     * Generate voucher code
     * */
    public function generateVoucherCode($softwareDate, $voucherType)
    {
        $voucherNumber = 0;
        $dateSlice = date('-y-m-', strtotime($softwareDate->date));

        /*
         * Get the last voucher of the day to increase voucher number
         * */
        $lastVoucher = DB::table('voucher_groups')
            ->where('date_id', '=', $softwareDate->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastVoucher)
            $voucherNumber = substr($lastVoucher->code,-2);

        $voucherNumber = $voucherNumber + 1;
        if ($voucherNumber < 10)
            $voucherNumber = "0{$voucherNumber}";

        $code = $voucherType->short_name . $dateSlice . $voucherNumber;
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
