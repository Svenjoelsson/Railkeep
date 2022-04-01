<?php namespace Tests\Repositories;

use App\Models\Units;
use App\Repositories\UnitsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UnitsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UnitsRepository
     */
    protected $unitsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->unitsRepo = \App::make(UnitsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_units()
    {
        $units = Units::factory()->make()->toArray();

        $createdUnits = $this->unitsRepo->create($units);

        $createdUnits = $createdUnits->toArray();
        $this->assertArrayHasKey('id', $createdUnits);
        $this->assertNotNull($createdUnits['id'], 'Created Units must have id specified');
        $this->assertNotNull(Units::find($createdUnits['id']), 'Units with given id must be in DB');
        $this->assertModelData($units, $createdUnits);
    }

    /**
     * @test read
     */
    public function test_read_units()
    {
        $units = Units::factory()->create();

        $dbUnits = $this->unitsRepo->find($units->id);

        $dbUnits = $dbUnits->toArray();
        $this->assertModelData($units->toArray(), $dbUnits);
    }

    /**
     * @test update
     */
    public function test_update_units()
    {
        $units = Units::factory()->create();
        $fakeUnits = Units::factory()->make()->toArray();

        $updatedUnits = $this->unitsRepo->update($fakeUnits, $units->id);

        $this->assertModelData($fakeUnits, $updatedUnits->toArray());
        $dbUnits = $this->unitsRepo->find($units->id);
        $this->assertModelData($fakeUnits, $dbUnits->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_units()
    {
        $units = Units::factory()->create();

        $resp = $this->unitsRepo->delete($units->id);

        $this->assertTrue($resp);
        $this->assertNull(Units::find($units->id), 'Units should not exist in DB');
    }
}
