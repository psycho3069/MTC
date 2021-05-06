<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Date;
use App\Http\Traits\SoftwareConfigurationTrait;
use App\TransactionHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoftwareConfigurationController extends Controller
{
    use SoftwareConfigurationTrait;



    public function hotelConfiguration()
    {
        $vatSettings['food'] = $this->getVatFood();
        $vatSettings['service'] = $this->getVatService();
        $vatSettings['others'] = $this->getVatOthers();

        $transactionHeads = TransactionHead::where('id', '!=', TransactionHead::$accounts['cash_in_hand'])
            ->select('id', 'name', 'code')
            ->whereNotIn('id', [353])
            ->get();

        $creditAccounts['room'] = $this->getRoomBookingAccount();
        $creditAccounts['venue'] = $this->getVenueBookingAccount();
        $creditAccounts['food_sale'] = $this->getHotelFoodSaleAccount();
        $creditAccounts['food_sale_personal'] = $this->getPersonalFoodSaleAccount();

        $debitAccounts['discount'] = $this->getDiscountAccount();



        $labels['food'] = 'Food';
        $labels['service'] = 'Service Charge';
        $labels['others'] = 'Others';
        $labels['room'] = 'Room';
        $labels['venue'] = 'Venue';
        $labels['food_sale'] = 'Restaurant';
        $labels['food_sale_personal'] = 'Restaurant (personal)';
        $labels['discount'] = 'Discount';


        return view('admin.software.hotel-configuration', compact(
            'vatSettings', 'creditAccounts', 'debitAccounts',
            'transactionHeads',  'labels'
        ));

    }




    public function updateHotelConfiguration(Request $request)
    {
        $cashInHand = TransactionHead::where('id', TransactionHead::$accounts['cash_in_hand'])->first();

        foreach ($request->settings as $key => $value) {
            $setting = Configuration::where('name', $key)->first();
            $setting->value = $value;
            $setting->save();
        }


        $creditAccounts['room'] = $this->getRoomBookingAccount();
        $creditAccounts['venue'] = $this->getVenueBookingAccount();
        $creditAccounts['food_sale'] = $this->getHotelFoodSaleAccount();
        $creditAccounts['food_sale_personal'] = $this->getPersonalFoodSaleAccount();

        $debitAccounts['discount'] = $this->getDiscountAccount();


        foreach ($creditAccounts as $key => $ledgerHead) {
            $ledgerHead->credit_head_id = $request->credit_accounts[$key];
            $ledgerHead->debit_head_id = $cashInHand->id;
            $ledgerHead->save();

            $ledgerHead->misHead->credit_head_id = $ledgerHead->credit_head_id;
            $ledgerHead->misHead->debit_head_id = $cashInHand->id;
            $ledgerHead->misHead->save();

         }


        foreach ($debitAccounts as $key => $ledgerHead) {
            $ledgerHead->debit_head_id = $request->debit_accounts[$key];
            $ledgerHead->credit_head_id = $cashInHand->id;
            $ledgerHead->save();

            $ledgerHead->misHead->debit_head_id = $ledgerHead->debit_head_id;
            $ledgerHead->misHead->credit_head_id = $cashInHand->id;
            $ledgerHead->misHead->save();
         }


        return redirect()->back()->with('update', '<b>Configuration updated successfully</b>');

    }





    /*
 * Software date view
 * */
    public function softwareDate()
    {
        $configuration = Configuration::find(1);
        $configuration->date = $configuration->date ?: date('Y-m-d');
        return view('admin.software.software-date', compact('configuration'));
    }





    public function updateSoftwareDate(Request $request)
    {
        $request->validate([
            'software_date' => 'required|date_format:Y-m-d'
        ]);

        $configuration = Configuration::find(1);
        $totalDates = Date::count();
        $status = false;

        //if date does not exist then create one
        if ($totalDates == 0){
            $date = new Date();
            $date->date = $request->software_date;
            $status = $date->save();
        }

        //if only one date is found then update
        if ($totalDates == 1){
            $date = Date::first();
            $date->date = $request->software_date;
            $status = $date->save();
        }

        $isValid = Date::whereDate('date', $request->software_date)->count();


        if ($isValid){
            /*If start date is updated then update configuration too*/
            if ($status){
                $configuration->software_start_date = $request->software_date;
            }

            $configuration->date = $request->software_date;
            $configuration->save();

            return redirect()->back()->with('success', '<b>Date updated successfully</b>');
        }

        session()->flash('errors', '<b>Date does not exist</b>');

        return redirect()->back()->withInput($request->all());

    }



}
