<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserTokenAPIRequest;
use App\Http\Requests\API\UpdateUserTokenAPIRequest;
use App\Models\UserToken;
use App\Repositories\UserTokenRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class UserTokenController
 * @package App\Http\Controllers\API
 */

class UserTokenAPIController extends AppBaseController
{
    /** @var  UserTokenRepository */
    private $userTokenRepository;

    public function __construct(UserTokenRepository $userTokenRepo)
    {
        $this->userTokenRepository = $userTokenRepo;
    }

    /**
     * Display a listing of the UserToken.
     * GET|HEAD /userTokens
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userTokenRepository->pushCriteria(new RequestCriteria($request));
        $this->userTokenRepository->pushCriteria(new LimitOffsetCriteria($request));
        $userTokens = $this->userTokenRepository->all();

        return $this->sendResponse($userTokens->toArray(), 'User Tokens retrieved successfully');
    }

    /**
     * Store a newly created UserToken in storage.
     * POST /userTokens
     *
     * @param CreateUserTokenAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserTokenAPIRequest $request)
    {
        $input = $request->all();

        $userToken = $this->userTokenRepository->create($input);

        return $this->sendResponse($userToken->toArray(), 'User Token saved successfully');
    }

    /**
     * Display the specified UserToken.
     * GET|HEAD /userTokens/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserToken $userToken */
        $userToken = $this->userTokenRepository->findWithoutFail($id);

        if (empty($userToken)) {
            return $this->sendError('User Token not found');
        }

        return $this->sendResponse($userToken->toArray(), 'User Token retrieved successfully');
    }

    /**
     * Update the specified UserToken in storage.
     * PUT/PATCH /userTokens/{id}
     *
     * @param  int $id
     * @param UpdateUserTokenAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserTokenAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserToken $userToken */
        $userToken = $this->userTokenRepository->findWithoutFail($id);

        if (empty($userToken)) {
            return $this->sendError('User Token not found');
        }

        $userToken = $this->userTokenRepository->update($input, $id);

        return $this->sendResponse($userToken->toArray(), 'UserToken updated successfully');
    }

    /**
     * Remove the specified UserToken from storage.
     * DELETE /userTokens/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserToken $userToken */
        $userToken = $this->userTokenRepository->findWithoutFail($id);

        if (empty($userToken)) {
            return $this->sendError('User Token not found');
        }

        $userToken->delete();

        return $this->sendSuccess('User Token deleted successfully');
    }
}
