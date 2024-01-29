<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name,
            "address" => $this->faker->address,
            "email" => $this->faker->email,
            "phone" => $this->faker->e164PhoneNumber,
            "department_id" => $this->faker->numberBetween(1,6),
            "status" => 1, // Cambiado a un valor fijo de 1
        ];
    }
}
