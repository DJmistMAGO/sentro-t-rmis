@props([
    'title' => 'Default Title',
    'backUrl' => '',
    'footer',
    'toolbar',
])

<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title">
            @if ($backUrl)
                <a href="{{ $backUrl }}" class="btn btn-sm btn-icon btn-light-primary mr-4">
                    <i class="flaticon2-left-arrow-1"></i>
                </a>
            @endif
            <h3 class="card-label">
                {{ $title }}
            </h3>
        </div>
        @isset($toolbar)
            <div class="card-toolbar">
                {{ $toolbar }}
            </div>
        @endisset
    </div>
    <div class="card-body" {{ $attributes }}>
        {{ $slot }}
    </div>
    @isset($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endisset
</div>
