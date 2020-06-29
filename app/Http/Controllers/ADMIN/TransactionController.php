<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\TransactionRepository;

class TransactionController extends Controller
{
    //
    private $transactionRepository;

    private $views = [
        'cc_history_index_page'=>'admin.transactions.cc-history',
        'cm_history_index_page'=>'admin.transactions.cm-history',
        'show_page'=>'admin.transactions.show'
    ];
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }
    public function index_cc_history()
    {
        //
        $cc_transactions_history = $this->transactionRepository->cc_history_transactions();
        return view($this->views['cc_history_index_page'],compact('cc_transactions_history'));
    }
    public function index_cm_history()
    {
        //
        $cm_transactions_history = $this->transactionRepository->cm_history_transactions();
        return view($this->views['cm_history_index_page'],compact('cm_transactions_history'));
    }
    public function show($id){
        $transaction= $this->transactionRepository->show($id);
        return view($this->views['show_page'],compact('transaction'));
    }
}
