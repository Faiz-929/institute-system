<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arabicFirstNames = [
            'أحمد', 'محمد', 'علي', 'حسن', 'خالد', 'سعد', 'عبدالله', 'يوسف', 'إبراهيم', 'محمود',
            'فاطمة', 'عائشة', 'خديجة', 'مريم', 'زينب', 'أسماء', 'رملة', 'صفية', 'رقية', 'ميمونة'
        ];

        $arabicLastNames = [
            'الرياض', 'الدمام', 'جدة', 'مكة', 'المدينة', 'الطائف', 'بريدة', 'تبوك', 'خميس', 'جازان',
            'نجران', 'الباحة', 'القصيم', 'حائل', 'عسير', 'الجوف', 'الحدود الشمالية'
        ];

        return [
            'name' => $this->faker->randomElement($arabicFirstNames) . ' ' . $this->faker->randomElement($arabicLastNames),
            'status' => $this->faker->randomElement(['active', 'inactive', 'graduated']),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'photo' => null,
            'address' => $this->faker->optional()->address(),
            'home_phone' => $this->faker->optional()->phoneNumber(),
            'mobile_phone' => $this->faker->optional()->phoneNumber(),
            'level' => $this->faker->randomElement(['أولى', 'ثانية', 'ثالثة']),
            'major' => $this->faker->randomElement(['كهرباء عام', 'تبريد وتكييف', 'كهرباء سيارات', 'ميكانيكا عام']),
            'notes' => $this->faker->optional()->text(),
            'parent_name' => $this->faker->optional()->name(),
            'parent_mobile' => $this->faker->optional()->phoneNumber(),
            'parent_whatsapp' => null,
            'parent_home_phone' => null,
            'parent_job' => $this->faker->optional()->jobTitle(),
        ];
    }

    /**
     * Indicate that the user should have a active state.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the user should have a inactive state.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the user should have a graduated state.
     */
    public function graduated(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'graduated',
        ]);
    }

    /**
     * Indicate that the user is male.
     */
    public function male(): static
    {
        return $this->state(fn (array $attributes) => [
            'gender' => 'male',
        ]);
    }

    /**
     * Indicate that the user is female.
     */
    public function female(): static
    {
        return $this->state(fn (array $attributes) => [
            'gender' => 'female',
        ]);
    }

    /**
     * Indicate that the user is in first level.
     */
    public function firstLevel(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 'أولى',
        ]);
    }

    /**
     * Indicate that the user is in second level.
     */
    public function secondLevel(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 'ثانية',
        ]);
    }

    /**
     * Indicate that the user is in third level.
     */
    public function thirdLevel(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 'ثالثة',
        ]);
    }
}