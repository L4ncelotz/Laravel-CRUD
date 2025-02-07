<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $species = ['สุนัข', 'แมว', 'ปลา', 'นก'];
        $dogBreeds = ['โกลเด้นรีทรีฟเวอร์', 'ชิวาวา', 'ปอมเมอเรเนียน', 'ชิสุ'];
        $catBreeds = ['เปอร์เซีย', 'สก็อตติชโฟลด์', 'เมนคูน', 'สยาม'];

        $selectedSpecies = $this->faker->randomElement($species);
        $breed = match($selectedSpecies) {
            'สุนัข' => $this->faker->randomElement($dogBreeds),
            'แมว' => $this->faker->randomElement($catBreeds),
            default => 'ทั่วไป'
        };

        return [
            'name' => $this->faker->firstName(),
            'species' => $selectedSpecies,
            'breed' => $breed,
            'age' => $this->faker->numberBetween(1, 120), // อายุเป็นเดือน
            'price' => $this->faker->randomFloat(2, 1000, 50000),
            'status' => $this->faker->randomElement(['available', 'sold']),
            'detail' => $this->faker->text(200),
            'photo' => 'pets/default.jpg',
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
