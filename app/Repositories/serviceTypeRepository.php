<?php

namespace App\Repositories;

use App\Models\serviceType;
use App\Repositories\BaseRepository;

/**
 * Class serviceTypeRepository
 * @package App\Repositories
 * @version February 15, 2022, 7:18 pm UTC
*/

class serviceTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'service_type',
        'service_desc'
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
        return serviceType::class;
    }
}
