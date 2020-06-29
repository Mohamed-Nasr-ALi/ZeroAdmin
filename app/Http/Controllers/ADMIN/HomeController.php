<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\AnalyticsRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    private $analyticsRepository;
    //
    public function __construct(AnalyticsRepository $analyticsRepository)
    {
        $this->analyticsRepository = $analyticsRepository;
    }

    public function index(){
        $topAgents=$this->analyticsRepository->topAgents(5);
        $topUsers=$this->analyticsRepository->topUsers(5);
        return view('home',compact([
            'topAgents',
            'topUsers']));
    }
    public function login_admin(Request $request){
        $request->validate([
            'email'=>'required|email|in:admin@zerocache.com',
            'password'=>'required|string|in:123456789'
        ]);
        $request->session()->put('admin_email', 'admin@zerocache.com');
        $request->session()->put('admin_password', '123456789');
        return redirect(route('home'));
    }
    public function logout_admin(Request $request){
        $request->session()->flush();
        return redirect(route('welcome_page'));
    }
    public function welcome_page(){
        if (session()->exists('admin_email')) {
            return redirect(route('home'));
        }
        return view('welcome');

    }
}
//analytics controller  IN API folder
//take data from analytics repository
//routes auth
//routes ajax return
//        $agents_count=$this->analyticsRepository->countAgents('role',1);
//        $customers_count=$this->analyticsRepository->countCustomers('role',2);
//        $transactions_count=$this->analyticsRepository->countTransactions();
//        $transactions_cc
//        $transactions_cm
//        $requests_count
