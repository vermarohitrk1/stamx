<?php
namespace App\Imports;
   
use App\User;
use App\Directory;
use App\Helpers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Auth;
class DirectoryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $directory = array();
        $directory["user_id"]  =  Auth::user()->id;
		if(!empty($row['name'])){
			$directory["name"] = $row['name'];
		}
		if(!empty($row['email_address'])){
			$directory["email"] = $row['email_address'];
		}
		if(!empty($row['phone'])){
			$directory["phone"] = $row['phone'];
		}
		if(!empty($row['city'])){
			$directory["city"] = $row['city'];
		}
		if(!empty($row['state'])){
			$directory["state"] = $row['state'];
		}
		if(!empty($row['zip'])){
			$directory["zip"] = $row['zip'];
		}
		if(!empty($row['website'])){
			$directory["website"] = $row['website'];
		}
        if(!empty($row['address'])){
			  $directory["address"] = $row['address'];
		}
		if(!empty($row['description'])){
			    $directory["description"] = $row['description'];
		}
        
                
                //removing extracted values
                unset($row['srno']);
                unset($row['name']);
                unset($row['email_address']);
                unset($row['phone']);
                unset($row['address']);
                unset($row['city']);
                unset($row['state']);
                unset($row['zip']);
                unset($row['website']);
                unset($row['description']);
                
                if(!empty($row)){
			    $directory["columns"] = json_encode($row);
		}
      
        

        Directory::create($directory);

    }   
}