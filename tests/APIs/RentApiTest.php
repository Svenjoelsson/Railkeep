<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Rent;

class RentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_rent()
    {
        $rent = Rent::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/rents', $rent
        );

        $this->assertApiResponse($rent);
    }

    /**
     * @test
     */
    public function test_read_rent()
    {
        $rent = Rent::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/rents/'.$rent->id
        );

        $this->assertApiResponse($rent->toArray());
    }

    /**
     * @test
     */
    public function test_update_rent()
    {
        $rent = Rent::factory()->create();
        $editedRent = Rent::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/rents/'.$rent->id,
            $editedRent
        );

        $this->assertApiResponse($editedRent);
    }

    /**
     * @test
     */
    public function test_delete_rent()
    {
        $rent = Rent::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/rents/'.$rent->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/rents/'.$rent->id
        );

        $this->response->assertStatus(404);
    }
}
