<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class inventory
 * @package App\Models
 * @version March 9, 2022, 6:57 pm UTC
 *
 * @property string $unit
 * @property string $partNumber
 * @property string $partName
 * @property string $usageCounter
 */
class inventory extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'inventory';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'unit',
        'partNumber',
        'partName',
        'usageCounter',
        'status',
        'batch',
        'maintenance',
        'eol',
        'dateMounted',
        'dateUnmounted'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unit' => 'string',
        'partNumber' => 'string',
        'partName' => 'string',
        'usageCounter' => 'string',
        'status' => 'string',
        'batch' => 'string',
        'maintenance' => 'string',
        'eol' => 'string',
        'dateMounted' => 'string',
        'dateUnmounted' => 'string',

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
