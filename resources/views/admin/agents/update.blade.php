@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container">
        @include('alerts.errors')
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title text-capitalize">Update Agent</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form autocomplete="off" enctype="multipart/form-data" class="form-horizontal" method="POST"
                      action="{{ route('agents.update',$agent->id) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="agent_id" value="{{$agent->id}}">
                    <input type="hidden" name="user_id" value="{{$agent->user->id}}">
                    <input type="hidden" name="cashback_id" value="{{$agent->cashback()->first()->id}}">
                    <div class="form-group">
                        <label for="full_name" class="col-sm-12 control-label text-capitalize">full name</label>

                        <div class="col-sm-12">
                            <input type="text" name="full_name" class="form-control" id="full_name"
                                   placeholder="full Name" value="{{$agent->user->full_name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-12 control-label text-capitalize">phone</label>

                        <div class="col-sm-12">
                            <input maxlength="16" type="text" name="phone" class="form-control" id="phone"
                                   placeholder="phone" value="{{$agent->user->phone}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-12 control-label text-capitalize">email</label>

                        <div class="col-sm-12">
                            <input type="email" name="email" class="form-control" id="email"
                                   placeholder="email" value="{{$agent->user->email}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-12 control-label text-capitalize">password</label>

                        <div class="col-sm-12">
                            <input type="password" name="password" class="form-control" id="password"
                                   placeholder="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pin" class="col-sm-12 control-label text-capitalize">pin</label>

                        <div class="col-sm-12">
                            <input maxlength="4" minlength="4" readonly type="text" name="pin" class="form-control"
                                   id="pin"
                                   placeholder="pin" value="{{$agent->user->pin}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type_id" class="col-sm-2 control-label text-capitalize">types</label>

                        <div class="col-sm-12">
                            <select class="form-control" name="type_id" id="type_id">
                                <option value={{null}}>--Choose Type--</option>
                                @foreach($types->all() as $type)
                                    <option
                                        value="{{ $type->id }}" {{ ($agent->type_id === $type->id) ? "selected" : "" }}>{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="business_name" class="col-sm-12 control-label text-capitalize">business name</label>

                        <div class="col-sm-12">
                            <input type="text" name="business_name" class="form-control" id="business_name"
                                   placeholder="Business Name" value="{{$agent->business_name}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label text-capitalize">business types</label>
                        <div class="col-sm-12">
                            <input type="hidden" name="business_type" id="business_type"
                                   value="{{$agent->business_type}}">
                            @if ($agent->business_type === 1)
                                <div class="form-check d-inline-block mr-5">
                                    <input checked class="form-check-input" type="checkbox" value="" id="POS">
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
                            @elseif ($agent->business_type === -1)
                                <div class="form-check d-inline-block mr-5">
                                    <input class="form-check-input" type="checkbox" value="" id="POS">
                                    <label class="form-check-label" for="POS">
                                        POS
                                    </label>
                                </div>
                                <div class="form-check d-inline-block">
                                    <input checked class="form-check-input" type="checkbox" value="" id="PUR">
                                    <label class="form-check-label" for="PUR">
                                        PUR
                                    </label>
                                </div>
                            @else
                                <div class="form-check d-inline-block mr-5">
                                    <input checked class="form-check-input" type="checkbox" value="" id="POS">
                                    <label class="form-check-label" for="POS">
                                        POS
                                    </label>
                                </div>
                                <div class="form-check d-inline-block">
                                    <input checked class="form-check-input" type="checkbox" value="" id="PUR">
                                    <label class="form-check-label" for="PUR">
                                        PUR
                                    </label>
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="form-group border p-3" style="position: relative">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="client_cashback" class="col-sm-12 control-label text-capitalize">client
                                    cashback</label>


                                <input oninput="sum()" type="number" pattern="[+-]?([0-9]*[.])?[0-9]+"
                                       name="client_cashback" class="form-control" id="client_cashback"
                                       placeholder="Client Cashback" value="{{$agent->cashback()->first()->client_cashback}}">
                            </div>

                            <div class="col-sm-6">
                                <label for="zerocach_cashback" class="col-sm-12 control-label text-capitalize">zerocash
                                    cashback</label>


                                <input oninput="sum()" type="number" pattern="[+-]?([0-9]*[.])?[0-9]+"
                                       name="zerocach_cashback" class="form-control" id="zerocach_cashback"
                                       placeholder="Zerocach cashback" value="{{$agent->cashback()->first()->zerocach_cashback}}">
                            </div>
                            <div style="position: absolute;top: 0;right: 0;"
                                 class="badge badge-success text-capitalize">
                                total cashback :- <span id="total_cashback">{{$agent->cashback()->first()->total_cashback}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cashback" class="col-sm-12 control-label text-capitalize">business logo</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control" name="business_logo" id="business_logo">
                            <div class="form-group">
                                <img style="height: 100px;" class="img-thumbnail image-preview" alt="..."
                                     src="{{  (isset($agent->business_logo) && ($agent->business_logo !== "")) ? asset("$agent->business_logo")  :  asset('defaults/agent_business_logo.png') }}">
                            </div>
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
    @push('js')
        <!-- Scripts -->
        <script src="{{ asset('js/admin/agents/create.js')}}"></script>
    @endpush
@endsection
