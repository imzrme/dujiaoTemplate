@extends('inkpress.layouts.default')

@section('content')
<div class="container" style="padding: 40px 0;">
    <div class="retro-card" style="max-width: 400px; margin: 0 auto; text-align: center;">
        <div class="retro-card-header">
            <h2 style="margin: 0; font-size: 24px;">{{ __('inkpress.qrpay_title') }}</h2>
        </div>

        <div style="padding: 24px 0;">
            <p style="font-size: 18px; font-weight: 700; margin-bottom: 24px;">{{ $actual_price }} {{ __('inkpress.global_currency') }}</p>
            
            <div style="border: 4px solid var(--retro-black); padding: 12px; display: inline-block; margin-bottom: 24px;">
                <img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->size(200)->generate($qr_code)) !!}" alt="QR Code">
            </div>

            <p style="font-size: 14px; color: var(--retro-gray-mid);">{{ __('inkpress.qrpay_open_app_to_pay') }}</p>
            
            <div style="margin-top: 24px; font-size: 12px;">
                {{ __('inkpress.qrpay_order_expiration_date') }}: {{ $order_expire_date }} {{ __('inkpress.qrpay_expiration_date') }}
            </div>
        </div>
    </div>
</div>

<script>
    // Simple polling for payment status
    setInterval(function() {
        $.post("{{ url('check-pay-status') }}", {
            order_sn: "{{ $order_sn }}",
            _token: "{{ csrf_token() }}"
        }, function(data) {
            if (data.code == 200) {
                window.location.href = data.url;
            }
        });
    }, 3000);
</script>
@endsection
