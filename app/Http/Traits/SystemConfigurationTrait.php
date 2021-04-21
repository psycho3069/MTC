<?php


namespace App\Http\Traits;



use App\Configuration;
use App\Date;

trait SystemConfigurationTrait
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



}
