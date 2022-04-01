<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class customers
 * @package App\Models
 * @version February 3, 2022, 5:47 am UTC
 *
 * @property string $name
 * @property string $country
 */
class customers extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'customers';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'country'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'country' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
