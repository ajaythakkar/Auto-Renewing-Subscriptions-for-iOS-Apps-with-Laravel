<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserSubscription
 * @package App\Models
 * @version January 6, 2020, 10:14 am UTC
 *
 * @property integer user_id
 * @property string product_id
 * @property string environment
 * @property string original_transaction_id
 * @property string start_date
 * @property string end_date
 * @property string latest_receipt
 */
class UserSubscription extends Model
{
    use SoftDeletes;

    public $table = 'user_subscriptions';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'product_id',
        'environment',
        'original_transaction_id',
        'start_date',
        'end_date',
        'latest_receipt'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'product_id' => 'string',
        'original_transaction_id' => 'string',
        'latest_receipt' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
