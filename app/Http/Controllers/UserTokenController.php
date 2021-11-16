<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserTokenRequest;
use App\Http\Requests\UpdateUserTokenRequest;
use App\Repositories\UserTokenRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UserTokenController extends AppBaseController
{
    /** @var  UserTokenRepository */
    private $userTokenRepository;

    public function __construct(UserTokenRepository $userTokenRepo)
    {
        $this->userTokenRepository = $userTokenRepo;
    }

    /**
     * Display a listing of the UserToken.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userTokenRepository->pushCriteria(new RequestCriteria($request));
        $userTokens = $this->userTokenRepository->all();

        return view('user_tokens.index')
            ->with('userTokens', $userTokens);
    }

    /**
     * Show the form for creating a new UserToken.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_tokens.create');
    }

    /**
     * Store a newly created UserToken in storage.
     *
     * @param CreateUserTokenRequest $request
     *
     * @return Response
     */
    public function store(CreateUserTokenRequest $request)
    {
        $input = $request->all();

        $userToken = $this->userTokenRepository->create($input);

        Flash::success('User Token saved successfully.');

        return redirect(route('userTokens.index'));
    }

    /**
     * Display the specified UserToken.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userToken = $this->userTokenRepository->findWithoutFail($id);

        if (empty($userToken)) {
            Flash::error('User Token not found');

            return redirect(route('userTokens.index'));
        }

        return view('user_tokens.show')->with('userToken', $userToken);
    }

    /**
     * Show the form for editing the specified UserToken.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userToken = $this->userTokenRepository->findWithoutFail($id);

        if (empty($userToken)) {
            Flash::error('User Token not found');

            return redirect(route('userTokens.index'));
        }

        return view('user_tokens.edit')->with('userToken', $userToken);
    }

    /**
     * Update the specified UserToken in storage.
     *
     * @param  int              $id
     * @param UpdateUserTokenRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserTokenRequest $request)
    {
        $userToken = $this->userTokenRepository->findWithoutFail($id);

        if (empty($userToken)) {
            Flash::error('User Token not found');

            return redirect(route('userTokens.index'));
        }

        $userToken = $this->userTokenRepository->update($request->all(), $id);

        Flash::success('User Token updated successfully.');

        return redirect(route('userTokens.index'));
    }

    /**
     * Remove the specified UserToken from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userToken = $this->userTokenRepository->findWithoutFail($id);

        if (empty($userToken)) {
            Flash::error('User Token not found');

            return redirect(route('userTokens.index'));
        }

        $this->userTokenRepository->delete($id);

        Flash::success('User Token deleted successfully.');

        return redirect(route('userTokens.index'));
    }
}
