<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAppUserAPIRequest;
use App\Http\Requests\API\UpdateAppUserAPIRequest;
use App\Models\AppUser;
use App\Repositories\AppUserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class AppUserController
 * @package App\Http\Controllers\API
 */

class AppUserAPIController extends AppBaseController
{
    /** @var  AppUserRepository */
    private $appUserRepository;

    public function __construct(AppUserRepository $appUserRepo)
    {
        $this->appUserRepository = $appUserRepo;
    }

    /**
     * Display a listing of the AppUser.
     * GET|HEAD /appUsers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->appUserRepository->pushCriteria(new RequestCriteria($request));
        $this->appUserRepository->pushCriteria(new LimitOffsetCriteria($request));
        $appUsers = $this->appUserRepository->all();

        return $this->sendResponse($appUsers->toArray(), 'App Users retrieved successfully');
    }

    /**
     * Store a newly created AppUser in storage.
     * POST /appUsers
     *
     * @param CreateAppUserAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAppUserAPIRequest $request)
    {
        $input = $request->all();

        $appUser = $this->appUserRepository->create($input);

        return $this->sendResponse($appUser->toArray(), 'App User saved successfully');
    }

    /**
     * Display the specified AppUser.
     * GET|HEAD /appUsers/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AppUser $appUser */
        $appUser = $this->appUserRepository->findWithoutFail($id);

        if (empty($appUser)) {
            return $this->sendError('App User not found');
        }

        return $this->sendResponse($appUser->toArray(), 'App User retrieved successfully');
    }

    /**
     * Update the specified AppUser in storage.
     * PUT/PATCH /appUsers/{id}
     *
     * @param  int $id
     * @param UpdateAppUserAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var AppUser $appUser */
        $appUser = $this->appUserRepository->findWithoutFail($id);

        if (empty($appUser)) {
            return $this->sendError('App User not found');
        }

        $appUser = $this->appUserRepository->update($input, $id);

        return $this->sendResponse($appUser->toArray(), 'AppUser updated successfully');
    }

    /**
     * Remove the specified AppUser from storage.
     * DELETE /appUsers/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AppUser $appUser */
        $appUser = $this->appUserRepository->findWithoutFail($id);

        if (empty($appUser)) {
            return $this->sendError('App User not found');
        }

        $appUser->delete();

        return $this->sendSuccess('App User deleted successfully');
    }
}
