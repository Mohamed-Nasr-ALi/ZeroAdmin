@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container animated fadeInUp">
        <div class="header">
            <h1>Transactions Management (CM)</h1>
        </div>
        <table class="table table-hover">
            <thead class="text-center">
            <tr class="text-capitalize">
                <th scope="col">#</th>
                <th scope="col">TransactionID</th>
                <th scope="col">Date</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Merchant Name</th>
                <th scope="col">Payment</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @if (count($cm_transactions_history)>0)
                @foreach($cm_transactions_history as $index=>$cm_transaction)
                    <tr class="text-center" id="{{$cm_transaction->id}}">
                        <td>{{$cm_transactions_history->firstItem() + $index}}</td>
                        <td>{{$cm_transaction->transaction_generated_id}}</td>
                        <td>{{$cm_transaction->created_at ?: 'No Date Entered'}}</td>
                        <td>{{$cm_transaction->first_user_name  ?: ''}}</td>
                        <td>{{$cm_transaction->second_user_name ?: ''}}</td>
                        <td>{{$cm_transaction->amount ?? ''}} L.E</td>
                        <td><a href="{{route('show_transaction',$cm_transaction->id)}}"
                               class="btn-sm btn-outline-primary text-capitalize">view</a>
                        </td>
                    </tr>
                @endforeach
                <mark class="d-inline-block mb-1">total entries:- {{$cm_transactions_history->total()}}</mark>
                <mark class="d-inline-block mb-1">current page Num:- {{$cm_transactions_history->currentPage()}}</mark>
            @endif
            </tbody>
        </table>
        <mark class="d-inline-block mb-1">showing <span>{{$cm_transactions_history->firstItem()}}</span> to
            <span>{{$cm_transactions_history->lastItem()}}</span> of <span>{{$cm_transactions_history->total()}}</span>
            entries
        </mark>
        {{ $cm_transactions_history->onEachSide(1)->links() }}
    </div>
@endsection

