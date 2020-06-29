@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container">
        @include('alerts.errors')
        <div class="box box-info">
            <div class="box-header d-flex justify-content-between">
                <h3 class="box-title text-capitalize">Update Wallet Data</h3>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
                    view user data
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">user</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ul>
                                    <li>Name: {{$wallet->user->full_name ?: 'no name'}}</li>
                                    <li>Email: {{$wallet->user->email ?: 'no email'}}</li>
                                    <li>Phone: {{$wallet->user->phone ?: 'no phone'}}</li>
                                    <li>Account Number: {{$wallet->user->account_number ?: 'empty'}}</li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
{{--                               //change friends.edit to be users.edit--}}
                                <a type="button" href="{{route('friends.edit',$wallet->user->id)}}" class="btn btn-primary">update</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form autocomplete="off" class="form-horizontal" method="POST" action="{{ route('wallets.update',$wallet->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="current_balance" class="col-sm-12 control-label text-capitalize">current balance</label>

                        <div class="col-sm-12">
                            <input type="text" name="current_balance" class="form-control" id="current_balance"
                                   placeholder="Current Balance" value="{{$wallet->current_balance}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cashback" class="col-sm-12 control-label text-capitalize">cashback</label>

                        <div class="col-sm-12">
                            <input type="text"  name="cashback" class="form-control" id="cashback"
                                   placeholder="Cashback" value="{{$wallet->cashback}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="total_spint" class="col-sm-12 control-label text-capitalize">total_spint</label>

                        <div class="col-sm-12">
                            <input type="text"  name="total_spint" class="form-control" id="total_spint"
                                   placeholder="Total Spint" value="{{$wallet->total_spint}}">
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
