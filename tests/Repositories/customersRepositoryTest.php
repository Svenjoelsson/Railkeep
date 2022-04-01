<?php namespace Tests\Repositories;

use App\Models\customers;
use App\Repositories\customersRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class customersRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var customersRepository
     */
    protected $customersRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->customersRepo = \App::make(customersRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_customers()
    {
        $customers = customers::factory()->make()->toArray();

        $createdcustomers = $this->customersRepo->create($customers);

        $createdcustomers = $createdcustomers->toArray();
        $this->assertArrayHasKey('id', $createdcustomers);
        $this->assertNotNull($createdcustomers['id'], 'Created customers must have id specified');
        $this->assertNotNull(customers::find($createdcustomers['id']), 'customers with given id must be in DB');
        $this->assertModelData($customers, $createdcustomers);
    }

    /**
     * @test read
     */
    public function test_read_customers()
    {
        $customers = customers::factory()->create();

        $dbcustomers = $this->customersRepo->find($customers->id);

        $dbcustomers = $dbcustomers->toArray();
        $this->assertModelData($customers->toArray(), $dbcustomers);
    }

    /**
     * @test update
     */
    public function test_update_customers()
    {
        $customers = customers::factory()->create();
        $fakecustomers = customers::factory()->make()->toArray();

        $updatedcustomers = $this->customersRepo->update($fakecustomers, $customers->id);

        $this->assertModelData($fakecustomers, $updatedcustomers->toArray());
        $dbcustomers = $this->customersRepo->find($customers->id);
        $this->assertModelData($fakecustomers, $dbcustomers->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_customers()
    {
        $customers = customers::factory()->create();

        $resp = $this->customersRepo->delete($customers->id);

        $this->assertTrue($resp);
        $this->assertNull(customers::find($customers->id), 'customers should not exist in DB');
    }
}
