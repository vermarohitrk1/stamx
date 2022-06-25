<?php
namespace App\Imports;
   
use App\User;
use App\Institution;
use App\Helpers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Auth;
class InstitutionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $institution = array();
       
        if(!empty($row['institution'])){
			$institution["institution"] = $row['institution'];
            $institution["address"] = $row['address'];
            $institution["city"] = $row['city'];
            $institution["state"] = $row['state'];
            $institution["zip"] = $row['zip'];
            $institution["country"] = $row['country'];
            $institution["lat"] = $row['lat']??0;
            $institution["long"] = $row['long']??0;
            $institution["type"] = $row['type'];
            $institution["user_id"] = 1;
            $institution["status"] = 1;
        }
      //  dd($institution);
        Institution::create($institution);
    }   
}