<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'language' => Arr::random(['VIETNAMESE','ENGLISH']),
            'author' => $this->faker->name,
            'category_id' => Arr::random([1,2,3,4]),
            'description' => $this->faker->text,
            'thumbnail' => '/storage/book/6Ba2b8JQp4c4abHYHrPfv4Sxy5yraYr2KkFDgyKD.jpg',
            'quantity' => 10,
        ];
    }
}
