<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperationRequests\OperationRequest;
use App\Repositories\Eloquent\RequestRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class RequestController extends Controller
{
    private $requestRepository;

    const indexRoute = 'requests.index';
    private $messages = [
        'update' => 'update success'
    ];
    private $views = [
        'index_page'=>'admin.requests.index',
        'update_page'=>'admin.requests.update'
    ];
    public function __construct(RequestRepository $requestRepository)
    {
        $this->requestRepository = $requestRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        //
        $requests = $this->requestRepository->all();
        return view($this->views['index_page'],compact('requests'));
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
     * @param  \Illuminate\Http\Request  $request
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
        $request= $this->requestRepository->show($id);
        return view($this->views['update_page'],compact('request'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OperationRequest  $request
     * @param  int  $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(OperationRequest $request, $id)
    {
        //
        $validated = $request->validated();
        $this->requestRepository->update($validated,$id);
        return  redirect(route(self::indexRoute))->with('message',$this->messages['update']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        //
    }
}
