@if (session()->has('success-message'))
    <div class="alert alert-custom alert-notice fade show mb-5 alert-light-success" role="alert">
        <div class="alert-icon">
            <i class="flaticon-warning"></i>
        </div>
        <div class="alert-text">{{session('success-message')}}</div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">
                    <i class="ki ki-close"></i>
                </span>
            </button>
        </div>
    </div>
@elseif (session('delete-message'))
<div class="alert alert-custom alert-notice fade show mb-5 alert-light-danger" role="alert">
    <div class="alert-icon">
        <i class="flaticon-warning"></i>
    </div>
    <div class="alert-text">{{session('delete-message')}}</div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
                <i class="ki ki-close"></i>
            </span>
        </button>
    </div>
</div>
@elseif (session('update-message'))
<div class="alert alert-custom alert-notice fade show mb-5 alert-light-primary" role="alert">
    <div class="alert-icon">
        <i class="flaticon-warning"></i>
    </div>
    <div class="alert-text">{{session('update-message')}}</div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
                <i class="ki ki-close"></i>
            </span>
        </button>
    </div>
</div>
@endif


