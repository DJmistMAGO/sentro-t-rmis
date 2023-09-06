@props([
    'title' => 'Default Title',
    'backUrl' => '',
    'footer',
    'toolbar',
])

<div class="card " style="border-radius: 10px;">
    <div class="card-header border-radius-md  mb-0 pb-0">
        <div class="card-title" style="display: flex; align-items: center;">
            @if ($backUrl)
                <a href="{{ $backUrl }}" class="btn btn-sm btn-icon bg-gradient-secondary px-3 me-3">
                    <i class="fa fa-arrow-left h-5"></i>
                </a>
            @endif
            <h5 class="card-label">
                {{ $title }}
            </h5>
        </div>

        @isset($toolbar)
            <div class="card-toolbar">
                {{ $toolbar }}
            </div>
        @endisset
    </div>
    <div class="card-body pt-0 " {{ $attributes }}>
        {{ $slot }}
    </div>
    @isset($footer)
        <div class="card-footer col-md-12 d-flex justify-content-end pt-0 pb-0">
            {{ $footer }}
        </div>
    @endisset
</div>
