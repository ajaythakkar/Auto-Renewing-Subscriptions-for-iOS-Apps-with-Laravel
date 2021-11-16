<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserToken;

class UserTokenApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_user_token()
    {
        $userToken = factory(UserToken::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/user_tokens', $userToken
        );

        $this->assertApiResponse($userToken);
    }

    /**
     * @test
     */
    public function test_read_user_token()
    {
        $userToken = factory(UserToken::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/user_tokens/'.$userToken->id
        );

        $this->assertApiResponse($userToken->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_token()
    {
        $userToken = factory(UserToken::class)->create();
        $editedUserToken = factory(UserToken::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/user_tokens/'.$userToken->id,
            $editedUserToken
        );

        $this->assertApiResponse($editedUserToken);
    }

    /**
     * @test
     */
    public function test_delete_user_token()
    {
        $userToken = factory(UserToken::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/user_tokens/'.$userToken->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/user_tokens/'.$userToken->id
        );

        $this->response->assertStatus(404);
    }
}
