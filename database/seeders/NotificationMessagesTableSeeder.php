<?php

    namespace Database\Seeders;

    use App\Models\User;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class NotificationMessagesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $array = [
            [
                'action' => 'customer.register',
                'message' => "<b>Вітаємо!</b><br>Ви зареєструвались як покупець на TECHNIKO!",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'customer.address.adding',
                'message' => "<b>Адреса додана!</b><br>Ви вказали вашу адресу за замовчуванням, ви завжди зможете її змінювати за бажанням під час пошуку і оформлення.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'customer.address.changed',
                'message' => "<b>Адресу змінено!</b><br>Ви вказали вашу нову адресу за замовчуванням.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'customer.phone.changed',
                'message' => "<b>Номер телефону змінено!</b><br>Ви успішно змінили номер телефону.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'customer.order.status.new',
                'message' => "<b>Заявка оформленна!</b><br>Скоро з вами зв'яжуться для уточнення деталей замовлення та доставки, очікуйте.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'customer.order.status.accepted',
                'message' => "Замовлення #:order_number прийнято в обробку.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'customer.order.status.executed',
                'message' => "Замовлення #:order_number виконується.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'customer.order.status.done',
                'message' => "Вітаємо замовлення #:order_number виконано.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'customer.order.status.canceled_by_buyer',
                'message' => "Покупець скасував замовлення #:order_number.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'customer.order.status.canceled_by_seller',
                'message' => "Продавець скасував замовлення #:order_number.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            [
                'action' => 'customer.tender.status.new',
                'message' => "<b>Заявка на тендер оформленна!</b><br>Скоро з вами зв'яжуться для уточнення деталей замовлення та доставки, очікуйте.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            [
                'action' => 'customer.offer.new',
                'message' => "Продавець зробив вам пропозицію по замовленню #:order_number.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            [
                'action' => 'customer.tender.offer.new',
                'message' => "Продавець зробив вам пропозицію по тендеру #:order_number.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],



            [
                'action' => 'business.register',
                'message' => "<b>Вітаємо!</b><br>Ви зареєструвались як продавець на TECHNIKO!",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.password.changed',
                'message' => "<b>Пароль змінено!</b><br>Ви успішно змінили пароль.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.phone.changed',
                'message' => "<b>Номер телефону змінено!</b><br>Ви успішно змінили номер телефону.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.email.changed',
                'message' => "<b>Поштову адресу змінено!</b><br>Ви успішно змінили поштову адресу.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.address.adding',
                'message' => "<b>Адреса додана!</b><br>Ви вказали вашу адресу за замовчуванням, ви завжди зможете її змінювати за бажанням.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.address.changed',
                'message' => "<b>Адресу змінено!</b><br>Ви вказали вашу нову адресу за замовчуванням.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.company.name.changed',
                'message' => "<b>Назва підприємства змінено!</b><br>Ви успішно змінили назву підприємства, ми повідомимо про це ваших клієнтів.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.product.adding',
                'message' => "Додано новий продукт! Вдалої торгівлі!",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.product.edited',
                'message' => "Змінено продукт",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.product.deleted',
                'message' => "Видалений продукт",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.tender.new.subscribed',
                'message' => "<b>Новий тендер</b><br>З'явився тендер який відповідає вашій продукції, візьміть участь, надішліть зустрічну пропозицію!",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.tender.new.unsubscribed',
                'message' => "<b>Новий тендер</b><br>З'явився тендер який відповідає вашій продукції, щоб взяти участь в ньому спробуйте <b>план \"Експертний\"</b>",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.tender.accepted_by_buyer',
                'message' => "<b>Вітаємо ви перемогли в тендері #:order_number!</b><br>Ваша пропозиція прийнята! Перейдіть в деталі замовлення",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.tender.canceled_by_buyer',
                'message' => "Нажаль в тендері #:order_number не обрали вашу пропозицію.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.tender.canceled_by_seller',
                'message' => "Ви скасували тендер #:order_number.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            [
                'action' => 'business.offer.new',
                'message' => "Ви зробили пропозицію по замовленню #:order_number.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.tender.offer.new',
                'message' => "Ви зробили пропозицію по тендеру #:order_number.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.offer.accepted',
                'message' => "<b>Зустрічна пропозиція прийнята!</b><br>Перейдіть в деталі замовлення!",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.offer.canceled_by_buyer',
                'message' => "Зустрічну пропозицію відхилено.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.order.status.new',
                'message' => "<b>Нова заявка!</b><br>У вас з'явилась нова заявка, надішліть зустрічну пропозицію!",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.order.status.accepted',
                'message' => "Замовлення #:order_number прийнято в обробку.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.order.status.executed',
                'message' => "Замовлення #:order_number виконується.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.order.status.done',
                'message' => "Вітаємо замовлення #:order_number виконано!",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.order.status.canceled_by_buyer',
                'message' => "Покупець скасував замовлення #:order_number.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'action' => 'business.order.status.canceled_by_seller',
                'message' => "Продавець скасував замовлення #:order_number.",
                'language' => 'ua',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]

        ];
        DB::table('notification_messages')->insert($array);


    }
}
