<?php namespace Tests\Repositories;

use App\Models\Vendors;
use App\Repositories\VendorsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class VendorsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var VendorsRepository
     */
    protected $vendorsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->vendorsRepo = \App::make(VendorsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_vendors()
    {
        $vendors = Vendors::factory()->make()->toArray();

        $createdVendors = $this->vendorsRepo->create($vendors);

        $createdVendors = $createdVendors->toArray();
        $this->assertArrayHasKey('id', $createdVendors);
        $this->assertNotNull($createdVendors['id'], 'Created Vendors must have id specified');
        $this->assertNotNull(Vendors::find($createdVendors['id']), 'Vendors with given id must be in DB');
        $this->assertModelData($vendors, $createdVendors);
    }

    /**
     * @test read
     */
    public function test_read_vendors()
    {
        $vendors = Vendors::factory()->create();

        $dbVendors = $this->vendorsRepo->find($vendors->id);

        $dbVendors = $dbVendors->toArray();
        $this->assertModelData($vendors->toArray(), $dbVendors);
    }

    /**
     * @test update
     */
    public function test_update_vendors()
    {
        $vendors = Vendors::factory()->create();
        $fakeVendors = Vendors::factory()->make()->toArray();

        $updatedVendors = $this->vendorsRepo->update($fakeVendors, $vendors->id);

        $this->assertModelData($fakeVendors, $updatedVendors->toArray());
        $dbVendors = $this->vendorsRepo->find($vendors->id);
        $this->assertModelData($fakeVendors, $dbVendors->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_vendors()
    {
        $vendors = Vendors::factory()->create();

        $resp = $this->vendorsRepo->delete($vendors->id);

        $this->assertTrue($resp);
        $this->assertNull(Vendors::find($vendors->id), 'Vendors should not exist in DB');
    }
}
