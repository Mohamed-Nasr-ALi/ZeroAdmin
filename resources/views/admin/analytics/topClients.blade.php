
<button data-toggle="modal" data-target="#fullHeightModalRight" type="button" class="btn btn-elegant"><i class="far fa-user pr-2" aria-hidden="true"></i>TOP CUSTOMERS</button>

<!-- Full Height Modal Right -->
<div class="modal fade right" id="fullHeightModalRight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">

    <!-- Add class .modal-full-height and then add class .modal-right (or other classes from list above) to set a position to the modal -->
    <div class="modal-dialog modal-full-height modal-right" role="document">


        <div class="modal-content">
            <div class="modal-header" style="background-color: #00c851 !important;">
                <h4 class="modal-title w-100 text-white" id="myModalLabel">TOP CUSTOMERS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (count($topUsers)>0)


                    @foreach($topUsers as $client)
                        <li class=" align-items-center list-group-item border">
             <span class="fa-stack fa-xs">
                  <i class="fas fa-square fa-stack-2x"></i>
                  <i class="fas fa-user fa-stack-1x fa-inverse"></i>
            </span>
                            <div class="text-capitalize">
                                <h4>{{$client->full_name}}</h4>
                                <span
                                    class="text-info">Total No. of Transactions : {{$client->count_transactions_for_user}}</span><br>
                                <span class="text-success">Total Transaction Amount : {{$client->count_transactions_amount}}</span>
                            </div>
                            <div>
                 <span class="fa-stack fa-xs">
                          <i class="fas fa-square fa-stack-2x"></i>
                          <i class="fas fa-mobile fa-stack-1x fa-inverse"></i>
                 </span>&nbsp;
                                <span>{{$client->phone}}</span>
                            </div>
                        </li>
                    @endforeach
                @endif
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-success" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Full Height Modal Right -->
