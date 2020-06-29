@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container">
        @include('alerts.errors')
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title text-capitalize">Update Friend Data</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form autocomplete="off" class="form-horizontal" method="POST" action="{{ route('friends.update',$friend->id) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" value="{{$friend->id}}">
                    <div class="form-group">
                        <label for="full_name" class="col-sm-12 control-label text-capitalize">friend name</label>

                        <div class="col-sm-12">
                            <input type="text" name="full_name" class="form-control" id="full_name"
                                   placeholder="Friend Name" value="{{$friend->full_name}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone_number" class="col-sm-12 control-label text-capitalize">Phone</label>

                        <div class="col-sm-12">
                            <input type="text"  name="phone_number" class="form-control" id="phone_number"
                                   placeholder="Phone" value="{{$friend->phone_number}}">
                        </div>
                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary pull-right">Update</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>


@endsection
