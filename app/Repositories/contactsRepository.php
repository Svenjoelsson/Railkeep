<?php

namespace App\Repositories;

use App\Models\contacts;
use App\Repositories\BaseRepository;

/**
 * Class contactsRepository
 * @package App\Repositories
 * @version February 3, 2022, 11:13 am UTC
*/

class contactsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer',
        'name',
        'phone',
        'email'
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
        return contacts::class;
    }
}
