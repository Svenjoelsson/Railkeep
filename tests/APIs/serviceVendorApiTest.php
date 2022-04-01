<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\serviceVendor;

class serviceVendorApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_service_vendor()
    {
        $serviceVendor = serviceVendor::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/service_vendors', $serviceVendor
        );

        $this->assertApiResponse($serviceVendor);
    }

    /**
     * @test
     */
    public function test_read_service_vendor()
    {
        $serviceVendor = serviceVendor::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/service_vendors/'.$serviceVendor->id
        );

        $this->assertApiResponse($serviceVendor->toArray());
    }

    /**
     * @test
     */
    public function test_update_service_vendor()
    {
        $serviceVendor = serviceVendor::factory()->create();
        $editedserviceVendor = serviceVendor::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/service_vendors/'.$serviceVendor->id,
            $editedserviceVendor
        );

        $this->assertApiResponse($editedserviceVendor);
    }

    /**
     * @test
     */
    public function test_delete_service_vendor()
    {
        $serviceVendor = serviceVendor::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/service_vendors/'.$serviceVendor->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/service_vendors/'.$serviceVendor->id
        );

        $this->response->assertStatus(404);
    }
}
