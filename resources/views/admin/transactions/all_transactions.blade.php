<table class="table table-hover">
    <thead class="text-center black white-text">
    <tr>
        <th scope="col">#</th>
        <th scope="col">TransactionID</th>
        <th scope="col">Data</th>
        <th scope="col">Customer Name</th>
        <th scope="col">Phone Number</th>
        <th scope="col">Payment</th>
        <th scope="col">View</th>
    </tr>
    </thead>
    <tbody>
    @if (count($transactions)>0)
        @foreach($transactions as $index=>$transaction)
            <tr class="text-center" id="{{$transaction->id}}">
                <td>{{$transactions->firstItem() + $index}}</td>
                <td>{{$transaction->transaction_generated_id}}</td>
                <td>{{$transaction->created_at ?: 'No Date Entered'}}</td>
                <td>{{$transaction->second_user_name  ?: ''}}</td>
                <td>{{$transaction->user->phone  ?: ''}}</td>
                <td>{{$transaction->amount ?? ''}} L.E</td>
                <td><a href="{{route('show_transaction',$transaction->id)}}"
                       class="btn-sm btn-outline-primary text-capitalize">view</a>
                </td>
            </tr>
        @endforeach
        <mark class="d-inline-block mb-1">total entries:- {{$transactions->total()}}</mark>
        <mark class="d-inline-block mb-1">current page Num:- {{$transactions->currentPage()}}</mark>
    @endif
    </tbody>
</table>

<div class="row">
    <div class="col-sm-12 col-md-5">
        <div class="dataTables_info" id="dtBasicExample_info" role="status" aria-live="polite">
            <mark class="d-inline-block mb-1">showing <span>{{$transactions->firstItem()}}</span> to
                <span>{{$transactions->lastItem()}}</span> of <span>{{$transactions->total()}}</span> entries
            </mark>
        </div>
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers" id="dtBasicExample_paginate">
            <ul class="pagination">
                {{ $transactions->onEachSide(1)->links() }}
            </ul>
        </div>
    </div>
</div>
