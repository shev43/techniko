<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_messages', function (Blueprint $table) {
            $table->id();
            $table->enum('action', [
                'customer.register',
                'customer.address.adding',
                'customer.address.changed',
                'customer.phone.changed',

                'customer.order.status.new',
                'customer.order.status.accepted',
                'customer.order.status.executed',
                'customer.order.status.done',
                'customer.order.status.canceled_by_buyer',
                'customer.order.status.canceled_by_seller',

                'customer.tender.status.new',

                'customer.tender.offer.new',
                'customer.offer.new',

                'business.register',
                'business.password.changed',
                'business.address.adding',
                'business.address.changed',
                'business.phone.changed',
                'business.email.changed',
                'business.company.name.changed',

                'business.tender.offer.new',
                'business.offer.new',
                'business.offer.accepted',
                'business.offer.canceled_by_buyer',

                'business.order.status.new',
                'business.order.status.accepted',
                'business.order.status.executed',
                'business.order.status.done',
                'business.order.status.canceled_by_buyer',
                'business.order.status.canceled_by_seller',

                'business.product.adding',
                'business.product.edited',
                'business.product.deleted',

                'business.tender.new.subscribed',
                'business.tender.new.unsubscribed',

                'business.tender.accepted_by_buyer',
                'business.tender.canceled_by_buyer',
                'business.tender.canceled_by_seller'
            ])->nullable();

            $table->text('message')->nullable();
            $table->enum('language', ['ua', 'ru'])->default('ua');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_messages');
    }
}
