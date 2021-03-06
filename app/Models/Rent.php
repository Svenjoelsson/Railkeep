<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Rent
 * @package App\Models
 * @version February 16, 2022, 6:22 pm UTC
 *
 * @property string $unit
 * @property string $customer
 * @property string $rentStart
 * @property string $rentEnd
 */
class Rent extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'Rent';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'unit',
        'customer',
        'periodofnotice',
        'autoextension',
        'rentStart',
        'rentEnd',
        'monthlyCost',
        'counterCost',
        'currency',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unit' => 'string',
        'periodofnotice' => 'string',
        'autoextension' => 'string',
        'customer' => 'string',
        'rentStart' => 'string',
        'rentEnd' => 'string',
        'monthlyCost' => 'string',
        'counterCost' => 'string',
        'currency' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
    
    public function units() {
        return $this->belongsTo(\App\Models\Units::class);

    }
}
