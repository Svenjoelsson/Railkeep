<?php

namespace App\Repositories;

use App\Models\Vendors;
use App\Repositories\BaseRepository;

/**
 * Class VendorsRepository
 * @package App\Repositories
 * @version February 3, 2022, 6:06 am UTC
*/

class VendorsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'address',
        'contact_name',
        'contact_phone',
        'contact_email'
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
        return Vendors::class;
    }
}
