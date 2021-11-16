<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppUserRequest;
use App\Http\Requests\UpdateAppUserRequest;
use App\Repositories\AppUserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AppUserController extends AppBaseController
{
    /** @var  AppUserRepository */
    private $appUserRepository;

    public function __construct(AppUserRepository $appUserRepo)
    {
        $this->appUserRepository = $appUserRepo;
    }

    /**
     * Display a listing of the AppUser.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->appUserRepository->pushCriteria(new RequestCriteria($request));
        $appUsers = $this->appUserRepository->all();

        return view('app_users.index')
            ->with('appUsers', $appUsers);
    }

    /**
     * Show the form for creating a new AppUser.
     *
     * @return Response
     */
    public function create()
    {
        return view('app_users.create');
    }

    /**
     * Store a newly created AppUser in storage.
     *
     * @param CreateAppUserRequest $request
     *
     * @return Response
     */
    public function store(CreateAppUserRequest $request)
    {
        $input = $request->all();

        $appUser = $this->appUserRepository->create($input);

        Flash::success('App User saved successfully.');

        return redirect(route('appUsers.index'));
    }

    /**
     * Display the specified AppUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $appUser = $this->appUserRepository->findWithoutFail($id);

        if (empty($appUser)) {
            Flash::error('App User not found');

            return redirect(route('appUsers.index'));
        }

        return view('app_users.show')->with('appUser', $appUser);
    }

    /**
     * Show the form for editing the specified AppUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $appUser = $this->appUserRepository->findWithoutFail($id);

        if (empty($appUser)) {
            Flash::error('App User not found');

            return redirect(route('appUsers.index'));
        }

        return view('app_users.edit')->with('appUser', $appUser);
    }

    /**
     * Update the specified AppUser in storage.
     *
     * @param  int              $id
     * @param UpdateAppUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppUserRequest $request)
    {
        $appUser = $this->appUserRepository->findWithoutFail($id);

        if (empty($appUser)) {
            Flash::error('App User not found');

            return redirect(route('appUsers.index'));
        }

        $appUser = $this->appUserRepository->update($request->all(), $id);

        Flash::success('App User updated successfully.');

        return redirect(route('appUsers.index'));
    }

    /**
     * Remove the specified AppUser from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $appUser = $this->appUserRepository->findWithoutFail($id);

        if (empty($appUser)) {
            Flash::error('App User not found');

            return redirect(route('appUsers.index'));
        }

        $this->appUserRepository->delete($id);

        Flash::success('App User deleted successfully.');

        return redirect(route('appUsers.index'));
    }
}
