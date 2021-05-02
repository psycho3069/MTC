<?php


namespace App\Http\Traits;

use App\Configuration;
use App\Date;
use App\MISHead;
use App\Unit;


trait SoftwareConfigurationTrait
{

    public function getSoftwareStartDate()
    {
        $configuration = Configuration::find(1);
        $date = Date::where('date', $configuration->software_start_date)->firstOrFail();
        return $date;
    }



    public function getSoftwareDate()
    {
        $configuration = Configuration::find(1);
        $date = Date::where('date', $configuration->date)->firstOrFail();
        return $date;
    }


    public function getVatFood()
    {
        return Configuration::where('name', Configuration::$property['vat_food'])
            ->firstOrFail();
    }


    public function getVatService()
    {
        return Configuration::where('name', Configuration::$property['vat_service'])
            ->firstOrFail();

    }


    public function getVatOthers()
    {
        return Configuration::where('name', Configuration::$property['vat_others'])
            ->firstOrFail();
    }


    public function getRoomBookingAccount()
    {
        $misHead = MISHead::where('account_type', MISHead::$accountType['room_booking'])->firstOrFail();
        return $misHead->firstAccount;
    }


    public function getVenueBookingAccount()
    {
        $misHead = MISHead::where('account_type', MISHead::$accountType['venue_booking'])->firstOrFail();
        return $misHead->firstAccount;
    }


    public function getHotelFoodSaleAccount()
    {
        $misHead = MISHead::where('account_type', MISHead::$accountType['food_sale'])->firstOrFail();
        return $misHead->foodSaleHotel;
    }


    public function getPersonalFoodSaleAccount()
    {
        $misHead = MISHead::where('account_type', MISHead::$accountType['food_sale'])->firstOrFail();
        return $misHead->foodSalePersonal;
    }


    public function getDiscountAccount()
    {
        $misHead = MISHead::where('account_type', MISHead::$accountType['discount'])
            ->firstOrFail();
        return $misHead->firstAccount;
    }


    public function getUnit($unitId, $unitTypeId = null)
    {
        $query = Unit::query();
        $query->where('id', $unitId);
        $query->when($unitTypeId, function ($query, $unitTypeId){
            $query->where('unit_type_id', $unitTypeId);
        });
        return $query->firstOrFail();
    }


    public function getPaymentType($misHead)
    {
        if ($misHead->account_type == MISHead::$accountType['room_booking']){
            return 'room';
        }

        if ($misHead->account_type == MISHead::$accountType['venue_booking']){
            return 'venue';
        }

        if ($misHead->account_type == MISHead::$accountType['food_sale']){
            return 'food';
        }

        if ($misHead->account_type == MISHead::$accountType['discount']){
            return 'discount';
        }
    }






}
