<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgentRequests\AgentRequest;
use App\Repositories\Eloquent\AgentRepository;
use App\Repositories\Eloquent\TypeRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Exception;
class AgentController extends Controller
{

    private $agentRepository;
    private $typeRepository;
    public const indexRoute = 'agents.index';
    private $messages = [
        'add' => 'add success',
        'update' => 'update success',
        'delete' => 'delete done!'
    ];
    private $views = [
        'index_page'=>'admin.agents.index',
        'create_page'=>'admin.agents.create',
        'update_page'=>'admin.agents.update'
    ];

    public function __construct(AgentRepository $agentRepository,TypeRepository $typeRepository)
    {
        $this->agentRepository = $agentRepository;
        $this->typeRepository = $typeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     *  @return Factory|View
     */
    public function index()
    {
        //
        $agents = $this->agentRepository->all();
        return view($this->views['index_page'],compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *  @return Factory|View
     */
    public function create()
    {
        //
        $types = $this->getTypes('state',1);
        return view($this->views['create_page'],compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AgentRequest $request
     * @return RedirectResponse|Redirector
     */
    public function store(AgentRequest $request)
    {
        //
        $validated = $request->validated();
        $validated= isset($validated['business_logo']) ? array_merge($validated,['business_logo'=>$this->agentRepository->uploadFile($validated['business_logo'],$validated['business_name'])]) : $validated;
        $this->agentRepository->storeUserAsAgent($validated);
        return  redirect(route(self::indexRoute))->with('message',$this->messages['add']);
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
        $types =$this->getTypes('state',1);
        $agent= $this->agentRepository->show($id);
        return view($this->views['update_page'],compact(['agent','types']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AgentRequest $request
     * @param  int  $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(AgentRequest $request, $id)
    {
        //
        $validated = $request->validated();
        $validated= isset($validated['business_logo']) ? array_merge($validated,['business_logo'=>$this->agentRepository->uploadFile($validated['business_logo'],$validated['business_name'])]) : $validated;
        $this->agentRepository->updateUserAsAgent($validated,$id,request('user_id'),request('cashback_id'));
        return  redirect(route(self::indexRoute))->with('message',$this->messages['update']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        //
        $this->agentRepository->delete($id);
        return redirect(route(self::indexRoute))->with('message', $this->messages['delete']);
    }

    private function getTypes($column,$value){
        return $this->typeRepository->specificType($column,$value);
    }
}
