<div class="row" id="product-list">
    <div class="card col-md-12">
        <div class="card-header  d-flex pb-0 mb-0 justify-content-between align-items-center">
            <div class="card-title">
                <h5>STOCK PRODUCTS</h5>
                <span class="align-middle fw-bold">Select category:
                    <select id="categorySelect" class="form-control filter-select">
                        <option value="*">Show All</option>
                        <option value=".electrical">Electrical and Lighting</option>
                        <option value=".marine">Marine and Boating Supplies</option>
                        <option value=".home">Home Improvement Materials</option>
                        <option value=".pumps">Pumps and Plumbing Supplies</option>
                        <option value=".steel">Steel and Metal Products</option>
                        <option value=".wood">Wood and Timber Products</option>
                        <option value=".power">Power Tools and Accessories</option>
                        <option value=".paints">Paints and Coatings</option>
                        <option value=".hardware">Hardware and others</option>
                        <option value=".out-of-stock">Low/Out of Stock</option>
                    </select>
                </span>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="row grid">
                @forelse ($products as $product)
                    @php
                        $borderClass = $product->quantity <= 10 ? 'border-danger' : 'border-secondary';
                        $boxShadow = $product->quantity <= 10 ? 'rgba(248, 67, 67, 0.35) 0px 5px 15px' : 'rgba(0, 0, 0, 0.35) 0px 5px 15px';
                        $textclass = $product->quantity <= 10 ? 'text-danger' : 'text-secondary';
                        $title = $product->quantity <= 10 ? 'Low Stock' : '';
                        $out_of_stock = $product->quantity <= 10 ? 'out-of-stock' : '';
                    @endphp
                    <div class="col-md-3 mb-2 grid-item {{ $product->category }} {{ $out_of_stock }}">
                        <div class="card border {{ $borderClass }}" title="{{ $title }}"
                            style="box-shadow: {{ $boxShadow }}">
                            <div class="card-header  text-center">
                                @php
                                    $imagePath = '/img/' . $product->image;
                                @endphp

                                @if (file_exists(public_path($imagePath)))
                                    <img src="{{ $imagePath }}" class="avatar avatar-xl" alt="img">
                                @else
                                    <img src="{{ asset('assets/img/prd.webp') }}" class="avatar avatar-xl me-1"
                                        alt="img">
                                @endif
                            </div>
                            <div class="card-body pt-0  text-center">
                                <h6 class="text-center mb-0" style="text-transform: uppercase;"
                                    title="{{ $product->product_name }}">
                                    {{ Str::words($product->product_name, 2, $end = '...') }}</h6>
                                <span class="text-sm">{{ $product->product_code }}</span><br>
                                <a href="{{ route('product.show', $product->id) }}" class="text-sm">View Info <span><i
                                            class="fa fa-arrow-right" aria-hidden="true"></i></span> </a>
                                <hr class="horizontal dark my-2">
                                <h5 class="mb-0 {{ $textclass }}">{{ $product->quantity }}</h5>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12 grid-item no-match">
                        <div class="card border border-secondary" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                            <div class="card-body">
                                <h5 class="text-center">No products found for this category.</h5>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script>
        var $grid = $('.grid').isotope({
            itemSelector: '.grid-item',
            layoutMode: 'fitRows'
        });

        $('#categorySelect').on('change', function() {
            var filterValue = this.value;

            // delete appended card
            $('.grid-item.no-match').remove();

            // Check if there are any items matching the selected category
            var $matchingItems = $grid.find('.grid-item' + filterValue);

            if ($matchingItems.length > 0) {
                $('.grid-item.no-match').remove();

                // If there are matching items, apply the filter
                $grid.isotope({
                    filter: filterValue
                });
            } else {

                // hide first appended card
                $('.grid-item.no-match').hide();
                // If no items match, show the fallback card
                $grid.isotope({
                    filter: '.no-match'
                });

                $('.grid-item.no-match').show();

                // Call the callback function
                onNoMatchesFound();
            }
        });

        function onNoMatchesFound() {
            // append a new card
            var $newCard = $(
                '<div class="col-md-12 grid-item no-match"><div class="card border border-secondary" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;"><div class="card-body"><h5 class="text-center">No products found for this category.</h5></div></div></div>'
            );

            $grid.append($newCard).isotope('appended', $newCard);
        }
    </script>
@endpush
