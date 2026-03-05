<?php

    namespace App\Models;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;
//    use App\Notifications\ResetPasswordNotification;


    class User extends Authenticatable {
        use HasApiTokens, HasFactory, Notifiable;
        use SoftDeletes;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
        protected $fillable = [
            'account_type', 'first_name', 'last_name', 'phone', 'email', 'photo', 'address', 'enabled', 'password',];

        /**
         * The attributes that should be hidden for serialization.
         *
         * @var array<int, string>
         */
        protected $hidden = [
            'password', 'remember_token',];

        /**
         * The attributes that should be cast.
         *
         * @var array<string, string>
         */
        protected $casts = [
            'email_verified_at' => 'datetime',];



        public function getPhoneFormattedAttribute() {
            $phone = preg_replace("/[^0-9]/","", $this->phone); //Remove all non-numers
            return '+' . substr($phone,0,2).' ('.substr($phone,2,3).') '.substr($phone,5,3).'-'.substr($phone,8,2).'-'.substr($phone,10,2);

        }

        public function authLoginCode() {
            return $this->hasOne(UserVerifyCode::class, 'user_id', 'id')->where('action', 'login')->where('used', 0)->latest()->first();
        }

        public function changePhoneCode() {
            return $this->hasOne(UserVerifyCode::class, 'user_id', 'id')->where('action', 'change-phone')->where('used', 0)->latest()->first();
        }

        public function isEnabled(): bool {
            return $this->enabled == 1;
        }

        /**
         * @return bool
         */
        public function isBusinessCompleteActive(): bool {
            return $this->isEnabled() && !empty($this->business);
        }


        public function business() {
            return $this->hasOne(Business::class, 'user_id', 'id')->with(['technics', 'contacts']);
        }

        public function roles() {
            return $this->hasOne(Role::class, 'user_id', 'id')->get();
        }

        public function currentRoles() {
            return $this->hasMany(Role::class, 'user_id', 'id');
        }

        //        public function sendPasswordResetNotification($token) {
//            $url = 'https://example.com/reset-password?token='.$token;
//
//            $this->notify(new ResetPasswordNotification($url));
//        }
    }
