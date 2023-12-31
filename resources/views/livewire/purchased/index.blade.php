<div class="row">
    <div class="card col-md-12">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center ">
            <h5 class="my-0 text-uppercase">SOLD PRODUCTS</h5>
            <div class="card-tool d-flex justify-content-end align-items-center align-middle">
                <form action="{{ route('purchased-product.index') }}" method="get">
                    @csrf
                    <div class="form-group pt-3">
                        <input class="form-control form-control-sm d-none d-md-block me-3" type="search" autofocus
                            autocomplete="off" placeholder="Search..." name="search" style="width: 300px;">
                    </div>
                </form>

                <a href="{{ route('purchased-product.create') }}" class="btn btn-sm bg-gradient-info align-middle">
                    <span><i class="fa fa-plus me-1" aria-hidden="true"></i></span> Add Sold Product</a>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-md-12 ms-auto">
                    <div class="align-middle ">
                        @if(auth()->user()->role === 'admin')
                        <form wire:submit.prevent="exportPurchasedProducts" class="">
                            <div class="form-group col-md-4">
                                <div class="input-group">
                                    <select wire:model="selectedDay" class="form-control col-md-3">
                                        <option value="">Please Select</option>
                                        <option value="today">Today</option>
                                        <option value="week">Weekly</option>
                                        <option value="month">Monthly</option>
                                        <option value="year">Yearly</option>
                                        <option value="selectDate">Select Date</option>
                                    </select>
                                    <button type="submit" class="btn bg-gradient-dark btn-sm me-1 mb-0 px-4" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Export</span>
                                        <span wire:loading wire:target="exportPurchasedProducts">Loading...</span>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group col-md-3 d-flex" id="range">
                                @if($selectedDay === 'selectDate')
                                    <input type="date" class="form-control col-md-1" wire:model="from" id="dateInputFrom">
                                    <input type="date" class="form-control col-md-1 ms-2 me-1" wire:model="to" id="dateInputTo">
                                    <button type="submit" class="btn bg-gradient-dark btn-sm mb-0 px-4" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Export</span>
                                        <span wire:loading wire:target="exportPurchasedProducts">Loading...</span>
                                    </button>
                                @endif
                            </div>
                        </form>
                        @endif

                    </div>
                    {{-- {{-- <div class="col-md-12"> --}}
                    @if (session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif
                    {{-- </div> --}}
                </div>
            </div>
            <div class="row">
                <div class="table-responsive p-0 mb-0">
                    <table class="table table-sm mb-0 table-hover">
                        <thead class="thead-gray">
                            <tr>
                                <th
                                    class="text-uppercase text-left text-secondary text-sm font-weight-bolder opacity-10">
                                    Reference No.</th>
                                <th
                                    class="text-uppercase text-center text-secondary text-sm font-weight-bolder opacity-10">
                                    Prepared By</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-10">
                                    Date of Preparation</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-10">
                                    Total Amount
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-10">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($purchaseProdInfo as $prodPurInfo)
                                <tr>
                                    <td class="text-left ps-4 text-sm">{{ $prodPurInfo->reference_no }}</td>
                                    <td class="text-center text-sm">{{ $prodPurInfo->prepared_by }}</td>
                                    <td class="text-center text-sm">
                                        {{ $prodPurInfo->date_preparation->format('M. d, Y') }}</td>
                                    <td class="text-end pe-4 text-sm">
                                        Php. {{ number_format($prodPurInfo->purchasedProducts->sum('total'), 2) }}
                                    </td>

                                    <td class="align-middle text-center">
                                        <div class="align-middle">
                                            <a href="{{ route('purchased-product.view', [$prodPurInfo]) }}"
                                                class="btn bg-gradient-success btn-sm me-1 mb-0 px-3">View</a>
                                            {{-- @if (auth()->user()->role == 'admin') --}}
                                            <a href="{{ route('purchased-product.edit', [$prodPurInfo]) }}"
                                                class="btn bg-gradient-primary btn-sm me-1 mb-0 px-3">Edit</a>
                                            @livewire('purchased.delete', ['prodPurInfo' => $prodPurInfo], key($prodPurInfo->id))
                                            {{-- @endif --}}
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
                        {{ $purchaseProdInfo->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

