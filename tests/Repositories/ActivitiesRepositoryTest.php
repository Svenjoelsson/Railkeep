<?php namespace Tests\Repositories;

use App\Models\Activities;
use App\Repositories\ActivitiesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ActivitiesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ActivitiesRepository
     */
    protected $activitiesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->activitiesRepo = \App::make(ActivitiesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_activities()
    {
        $activities = Activities::factory()->make()->toArray();

        $createdActivities = $this->activitiesRepo->create($activities);

        $createdActivities = $createdActivities->toArray();
        $this->assertArrayHasKey('id', $createdActivities);
        $this->assertNotNull($createdActivities['id'], 'Created Activities must have id specified');
        $this->assertNotNull(Activities::find($createdActivities['id']), 'Activities with given id must be in DB');
        $this->assertModelData($activities, $createdActivities);
    }

    /**
     * @test read
     */
    public function test_read_activities()
    {
        $activities = Activities::factory()->create();

        $dbActivities = $this->activitiesRepo->find($activities->id);

        $dbActivities = $dbActivities->toArray();
        $this->assertModelData($activities->toArray(), $dbActivities);
    }

    /**
     * @test update
     */
    public function test_update_activities()
    {
        $activities = Activities::factory()->create();
        $fakeActivities = Activities::factory()->make()->toArray();

        $updatedActivities = $this->activitiesRepo->update($fakeActivities, $activities->id);

        $this->assertModelData($fakeActivities, $updatedActivities->toArray());
        $dbActivities = $this->activitiesRepo->find($activities->id);
        $this->assertModelData($fakeActivities, $dbActivities->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_activities()
    {
        $activities = Activities::factory()->create();

        $resp = $this->activitiesRepo->delete($activities->id);

        $this->assertTrue($resp);
        $this->assertNull(Activities::find($activities->id), 'Activities should not exist in DB');
    }
}
