<?php

namespace App\Repositories;

use App\Models\UserSubscription;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserSubscriptionRepository
 * @package App\Repositories
 * @version January 6, 2020, 10:14 am UTC
 *
 * @method UserSubscription findWithoutFail($id, $columns = ['*'])
 * @method UserSubscription find($id, $columns = ['*'])
 * @method UserSubscription first($columns = ['*'])
*/
class UserSubscriptionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'product_id',
        'original_transaction_id',
        'start_date',
        'end_date',
        'latest_receipt'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserSubscription::class;
    }
}
