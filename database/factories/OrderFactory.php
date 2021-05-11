<?php

namespace Database\Factories;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'reader_id' => $this->faker->numberBetween(1,190),
            'book_id' => $this->faker->numberBetween(1,190),
            'from' => Carbon::now(),
            'to' => Carbon::now()->addSeconds( $this->faker->numberBetween(1,20000000)),
            'created_by' => 1,
            'updated_by' => 1,
            'quantity' => 5,
            'is_done' => 0
        ];
    }
}
