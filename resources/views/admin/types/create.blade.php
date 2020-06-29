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
                <form autocomplete="off" class="form-horizontal" method="POST" action="{{ route('types.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="type_name" class="col-sm-12 control-label text-capitalize">type name</label>

                        <div class="col-sm-12">
                            <input type="text" name="type_name" class="form-control" id="type_name"
                                   placeholder="Type Name" value="{{old('type_name')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="state" class="col-sm-12 control-label text-capitalize">state</label>

                        <div class="col-sm-12">
                            <input type="number"  name="state" class="form-control" id="state"
                                   placeholder="State" value="{{old('state')}}">
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

@endsection
