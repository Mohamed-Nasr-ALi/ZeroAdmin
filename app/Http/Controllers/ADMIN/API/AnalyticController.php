<?php

namespace App\Http\Controllers\ADMIN\API;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\AnalyticsRepository;
use Illuminate\Http\Request;

class AnalyticController extends Controller
{
    //
    private $analyticsRepository;
    //
    public function __construct(AnalyticsRepository $analyticsRepository)
    {
        $this->analyticsRepository = $analyticsRepository;
    }
    public function total(){
        $agents_count=$this->analyticsRepository->countAgents('role',1);
        $customers_count=$this->analyticsRepository->countCustomers('role',2);
        $transactions_count=$this->analyticsRepository->countTransactions();
        $requests_count=$this->analyticsRepository->count_requests();
        $data = $this->analyticsRepository->history_transactions_types();
        return response()->json(['requests_count'=>$requests_count,
            'agents_count'=> $agents_count,
           'customers_count'=> $customers_count,
            'transactions_count'=>$transactions_count,
            'cc_count'=>$data[0],
            'cm_count'=>$data[1]],200);
    }
    public function TransactionsTypesCount(){
        $data = $this->analyticsRepository->history_transactions_types();
        return response()->json(['cc'=>$data[0],'cm'=>$data[1]],200);
    }
}
