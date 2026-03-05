<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Offer extends Model {
        use HasFactory;

        public function order() {
            return $this->belongsTo(Order::class)->with(['seller', 'customer','technic']);
        }

        public function seller() {
            return $this->hasOne(User::class, 'id', 'seller_id')->with('business');
        }

    }
