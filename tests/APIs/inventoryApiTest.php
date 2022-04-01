<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\inventory;

class inventoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_inventory()
    {
        $inventory = inventory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/inventories', $inventory
        );

        $this->assertApiResponse($inventory);
    }

    /**
     * @test
     */
    public function test_read_inventory()
    {
        $inventory = inventory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/inventories/'.$inventory->id
        );

        $this->assertApiResponse($inventory->toArray());
    }

    /**
     * @test
     */
    public function test_update_inventory()
    {
        $inventory = inventory::factory()->create();
        $editedinventory = inventory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/inventories/'.$inventory->id,
            $editedinventory
        );

        $this->assertApiResponse($editedinventory);
    }

    /**
     * @test
     */
    public function test_delete_inventory()
    {
        $inventory = inventory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/inventories/'.$inventory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/inventories/'.$inventory->id
        );

        $this->response->assertStatus(404);
    }
}
