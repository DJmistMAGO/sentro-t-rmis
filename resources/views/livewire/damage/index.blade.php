<div class="row">
    <div class="card col-md-12">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center ">
            <h5 class="my-0 text-uppercase">DAMAGED PRODUCTS</h5>
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
        <div class="card-body pt-0 pb-0 pe-2 ps-2">
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
                            @forelse ( $damageProd as $prodPurInfo )
                            <tr>
                                <td class="text-center text-sm">{{ $prodPurInfo->reference_no }}</td>
                                <td class="text-center text-sm">{{ $prodPurInfo->prepared_by }}</td>
                                <td class="text-center text-sm">{{ $prodPurInfo->date_preparation->format('m/d/y') }}</td>
                                <td class="align-middle text-center">
                                    <div class="align-middle">
                                        <button class="btn bg-gradient-success btn-sm  me-1 mb-0 px-3">View</button>
                                        <button class="btn bg-gradient-info btn-sm  me-1 mb-0 px-3">Edit</button>
                                        <button class="btn bg-gradient-danger btn-sm  me-1 mb-0 px-3">Delete</button>
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
