<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\testOne;

class testOneApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_test_one()
    {
        $testOne = testOne::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/test_ones', $testOne
        );

        $this->assertApiResponse($testOne);
    }

    /**
     * @test
     */
    public function test_read_test_one()
    {
        $testOne = testOne::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/test_ones/'.$testOne->id
        );

        $this->assertApiResponse($testOne->toArray());
    }

    /**
     * @test
     */
    public function test_update_test_one()
    {
        $testOne = testOne::factory()->create();
        $editedtestOne = testOne::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/test_ones/'.$testOne->id,
            $editedtestOne
        );

        $this->assertApiResponse($editedtestOne);
    }

    /**
     * @test
     */
    public function test_delete_test_one()
    {
        $testOne = testOne::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/test_ones/'.$testOne->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/test_ones/'.$testOne->id
        );

        $this->response->assertStatus(404);
    }
}
