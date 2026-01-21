@extends('inkpress.layouts.default')

@section('content')
<!-- Hero Section -->
<section class="retro-hero">
    <div class="container">
    <div class="container">
        <!-- Shop Name Removed -->
        <div class="retro-notice">{!! dujiaoka_config_get('notice') !!}</div>
    </div>
    <script>
        // Force clear backgrounds from rich text content
        document.addEventListener("DOMContentLoaded", function() {
            var noticeContainer = document.querySelector('.retro-notice');
            if(noticeContainer) {
                var children = noticeContainer.querySelectorAll('*');
                children.forEach(function(el) {
                    el.style.setProperty('background', 'transparent', 'important');
                    el.style.setProperty('background-color', 'transparent', 'important');
                    el.style.setProperty('box-shadow', 'none', 'important');
                });
            }
        });
    </script>
</section>

<!-- Main Content -->
<main class="container">
    
    <!-- Category Filter (Generated from $data) -->
    <div class="category-filter" style="text-align: center; margin-bottom: 40px; display: flex; justify-content: center; flex-wrap: wrap; gap: 8px;">
        <a href="#all" class="btn-retro filter-btn active" onclick="filterByGroup('all')">{{ __('inkpress.all_products') }}</a>
        @foreach($data as $group)
            <a href="#group-{{ $group['id'] }}" class="btn-retro-outline filter-btn" onclick="filterByGroup('{{ $group['id'] }}')">{{ $group['gp_name'] }}</a>
        @endforeach
    </div>

    <!-- Product Grid -->
    <div class="retro-grid">
        @foreach($data as $group)
            @foreach($group['goods'] as $good)
            <div class="retro-card product-item group-{{ $group['id'] }}">
                <div class="retro-card-header">
                    <span class="retro-card-title">{{ $good['type'] == \App\Models\Goods::AUTOMATIC_DELIVERY ? __('inkpress.automatic_delivery') : __('inkpress.manual_delivery') }}</span>
                    <span class="retro-tag" style="{{ $good['in_stock'] <= 0 ? 'border-color: #E74C3C; color: #E74C3C;' : '' }}">
                        {{ $good['in_stock'] > 0 ? __('inkpress.stock').': '.$good['in_stock'] : __('inkpress.out_of_stock') }}
                    </span>
                </div>
                
                <div style="height: 150px; background: #f5f5f5; margin-bottom: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    <img src="{{ empty($good['picture']) ? asset('assets/inkpress/images/placeholder.png') : picture_ulr($good['picture']) }}" alt="{{ $good['gd_name'] }}" style="max-height: 100%; max-width: 100%;">
                </div>

                <h3>{{ $good['gd_name'] }}</h3>
                
                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div class="retro-price">{{ __('inkpress.global_currency') }} {{ $good['actual_price'] }}</div>
                    <a href="{{ url('buy/'.$good['id']) }}" class="btn-retro" style="padding: 8px 16px; font-size: 12px;">{{ __('inkpress.buy') }}</a>
                </div>
            </div>
            @endforeach
        @endforeach
    </div>

</main>

@section('js')
<script>
    function filterByGroup(groupId) {
        // Update Buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('btn-retro');
            btn.classList.add('btn-retro-outline');
            btn.classList.remove('active');
        });
        
        // Find clicked button (simple approach)
        event.target.classList.remove('btn-retro-outline');
        event.target.classList.add('btn-retro');

        // Filter Products
        if (groupId === 'all') {
            document.querySelectorAll('.product-item').forEach(el => el.style.display = 'block');
        } else {
            document.querySelectorAll('.product-item').forEach(el => {
                if (el.classList.contains('group-' + groupId)) {
                    el.style.display = 'block';
                } else {
                    el.style.display = 'none';
                }
            });
        }
    }
</script>
@endsection

@endsection
