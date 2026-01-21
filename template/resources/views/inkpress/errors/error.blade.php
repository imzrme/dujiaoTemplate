@extends('inkpress.layouts.default')

@section('content')
<div class="container" style="padding: 80px 20px; display: flex; justify-content: center; align-items: center;">
    <div class="retro-card" style="max-width: 500px; width: 100%; text-align: center; padding: 0; overflow: hidden; box-shadow: 8px 8px 0 var(--retro-black);">
        <div class="retro-card-header" style="background: var(--retro-black); color: var(--retro-white); margin: 0; padding: 20px; justify-content: center; border: none;">
            <h2 style="margin: 0; font-size: 24px; color: var(--retro-white);">ERROR</h2>
        </div>
        
        <div style="padding: 40px 20px;">
            <div style="font-size: 48px; margin-bottom: 24px;">:(</div>
            <h3 style="font-size: 18px; margin-bottom: 40px;">{{ $content }}</h3>
            
            @if(!$url)
                <a href="javascript:history.back(-1);" class="btn-retro" style="min-width: 150px; text-decoration: none;">{{ __('dujiaoka.callback') }}</a>
            @else
                <a href="{{ $url }}" class="btn-retro" style="min-width: 150px; text-decoration: none;">{{ __('dujiaoka.callback') }}</a>
            @endif
        </div>
    </div>
</div>
@endsection
