<?php

namespace Database\Factories;

use App\Models\Vendors;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vendors::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'name' => $this->faker->company,
        'address' => $this->faker->address,
        'contact_name' => $this->faker->name,
        'contact_phone' => $this->faker->phonenumber,
        'contact_email' => $this->faker->email
        ];
    }
}
