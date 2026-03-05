<?php

    namespace App\Models;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Subscription extends Model {
        use HasFactory;

        public function isActive(): bool {

            if(empty($this->active_to) || $this->status !== 'Approved') {
                return false;
            }

            $today = Carbon::now()->endOfDay();
            $activeTo = Carbon::parse($this->active_to)->endOfDay();
            return $today->lessThanOrEqualTo($activeTo);

        }


        public function business() {
            return $this->hasOne(Business::class, 'id', 'business_id')->with('seller');
        }

        public function items() {
            return $this->hasMany(SubscriptionSlotItem::class, 'slot_id', 'id');
        }


    }
