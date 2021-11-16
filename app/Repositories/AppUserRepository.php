<?php

namespace App\Repositories;

use App\Models\AppUser;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class AppUserRepository
 * @package App\Repositories
 * @version January 6, 2020, 10:11 am UTC
 *
 * @method AppUser findWithoutFail($id, $columns = ['*'])
 * @method AppUser find($id, $columns = ['*'])
 * @method AppUser first($columns = ['*'])
*/
class AppUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AppUser::class;
    }
}
