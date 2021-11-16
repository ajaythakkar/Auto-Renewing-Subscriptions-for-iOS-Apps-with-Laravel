<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AppUser;

class AppUserApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_app_user()
    {
        $appUser = factory(AppUser::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/app_users', $appUser
        );

        $this->assertApiResponse($appUser);
    }

    /**
     * @test
     */
    public function test_read_app_user()
    {
        $appUser = factory(AppUser::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/app_users/'.$appUser->id
        );

        $this->assertApiResponse($appUser->toArray());
    }

    /**
     * @test
     */
    public function test_update_app_user()
    {
        $appUser = factory(AppUser::class)->create();
        $editedAppUser = factory(AppUser::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/app_users/'.$appUser->id,
            $editedAppUser
        );

        $this->assertApiResponse($editedAppUser);
    }

    /**
     * @test
     */
    public function test_delete_app_user()
    {
        $appUser = factory(AppUser::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/app_users/'.$appUser->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/app_users/'.$appUser->id
        );

        $this->response->assertStatus(404);
    }
}
