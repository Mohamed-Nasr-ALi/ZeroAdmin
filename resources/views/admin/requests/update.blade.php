@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container">
        @include('alerts.errors')
        <div class="box box-info">
            <div class="box-header d-flex justify-content-between">
                <h3 class="box-title text-capitalize">Update Request Data</h3>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
                    view user data
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <li>Name: {{$request->user->full_name ?: 'no name'}}</li>
                                    <li>Email: {{$request->user->email ?: 'no email'}}</li>
                                    <li>Phone: {{$request->user->phone ?: 'no phone'}}</li>
                                    <li>Account Number: {{$request->user->account_number ?: 'empty'}}</li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
{{--                               //change friends.edit to be users.edit--}}
                                <a type="button" href="{{route('friends.edit',$request->user->id)}}" class="btn btn-primary">update</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form autocomplete="off" class="form-horizontal" method="POST" action="{{ route('requests.update',$request->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="title" class="col-sm-12 control-label text-capitalize">title</label>

                        <div class="col-sm-12">
                            <input type="text"  name="title" class="form-control" id="title"
                                   placeholder="Title" value="{{$request->title}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="amount" class="col-sm-12 control-label text-capitalize">amount</label>

                        <div class="col-sm-12">
                            <input type="text"  name="amount" class="form-control" id="amount"
                                   placeholder="Amount" value="{{$request->amount}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone_number" class="col-sm-12 control-label text-capitalize">phone_number</label>

                        <div class="col-sm-12">
                            <input type="text"  name="phone_number" class="form-control" id="phone_number"
                                   placeholder="Phone Number" value="{{$request->phone_number}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="state" class="col-sm-12 control-label text-capitalize">request state</label>

                        <div class="col-sm-12">
                            <input type="text" name="state" class="form-control" id="state"
                                   placeholder="Request State" value="{{$request->state}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-sm-12 control-label text-capitalize">description</label>

                        <div class="col-sm-12">
                            <textarea name="description" class="form-control" id="description"
                                      placeholder="Description" >{{Str::of($request->description)}}</textarea>
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
