<?php

namespace Database\Factories;

use App\Models\Reader;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReaderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reader::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'avatar' => 'https://i.pinimg.com/originals/d8/ca/c7/d8cac7903de22dad05d9f17ace441d97.jpg',
        ];
    }
}
