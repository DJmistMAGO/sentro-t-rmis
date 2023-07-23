@if (session('success'))
    <div class="alert alert-custom alert-success d-flex justify-content-start" role="alert">
        <div class="alert-icon me-2"><i class="fa fa-check"></i></div>
        <div class="alert-text">{{ session('success') }}</div>
    </div>
@endif
