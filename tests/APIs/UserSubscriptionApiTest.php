<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserSubscription;

class UserSubscriptionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_subscription()
    {
        $userSubscription = factory(UserSubscription::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/user_subscriptions', $userSubscription
        );

        $this->assertApiResponse($userSubscription);
    }

    /**
     * @test
     */
    public function test_read_user_subscription()
    {
        $userSubscription = factory(UserSubscription::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/user_subscriptions/'.$userSubscription->id
        );

        $this->assertApiResponse($userSubscription->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_subscription()
    {
        $userSubscription = factory(UserSubscription::class)->create();
        $editedUserSubscription = factory(UserSubscription::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/user_subscriptions/'.$userSubscription->id,
            $editedUserSubscription
        );

        $this->assertApiResponse($editedUserSubscription);
    }

    /**
     * @test
     */
    public function test_delete_user_subscription()
    {
        $userSubscription = factory(UserSubscription::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/user_subscriptions/'.$userSubscription->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/user_subscriptions/'.$userSubscription->id
        );

        $this->response->assertStatus(404);
    }
}
