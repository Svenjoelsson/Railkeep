<?php

namespace App\Repositories;

use App\Models\AppModelsuser;
use App\Repositories\BaseRepository;

/**
 * Class AppModelsuserRepository
 * @package App\Repositories
 * @version February 3, 2022, 10:25 am UTC
*/

class AppModelsuserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token'
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
        return AppModelsuser::class;
    }
}
