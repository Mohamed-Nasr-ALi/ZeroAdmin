@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container animated fadeInUp">
        <div class="header">
            <h1>Countries</h1>
        </div>
        <div class="d-flex flex-row-reverse bd-highlight">
            <a href="{{route('countries.create')}}" class="btn btn-outline-success text-capitalize">Create country</a>
        </div>
        <table class="table table-hover">
            <thead class="text-center">
            <tr class="text-capitalize">
                <th scope="col">#</th>
                <th scope="col">country name ar</th>
                <th scope="col">country name en</th>
                <th scope="col">country calling code</th>
                <th scope="col">country currency name</th>
                <th scope="col">country currency code</th>
                <th scope="col">country currency symbol</th>
                <th scope="col">country flag</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            @if (count($countries)>0)
                @foreach($countries as $index=>$country)
                    <tr class="text-center"  id="{{$country->id}}">
                        <td>{{$countries->firstItem() + $index}}</td>
                        <td>{{$country->country_name_ar ?? ''}}</td>
                        <td>{{$country->country_name_en ?? ''}}</td>
                        <td>{{$country->calling_code ?? ''}}</td>
                        <td>{{$country->currency_name ?? ''}}</td>
                        <td>{{$country->currency_code ?? ''}}</td>
                        <td>{{$country->currency_symbol ?? ''}}</td>
                        <td><img class="img-thumbnail" src="{{$country->flag ?? ''}}" alt="{{$country->country_name_en}}" width="100" height="100"></td>

                        <td><a href="{{route('countries.edit',$country->id)}}"
                               class="btn btn-outline-primary text-capitalize">update</a></td>
                        <td><!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#exampleModal-{{$country->id}}">
                                Delete
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal-{{$country->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete ?!
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('countries.destroy', $country->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger delete">Delete</button>
                                            </form><!-- end of form -->
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Cancel
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                <mark class="d-inline-block mb-1">total entries:- {{$countries->total()}}</mark>
                <mark class="d-inline-block mb-1">current page Num:- {{$countries->currentPage()}}</mark>
            @endif
            </tbody>
        </table>
        <mark class="d-inline-block mb-1">showing <span>{{$countries->firstItem()}}</span> to <span>{{$countries->lastItem()}}</span> of <span>{{$countries->total()}}</span> entries</mark>
        {{ $countries->onEachSide(1)->links() }}
    </div>
@endsection

