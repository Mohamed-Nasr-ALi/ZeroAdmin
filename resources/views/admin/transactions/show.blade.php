@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-2 text-center  no-padding m-t-30">
                <img src="http://rpayadmn.rpaywallet.com/images/transactions.png">
            </div>
            <div class="col-sm-10">
                <div class="col-xs-12 no-padding">
                    <ul class="list-unstyled text-capitalize">
                        <li>SUCCESS</li>
                        <li>TransactionID :-&nbsp; {{$transaction->transaction_generated_id}}</li>
                        <li>transaction title:-&nbsp; {{$transaction->title ?: ''}}</li>
                        <li>transaction amount:-&nbsp; {{$transaction->amount ?: ''}} L.E</li>
                        <li>transaction type:-&nbsp; {{$transaction->type===1 ? 'deposit': 'Withdraw'}}</li>
                        <li>transaction date:-&nbsp; {{$transaction->created_at ?: ''}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
