<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use function request;

    class Order extends Model {
        use HasFactory;

        public function offers() {
            return $this->hasMany(Offer::class)->with('seller');
        }

        public function offer() {
            return $this->hasOne(Offer::class, 'order_id', 'id')->with('seller');
        }

        public function machine() {
            return $this->hasOne(Machine::class, 'id', 'machine_id')->where('visible', 1);
        }

        public function orders() {
            return $this->hasMany(Order::class, 'id', 'id');
        }

        public function customer() {
            return $this->hasOne(User::class, 'id', 'customer_id');
        }

        public function seller() {
            return $this->hasOne(User::class, 'id', 'seller_id')->with('business');
        }

        public function technic() {
            return $this->hasOne(Technic::class, 'id', 'technic_id')->with('photo');
        }

        public function technics_by_machine() {
            return $this->hasMany(Technic::class, 'machine_id', 'machine_id')->with('photo');
        }

        public function getPhoneFormattedAttribute() {
            $phone = preg_replace("/[^0-9]/","", $this->phone); //Remove all non-numers
            return '+' . substr($phone,0,2).' ('.substr($phone,2,3).') '.substr($phone,5,3).'-'.substr($phone,8,2).'-'.substr($phone,10,2);

        }

    }
