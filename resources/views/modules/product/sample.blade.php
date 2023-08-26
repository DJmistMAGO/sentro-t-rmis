@extends('layouts.app')

@section('title')
    Sample
@endsection

@section('content')
    {{-- <x-errors></x-errors> --}}
    <x-success></x-success>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-5">
                    <x-card title="Item list" data-item-container>

                        <button type="button" class="btn btn-primary mb-3" data-add-item>Add new item</button>
                        <div class="row border rounded-sm border-primary pt-3 m-1" data-parent>
                            <div class="form-group col-md-6">
                                <label>sample input <span class="text-danger">*</span></label>
                                <input type="text" name="" id="" class="form-control form-control-sm">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Sample with delete</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" name="" />
                                    <div class="input-group-append input-group-sm d-none" data-item-hide>
                                        <button class="btn btn-danger" type="button" data-remove-item>
                                            <span class="fa fa-trash"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <x-slot:footer>
                            <button type="submit" class="btn btn-info">Create</button>
                        </x-slot:footer>
                    </x-card>
                </div>
            </div>
        </div>
    </div>
@endsection
