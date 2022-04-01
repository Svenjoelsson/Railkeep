<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class makeList
 * @package App\Models
 * @version March 14, 2022, 7:24 pm UTC
 *
 * @property string $make
 * @property string $serviceName
 * @property integer $operationDays
 * @property integer $calendarDays
 * @property string $counterType
 */
class makeList extends Model
{
    use SoftDeletes;


    public $table = 'makelist';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'make',
        'serviceName',
        'operationDays',
        'calendarDays',
        'counter',
        'level',
        'counterType'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'make' => 'string',
        'serviceName' => 'string',
        'operationDays' => 'integer',
        'calendarDays' => 'integer',
        'counter' => 'integer',
        'level' => 'integer',
        'counterType' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

        /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/

    
}
