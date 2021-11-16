<?php namespace Tests\Repositories;

use App\Models\UserSubscription;
use App\Repositories\UserSubscriptionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UserSubscriptionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UserSubscriptionRepository
     */
    protected $userSubscriptionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userSubscriptionRepo = \App::make(UserSubscriptionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_subscription()
    {
        $userSubscription = factory(UserSubscription::class)->make()->toArray();

        $createdUserSubscription = $this->userSubscriptionRepo->create($userSubscription);

        $createdUserSubscription = $createdUserSubscription->toArray();
        $this->assertArrayHasKey('id', $createdUserSubscription);
        $this->assertNotNull($createdUserSubscription['id'], 'Created UserSubscription must have id specified');
        $this->assertNotNull(UserSubscription::find($createdUserSubscription['id']), 'UserSubscription with given id must be in DB');
        $this->assertModelData($userSubscription, $createdUserSubscription);
    }

    /**
     * @test read
     */
    public function test_read_user_subscription()
    {
        $userSubscription = factory(UserSubscription::class)->create();

        $dbUserSubscription = $this->userSubscriptionRepo->find($userSubscription->id);

        $dbUserSubscription = $dbUserSubscription->toArray();
        $this->assertModelData($userSubscription->toArray(), $dbUserSubscription);
    }

    /**
     * @test update
     */
    public function test_update_user_subscription()
    {
        $userSubscription = factory(UserSubscription::class)->create();
        $fakeUserSubscription = factory(UserSubscription::class)->make()->toArray();

        $updatedUserSubscription = $this->userSubscriptionRepo->update($fakeUserSubscription, $userSubscription->id);

        $this->assertModelData($fakeUserSubscription, $updatedUserSubscription->toArray());
        $dbUserSubscription = $this->userSubscriptionRepo->find($userSubscription->id);
        $this->assertModelData($fakeUserSubscription, $dbUserSubscription->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_subscription()
    {
        $userSubscription = factory(UserSubscription::class)->create();

        $resp = $this->userSubscriptionRepo->delete($userSubscription->id);

        $this->assertTrue($resp);
        $this->assertNull(UserSubscription::find($userSubscription->id), 'UserSubscription should not exist in DB');
    }
}
