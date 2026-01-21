@extends('inkpress.layouts.default')

@section('content')
<div class="container" style="padding: 40px 20px;">
    <div class="retro-card" style="max-width: 500px; margin: 0 auto;">
        <div class="retro-card-header" style="text-align: center; border-bottom: 2px dashed var(--retro-black); padding-bottom: 20px;">
            <h2 style="margin: 0; font-size: 24px;">{{ __('inkpress.bill_yes') }}</h2>
            <p style="margin: 4px 0 0; font-size: 14px;">{{ date('Y-m-d H:i:s') }}</p>
        </div>

        <div style="padding: 24px 0; border-bottom: 2px dashed var(--retro-black);">
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-weight: 700;">{{ __('inkpress.bill_order_number') }}</span>
                <span>{{ $order_sn }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-weight: 700;">{{ __('inkpress.bill_title') }}</span>
                <span>{{ $title }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-weight: 700;">{{ __('inkpress.bill_danjia') }}</span>
                <span>{{ $goods_price }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-weight: 700;">{{ __('inkpress.bill_number') }}</span>
                <span>x {{ $buy_amount }}</span>
            </div>
            @if(!empty($coupon))
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-weight: 700;">{{ __('inkpress.bill_promo_code') }}</span>
                <span>- {{ $coupon_discount_price }}</span>
            </div>
            @endif
             <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-weight: 700;">{{ __('inkpress.bill_email') }}</span>
                <span>{{ $email }}</span>
            </div>
             <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-weight: 700;">{{ __('inkpress.bill_payment_method') }}</span>
                <span>{{ $pay["pay_name"] }}</span>
            </div>
        </div>

        <div style="padding: 24px 0; text-align: right;">
            <div style="font-size: 14px; text-transform: uppercase;">{{ __('inkpress.bill_actual_payment') }}</div>
            <div style="font-size: 32px; font-weight: 700;">{{ $actual_price }}</div>
        </div>

        <a href="{{ url('pay-gateway', ['handle' => urlencode($pay['pay_handleroute']),'payway' => $pay['pay_check'], 'orderSN' => $order_sn]) }}" class="btn-retro" style="display: block; width: 100%; text-decoration: none; box-sizing: border-box;">{{ __('inkpress.buy_pay') }}</a>
    </div>
</div>
@endsection
