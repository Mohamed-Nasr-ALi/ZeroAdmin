@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container">
        @include('alerts.errors')
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title text-capitalize">Create Agent</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form autocomplete="off" enctype="multipart/form-data" class="form-horizontal" method="POST"
                      action="{{ route('agents.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="full_name" class="col-sm-12 control-label text-capitalize">full name</label>

                        <div class="col-sm-12">
                            <input type="text" name="full_name" class="form-control" id="full_name"
                                   placeholder="full Name" value="{{old('full_name')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-12 control-label text-capitalize">phone</label>

                        <div class="col-sm-12">
                            <input maxlength="16" type="text" name="phone" class="form-control" id="phone"
                                   placeholder="phone" value="{{old('phone')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-12 control-label text-capitalize">email</label>

                        <div class="col-sm-12">
                            <input type="email" name="email" class="form-control" id="email"
                                   placeholder="email" value="{{old('email')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-12 control-label text-capitalize">password</label>

                        <div class="col-sm-12">
                            <input type="password" name="password" class="form-control" id="password"
                                   placeholder="password" value="{{old('password')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pin" class="col-sm-12 control-label text-capitalize">pin</label>

                        <div class="col-sm-12">
                            <input maxlength="4" minlength="4" type="text" name="pin" class="form-control" id="pin"
                                   placeholder="pin" value="{{old('pin')}}">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="type_id" class="col-sm-2 control-label text-capitalize">types</label>

                        <div class="col-sm-12">
                            <select class="form-control" name="type_id" id="type_id">
                                <option value={{null}}>--Choose Type--</option>
                                @foreach($types->all() as $type)
                                    <option value="{{$type->id}}">{{$type->type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="business_name" class="col-sm-12 control-label text-capitalize">business name</label>

                        <div class="col-sm-12">
                            <input type="text" name="business_name" class="form-control" id="business_name"
                                   placeholder="Business Name" value="{{old('business_name')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label text-capitalize">business types</label>
                        <div class="col-sm-12">
                            <input type="hidden" name="business_type" id="business_type" value="">
                            <div class="form-check d-inline-block mr-5">
                                <input class="form-check-input" type="checkbox" value="" id="POS">
                                <label class="form-check-label" for="POS">
                                    POS
                                </label>
                            </div>
                            <div class="form-check d-inline-block">
                                <input class="form-check-input" type="checkbox" value="" id="PUR">
                                <label class="form-check-label" for="PUR">
                                    PUR
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group border p-3" style="position: relative">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="client_cashback" class="col-sm-12 control-label text-capitalize">client
                                    cashback</label>


                                <input oninput="sum()" type="number" pattern="[+-]?([0-9]*[.])?[0-9]+"
                                       name="client_cashback" class="form-control" id="client_cashback"
                                       placeholder="Client Cashback">
                            </div>

                            <div class="col-sm-6">
                                <label for="zerocach_cashback" class="col-sm-12 control-label text-capitalize">zerocash
                                    cashback</label>


                                <input oninput="sum()" type="number" pattern="[+-]?([0-9]*[.])?[0-9]+"
                                       name="zerocach_cashback" class="form-control" id="zerocach_cashback"
                                       placeholder="Zerocach cashback">
                            </div>
                            <div style="position: absolute;top: 0;right: 0;"
                                 class="badge badge-success text-capitalize">
                                total cashback :- <span id="total_cashback">0.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cashback" class="col-sm-12 control-label text-capitalize">business logo</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control" name="business_logo" id="business_logo">
                            <div class="form-group">
                                <img style="height: 100px;" class="img-thumbnail image-preview" alt="..." src="">
                            </div>
                        </div>
                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-info pull-right">create</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <!-- Scripts -->
        <script src="{{ asset('js/admin/agents/create.js')}}"></script>
    @endpush
@endsection
