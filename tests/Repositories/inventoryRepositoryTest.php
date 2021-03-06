<?php namespace Tests\Repositories;

use App\Models\inventory;
use App\Repositories\inventoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class inventoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var inventoryRepository
     */
    protected $inventoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->inventoryRepo = \App::make(inventoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_inventory()
    {
        $inventory = inventory::factory()->make()->toArray();

        $createdinventory = $this->inventoryRepo->create($inventory);

        $createdinventory = $createdinventory->toArray();
        $this->assertArrayHasKey('id', $createdinventory);
        $this->assertNotNull($createdinventory['id'], 'Created inventory must have id specified');
        $this->assertNotNull(inventory::find($createdinventory['id']), 'inventory with given id must be in DB');
        $this->assertModelData($inventory, $createdinventory);
    }

    /**
     * @test read
     */
    public function test_read_inventory()
    {
        $inventory = inventory::factory()->create();

        $dbinventory = $this->inventoryRepo->find($inventory->id);

        $dbinventory = $dbinventory->toArray();
        $this->assertModelData($inventory->toArray(), $dbinventory);
    }

    /**
     * @test update
     */
    public function test_update_inventory()
    {
        $inventory = inventory::factory()->create();
        $fakeinventory = inventory::factory()->make()->toArray();

        $updatedinventory = $this->inventoryRepo->update($fakeinventory, $inventory->id);

        $this->assertModelData($fakeinventory, $updatedinventory->toArray());
        $dbinventory = $this->inventoryRepo->find($inventory->id);
        $this->assertModelData($fakeinventory, $dbinventory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_inventory()
    {
        $inventory = inventory::factory()->create();

        $resp = $this->inventoryRepo->delete($inventory->id);

        $this->assertTrue($resp);
        $this->assertNull(inventory::find($inventory->id), 'inventory should not exist in DB');
    }
}
