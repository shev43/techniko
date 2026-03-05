@extends('layouts.app')

@section('content')

    @php
        $donateSum = 1;
        $now = time();

        $string = 'test_merch_n1;www.techniko.loc;';
        $string .= 'XS-'.$now.';';
        $string .= $now.';';

        $string .= $donateSum.';UAH;';
        $string .= 'Оплата тарифного пакету Експерт'.';1;';
        $string .= $donateSum;

        $key = "flk3409refn54t54t*FNJRET";

        $hash = hash_hmac("md5",$string,$key);
    @endphp

    <form method="post" action="https://secure.wayforpay.com/pay" accept-charset="utf-8" class="form">
        <input hidden name="merchantAccount" value="test_merch_n1">
        <input hidden name="merchantAuthType" value="SimpleSignature">
        <input hidden name="merchantDomainName" value="www.techniko.loc">
        <input hidden name="merchantSignature" value="{{$hash}}">
        <input hidden name="orderReference" value="{{ 'XS-'.$now }}">
        <input hidden name="orderDate" value="{{$now}}">
        <input hidden name="amount" value="{{ $donateSum }}">
        <input hidden name="returnUrl" value="{{ route('business::subscription.create', ['lang'=>app()->getLocale()]) }}">
        <input hidden name="currency" value="UAH">
        <input hidden name="orderTimeout" value="49000">
        <input hidden name="productName[]" value="Оплата тарифного пакету Експерт">
        <input hidden name="productCount[]" value="1">
        <input hidden name="defaultPaymentSystem" value="card">
    </form>
@endsection
