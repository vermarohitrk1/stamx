<?php
namespace App\Imports;
   
use App\User;
use App\Newconnect;
use App\Helpers;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Auth;
class ContactImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $directory = array(
        "user_id"  =>  Auth::user()->id,
        "fname" => $row['first_name'],
        "lname" => $row['last_name'],
        "email" => $row['email'],
        "phone" => $row['phone'],
        "city" => $row['sms'],
        );

        Newconnect::create($directory);

    }   
}