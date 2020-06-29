<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\FriendRequests\FriendRequest;
use App\Repositories\Eloquent\FriendRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class FriendController extends Controller
{
    private $friendRepository;

    public const indexRoute = 'friends.index';
    private $messages = [
        'add' => 'add success',
        'update' => 'update success',
        'delete' => 'delete done!'
    ];
    private $views = [
        'index_page'=>'admin.friends.index',
        'create_page'=>'admin.friends.create',
        'update_page'=>'admin.friends.update'
    ];
    public function __construct(FriendRepository $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }
    /**
     * Display a listing of the resource.
     *
     *  @return Factory|View
     */
    public function index()
    {
        //
        $friends = $this->friendRepository->all();
        return view($this->views['index_page'],compact('friends'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *  @return Factory|View
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FriendRequest $request
     */
    public function store(FriendRequest $request)
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
        $friend= $this->friendRepository->show($id);
        return view($this->views['update_page'],compact('friend'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FriendRequest $request
     * @param  int  $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(FriendRequest $request, $id)
    {
        //
        $validated = $request->validated();
        $this->friendRepository->update($validated,$id);
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
        $this->friendRepository->delete($id);
        return redirect(route(self::indexRoute))->with('message', $this->messages['delete']);
    }
}
