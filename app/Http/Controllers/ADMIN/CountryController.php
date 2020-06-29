<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryRequests\CountryRequest;
use App\Repositories\Eloquent\CountryRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class CountryController extends Controller
{
    private $countryRepository;

    public const indexRoute = 'countries.index';
    private $messages = [
        'add' => 'add success',
        'update' => 'update success',
        'delete' => 'delete done!'
    ];
    private $views = [
        'index_page'=>'admin.countries.index',
        'create_page'=>'admin.countries.create',
        'update_page'=>'admin.countries.update'
    ];
    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     *  @return Factory|View
     */
    public function index()
    {
        //
        $countries = $this->countryRepository->all();
        return view($this->views['index_page'],compact('countries'));
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
     * @param CountryRequest $request
     * @return RedirectResponse|Redirector
     */
    public function store(CountryRequest $request)
    {
        //
        $validated = $request->validated();
        $this->countryRepository->create($validated);
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
        $country= $this->countryRepository->show($id);
        return view($this->views['update_page'],compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CountryRequest $request
     * @param  int  $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(CountryRequest $request, $id)
    {
        //
        $validated = $request->validated();
        $this->countryRepository->update($validated,$id);
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
        $this->countryRepository->delete($id);
        return redirect(route(self::indexRoute))->with('message', $this->messages['delete']);
    }
}
