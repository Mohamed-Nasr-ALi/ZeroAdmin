<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Transaction;
use Carbon\Carbon;

class TransactionController extends Controller
{
    protected $successStatus = 200;

    public function transactions()
    {
        $transactions = Transaction::where('user_id', auth()->id())->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['success' => $transactions, 'code' => $this->successStatus], $this->successStatus);
    }

    public function showTransactionItem($id)
    {
        $transaction = Transaction::where('user_id', auth()->id())->where('id', $id)->get();
        return response()->json(['success' => $transaction, 'code' => $this->successStatus], $this->successStatus);
    }

    public function graph()
    {
        /******************** All week transactions ********************/
        $days = array();

        $date_begain =  Carbon::now()->subDays(6)->startOfDay();
        $date_end =  Carbon::now()->subDays(6)->endOfDay();
        $first_day_transactions = Transaction::where('user_id', auth()->id())->whereBetween('created_at', [$date_begain, $date_end])->get();
        array_push($days, $date_begain);

        $date_begain =  Carbon::now()->subDays(5)->startOfDay();
        $date_end =  Carbon::now()->subDays(5)->endOfDay();
        $second_day_transactions = Transaction::where('user_id', auth()->id())->whereBetween('created_at', [$date_begain, $date_end])->get();
        array_push($days, $date_begain);

        $date_begain =  Carbon::now()->subDays(4)->startOfDay();
        $date_end =  Carbon::now()->subDays(4)->endOfDay();
        $third_day_transactions = Transaction::where('user_id', auth()->id())->whereBetween('created_at', [$date_begain, $date_end])->get();
        array_push($days, $date_begain);

        $date_begain =  Carbon::now()->subDays(3)->startOfDay();
        $date_end =  Carbon::now()->subDays(3)->endOfDay();
        $fourth_day_transactions = Transaction::where('user_id', auth()->id())->whereBetween('created_at', [$date_begain, $date_end])->get();
        array_push($days, $date_begain);

        $date_begain =  Carbon::now()->subDays(2)->startOfDay();
        $date_end =  Carbon::now()->subDays(2)->endOfDay();
        $fifth_day_transactions = Transaction::where('user_id', auth()->id())->whereBetween('created_at', [$date_begain, $date_end])->get();
        array_push($days, $date_begain);

        $date_begain =  Carbon::now()->subDays(1)->startOfDay();
        $date_end =  Carbon::now()->subDays(1)->endOfDay();
        $sixth_day_transactions = Transaction::where('user_id', auth()->id())->whereBetween('created_at', [$date_begain, $date_end])->get();
        array_push($days, $date_begain);

        $date_begain =  Carbon::now()->startOfDay();
        $date_end =  Carbon::now()->endOfDay();
        $seventh_day_transactions = Transaction::where('user_id', auth()->id())->whereBetween('created_at', [$date_begain, $date_end])->get();
        array_push($days, $date_begain);

        $transactions = array(
            $first_day_transactions,
            $second_day_transactions,
            $third_day_transactions,
            $fourth_day_transactions,
            $fifth_day_transactions,
            $sixth_day_transactions,
            $seventh_day_transactions
        );
        $data = array();

        foreach ($transactions as $key1 => $transactions_of_day) {
            $day = new Carbon($days[$key1]);
            array_push($data, array($day->format('D'), 0, 0));
            foreach ($transactions_of_day as $key2 => $transaction) {
                if ($transaction->type == +1)
                    $data[$key1] = array($day->format('D'), $data[$key1][1] + $transaction->amount, $data[$key1][2]);
                else
                    $data[$key1] = array($day->format('D'), $data[$key1][1], $data[$key1][2] + $transaction->amount);
            }
        }

        return response()->json(['success' => $data, 'code' => $this->successStatus], $this->successStatus);
    }
}
