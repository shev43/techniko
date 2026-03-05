<?php

return [
    /*
     * Test mode for using test credentials
     */
    'testMode' => env("WAYFORPAY_TEST", true),
    'currency' => 'UAH',

    /*
     * Merchant domain
     */
    'merchantDomain' => env('WAYFORPAY_DOMAIN', 'betonko.com.ua'),

    /*
     * Merchant Account ID
     */
    'merchantAccount' => env('WAYFORPAY_ACCOUNT', 'betonko_com_ua'),

    /*
     * Merchant Secret key
     */
    'merchantSecretKey' => env('WAYFORPAY_SECRET_KEY', '18b8857710b1a726b6fd4ae6d4d81f762382db70'),
];
