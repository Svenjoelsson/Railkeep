<?php

namespace Database\Factories;

use App\Models\inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class inventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = inventory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unit' => $this->faker->word,
        'partNumber' => $this->faker->text,
        'partName' => $this->faker->word,
        'usageCounter' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
