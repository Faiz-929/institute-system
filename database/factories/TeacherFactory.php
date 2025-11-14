<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
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

        $subjects = ['رياضيات', 'عربي', 'إنجليزي', 'فيزياء', 'كيمياء', 'أحياء', 'تاريخ', 'جغرافيا', 'دين', 'تربية بدنية'];

        return [
            'name' => $this->faker->randomElement($arabicFirstNames) . ' ' . $this->faker->randomElement($arabicLastNames),
            'qualification' => $this->faker->randomElement(['بكالوريوس', 'ماجستير', 'دكتوراه']),
            'subject' => $this->faker->randomElement($subjects),
            'phone' => $this->faker->optional()->phoneNumber(),
            'home_phone' => $this->faker->optional()->phoneNumber(),
            'address' => $this->faker->optional()->address(),
        ];
    }

    /**
     * Indicate that the teacher teaches mathematics.
     */
    public function mathematics(): static
    {
        return $this->state(fn (array $attributes) => [
            'subject' => 'رياضيات',
        ]);
    }

    /**
     * Indicate that the teacher teaches Arabic.
     */
    public function arabic(): static
    {
        return $this->state(fn (array $attributes) => [
            'subject' => 'عربي',
        ]);
    }

    /**
     * Indicate that the teacher teaches English.
     */
    public function english(): static
    {
        return $this->state(fn (array $attributes) => [
            'subject' => 'إنجليزي',
        ]);
    }

    /**
     * Indicate that the teacher has a master's degree.
     */
    public function masters(): static
    {
        return $this->state(fn (array $attributes) => [
            'qualification' => 'ماجستير',
        ]);
    }

    /**
     * Indicate that the teacher has a PhD.
     */
    public function phd(): static
    {
        return $this->state(fn (array $attributes) => [
            'qualification' => 'دكتوراه',
        ]);
    }
}