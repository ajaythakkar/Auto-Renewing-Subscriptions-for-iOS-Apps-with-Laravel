<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserToken
 * @package App\Models
 * @version January 6, 2020, 10:12 am UTC
 *
 * @property integer user_id
 * @property string device_token
 */
class UserToken extends Model
{
    use SoftDeletes;

    public $table = 'user_tokens';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'device_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'device_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
