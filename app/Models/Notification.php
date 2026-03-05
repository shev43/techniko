<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
    use HasFactory;

    public function message() {
        return $this->hasOne(NotificationMessage::class, 'id', 'notification_messages_id');
    }

    public function order() {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

}
