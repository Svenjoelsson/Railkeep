<?php namespace Tests\Repositories;

use App\Models\serviceType;
use App\Repositories\serviceTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class serviceTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var serviceTypeRepository
     */
    protected $serviceTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->serviceTypeRepo = \App::make(serviceTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_service_type()
    {
        $serviceType = serviceType::factory()->make()->toArray();

        $createdserviceType = $this->serviceTypeRepo->create($serviceType);

        $createdserviceType = $createdserviceType->toArray();
        $this->assertArrayHasKey('id', $createdserviceType);
        $this->assertNotNull($createdserviceType['id'], 'Created serviceType must have id specified');
        $this->assertNotNull(serviceType::find($createdserviceType['id']), 'serviceType with given id must be in DB');
        $this->assertModelData($serviceType, $createdserviceType);
    }

    /**
     * @test read
     */
    public function test_read_service_type()
    {
        $serviceType = serviceType::factory()->create();

        $dbserviceType = $this->serviceTypeRepo->find($serviceType->id);

        $dbserviceType = $dbserviceType->toArray();
        $this->assertModelData($serviceType->toArray(), $dbserviceType);
    }

    /**
     * @test update
     */
    public function test_update_service_type()
    {
        $serviceType = serviceType::factory()->create();
        $fakeserviceType = serviceType::factory()->make()->toArray();

        $updatedserviceType = $this->serviceTypeRepo->update($fakeserviceType, $serviceType->id);

        $this->assertModelData($fakeserviceType, $updatedserviceType->toArray());
        $dbserviceType = $this->serviceTypeRepo->find($serviceType->id);
        $this->assertModelData($fakeserviceType, $dbserviceType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_service_type()
    {
        $serviceType = serviceType::factory()->create();

        $resp = $this->serviceTypeRepo->delete($serviceType->id);

        $this->assertTrue($resp);
        $this->assertNull(serviceType::find($serviceType->id), 'serviceType should not exist in DB');
    }
}
