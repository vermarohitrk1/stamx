<?php
namespace App\Imports;
   
use App\User;
use App\Employer;
use App\Helpers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Auth;
class EmployerImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $employer = array();
       
        if(!empty($row['employer'])){
			$employer["company"] = $row['employer'];
            $employer["address"] = $row['address'];
            $employer["city"] = $row['city'];
            $employer["state"] = $row['state'];
            $employer["user_id"] = 1;
            $employer["status"] = 1;
        }
       // dd($institution);
       Employer::create($employer);
    }   
}