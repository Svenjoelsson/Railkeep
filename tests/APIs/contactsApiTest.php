<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\contacts;

class contactsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_contacts()
    {
        $contacts = contacts::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/contacts', $contacts
        );

        $this->assertApiResponse($contacts);
    }

    /**
     * @test
     */
    public function test_read_contacts()
    {
        $contacts = contacts::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/contacts/'.$contacts->id
        );

        $this->assertApiResponse($contacts->toArray());
    }

    /**
     * @test
     */
    public function test_update_contacts()
    {
        $contacts = contacts::factory()->create();
        $editedcontacts = contacts::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/contacts/'.$contacts->id,
            $editedcontacts
        );

        $this->assertApiResponse($editedcontacts);
    }

    /**
     * @test
     */
    public function test_delete_contacts()
    {
        $contacts = contacts::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/contacts/'.$contacts->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/contacts/'.$contacts->id
        );

        $this->response->assertStatus(404);
    }
}
