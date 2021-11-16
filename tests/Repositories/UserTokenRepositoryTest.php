<?php namespace Tests\Repositories;

use App\Models\UserToken;
use App\Repositories\UserTokenRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UserTokenRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UserTokenRepository
     */
    protected $userTokenRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->userTokenRepo = \App::make(UserTokenRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_user_token()
    {
        $userToken = factory(UserToken::class)->make()->toArray();

        $createdUserToken = $this->userTokenRepo->create($userToken);

        $createdUserToken = $createdUserToken->toArray();
        $this->assertArrayHasKey('id', $createdUserToken);
        $this->assertNotNull($createdUserToken['id'], 'Created UserToken must have id specified');
        $this->assertNotNull(UserToken::find($createdUserToken['id']), 'UserToken with given id must be in DB');
        $this->assertModelData($userToken, $createdUserToken);
    }

    /**
     * @test read
     */
    public function test_read_user_token()
    {
        $userToken = factory(UserToken::class)->create();

        $dbUserToken = $this->userTokenRepo->find($userToken->id);

        $dbUserToken = $dbUserToken->toArray();
        $this->assertModelData($userToken->toArray(), $dbUserToken);
    }

    /**
     * @test update
     */
    public function test_update_user_token()
    {
        $userToken = factory(UserToken::class)->create();
        $fakeUserToken = factory(UserToken::class)->make()->toArray();

        $updatedUserToken = $this->userTokenRepo->update($fakeUserToken, $userToken->id);

        $this->assertModelData($fakeUserToken, $updatedUserToken->toArray());
        $dbUserToken = $this->userTokenRepo->find($userToken->id);
        $this->assertModelData($fakeUserToken, $dbUserToken->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_user_token()
    {
        $userToken = factory(UserToken::class)->create();

        $resp = $this->userTokenRepo->delete($userToken->id);

        $this->assertTrue($resp);
        $this->assertNull(UserToken::find($userToken->id), 'UserToken should not exist in DB');
    }
}
