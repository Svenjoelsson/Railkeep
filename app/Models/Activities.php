<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Activities
 * @package App\Models
 * @version February 4, 2022, 7:06 am UTC
 *
 * @property string $activity_type
 * @property string $activity_id
 * @property string $activity_message
 */
class Activities extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'activities';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'activity_type',
        'activity_id',
        'activity_message',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'activity_type' => 'string',
        'activity_id' => 'string',
        'activity_message' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i');
    }

    
}
