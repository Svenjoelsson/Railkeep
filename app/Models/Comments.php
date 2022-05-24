<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comments extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'comments';
    protected $dates = ['deleted_at'];

    public $fillable = [
        'model_type',
        'model_id',
        'comment',
        'created_by',
    ];

        /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'model_id' => 'string',
        'model_type' => 'string',
        'comment' => 'string',
        'created_by' => 'string',
        'created_at' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
}
