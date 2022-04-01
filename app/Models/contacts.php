<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class contacts
 * @package App\Models
 * @version February 3, 2022, 11:13 am UTC
 *
<<<<<<< HEAD
 * @property \\App\Models\Customers $customers
=======
 * @property \App\Models\customers $customers
>>>>>>> parent of df25d446 (bug fix)
 * @property string $customer
 * @property string $name
 * @property string $phone
 * @property string $email
 */
class contacts extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'contact';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'customer',
        'name',
        'phone',
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'customer' => 'string',
        'name' => 'string',
        'phone' => 'string',
        'email' => 'string'
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
<<<<<<< HEAD
        return $this->belongsTo(\\App\Models\Customers::class);
=======
        return $this->belongsTo(\App\Models\customers::class);
>>>>>>> parent of df25d446 (bug fix)
    }
}
