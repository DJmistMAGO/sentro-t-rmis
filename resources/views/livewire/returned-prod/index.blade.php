<div class="row">
    <div class="card bg-light col-md-12">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <h5 class="my-0 text-uppercase">PURCHASED PRODUCTS</h5>
            <div class="card-tool d-flex justify-content-end align-items-center align-middle">
                <form action="{{ route('purchased-product.index') }}" method="get">
                    @csrf
                    <div class="form-group pt-3">
                        <input class="form-control form-control-sm d-sm-none d-md-block me-3" type="search"
                            placeholder="Search..." name="search" style="width: 300px;">
                    </div>
                </form>

                <a href="{{ route('purchased-product.create') }}" class="btn btn-sm bg-gradient-info align-middle">
                    <span><i class="fa fa-plus me-1" aria-hidden="true"></i></span> Add Purchased Product</a>
            </div>
        </div>
        <div class="card-body bg-light pt-0 pb-0 pe-2 ps-2">
            <div class="row">
                <div class="table-responsive p-0 mb-0">
                    <table class="table table-sm mb-0 table-hover">
                        <thead class="thead-gray">
                            <tr>
                                <th class="text-uppercase text-center text-secondary text-sm font-weight-bolder opacity-10">Reference No.</th>
                                <th class="text-uppercase text-center text-secondary text-sm font-weight-bolder opacity-10">Prepared By</th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-10">Date Preparation</th>
                                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-10">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $returnedProdInfo as $prodPurInfo )
                            <tr>
                                <td class="text-center">{{ $prodPurInfo->reference_no }}</td>
                                <td class="text-center">{{ $prodPurInfo->prepared_by }}</td>
                                <td class="text-center">{{ $prodPurInfo->date_preparation->format('m/d/y') }}</td>
                                <td class="align-middle text-center">
                                    <div class="align-middle">
                                        <button class="btn btn-sm btn-success mb-0 mx-1">View</button>
                                        <button class="btn btn-sm btn-danger mb-0">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    No Record!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mb-0 mt-1">
                        ..
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
