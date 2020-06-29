<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeRequests\TypeRequest;
use App\Repositories\Eloquent\TypeRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class TypeController extends Controller
{
    private $typeRepository;

    public const indexRoute = 'types.index';
    private $messages = [
        'add' => 'add success',
        'update' => 'update success',
        'delete' => 'delete done!'
    ];
    private $views = [
        'index_page'=>'admin.types.index',
        'create_page'=>'admin.types.create',
        'update_page'=>'admin.types.update'
    ];
    public function __construct(TypeRepository $typeRepository)
    {
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
        $types = $this->typeRepository->all();
        return view($this->views['index_page'],compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *  @return Factory|View
     */
    public function create()
    {
        //
        return view($this->views['create_page']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TypeRequest $request
     * @return RedirectResponse|Redirector
     */
    public function store(TypeRequest $request)
    {
        //
        $validated = $request->validated();
        $this->typeRepository->create($validated);
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
        $type= $this->typeRepository->show($id);
        return view($this->views['update_page'],compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TypeRequest $request
     * @param  int  $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(TypeRequest $request, $id)
    {
        //
        $validated = $request->validated();
        $this->typeRepository->update($validated,$id);
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
        $this->typeRepository->delete($id);
        return redirect(route(self::indexRoute))->with('message', $this->messages['delete']);
    }
}
