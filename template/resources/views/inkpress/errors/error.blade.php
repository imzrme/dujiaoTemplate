@extends('inkpress.layouts.default')

@section('content')
<div class="container" style="padding: 80px 0; display: flex; justify-content: center;">
    <div class="retro-card" style="max-width: 500px; width: 100%; text-align: center;">
        <div class="retro-card-header" style="background: var(--retro-black); color: var(--retro-white);">
            <h2 style="margin: 0; font-size: 24px;">ERROR</h2>
        </div>
        
        <div style="padding: 40px 20px;">
            <div style="font-size: 48px; margin-bottom: 24px;">:(</div>
            <h3 style="font-size: 18px; margin-bottom: 24px;">{{ $content }}</h3>
            
            @if(!$url)
                <a href="javascript:history.back(-1);" class="btn-retro" style="width: 100%; display: block; text-decoration: none;">{{ __('dujiaoka.callback') }}</a>
            @else
                <a href="{{ $url }}" class="btn-retro" style="width: 100%; display: block; text-decoration: none;">{{ __('dujiaoka.callback') }}</a>
            @endif
        </div>
    </div>
</div>
@endsection
