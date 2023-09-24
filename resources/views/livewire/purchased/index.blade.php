<div class="row">
    <div class="card col-md-12">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center ">
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
        <div class="card-body pt-0">
            <div class="row">
                <div class="table-responsive p-0 mb-0">
                    <table class="table table-sm mb-0 table-hover">
                        <thead class="thead-gray">
                            <tr class="text-secondary text-sm font-weight-bolder opacity-10">
                                <th class="text-uppercase text-left">Reference No.</th>
                                <th class="text-uppercase text-center">Prepared By</th>
                                <th class="text-center text-uppercase">Date of Preparation</th>
                                <th class="text-center text-uppercase">Total Amount</th>
                                <th class="text-center text-uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($purchaseProdInfo as $prodPurInfo)
                                <tr>
                                    <td class="text-left ps-4 text-sm">{{ $prodPurInfo->reference_no }}</td>
                                    <td class="text-center text-sm">{{ $prodPurInfo->prepared_by }}</td>
                                    <td class="text-center text-sm">
                                        {{ $prodPurInfo->date_preparation->format('M. d, Y') }}</td>

                                    @php
                                        $total = 0;
                                        foreach ($prodPurInfo->purchasedProducts as $purchasedProduct) {
                                            $total += $purchasedProduct->total;
                                        }
                                    @endphp
                                    <td class="text-end pe-4 text-sm">
                                        {{ number_format($total, 2) }}
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="align-middle">
                                            <a href="{{ route('purchased-product.view', [$prodPurInfo]) }}"
                                                class="btn bg-gradient-success btn-sm me-1 mb-0 px-3">View</a>
                                            @if (auth()->user()->role == 'admin')
                                                <button type="button"
                                                    class="btn bg-gradient-danger btn-sm  me-1 mb-0 px-3" title="Delete"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#confirmationModal{{ $prodPurInfo->id }}">
                                                    Delete
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                {{-- modal --}}
                                <div class="modal fade" id="confirmationModal{{ $prodPurInfo->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true"
                                    data-bs-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content modal-static">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion
                                                </h5>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body mt-2 mb-2 text-center">
                                                <i class="fas fa-exclamation-triangle fa-4x text-warning"></i>
                                                <h3>Are you sure you want to delete this record?</h3>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-between">
                                                <button type="button" class="btn bg-gradient-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <form
                                                    action="{{ route('purchased-product.destroy', $prodPurInfo->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn bg-gradient-danger">Yes,
                                                        Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No Record!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mb-0 mt-1">
                        {{ $purchaseProdInfo->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
