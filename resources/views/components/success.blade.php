@if (session('success'))
    <div class="alert alert-custom alert-success alert-dismissible fade show d-flex justify-content-start" role="alert">
        <div class="alert-icon me-2"><i class="fa fa-check"></i></div>
        <div class="alert-text">{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
    </div>
@endif
