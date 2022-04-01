<?php namespace Tests\Repositories;

use App\Models\contacts;
use App\Repositories\contactsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class contactsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var contactsRepository
     */
    protected $contactsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->contactsRepo = \App::make(contactsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_contacts()
    {
        $contacts = contacts::factory()->make()->toArray();

        $createdcontacts = $this->contactsRepo->create($contacts);

        $createdcontacts = $createdcontacts->toArray();
        $this->assertArrayHasKey('id', $createdcontacts);
        $this->assertNotNull($createdcontacts['id'], 'Created contacts must have id specified');
        $this->assertNotNull(contacts::find($createdcontacts['id']), 'contacts with given id must be in DB');
        $this->assertModelData($contacts, $createdcontacts);
    }

    /**
     * @test read
     */
    public function test_read_contacts()
    {
        $contacts = contacts::factory()->create();

        $dbcontacts = $this->contactsRepo->find($contacts->id);

        $dbcontacts = $dbcontacts->toArray();
        $this->assertModelData($contacts->toArray(), $dbcontacts);
    }

    /**
     * @test update
     */
    public function test_update_contacts()
    {
        $contacts = contacts::factory()->create();
        $fakecontacts = contacts::factory()->make()->toArray();

        $updatedcontacts = $this->contactsRepo->update($fakecontacts, $contacts->id);

        $this->assertModelData($fakecontacts, $updatedcontacts->toArray());
        $dbcontacts = $this->contactsRepo->find($contacts->id);
        $this->assertModelData($fakecontacts, $dbcontacts->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_contacts()
    {
        $contacts = contacts::factory()->create();

        $resp = $this->contactsRepo->delete($contacts->id);

        $this->assertTrue($resp);
        $this->assertNull(contacts::find($contacts->id), 'contacts should not exist in DB');
    }
}
