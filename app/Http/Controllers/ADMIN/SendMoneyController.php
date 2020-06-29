<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendMoneyRequests\SendMoneyRequest;
use App\Repositories\Eloquent\AgentRepository;
use App\Repositories\Eloquent\SendMoneyRepository;
use App\Repositories\Eloquent\TransactionRepository;
use App\Repositories\Eloquent\TypeRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SendMoneyController extends Controller
{
    //

    private $sendMoneyRepository;
    private $transactionRepository;
    public const indexRoute = 'send_money';
    private $messages = [
        'add' => 'add success'
    ];
    private $views = [
        'index_page'=>'admin.send_money.send'
    ];

    public function __construct(SendMoneyRepository $sendMoneyRepository,TransactionRepository $transactionRepository)
    {
        $this->sendMoneyRepository =$sendMoneyRepository;
        $this->transactionRepository =$transactionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     *  @return Factory|View
     */
    public function index()
    {
        //
        $transactions = $this->transactionRepository->all_history_transactions();
        return view($this->views['index_page'],compact('transactions'));
    }

    public function sendMoneyTransaction(SendMoneyRequest $request){
        $validated = $request->validated();
        $this->sendMoneyRepository->sendMoney($validated);
        return  redirect(route(self::indexRoute))->with('message',$this->messages['add']);
    }
}
