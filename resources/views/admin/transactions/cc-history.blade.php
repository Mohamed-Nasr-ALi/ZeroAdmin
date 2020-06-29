@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container animated fadeInUp">
        <div class="header">
            <h1>Transactions Management (CC)</h1>
        </div>
        <table class="table table-hover">
            <thead class="text-center">
            <tr class="text-capitalize">
                <th scope="col">#</th>
                <th scope="col">TransactionID</th>
                <th scope="col">Date</th>
                <th scope="col">Customer Name (Sender)</th>
                <th scope="col">Customer Name(Receiver)</th>
                <th scope="col">Payment</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @if (count($cc_transactions_history)>0)
                @foreach($cc_transactions_history as $index=>$cc_transaction)
                    <tr class="text-center" id="{{$cc_transaction->id}}">
                        <td>{{$cc_transactions_history->firstItem() + $index}}</td>
                        <td>{{$cc_transaction->transaction_generated_id}}</td>
                        <td>{{$cc_transaction->created_at ?: 'No Date Entered'}}</td>
                        <td>{{$cc_transaction->first_user_name  ?: ''}}</td>
                        <td>{{$cc_transaction->second_user_name  ?: ''}}</td>
                        <td>{{$cc_transaction->amount ?? ''}} L.E</td>
                        <td><a href="{{route('show_transaction',$cc_transaction->id)}}"
                               class="btn-sm btn-outline-primary text-capitalize">view</a>
                        </td>
                    </tr>
                @endforeach
                <mark class="d-inline-block mb-1">total entries:- {{$cc_transactions_history->total()}}</mark>
                <mark class="d-inline-block mb-1">current page Num:- {{$cc_transactions_history->currentPage()}}</mark>
            @endif
            </tbody>
        </table>
        <mark class="d-inline-block mb-1">showing <span>{{$cc_transactions_history->firstItem()}}</span> to
            <span>{{$cc_transactions_history->lastItem()}}</span> of <span>{{$cc_transactions_history->total()}}</span>
            entries
        </mark>
        {{ $cc_transactions_history->onEachSide(1)->links() }}
    </div>
@endsection

