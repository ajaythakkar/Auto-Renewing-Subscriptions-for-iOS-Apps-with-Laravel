<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AppUser
 * @package App\Models
 * @version January 6, 2020, 10:11 am UTC
 *
 * @property string name
 * @property integer status
 */
class AppUser extends Model
{
    use SoftDeletes;

    public $table = 'app_users';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'status' => 'integer'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
