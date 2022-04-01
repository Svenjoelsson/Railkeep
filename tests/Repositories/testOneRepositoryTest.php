<?php namespace Tests\Repositories;

use App\Models\testOne;
use App\Repositories\testOneRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class testOneRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var testOneRepository
     */
    protected $testOneRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->testOneRepo = \App::make(testOneRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_test_one()
    {
        $testOne = testOne::factory()->make()->toArray();

        $createdtestOne = $this->testOneRepo->create($testOne);

        $createdtestOne = $createdtestOne->toArray();
        $this->assertArrayHasKey('id', $createdtestOne);
        $this->assertNotNull($createdtestOne['id'], 'Created testOne must have id specified');
        $this->assertNotNull(testOne::find($createdtestOne['id']), 'testOne with given id must be in DB');
        $this->assertModelData($testOne, $createdtestOne);
    }

    /**
     * @test read
     */
    public function test_read_test_one()
    {
        $testOne = testOne::factory()->create();

        $dbtestOne = $this->testOneRepo->find($testOne->id);

        $dbtestOne = $dbtestOne->toArray();
        $this->assertModelData($testOne->toArray(), $dbtestOne);
    }

    /**
     * @test update
     */
    public function test_update_test_one()
    {
        $testOne = testOne::factory()->create();
        $faketestOne = testOne::factory()->make()->toArray();

        $updatedtestOne = $this->testOneRepo->update($faketestOne, $testOne->id);

        $this->assertModelData($faketestOne, $updatedtestOne->toArray());
        $dbtestOne = $this->testOneRepo->find($testOne->id);
        $this->assertModelData($faketestOne, $dbtestOne->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_test_one()
    {
        $testOne = testOne::factory()->create();

        $resp = $this->testOneRepo->delete($testOne->id);

        $this->assertTrue($resp);
        $this->assertNull(testOne::find($testOne->id), 'testOne should not exist in DB');
    }
}
