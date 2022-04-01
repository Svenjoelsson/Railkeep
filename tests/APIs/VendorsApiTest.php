<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Vendors;

class VendorsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_vendors()
    {
        $vendors = Vendors::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/vendors', $vendors
        );

        $this->assertApiResponse($vendors);
    }

    /**
     * @test
     */
    public function test_read_vendors()
    {
        $vendors = Vendors::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/vendors/'.$vendors->id
        );

        $this->assertApiResponse($vendors->toArray());
    }

    /**
     * @test
     */
    public function test_update_vendors()
    {
        $vendors = Vendors::factory()->create();
        $editedVendors = Vendors::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/vendors/'.$vendors->id,
            $editedVendors
        );

        $this->assertApiResponse($editedVendors);
    }

    /**
     * @test
     */
    public function test_delete_vendors()
    {
        $vendors = Vendors::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/vendors/'.$vendors->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/vendors/'.$vendors->id
        );

        $this->response->assertStatus(404);
    }
}
