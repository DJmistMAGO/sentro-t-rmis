<div class="row">
    <div class="card bg-light col-md-12">
        <div class="card-header bg-light d-flex pb-0 mb-0 justify-content-between align-items-center">
            <div class="card-title">
                <h5>STOCK PRODUCTS</h5>
            </div>
            <div class="card-tool d-flex justify-content-end">
                
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-md-3 mb-2">
                        <div class="card" style="border: solid 1px">
                            <div class="card-header mx-4 p-3 text-center">
                                @php
                                    $imagePath = '/img/' . $product->image;
                                @endphp

                                @if (file_exists(public_path($imagePath)))
                                    <img src="{{ $imagePath }}" class="avatar avatar-xl me-1" alt="img">
                                @else
                                    <img src="{{ asset('assets/img/prd.webp') }}" class="avatar avatar-xl me-1"
                                        alt="img">
                                @endif
                            </div>
                            <div class="card-body pt-0 p-3 text-center">
                                <h6 class="text-center mb-0">{{ $product->product_name }}</h6>
                                <span class="text-sm">{{ $product->product_code }}</span><br>
                                <a href="#" class="text-xs">View Info.</a>
                                <hr class="horizontal dark my-2">
                                <h5 class="mb-0">{{ $product->quantity }}</h5>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        {{-- <div class="card">
                            <div class="card-body"> --}}
                        <h5 class="text-center">No Products Found</h5>
                        {{-- </div>
                        </div> --}}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
