<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Vendors
 * @package App\Models
 * @version February 3, 2022, 6:06 am UTC
 *
 * @property string $name
 * @property string $address
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $contact_email
 */
class Vendors extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'vendors';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'address',
        'contact_name',
        'contact_phone',
        'contact_email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'address' => 'string',
        'contact_name' => 'string',
        'contact_phone' => 'string',
        'contact_email' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
