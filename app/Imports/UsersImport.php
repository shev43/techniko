<?php

namespace App\Imports;

use App\Mail\VerifyBusiness;
use App\Models\Business;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Mail;

class UsersImport implements ToModel, WithStartRow {

    private $setStartRow = 2;

    public function startRow() : int{
        return $this->setStartRow;
    }

    public function model(array $row) {
        if(!empty($row[3])) {
            $checkEmail = User::whereIn('email', [$row[3]])->get();
            $checkBusinessEmail = Business::whereIn('email', [$row[3]])->get();
            if(count($checkEmail) == 0 && count($checkBusinessEmail) == 0) {
                $latestEntry = User::get();
                $password = Str::random(8);

//                dd($password);

                $users = new User;
                $users->account_type = 3;
                $users->profile_number_seller = 'UE' . str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
                $users->first_name = "Ваше ім'я";
                $users->last_name = "Ваше прізвище";
                $users->address = ($row[1]) ?? null;
                $users->phone = str_replace(' ', '', $row[2]) ?? null;
                $users->email = strtolower(str_replace(' ', '', $row[3])) ?? null;
                $users->password = Hash::make($password);
                $users->verify_token = Str::random(60);

                $users->save();


                $businessLatestEntry = Business::get();

                $business = new Business();
                $business->user_id = $users->id;
                $business->business_number = 'UE'.str_pad(($businessLatestEntry) ? count($businessLatestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
                $business->name = ($row[0]) ?? null;
                $business->slug = Str::slug($business->name);
                $business->phone = str_replace(' ', '', $row[2]) ?? null;
                $business->email = strtolower(str_replace(' ', '', $row[3])) ?? null;

                $business->description = null;
                $business->address = ($row[1]) ?? null;
                $business->www = ($row[4]) ?? null;
                $business->save();


                $response = [
                    'subject'=> 'Активація аккаунту',
                    'name'=> $business->name,
                    'email'=> $users->email,
                    'password'=> $password,
                    'target'=> route('business::profile.activate', ['lang'=>app()->getLocale(), 'token'=>$users->verify_token]),
                ];

                Mail::to($users->email)
                    ->locale('uk')
                    ->send(new VerifyBusiness($response));


//                dd($business, $response);
            }

        }

    }


}
