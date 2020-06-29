@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container animated fadeInUp">
        <div class="header">
            <h1>Wallets</h1>
        </div>
        <table class="table table-hover table-responsive">
            <thead class="text-center">
            <tr class="text-capitalize">
                <th scope="col">#</th>
                <th scope="col">name</th>
                <th scope="col">email</th>
                <th scope="col">phone</th>
                <th scope="col">account_number</th>
                <th scope="col">current balance</th>
                <th scope="col">cashback</th>
                <th scope="col">total spint</th>
                <th scope="col">Edit</th>
            </tr>
            </thead>
            <tbody>
            @if (count($wallets)>0)
                @foreach($wallets as $index=>$wallet)
                    <tr class="text-center"  id="{{$wallet->id}}">
                        <td>{{$wallets->firstItem() + $index}}</td>
                        <td>{{$wallet->user->full_name ?? ''}}</td>
                        <td>{{$wallet->user->email ?? ''}}</td>
                        <td>{{$wallet->user->phone ?? ''}}</td>
                        <td>{{$wallet->user->account_number ?? ''}}</td>
                        <td>{{$wallet->current_balance ?? ''}}</td>
                        <td>{{$wallet->cashback ?? ''}}</td>
                        <td>{{$wallet->total_spint ?? ''}}</td>
                        <td><a href="{{route('wallets.edit',$wallet->id)}}"
                               class="btn btn-outline-primary text-capitalize">update</a>
                        </td>
                    </tr>
                @endforeach
                <mark class="d-inline-block mb-1">total entries:- {{$wallets->total()}}</mark>
                <mark class="d-inline-block mb-1">current page Num:- {{$wallets->currentPage()}}</mark>
            @endif
            </tbody>
        </table>
        <mark class="d-inline-block mb-1">showing <span>{{$wallets->firstItem()}}</span> to <span>{{$wallets->lastItem()}}</span> of <span>{{$wallets->total()}}</span> entries</mark>
        {{ $wallets->onEachSide(1)->links() }}
    </div>
@endsection

