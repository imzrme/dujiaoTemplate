@extends('inkpress.layouts.default')

@section('content')
<div class="container" style="padding: 40px 20px;">
    <div class="retro-card" style="margin-bottom: 40px; max-width: 800px; margin-left: auto; margin-right: auto;">
        <div class="retro-card-header">
            <h2 style="margin: 0; font-size: 24px;">{{ __('inkpress.buy') }} // {{ $gd_name }}</h2>
        </div>
        
        <form class="buy-form" action="{{ url('create-order') }}" method="post">
            {{ csrf_field() }}
            <div style="display: flex; flex-wrap: wrap; gap: 40px;">
                <!-- Left Column: Image -->
                <div style="flex: 1; min-width: 300px;">
                    <div style="border: 2px solid var(--retro-black); padding: 10px; background: #fff;">
                        <img src="{{ picture_ulr($picture) }}" alt="{{ $gd_name }}" style="width: 100%; display: block;">
                    </div>
                </div>

                <!-- Right Column: Details & Form -->
                <div style="flex: 1; min-width: 300px;">
                    
                    <!-- Meta Info (Badges) -->
                    <div style="margin-bottom: 24px; display: flex; flex-wrap: wrap; gap: 8px;">
                        <span class="retro-tag">
                            {{ $type == \App\Models\Goods::AUTOMATIC_DELIVERY ? __('inkpress.automatic_delivery') : __('inkpress.manual_delivery') }}
                        </span>
                        <span class="retro-tag">
                            {{ __('inkpress.stock') }}: {{ $in_stock }}
                        </span>
                        @if($buy_limit_num > 0)
                        <span class="retro-tag">
                            {{ __('inkpress.buy_purchase_restrictions') }}: {{ $buy_limit_num }}
                        </span>
                        @endif
                        
                        @if(!empty($wholesale_price_cnf) && is_array($wholesale_price_cnf))
                            @foreach($wholesale_price_cnf as $ws)
                                <span class="retro-tag">
                                    {{ __('inkpress.buy_the_above', ['number' => $ws['number']]) }} {{ $ws['price'] }} {{ __('inkpress.global_currency') }}
                                </span>
                            @endforeach
                        @endif
                    </div>

                    <!-- Price -->
                    <div class="retro-price" style="margin-bottom: 24px; font-size: 32px;">
                        {{ __('inkpress.global_currency') }} {{ $actual_price }}
                    </div>
                    
                    <input type="hidden" name="gid" value="{{ $id }}">

                    <!-- Email Input -->
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 700; text-transform: uppercase;">{{ __('inkpress.buy_email') }}</label>
                        <input type="email" name="email" class="retro-input" placeholder="example@email.com" required style="width: 100%; padding: 12px; border: 2px solid var(--retro-black); background: var(--retro-white); font-family: inherit; box-sizing: border-box;">
                    </div>

                    <!-- Search Password (if enabled) -->
                    @if(dujiaoka_config_get('is_open_search_pwd') == \App\Models\Goods::STATUS_OPEN)
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 700; text-transform: uppercase;">{{ __('inkpress.buy_search_password') }}</label>
                        <input type="text" name="search_pwd" class="retro-input" placeholder="" style="width: 100%; padding: 12px; border: 2px solid var(--retro-black); background: var(--retro-white); font-family: inherit; box-sizing: border-box;">
                    </div>
                    @endif

                    <!-- Coupon (if enabled) -->
                    @if(isset($open_coupon))
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 700; text-transform: uppercase;">{{ __('inkpress.buy_promo_code') }}</label>
                        <input type="text" name="coupon_code" class="retro-input" placeholder="" style="width: 100%; padding: 12px; border: 2px solid var(--retro-black); background: var(--retro-white); font-family: inherit; box-sizing: border-box;">
                    </div>
                    @endif

                    <!-- Custom Fields (Manual Processing) -->
                    @if($type == \App\Models\Goods::MANUAL_PROCESSING && is_array($other_ipu))
                        @foreach($other_ipu as $ipu)
                        <div class="form-group" style="margin-bottom: 16px;">
                            <label style="font-weight: 700; text-transform: uppercase;">{{ $ipu['desc'] }}</label>
                            <input type="text" name="{{ $ipu['field'] }}" @if($ipu['rule'] !== false) required @endif class="retro-input" style="width: 100%; padding: 12px; border: 2px solid var(--retro-black); background: var(--retro-white); font-family: inherit; box-sizing: border-box;">
                        </div>
                        @endforeach
                    @endif

                    <!-- Payment Method -->
                    <div class="form-group" style="margin-bottom: 16px;">
                         <label style="font-weight: 700; text-transform: uppercase;">{{ __('inkpress.buy_pay') }}</label>
                         <select name="payway" class="retro-input" style="width: 100%; padding: 12px; border: 2px solid var(--retro-black); background: var(--retro-white); font-family: inherit; border-radius: 0; appearance: none; -webkit-appearance: none; box-sizing: border-box;">
                            @foreach($payways as $key => $way)
                                <option value="{{ $way['id'] }}" @if($key==0) selected @endif>{{ $way['pay_name'] }}</option>
                            @endforeach
                         </select>
                    </div>

                    <!-- Captcha (Image) -->
                    @if(dujiaoka_config_get('is_open_img_code') == \App\Models\Goods::STATUS_OPEN)
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="font-weight: 700; text-transform: uppercase;">{{ __('inkpress.buy_verify_code') }}</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" name="img_verify_code" class="retro-input" required style="flex: 1; padding: 12px; border: 2px solid var(--retro-black); background: var(--retro-white); font-family: inherit; box-sizing: border-box;">
                            <img class="captcha-img" src="{{ captcha_src('buy') . time() }}" onclick="refresh()" style="cursor: pointer; border: 2px solid var(--retro-black); height: 46px;">
                        </div>
                        <script>
                            function refresh() {
                                document.querySelector('.captcha-img').src = '{{ captcha_src('buy') }}' + Math.random();
                            }
                        </script>
                    </div>
                    @endif

                    <!-- Geetest (Behavior Verification) -->
                    @if(dujiaoka_config_get('is_open_geetest') == \App\Models\Goods::STATUS_OPEN )
                    <div class="form-group" style="margin-bottom: 16px;">
                         <div id="geetest-captcha"></div>
                    </div>
                    @endif

                    <!-- Quantity & Submit -->
                    <div style="display: flex; gap: 16px; align-items: stretch; margin-top: 24px;">
                        <div style="display: flex; border: 2px solid var(--retro-black);">
                            <button type="button" class="decrement" style="border: none; background: transparent; padding: 0 16px; font-weight: bold; cursor: pointer; border-right: 2px solid var(--retro-black);">-</button>
                            <input type="text" name="by_amount" value="1" style="width: 50px; text-align: center; border: none; font-size: 16px; font-weight: bold; -moz-appearance: textfield;">
                            <button type="button" class="increment" style="border: none; background: transparent; padding: 0 16px; font-weight: bold; cursor: pointer; border-left: 2px solid var(--retro-black);">+</button>
                        </div>
                        <button type="submit" class="btn-retro" style="flex: 1;">{{ __('inkpress.buy') }}</button>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <!-- Product Description -->
    <div class="retro-card" style="max-width: 800px; margin-left: auto; margin-right: auto;">
        <div class="retro-card-header">
            <h3 style="margin: 0; font-size: 18px;">{{ __('inkpress.buy_product_desciption') }}</h3>
        </div>
        <div class="retro-content" style="padding: 0 10px;">
            {!! $description !!}
        </div>
    </div>
</div>

<!-- Buy Prompt Modal -->
@if(!empty($buy_prompt))
<div id="buy-prompt-modal" class="retro-modal show">
    <div class="retro-modal-content">
        <div class="retro-modal-header">
            <h3>NOTICE</h3>
            <span class="retro-close" onclick="document.getElementById('buy-prompt-modal').classList.remove('show')">&times;</span>
        </div>
        <div class="retro-modal-body">
            {!! $buy_prompt !!}
        </div>
    </div>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity Logic
        const decrementBtn = document.querySelector('.decrement');
        const incrementBtn = document.querySelector('.increment');
        const amountInput = document.querySelector('input[name="by_amount"]');

        if(decrementBtn && incrementBtn && amountInput) {
            decrementBtn.addEventListener('click', () => {
                let val = parseInt(amountInput.value);
                if(val > 1) amountInput.value = val - 1;
            });
            incrementBtn.addEventListener('click', () => {
                let val = parseInt(amountInput.value);
                amountInput.value = val + 1;
            });
        }

        // Force Responsive Images in Description (Nuclear Option)
        const descImages = document.querySelectorAll('.retro-content img');
        descImages.forEach(img => {
            img.style.removeProperty('width');
            img.style.removeProperty('height');
            img.style.width = '100%';
            img.style.height = 'auto';
            img.removeAttribute('width');
            img.removeAttribute('height');
        });
    });
</script>

@endsection
