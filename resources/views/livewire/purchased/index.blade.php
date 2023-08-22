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
                                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-10">Product
                                    Name</th>
                                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-10">Brand
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-10">
                                    Price</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-10">
                                    Quantity</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-10">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-sm align-middle">
                                    <img src="../assets/img/prd.webp" class="avatar avatar-sm me-1" alt="img">
                                    Product Name
                                </td>
                                <td class="text-sm align-middle">
                                    <p class="mb-0 text-sm">test product</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="mb-0 text-sm">test product</p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="mb-0 text-sm">test product</p>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="align-middle">
                                        <button class="btn btn-sm btn-success mb-0 mx-1">View</button>
                                        <button class="btn btn-sm btn-danger mb-0">Delete</button>
                                    </div>
                                </td>
                            </tr>
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
