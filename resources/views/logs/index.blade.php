@extends('layouts.app')
@livewireStyles()

@section('content')
    <x-success></x-success>
    <x-errors></x-errors>
    <div class="row">
        <div class="card col-md-12">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center ">
                <h5 class="my-0 text-uppercase">ACITIVITY LIST</h5>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive ">
                        <table class="table table-sm table-hover">
                            <thead class="thead-gray">
                                <tr>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-10">Activity</th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-10">Date Activity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ( $logs as $log )
                                <tr>
                                    <td class=" text-sm">{{$log->subject}}</td>
                                    <td class="text-center text-sm">{{$log->created_at}}</td>

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

@endsection

@livewireScripts()
