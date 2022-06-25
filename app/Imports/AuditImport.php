<?php
namespace App\Imports;
   
use App\User;
use App\Quote;
use App\Helpers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Auth;
class AuditImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
    //     // $quote = array();
    //     // if(!empty($row['title'])){
	// 	// 	$quote["name"] = $row['title'];
    //     // }
    //   //  Audit::create($quote);
    //   return
    // }   
   // $csvdata= array();
    return  $row;
  
   }
}