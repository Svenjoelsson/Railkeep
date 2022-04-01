<?php

namespace App\Repositories;

use App\Models\Activities;
use App\Repositories\BaseRepository;

/**
 * Class ActivitiesRepository
 * @package App\Repositories
 * @version February 4, 2022, 7:06 am UTC
*/

class ActivitiesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'activity_type',
        'activity_id',
        'activity_message'
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
        return Activities::class;
    }
}
