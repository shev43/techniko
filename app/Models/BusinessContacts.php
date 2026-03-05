<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class BusinessContacts extends Model {
        use HasFactory;
        use SoftDeletes;

        public function getPhoneFormattedAttribute() {
            $phone = preg_replace("/[^0-9]/","", $this->phone);
            return '+' . substr($phone,0,2).' ('.substr($phone,2,3).') '.substr($phone,5,3).'-'.substr($phone,8,2).'-'.substr($phone,10,2);

        }

        public function getPhoneSmallAttribute() {
            $phone = preg_replace("/[^0-9]/","", $this->phone); //Remove all non-numers
            return '+' . substr($phone,0,2).' ('.substr($phone,2,3).') ***-**-**';

        }

        public function setPhoneFormattedAttribute($phone) {
            return $this->attributes['phone'] = str_replace([' ', '-', '+', '(', ')'], '', $phone);
        }

    }
