<?php

namespace App\Http\Controllers\Api\Client\House;

use App\Http\Controllers\Controller;
use App\Http\Resources\HouseResource;
use App\Repositories\House\HouseRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IndexController extends Controller {

	/**
	 * @param HouseRepository $repository
	 * @return AnonymousResourceCollection
	 */
	public function __invoke(HouseRepository $repository): AnonymousResourceCollection
	{
		return HouseResource::collection($repository->paginate(\request()->query('per_page')));
	}
}
