<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources\V1\User
 *
 * @property mixed id
 * @property mixed $name
 * @property mixed $price
 * @property mixed $created_at
 * @property mixed $bedrooms
 * @property mixed $bathrooms
 * @property mixed $storeys
 * @property mixed $garages
 */
class HouseResource extends JsonResource {

    /**
     * @var bool
     */
    public static $wrap = false;

    /**
     * @param Request $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array|\JsonSerializable|Arrayable {

        if ($this->resource instanceof LengthAwarePaginator) {
            return parent::toArray($request);
        }

        return [
            'name' => $this->name,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'storeys' => $this->storeys,
            'garages' => $this->garages,
            'price' => $this->price,
            'created_at' => $this->created_at
        ];
    }
}
