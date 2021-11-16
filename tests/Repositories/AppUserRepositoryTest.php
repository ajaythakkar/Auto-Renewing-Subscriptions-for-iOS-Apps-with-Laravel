<?php namespace Tests\Repositories;

use App\Models\AppUser;
use App\Repositories\AppUserRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AppUserRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AppUserRepository
     */
    protected $appUserRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->appUserRepo = \App::make(AppUserRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_app_user()
    {
        $appUser = factory(AppUser::class)->make()->toArray();

        $createdAppUser = $this->appUserRepo->create($appUser);

        $createdAppUser = $createdAppUser->toArray();
        $this->assertArrayHasKey('id', $createdAppUser);
        $this->assertNotNull($createdAppUser['id'], 'Created AppUser must have id specified');
        $this->assertNotNull(AppUser::find($createdAppUser['id']), 'AppUser with given id must be in DB');
        $this->assertModelData($appUser, $createdAppUser);
    }

    /**
     * @test read
     */
    public function test_read_app_user()
    {
        $appUser = factory(AppUser::class)->create();

        $dbAppUser = $this->appUserRepo->find($appUser->id);

        $dbAppUser = $dbAppUser->toArray();
        $this->assertModelData($appUser->toArray(), $dbAppUser);
    }

    /**
     * @test update
     */
    public function test_update_app_user()
    {
        $appUser = factory(AppUser::class)->create();
        $fakeAppUser = factory(AppUser::class)->make()->toArray();

        $updatedAppUser = $this->appUserRepo->update($fakeAppUser, $appUser->id);

        $this->assertModelData($fakeAppUser, $updatedAppUser->toArray());
        $dbAppUser = $this->appUserRepo->find($appUser->id);
        $this->assertModelData($fakeAppUser, $dbAppUser->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_app_user()
    {
        $appUser = factory(AppUser::class)->create();

        $resp = $this->appUserRepo->delete($appUser->id);

        $this->assertTrue($resp);
        $this->assertNull(AppUser::find($appUser->id), 'AppUser should not exist in DB');
    }
}
