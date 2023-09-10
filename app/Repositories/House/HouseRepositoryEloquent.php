<?php

namespace App\Repositories\House;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class HouseRepositoryEloquent.
 *
 * @package namespace App\Repositories\Product;
 */
class HouseRepositoryEloquent extends BaseRepository implements HouseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'LIKE',
        'bedrooms',
        'bathrooms',
        'storeys',
        'garages',
        'price' => 'between',
    ];

	/**
	 * Boot up the repository, pushing criteria
	 * @throws RepositoryException
	 */
    public function boot() {
		$this->pushCriteria(app(\App\Criteria\SearchCriteria::class));
	}

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string {
        return \App\Models\House::class;
    }

    /**
     * @param array $houses
     * @return void
     */
    public function insertHouses(array $houses): void
    {
        \DB::table('houses')->insert($houses);
    }
}
