<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserSubscriptionRequest;
use App\Http\Requests\UpdateUserSubscriptionRequest;
use App\Repositories\UserSubscriptionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class UserSubscriptionController extends AppBaseController
{
    /** @var  UserSubscriptionRepository */
    private $userSubscriptionRepository;

    public function __construct(UserSubscriptionRepository $userSubscriptionRepo)
    {
        $this->userSubscriptionRepository = $userSubscriptionRepo;
    }

    /**
     * Display a listing of the UserSubscription.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userSubscriptionRepository->pushCriteria(new RequestCriteria($request));
        $userSubscriptions = $this->userSubscriptionRepository->all();

        return view('user_subscriptions.index')
            ->with('userSubscriptions', $userSubscriptions);
    }

    /**
     * Show the form for creating a new UserSubscription.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_subscriptions.create');
    }

    /**
     * Store a newly created UserSubscription in storage.
     *
     * @param CreateUserSubscriptionRequest $request
     *
     * @return Response
     */
    public function store(CreateUserSubscriptionRequest $request)
    {
        $input = $request->all();

        $userSubscription = $this->userSubscriptionRepository->create($input);

        Flash::success('User Subscription saved successfully.');

        return redirect(route('userSubscriptions.index'));
    }

    /**
     * Display the specified UserSubscription.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userSubscription = $this->userSubscriptionRepository->findWithoutFail($id);

        if (empty($userSubscription)) {
            Flash::error('User Subscription not found');

            return redirect(route('userSubscriptions.index'));
        }

        return view('user_subscriptions.show')->with('userSubscription', $userSubscription);
    }

    /**
     * Show the form for editing the specified UserSubscription.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userSubscription = $this->userSubscriptionRepository->findWithoutFail($id);

        if (empty($userSubscription)) {
            Flash::error('User Subscription not found');

            return redirect(route('userSubscriptions.index'));
        }

        return view('user_subscriptions.edit')->with('userSubscription', $userSubscription);
    }

    /**
     * Update the specified UserSubscription in storage.
     *
     * @param  int              $id
     * @param UpdateUserSubscriptionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserSubscriptionRequest $request)
    {
        $userSubscription = $this->userSubscriptionRepository->findWithoutFail($id);

        if (empty($userSubscription)) {
            Flash::error('User Subscription not found');

            return redirect(route('userSubscriptions.index'));
        }

        $userSubscription = $this->userSubscriptionRepository->update($request->all(), $id);

        Flash::success('User Subscription updated successfully.');

        return redirect(route('userSubscriptions.index'));
    }

    /**
     * Remove the specified UserSubscription from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userSubscription = $this->userSubscriptionRepository->findWithoutFail($id);

        if (empty($userSubscription)) {
            Flash::error('User Subscription not found');

            return redirect(route('userSubscriptions.index'));
        }

        $this->userSubscriptionRepository->delete($id);

        Flash::success('User Subscription deleted successfully.');

        return redirect(route('userSubscriptions.index'));
    }
}
