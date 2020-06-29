<?php

namespace App\Http\Controllers\API;

use App\Country;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\CountryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    /**
     * @var CountryRepository
     */
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * Handle the incoming request.
     *
     * @return Country[]|Collection
     */
    public function __invoke()
    {
        return $this->countryRepository->get_all();
    }
}
