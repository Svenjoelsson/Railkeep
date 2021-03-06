<?php

namespace App\Repositories;

use App\Models\inventory;
use App\Repositories\BaseRepository;

/**
 * Class inventoryRepository
 * @package App\Repositories
 * @version March 9, 2022, 6:57 pm UTC
*/

class inventoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'unit',
        'partNumber',
        'partName',
        'usageCounter'
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
        return inventory::class;
    }
}
