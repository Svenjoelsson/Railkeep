<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Units
 * @package App\Models
 * @version February 3, 2022, 7:11 pm UTC
 *
 * @property \App\Models\Customers $customers
 * @property \App\Models\Services $services
 * @property string $unit
 * @property string $make
 * @property string $model
 * @property string $year_model
 * @property string $traction_force
 * @property string $customer
 */
class Units extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'units';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'unit',
        'make',
        'model',
        'year_model',
        'traction_force',
        'customer',
        'maintenanceType',
        'inService',
        'trackerId',
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
        'make' => 'string',
        'model' => 'string',
        'year_model' => 'string',
        'traction_force' => 'string',
        'customer' => 'string',
        'maintenanceType' => 'string',
        'inService' => 'integer',
        'trackerId' => 'string',
        'dateMounted' => 'string',
        'dateUnmounted' > 'string'
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
    public function customers()
    {
        return $this->belongsTo(\App\Models\Customers::class);
    }

    public function services()
    {
        return $this->belongsTo(\App\Models\Services::class);
    }

    public function rent() {
        return $this->hasMany(\App\Models\Rent::class);
    }
}
