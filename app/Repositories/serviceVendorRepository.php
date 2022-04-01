<?php

namespace App\Repositories;

use App\Models\serviceVendor;
use App\Repositories\BaseRepository;

/**
 * Class serviceVendorRepository
 * @package App\Repositories
 * @version February 15, 2022, 5:26 pm UTC
*/

class serviceVendorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'serviceId',
        'vendorId'
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
        return serviceVendor::class;
    }
}
