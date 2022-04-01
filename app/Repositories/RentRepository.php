<?php

namespace App\Repositories;

use App\Models\Rent;
use App\Repositories\BaseRepository;

/**
 * Class RentRepository
 * @package App\Repositories
 * @version February 16, 2022, 6:22 pm UTC
*/

class RentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'unit',
        'customer',
        'rentStart',
        'rentEnd'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Rent::class;
    }
}
