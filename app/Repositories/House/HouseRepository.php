<?php

namespace App\Repositories\House;

/**
 * Interface HouseRepository
 *
 * @package namespace App\Repositories\House;
 */
interface HouseRepository extends \Prettus\Repository\Contracts\RepositoryInterface {

    /**
     * @param array $houses
     * @return void
     */
    public function insertHouses(array $houses): void;
}
