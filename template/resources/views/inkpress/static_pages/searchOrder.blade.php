@extends('inkpress.layouts.default')

@section('content')
<div class="container" style="padding: 40px 20px;">
    <div class="retro-card" style="max-width: 600px; margin: 0 auto;">
        <div class="retro-card-header">
            <h2 style="margin: 0; font-size: 24px;">{{ __('inkpress.searchOrder_title') }}</h2>
            <p style="margin: 4px 0 0; font-size: 12px; color: var(--retro-gray-mid);">{{ __('inkpress.searchOrder_query_tips') }}</p>
        </div>

        <div style="padding: 24px 0;">
            <!-- Tabs -->
            <div style="display: flex; gap: 8px; margin-bottom: 24px; border-bottom: 2px solid var(--retro-black); padding-bottom: 16px;">
                <button type="button" class="btn-retro tab-btn active" data-target="tab-order" onclick="switchTab('tab-order')">{{ __('inkpress.searchOrder_order_search_by_number') }}</button>
                <button type="button" class="btn-retro-outline tab-btn" data-target="tab-email" onclick="switchTab('tab-email')">{{ __('inkpress.searchOrder_order_search_by_email') }}</button>
                <button type="button" class="btn-retro-outline tab-btn" data-target="tab-cache" onclick="switchTab('tab-cache')">{{ __('inkpress.searchOrder_order_search_by_ie') }}</button>
            </div>

            <!-- Tab Content: Order Number -->
            <div id="tab-order" class="tab-content" style="display: block;">
                <form action="{{ url('search-order-by-sn') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-bottom: 16px;">
                        <input type="text" name="order_sn" placeholder="{{ __('inkpress.search_ddh') }}" required class="retro-input" style="width: 100%; padding: 12px; border: 2px solid var(--retro-black); background: var(--retro-white); font-family: inherit; box-sizing: border-box;">
                    </div>
                    <button type="submit" class="btn-retro" style="width: 100%;">{{ __('inkpress.search_now') }}</button>
                </form>
            </div>

            <!-- Tab Content: Email -->
            <div id="tab-email" class="tab-content" style="display: none;">
                <form action="{{ url('search-order-by-email') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-bottom: 16px;">
                        <input type="email" name="email" placeholder="{{ __('inkpress.search_email') }}" required class="retro-input" style="width: 100%; padding: 12px; border: 2px solid var(--retro-black); background: var(--retro-white); font-family: inherit; box-sizing: border-box;">
                    </div>
                    
                    @if(dujiaoka_config_get('is_open_search_pwd', \App\Models\BaseModel::STATUS_CLOSE) == \App\Models\BaseModel::STATUS_OPEN)
                    <div class="form-group" style="margin-bottom: 16px;">
                        <input type="password" name="search_pwd" placeholder="{{ __('inkpress.search_password') }}" required class="retro-input" style="width: 100%; padding: 12px; border: 2px solid var(--retro-black); background: var(--retro-white); font-family: inherit; box-sizing: border-box;">
                    </div>
                    @endif

                    <button type="submit" class="btn-retro" style="width: 100%;">{{ __('inkpress.search_now') }}</button>
                </form>
            </div>

            <!-- Tab Content: Browser Cache -->
            <div id="tab-cache" class="tab-content" style="display: none;">
                <form action="{{ url('search-order-by-browser') }}" method="post">
                    {{ csrf_field() }}
                    <p style="margin-bottom: 16px;">{{ __('inkpress.searchOrder_query_tips') }}</p>
                    <button type="submit" class="btn-retro" style="width: 100%;">{{ __('inkpress.search_now') }}</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    function switchTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
        // Show target content
        document.getElementById(tabId).style.display = 'block';

        // Update buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            if (btn.getAttribute('data-target') === tabId) {
                btn.classList.remove('btn-retro-outline');
                btn.classList.add('btn-retro');
            } else {
                btn.classList.remove('btn-retro');
                btn.classList.add('btn-retro-outline');
            }
        });
    }
</script>
@endsection
