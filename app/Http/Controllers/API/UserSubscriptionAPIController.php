<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserSubscriptionAPIRequest;
use App\Http\Requests\API\UpdateUserSubscriptionAPIRequest;
use App\Models\AppUser;
use App\Models\UserSubscription;
use App\Models\UserToken;
use App\Repositories\UserSubscriptionRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class UserSubscriptionController
 * @package App\Http\Controllers\API
 */

class UserSubscriptionAPIController extends AppBaseController
{
    /** @var  UserSubscriptionRepository */
    private $userSubscriptionRepository;

    public function __construct(UserSubscriptionRepository $userSubscriptionRepo)
    {
        $this->userSubscriptionRepository = $userSubscriptionRepo;
    }

    /**
     * Display a listing of the UserSubscription.
     * GET|HEAD /userSubscriptions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userSubscriptionRepository->pushCriteria(new RequestCriteria($request));
        $this->userSubscriptionRepository->pushCriteria(new LimitOffsetCriteria($request));
        $userSubscriptions = $this->userSubscriptionRepository->all();

        return $this->sendResponse($userSubscriptions->toArray(), 'User Subscriptions retrieved successfully');
    }

    /**
     * Store a newly created UserSubscription in storage.
     * POST /userSubscriptions
     *
     * @param CreateUserSubscriptionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserSubscriptionAPIRequest $request)
    {
        $input = $request->all();

        $userSubscription = $this->userSubscriptionRepository->create($input);

        return $this->sendResponse($userSubscription->toArray(), 'User Subscription saved successfully');
    }

    /**
     * Display the specified UserSubscription.
     * GET|HEAD /userSubscriptions/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserSubscription $userSubscription */
        $userSubscription = $this->userSubscriptionRepository->findWithoutFail($id);

        if (empty($userSubscription)) {
            return $this->sendError('User Subscription not found');
        }

        return $this->sendResponse($userSubscription->toArray(), 'User Subscription retrieved successfully');
    }

    /**
     * Update the specified UserSubscription in storage.
     * PUT/PATCH /userSubscriptions/{id}
     *
     * @param  int $id
     * @param UpdateUserSubscriptionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserSubscriptionAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserSubscription $userSubscription */
        $userSubscription = $this->userSubscriptionRepository->findWithoutFail($id);

        if (empty($userSubscription)) {
            return $this->sendError('User Subscription not found');
        }

        $userSubscription = $this->userSubscriptionRepository->update($input, $id);

        return $this->sendResponse($userSubscription->toArray(), 'UserSubscription updated successfully');
    }

    /**
     * Remove the specified UserSubscription from storage.
     * DELETE /userSubscriptions/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserSubscription $userSubscription */
        $userSubscription = $this->userSubscriptionRepository->findWithoutFail($id);

        if (empty($userSubscription)) {
            return $this->sendError('User Subscription not found');
        }

        $userSubscription->delete();

        return $this->sendSuccess('User Subscription deleted successfully');
    }



    public function subscribe(Request $request){

        Log::info($request->all());

        //User Login First Time
        if(empty($request->original_transaction_id)){
            return $this->responseError('No Subscription');
        }

        //Check Already Subscribe
        $userSubscription = UserSubscription::where('original_transaction_id',$request->original_transaction_id)->first();

        if($userSubscription){

            //Add New User Token
            $exist = UserToken::where('device_token',$request->device_token)->first();
            if(!$exist) {

                $userToken = new UserToken();
                $userToken->user_id = $userSubscription->user_id;
                $userToken->device_token = $request->device_token;
                $userToken->save();
            }

        }else {

            $validator = Validator::make($request->all(), [
                'device_token' => 'required',
                'original_transaction_id' => 'required'

            ]);

            if ($validator->fails()) {
                Log::info($validator->messages()->first());
                return $this->responseError($validator->messages()->first());
            }

            $exist = UserToken::where('device_token',$request->device_token)->first();
            if($exist){
                $user_id = $exist->user_id;
            }else{

                //Add New User
                $user = new AppUser();
                $user->name=$request->device_token;
                $user->status=1;
                $user->save();
                $user_id = $user->id;

                //Add New User Token
                $userToken = new UserToken();
                $userToken->user_id= $user->id;
                $userToken->device_token= $request->device_token;
                $userToken->save();
            }

            $userSubscription = new UserSubscription();
            $userSubscription->user_id = $user_id;
            $userSubscription->environment = '';
            $userSubscription->original_transaction_id = $request->original_transaction_id;
            $userSubscription->product_id = '';
            $userSubscription->start_date = date('Y-m-d H:i:s');
            $userSubscription->end_date = null;
            $userSubscription->latest_receipt = '';
            $userSubscription->save();
        }

        if($userSubscription){
            $user = AppUser::where('id',$userSubscription->user_id)->first();
            if($user) {

                $expiry_date = strtotime($userSubscription->end_date);
                $now = strtotime(date('Y-m-d H:i:s'));

                if(empty($userSubscription->end_date) OR (!empty($userSubscription->end_date) AND $expiry_date>=$now) ){

                    return $this->responseWithData($userSubscription);

                }else{

                    return $this->responseError('Sorry, Your Subscription Expired !');

                }

            }else{
                return $this->responseError('No User Found !');
            }
        }else{
            return $this->responseError('No Subscription Found !');
        }

    }

    public function webhook(Request $request){


        $input=$request->json()->all();
        $original_transaction_id='';

        Log::info('---> Web Hook Start <---');
        Log::info('Notification Type:  '.$input['notification_type']);
        Log::info($input);

        //Status Remaining : DID_CHANGE_RENEWAL_STATUS,INTERACTIVE_RENEWAL
        //$input['notification_type']=="INITIAL_BUY" OR

        if($input['notification_type']=="RENEWAL" OR $input['notification_type']=="DID_CHANGE_RENEWAL_STATUS" OR $input['notification_type']=="INTERACTIVE_RENEWAL") {

            $original_transaction_id = isset($input['latest_receipt_info']['original_transaction_id'])?$input['latest_receipt_info']['original_transaction_id']:'';
            $subscription = UserSubscription::where('original_transaction_id',$original_transaction_id)->first();

            Log::info($subscription);

            if($subscription) {
                $subscription->environment = $input['environment'];
                $subscription->product_id = $input['latest_receipt_info']['product_id'];
                $subscription->start_date = date('Y-m-d H:i:s', $input['latest_receipt_info']['purchase_date_ms'] / 1000);
                Log::info("---> Auto Renew Status: ".$input['auto_renew_status']);

                if(isset($input['auto_renew_status']) AND $input['auto_renew_status']=='true'){

                    //auto_renew_status == end_date == '' unlimited (no need to update end date) change end_date if cancel only
                    $subscription->end_date = null;

                }else{

                    $subscription->end_date = date('Y-m-d H:i:s', $input['latest_receipt_info']['expires_date'] / 1000);
                }
                $subscription->save();

            }else{
                Log::info('Not Found: '.$original_transaction_id);

            }



        }elseif($input['notification_type']=="CANCEL"){

            $original_transaction_id = isset($input['latest_expired_receipt_info']['original_transaction_id'])?$input['latest_expired_receipt_info']['original_transaction_id']:'';
            $subscription = UserSubscription::where('original_transaction_id',$original_transaction_id)->first();

            if($subscription) {
                $subscription->environment = $input['environment'];
                $subscription->end_date = date('Y-m-d H:i:s', $input['cancellation_date_ms'] / 1000);
                $subscription->save();
            }else{
                Log::info('Not Found: '.$original_transaction_id);

            }
        }


        Log::info('Web Hook :-> Update: '.$original_transaction_id);
        Log::info('----> Web Hook END <----');

    }
}
