<?php

namespace App\Repositories;

use App\Models\UserToken;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserTokenRepository
 * @package App\Repositories
 * @version January 6, 2020, 10:12 am UTC
 *
 * @method UserToken findWithoutFail($id, $columns = ['*'])
 * @method UserToken find($id, $columns = ['*'])
 * @method UserToken first($columns = ['*'])
*/
class UserTokenRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'device_token'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserToken::class;
    }
}
