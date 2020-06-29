@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container">
        @include('alerts.errors')
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title text-capitalize">Create Type</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form autocomplete="off" class="form-horizontal" method="POST" action="{{ route('countries.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="country_name_ar" class="col-sm-12 control-label text-capitalize">country name ar</label>

                        <div class="col-sm-12">
                            <input type="text" name="country_name_ar" class="form-control" id="country_name_ar"
                                   placeholder="country_name_ar" value="{{old('country_name_ar')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country_name_en" class="col-sm-12 control-label text-capitalize">country name en</label>

                        <div class="col-sm-12">
                            <input type="text" name="country_name_en" class="form-control" id="country_name_en"
                                   placeholder="country_name_en" value="{{old('country_name_en')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="calling_code" class="col-sm-12 control-label text-capitalize">calling code</label>

                        <div class="col-sm-12">
                            <input type="number" name="calling_code" class="form-control" id="calling_code"
                                   placeholder="calling_code" value="{{old('calling_code')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="currency_name" class="col-sm-12 control-label text-capitalize">currency name</label>

                        <div class="col-sm-12">
                            <input type="text" name="currency_name" class="form-control" id="currency_name"
                                   placeholder="currency_name" value="{{old('currency_name')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="currency_code" class="col-sm-12 control-label text-capitalize">currency code</label>

                        <div class="col-sm-12">
                            <input type="text" name="currency_code" class="form-control" id="currency_code"
                                   placeholder="currency_code" value="{{old('currency_code')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="currency_symbol" class="col-sm-12 control-label text-capitalize">currency symbol</label>

                        <div class="col-sm-12">
                            <input type="text" name="currency_symbol" class="form-control" id="currency_symbol"
                                   placeholder="currency_symbol" value="{{old('currency_symbol')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="flag" class="col-sm-12 control-label text-capitalize">flag (paste img link for country)</label>

                        <div class="col-sm-12">
                            <input type="text" name="flag" class="form-control mb-2 d-block" id="flag"
                                   placeholder="flag" value="{{old('flag')}}">
                            <img id="img_flag" src="" alt="flag" class="img-thumbnail" height="100" width="100">
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
        <script src="{{ asset('js/admin/countries/create.js')}}"></script>
        <script src="{{ asset('js/admin/countries/update.js')}}"></script>
    @endpush
@endsection
