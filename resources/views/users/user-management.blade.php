@extends('layouts.app')

@section('content')
    <div>
        @if (session('success'))
            <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                <span class="alert-text text-white">
                    {{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <i class="fa fa-close" aria-hidden="true"></i>
                </button>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">All Users</h5>
                            </div>
                            <a href="{{ route('user-management.create') }}" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">+&nbsp; New
                                User</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Name
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Contact No
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            role
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->name }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->contact_no }}</p>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $user->role }}</span>
                                            </td>
                                            <td
                                                class="text-center d-flex justify-content-center align-items-center align-middle">
                                                <a href="{{ route('user-management.view-staff', $user->id) }}"
                                                    class="mx-3 align-middle" title="Edit user">
                                                    <i class="fas fa-user-edit text-secondary"></i>
                                                </a>
                                                @if ($user->role != 'admin')
                                                    <form method="POST"
                                                        action="{{ route('user-management.reset-pass', $user) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-link m-0"
                                                            title="Reset Password">
                                                            <i class="fas fa-lock text-warning"></i>
                                                        </button>
                                                    </form>
                                                    {{-- modal toggle button --}}
                                                    <button type="button" class="btn btn-link m-0 text-danger"
                                                        data-bs-toggle="modal" title="Delete user"
                                                        data-bs-target="#deleteModal{{ $user->id }}">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        {{-- modal --}}
                                        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true"
                                            data-bs-backdrop="static">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content modal-static">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body mt-2 mb-2 text-center">
                                                        <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
                                                        <h3>Are you sure you want to delete this user?</h3>
                                                    </div>
                                                    <div class="modal-footer d-flex justify-content-center">
                                                        <button type="button" class="btn bg-gradient-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('user-management.delete', $user) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn bg-gradient-danger border border-danger shadow-lg">Yes,
                                                                Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
