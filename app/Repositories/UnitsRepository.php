<?php

namespace App\Repositories;

use App\Models\Units;
use App\Repositories\BaseRepository;

/**
 * Class UnitsRepository
 * @package App\Repositories
 * @version February 3, 2022, 7:11 pm UTC
*/

class UnitsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'unit',
        'make',
        'model',
        'year_model',
        'traction_force',
        'customer'
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
        return Units::class;
    }
}
