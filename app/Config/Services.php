<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use App\Models\ChecklistModel;
use App\Models\CouncilModel;
use App\Models\FacilityModel;
use App\Models\RegionModel;
use App\Models\ResultsModel;
use App\Models\ResultitemModel;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */

    public static function checklistModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('checklistModel');
        }

        return new ChecklistModel();
    }


    public static function councilModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('councilModel');
        }

        return new CouncilModel();
    }


    public static function facilityModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('facilityModel');
        }

        return new FacilityModel();
    }


    public static function regionModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('regionModel');
        }

        return new RegionModel();
    }


    public static function resultsModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('resultsModel');
        }

        return new ResultsModel();
    }


    public static function resultitemModel(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('resultitemModel');
        }

        return new ResultitemModel();
    }


}
