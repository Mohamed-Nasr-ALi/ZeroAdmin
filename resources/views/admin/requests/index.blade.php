@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container animated fadeInUp">
        <div class="header">
            <h1>Requests</h1>
        </div>
        <table class="table table-hover">
            <thead class="text-center">
            <tr class="text-capitalize">
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">request state</th>
                <th scope="col">request amount</th>
                <th scope="col">request title</th>
                <th scope="col">request phone</th>
                <th scope="col">update</th>
            </tr>
            </thead>
            <tbody>
            @if (count($requests)>0)
                @foreach($requests as $index=>$request)
                    <tr class="text-center"  id="{{$request->id}}">
                        <td>{{$requests->firstItem() + $index}}</td>
                        <td>{{$request->user->full_name ?? ''}}</td>
                        <td>{{$request->state === 1? 'active' : 'disactive'}}</td>
                        <td>{{$request->amount ?? ''}}</td>
                        <td>{{$request->title ?? ''}}</td>
                        <td>{{$request->phone_number ?? ''}}</td>
                        <td><a href="{{route('requests.edit',$request->id)}}"
                               class="btn btn-outline-primary text-capitalize">update</a>
                        </td>
                    </tr>
                @endforeach
                <mark class="d-inline-block mb-1">total entries:- {{$requests->total()}}</mark>
                <mark class="d-inline-block mb-1">current page Num:- {{$requests->currentPage()}}</mark>
            @endif
            </tbody>
        </table>
        <mark class="d-inline-block mb-1">showing <span>{{$requests->firstItem()}}</span> to <span>{{$requests->lastItem()}}</span> of <span>{{$requests->total()}}</span> entries</mark>
        {{ $requests->onEachSide(1)->links() }}
    </div>
@endsection

