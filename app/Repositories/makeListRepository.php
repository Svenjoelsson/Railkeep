<?php

namespace App\Repositories;

use App\Models\makeList;
use App\Repositories\BaseRepository;

/**
 * Class makeListRepository
 * @package App\Repositories
 * @version March 14, 2022, 7:24 pm UTC
*/

class makeListRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'make',
        'serviceName',
        'operationDays',
        'calendarDays',
        'counterType'
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
        return makeList::class;
    }
}
