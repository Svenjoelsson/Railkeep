<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Activities;

class ActivitiesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_activities()
    {
        $activities = Activities::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/activities', $activities
        );

        $this->assertApiResponse($activities);
    }

    /**
     * @test
     */
    public function test_read_activities()
    {
        $activities = Activities::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/activities/'.$activities->id
        );

        $this->assertApiResponse($activities->toArray());
    }

    /**
     * @test
     */
    public function test_update_activities()
    {
        $activities = Activities::factory()->create();
        $editedActivities = Activities::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/activities/'.$activities->id,
            $editedActivities
        );

        $this->assertApiResponse($editedActivities);
    }

    /**
     * @test
     */
    public function test_delete_activities()
    {
        $activities = Activities::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/activities/'.$activities->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/activities/'.$activities->id
        );

        $this->response->assertStatus(404);
    }
}
