<?php
namespace App\Repositories\Eloquent;


use App\Agent;
use App\Repositories\Interfaces\AnalyticsInterface;
use App\Request;
use App\Transaction;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
class AnalyticsRepository implements AnalyticsInterface
{

    // model property on class instances
    protected $agents;
    protected $users;
    protected $transactions;
    protected $requests;
    // Constructor to bind model to repo
    public function __construct(Agent $agent_model,User $user_model ,Transaction $transaction_model,Request $request_model)
    {
        $this->agents = $agent_model;
        $this->users = $user_model;
        $this->transactions = $transaction_model;
        $this->requests = $request_model;
    }

    public function countCustomers($column = null, $value = null)
    {
        return $this->users->where($column,$value)->count();
    }

    public function countAgents($column = null, $value = null)
    {
        return $this->users->where($column,$value)->count();
    }

    public function countTransactions()
    {
        return $this->transactions->get()->count();
    }

    public function topUsers($take)
    {

        try {
            return DB::table('users')
                ->where('role','=',2)
                ->join('transactions', 'users.id', '=', 'transactions.user_id')
                ->select('users.id as user_id_users',
                    'users.full_name','users.phone',
                    DB::raw('COUNT(transactions.user_id) as count_transactions_for_user'),
                    DB::raw('SUM(transactions.amount) as count_transactions_amount')
                )
                ->groupBy('transactions.user_id', 'users.id')
                ->orderBy(DB::raw('COUNT(transactions.user_id)'), 'DESC')
                ->take($take)
                ->get();
        } catch (Exception $exception) {
            Log::info($exception);
            return $exception;
        }

    }

    public function topAgents($take)
    {
        try {
            return DB::table('users')
                ->where('role','=',1)
                ->join('transactions', 'users.id', '=', 'transactions.user_id')
                ->select( 'users.id as user_id_users',
                    'users.full_name','users.phone',
                    DB::raw('COUNT(transactions.user_id) as count_transactions_for_user'),
                    DB::raw('SUM(transactions.amount) as count_transactions_amount')
                )
                ->groupBy('transactions.user_id', 'users.id')
                ->orderBy(DB::raw('COUNT(transactions.user_id)'), 'DESC')
                ->take($take)
                ->get();
        } catch (Exception $exception) {
            Log::info($exception);
            return $exception;
        }


    }


    // Get all instances of transactions
    public function history_transactions_types()
    {
        $cc=$this->transactions->where('cc',1)->get()->count();
        $cm=$this->transactions->where('cc',0)->get()->count();
        return [$cc, $cm];
    }

    public function count_requests(){
        return $this->requests->all()->count();
    }
}
