@extends('inkpress.layouts.default')

@section('content')
<div class="container" style="padding: 40px 20px;">
    <!-- Detection Logic: Single vs Multiple -->
    @php
        $ordersList = isset($orders) ? $orders : (isset($order_sn) ? [['order_sn' => $order_sn, 'title' => $title, 'created_at' => $created_at, 'email' => $email, 'actual_price' => $actual_price, 'status' => $status, 'info' => isset($carmi) ? $carmi : '']] : []);
    @endphp

    @if(empty($ordersList))
         <div class="retro-card" style="max-width: 600px; margin: 0 auto; text-align: center;">
            <h2>{{ __('inkpress.search_order_none') ?? 'No Orders Found' }}</h2>
            <a href="/" class="btn-retro">{{ __('inkpress.home') }}</a>
         </div>
    @else
        @foreach($ordersList as $order)
        <div class="retro-card" style="max-width: 600px; margin: 0 auto 40px auto;">
            <div class="retro-card-header" style="text-align: center; border-bottom: 2px dashed var(--retro-black); padding-bottom: 20px;">
                <h2 style="margin: 0; font-size: 24px;">{{ __('inkpress.orderinfo_title') }}</h2>
                <div style="margin-top: 8px;">
                    @php $status = data_get($order, 'status'); @endphp
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
                <div style="margin-bottom: 24px; border-bottom: 2px dashed var(--retro-black); padding-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-weight: 700;">{{ __('inkpress.bill_order_number') }}</span>
                        <span>{{ data_get($order, 'order_sn') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-weight: 700;">{{ __('inkpress.bill_title') }}</span>
                        <span>{{ data_get($order, 'title') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-weight: 700;">{{ __('inkpress.orderinfo_order_time') }}</span>
                        <span>{{ data_get($order, 'created_at') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-weight: 700;">{{ __('inkpress.bill_email') }}</span>
                        <span>{{ data_get($order, 'email') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                        <span style="font-weight: 700;">{{ __('inkpress.orderinfo_total_order_price') }}</span>
                        <span class="retro-price">{{ data_get($order, 'actual_price') }}</span>
                    </div>
                </div>

                @php $carmi = data_get($order, 'info'); @endphp
                @if($status == \App\Models\Order::STATUS_COMPLETED)
                <div style="margin-bottom: 24px;">
                    <h3 style="font-size: 16px; margin-bottom: 12px; text-transform: uppercase; border-bottom: 2px solid var(--retro-black); display: inline-block;">{{ __('inkpress.orderinfo_carmi') }}</h3>
                    <div style="background: #fff; padding: 16px; border: 2px solid var(--retro-black); font-family: monospace; white-space: pre-wrap; word-break: break-all;">{!! $carmi !!}</div>
                    <button class="btn-retro-outline" style="margin-top: 12px; width: 100%;" onclick="copyCarmi(this)">{{ __('inkpress.orderinfo_copy_carmi') }}</button>
                    <textarea style="display:none;" class="carmi-text">{!! $carmi !!}</textarea>
                </div>
                @endif
                
                @if($status == \App\Models\Order::STATUS_WAIT_PAY)
                     <a href="{{ url('bill', ['orderSN' => data_get($order, 'order_sn')]) }}" class="btn-retro" style="display: block; width: 100%; text-decoration: none; box-sizing: border-box; margin-bottom: 12px;">{{ __('inkpress.buy_pay') }}</a>
                @endif
            </div>
        </div>
        @endforeach
        
        <div style="max-width: 600px; margin: 0 auto; text-align: center; padding-bottom: 40px;">
             <a href="/" class="btn-retro" style="display: inline-block; padding: 12px 40px; text-decoration: none;">{{ __('inkpress.home') }}</a>
             <a href="{{ url('order-search') }}" class="btn-retro-outline" style="display: inline-block; padding: 12px 40px; text-decoration: none; margin-left: 10px;">{{ __('inkpress.order_search') }}</a>
        </div>
    @endif
</div>

<script>
    function copyCarmi(btn) {
        // Find the text area sibling or the div content logic
        const container = btn.parentElement;
        const carmiDiv = container.querySelector('div[style*="monospace"]');
        if(carmiDiv) {
             const text = carmiDiv.innerText;
             navigator.clipboard.writeText(text).then(() => {
                const originalText = btn.innerText;
                btn.innerText = 'COPIED!';
                setTimeout(() => {
                    btn.innerText = originalText;
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    }
</script>
@endsection
