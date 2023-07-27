@if ($errors->any())
    {{-- <div class="alert alert-custom alert-danger">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span><br>
            @endforeach
        </div>
    </div> --}}
    <div class="alert alert-custom alert-danger alert-dismissible fade show d-flex justify-content-start" role="alert">
        <div class="alert-icon me-2"><i class="fa fa-warning"></i></div>
        <div class="alert-text">
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span><br>
            @endforeach
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
    </div>
@endif
