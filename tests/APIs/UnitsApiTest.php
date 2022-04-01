<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Units;

class UnitsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_units()
    {
        $units = Units::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/units', $units
        );

        $this->assertApiResponse($units);
    }

    /**
     * @test
     */
    public function test_read_units()
    {
        $units = Units::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/units/'.$units->id
        );

        $this->assertApiResponse($units->toArray());
    }

    /**
     * @test
     */
    public function test_update_units()
    {
        $units = Units::factory()->create();
        $editedUnits = Units::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/units/'.$units->id,
            $editedUnits
        );

        $this->assertApiResponse($editedUnits);
    }

    /**
     * @test
     */
    public function test_delete_units()
    {
        $units = Units::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/units/'.$units->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/units/'.$units->id
        );

        $this->response->assertStatus(404);
    }
}
