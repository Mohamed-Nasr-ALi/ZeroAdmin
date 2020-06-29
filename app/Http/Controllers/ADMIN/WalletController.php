<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequests\WalletRequest;
use App\Repositories\Eloquent\WalletRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class WalletController extends Controller
{
    private $walletRepository;

    public const indexRoute = 'wallets.index';
    private $messages = [
        'update' => 'update success'
    ];
    private $views = [
        'index_page'=>'admin.wallets.index',
        'update_page'=>'admin.wallets.update'
    ];
    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        //
        $wallets = $this->walletRepository->all();
        return view($this->views['index_page'],compact('wallets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        //
        $wallet= $this->walletRepository->show($id);
        return view($this->views['update_page'],compact('wallet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param WalletRequest $request
     * @param  int  $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(WalletRequest $request, $id)
    {
        //
        $validated = $request->validated();
        $this->walletRepository->update($validated,$id);
        return  redirect(route(self::indexRoute))->with('message',$this->messages['update']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
