<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class serviceVendor
 * @package App\Models
 * @version February 15, 2022, 5:26 pm UTC
 *
 * @property string $serviceId
 * @property string $vendorId
 */
class serviceVendor extends Model
{

    use HasFactory;

    public $table = 'serviceVendor';
        
    public function vendors() {
        return $this->hasOne('App\Models\Vendors');
    }


    public $fillable = [
        'serviceId',
        'vendorId'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'serviceId' => 'string',
        'vendorId' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
