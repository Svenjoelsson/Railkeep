<?php namespace Tests\Repositories;

use App\Models\serviceVendor;
use App\Repositories\serviceVendorRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class serviceVendorRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var serviceVendorRepository
     */
    protected $serviceVendorRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->serviceVendorRepo = \App::make(serviceVendorRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_service_vendor()
    {
        $serviceVendor = serviceVendor::factory()->make()->toArray();

        $createdserviceVendor = $this->serviceVendorRepo->create($serviceVendor);

        $createdserviceVendor = $createdserviceVendor->toArray();
        $this->assertArrayHasKey('id', $createdserviceVendor);
        $this->assertNotNull($createdserviceVendor['id'], 'Created serviceVendor must have id specified');
        $this->assertNotNull(serviceVendor::find($createdserviceVendor['id']), 'serviceVendor with given id must be in DB');
        $this->assertModelData($serviceVendor, $createdserviceVendor);
    }

    /**
     * @test read
     */
    public function test_read_service_vendor()
    {
        $serviceVendor = serviceVendor::factory()->create();

        $dbserviceVendor = $this->serviceVendorRepo->find($serviceVendor->id);

        $dbserviceVendor = $dbserviceVendor->toArray();
        $this->assertModelData($serviceVendor->toArray(), $dbserviceVendor);
    }

    /**
     * @test update
     */
    public function test_update_service_vendor()
    {
        $serviceVendor = serviceVendor::factory()->create();
        $fakeserviceVendor = serviceVendor::factory()->make()->toArray();

        $updatedserviceVendor = $this->serviceVendorRepo->update($fakeserviceVendor, $serviceVendor->id);

        $this->assertModelData($fakeserviceVendor, $updatedserviceVendor->toArray());
        $dbserviceVendor = $this->serviceVendorRepo->find($serviceVendor->id);
        $this->assertModelData($fakeserviceVendor, $dbserviceVendor->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_service_vendor()
    {
        $serviceVendor = serviceVendor::factory()->create();

        $resp = $this->serviceVendorRepo->delete($serviceVendor->id);

        $this->assertTrue($resp);
        $this->assertNull(serviceVendor::find($serviceVendor->id), 'serviceVendor should not exist in DB');
    }
}
