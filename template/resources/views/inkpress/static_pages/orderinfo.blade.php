@extends('inkpress.layouts.default')

@section('content')
<div class="container" style="padding: 40px 0;">
    <div class="retro-card" style="max-width: 600px; margin: 0 auto;">
        <div class="retro-card-header">
            <h2 style="margin: 0; font-size: 24px;">{{ __('inkpress.orderinfo_title') }}</h2>
            <div style="margin-top: 8px;">
                @switch($status)
                    @case(\App\Models\Order::STATUS_EXPIRED)
                        <span class="retro-tag" style="border-color: #666; color: #666;">{{ __('inkpress.orderinfo_status_expired') }}</span>
                        @break
                    @case(\App\Models\Order::STATUS_WAIT_PAY)
                        <span class="retro-tag" style="border-color: #F39C12; color: #F39C12;">{{ __('inkpress.orderinfo_status_wait_pay') }}</span>
                        @break
                    @case(\App\Models\Order::STATUS_PENDING)
                        <span class="retro-tag" style="border-color: #3498DB; color: #3498DB;">{{ __('inkpress.orderinfo_status_pending') }}</span>
                        @break
                    @case(\App\Models\Order::STATUS_COMPLETED)
                        <span class="retro-tag" style="border-color: #27AE60; color: #27AE60;">{{ __('inkpress.orderinfo_status_completed') }}</span>
                        @break
                    @case(\App\Models\Order::STATUS_FAILURE)
                        <span class="retro-tag" style="border-color: #E74C3C; color: #E74C3C;">{{ __('inkpress.orderinfo_status_failed') }}</span>
                        @break
                    @default
                        <span class="retro-tag">{{ __('inkpress.orderinfo_status_abnormal') }}</span>
                @endswitch
            </div>
        </div>

        <div style="padding: 24px 0;">
            <div style="margin-bottom: 24px;">
                <h3 style="font-size: 16px; margin-bottom: 12px; text-transform: uppercase; border-bottom: 2px solid var(--retro-black); display: inline-block;">{{ __('inkpress.bill_order_information') }}</h3>
                <p><strong>{{ __('inkpress.bill_order_number') }}:</strong> {{ $order_sn }}</p>
                <p><strong>{{ __('inkpress.bill_title') }}:</strong> {{ $title }}</p>
                <p><strong>{{ __('inkpress.orderinfo_order_time') }}:</strong> {{ $created_at }}</p>
                <p><strong>{{ __('inkpress.bill_email') }}:</strong> {{ $email }}</p>
                <p><strong>{{ __('inkpress.orderinfo_total_order_price') }}:</strong> {{ $actual_price }}</p>
            </div>

            @if($status == \App\Models\Order::STATUS_COMPLETED)
            <div style="margin-bottom: 24px;">
                <h3 style="font-size: 16px; margin-bottom: 12px; text-transform: uppercase; border-bottom: 2px solid var(--retro-black); display: inline-block;">{{ __('inkpress.orderinfo_carmi') }}</h3>
                <div style="background: var(--retro-cream); padding: 16px; border: 2px solid var(--retro-black); font-family: monospace; white-space: pre-wrap; word-break: break-all;">
                    {!! $carmi !!}
                </div>
                <button class="btn-retro-outline" style="margin-top: 12px; width: 100%;" onclick="copyCarmi()">{{ __('inkpress.orderinfo_copy_carmi') }}</button>
            </div>
            @endif
            
            <a href="/" class="btn-retro" style="display: block; width: 100%; text-decoration: none;">{{ __('inkpress.home') }}</a>
        </div>
    </div>
</div>

<script>
    function copyCarmi() {
        const carmiText = document.querySelector('div[style*="monospace"]').innerText;
        navigator.clipboard.writeText(carmiText).then(() => {
            alert('Copied!');
        });
    }
</script>
@endsection
