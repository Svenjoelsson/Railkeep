<?php namespace Tests\Repositories;

use App\Models\Rent;
use App\Repositories\RentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var RentRepository
     */
    protected $rentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->rentRepo = \App::make(RentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_rent()
    {
        $rent = Rent::factory()->make()->toArray();

        $createdRent = $this->rentRepo->create($rent);

        $createdRent = $createdRent->toArray();
        $this->assertArrayHasKey('id', $createdRent);
        $this->assertNotNull($createdRent['id'], 'Created Rent must have id specified');
        $this->assertNotNull(Rent::find($createdRent['id']), 'Rent with given id must be in DB');
        $this->assertModelData($rent, $createdRent);
    }

    /**
     * @test read
     */
    public function test_read_rent()
    {
        $rent = Rent::factory()->create();

        $dbRent = $this->rentRepo->find($rent->id);

        $dbRent = $dbRent->toArray();
        $this->assertModelData($rent->toArray(), $dbRent);
    }

    /**
     * @test update
     */
    public function test_update_rent()
    {
        $rent = Rent::factory()->create();
        $fakeRent = Rent::factory()->make()->toArray();

        $updatedRent = $this->rentRepo->update($fakeRent, $rent->id);

        $this->assertModelData($fakeRent, $updatedRent->toArray());
        $dbRent = $this->rentRepo->find($rent->id);
        $this->assertModelData($fakeRent, $dbRent->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_rent()
    {
        $rent = Rent::factory()->create();

        $resp = $this->rentRepo->delete($rent->id);

        $this->assertTrue($resp);
        $this->assertNull(Rent::find($rent->id), 'Rent should not exist in DB');
    }
}
