<header class="retro-header">
    <div class="container">
        <!-- Logo Section -->
        <div class="retro-logo">
            <a href="/" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
                <img src="{{ picture_ulr(dujiaoka_config_get('img_logo')) }}" alt="Logo">
                <div class="retro-logo-text">{{ dujiaoka_config_get('text_logo') }}</div>
            </a>
        </div>



        <!-- Navigation -->
        <div class="retro-nav-container">
            <ul class="retro-nav">
                <li class="retro-nav-item"><a href="/">{{ __('inkpress.home') }}</a></li>
                <li class="retro-nav-item" style="position: relative;">
                    <a href="javascript:void(0);" id="support-toggle">{{ __('inkpress.contact_support') }}</a>
                    <!-- Support Dropdown (Simple manual implementation) -->
                    <div id="support-dropdown" style="display: none; position: absolute; top: 100%; left: 0; background: #FAFAFA; border: 2px solid #1A1A1A; min-width: 150px; z-index: 100;">
                        <a href="#" target="_blank" style="display: block; padding: 8px 16px; border-bottom: 1px solid #eee;">{{ __('inkpress.site_support') }}</a>
                        <a href="#" target="_blank" style="display: block; padding: 8px 16px;">{{ __('inkpress.telegram_support') }}</a>
                    </div>
                </li>
                <li class="retro-nav-item"><a href="javascript:void(0);" id="announcement-btn">{{ __('inkpress.site_announcement') }}</a></li>
                <li class="retro-nav-item"><a href="{{ url('order-search') }}">{{ __('inkpress.order_search') }}</a></li>
            </ul>
        </div>
    </div>
</header>

<!-- Announcement Modal -->
<div id="announcement-modal" class="retro-modal">
    <div class="retro-modal-content">
        <div class="retro-modal-header">
            <h3>{{ __('inkpress.site_announcement') }}</h3>
            <span class="retro-close" id="modal-close">&times;</span>
        </div>
        <div class="retro-modal-body">
            {!! dujiaoka_config_get('notice') !!}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Logic
        var modal = document.getElementById('announcement-modal');
        var btn = document.getElementById('announcement-btn');
        var close = document.getElementById('modal-close');

        btn.onclick = function() {
            modal.classList.add('show');
        }

        close.onclick = function() {
            modal.classList.remove('show');
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.classList.remove('show');
            }
        }

        // Support Dropdown Logic
        var supportBtn = document.getElementById('support-toggle');
        var supportDropdown = document.getElementById('support-dropdown');
        
        supportBtn.onclick = function(e) {
            e.stopPropagation();
            supportDropdown.style.display = supportDropdown.style.display === 'block' ? 'none' : 'block';
        }

        document.onclick = function() {
             supportDropdown.style.display = 'none';
        }
    });
</script>
