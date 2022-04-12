<?php

namespace App\Models;

use Eloquent as Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Services
 * @package App\Models
 * @version February 3, 2022, 7:21 pm UTC
 *
 * @property \App\Models\Units $units
 * @property \App\Models\Customers $customers
 * @property string $unit
 * @property string $customer
 * @property string $service_type
 * @property string $service_desc
 * @property string $service_date
 */
class Services extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'services';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'unit',
        'customer',
        'customerContact',
        'service_type',
        'service_desc',
        'service_date',
        'service_end',
        'nextServiceDate',
        'nextServiceCounter',
        'service_status',
        'critical',
        'remarks',
        'notPerformedActions',
        'doneDate',
        'doneCounter'
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unit' => 'string',
        'customer' => 'string',
        'customerContact' => 'string',
        'service_type' => 'string',
        'service_desc' => 'string',
        'service_date' => 'date',
        'service_end' => 'date',
        'nextServiceDate' => 'date',
        'nextServiceCounter' => 'string',
        'service_status' => 'string',
        'critical' => 'boolean',
        'remarks' => 'string',
        'notPerformedActions' => 'string',
        'doneDate' => 'date',
        'doneCounter' => 'string',
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
    public function units()
    {
        return $this->belongsTo(\App\Models\Units::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function customers()
    {
        return $this->belongsTo(\App\Models\Customers::class);
    }

    public function getServiceDateAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('Y-m-d H:i');
        } else {
            return '';
        }
    }

    public function getServiceEndAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->format('Y-m-d H:i');
        } else {
            return '';
        }
    }
}
