<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'InventoryLog';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'unit',
        'part',
        'comment',
        'dateMounted',
        'dateUnmounted',
        'counter',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'unit' => 'string',
        'part' => 'string',
        'comment' => 'string',
        'dateMounted' => 'string',
        'dateUnmounted' => 'string',
        'counter' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
}
