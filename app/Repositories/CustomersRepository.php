<?php

namespace App\Repositories;

use App\Models\Customers;
use App\Repositories\BaseRepository;

/**
 * Class customersRepository
 * @package App\Repositories
 * @version February 3, 2022, 5:47 am UTC
*/

class customersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'country'
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
        return customers::class;
    }
}
