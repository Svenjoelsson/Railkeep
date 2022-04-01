<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class serviceType
 * @package App\Models
 * @version February 15, 2022, 7:18 pm UTC
 *
 * @property string $service_type
 * @property string $service_desc
 */
class serviceType extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'serviceType';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'service_type',
        'service_desc'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'service_type' => 'string',
        'service_desc' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
