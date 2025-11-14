<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arabicSubjects = [
            'رياضيات', 'عربي', 'إنجليزي', 'فيزياء', 'كيمياء', 'أحياء', 'تاريخ', 'جغرافيا', 
            'دين', 'تربية بدنية', 'حاسوب', 'فنون', 'موسيقى', 'اقتصاد', 'نفسية', 'فلسفة',
            'دراسات إسلامية', 'اللغة العربية', 'العلوم الطبيعية', 'العلوم الاجتماعية',
            'الرياضيات المتقدمة', 'الكيمياء العضوية', 'الفيزياء الحديثة', 'الأحياء الدقيقة'
        ];

        $gradeLevels = [
            'أولى', 'ثانية', 'ثالثة', 'رابعة', 'خامسة', 'سادسة'
        ];

        return [
            'name' => $this->faker->randomElement($arabicSubjects),
            'code' => $this->faker->unique()->regexify('[A-Z]{3}\d{3}'),
            'description' => $this->faker->optional()->sentence(),
            'grade_level' => $this->faker->randomElement($gradeLevels),
            'credit_hours' => $this->faker->numberBetween(1, 5),
            'is_active' => $this->faker->boolean(80), // 80% نشط
        ];
    }

    /**
     * Indicate that the subject should be active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the subject should be inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the subject should be for first year.
     */
    public function firstYear(): static
    {
        return $this->state(fn (array $attributes) => [
            'grade_level' => 'أولى',
        ]);
    }

    /**
     * Indicate that the subject should be for second year.
     */
    public function secondYear(): static
    {
        return $this->state(fn (array $attributes) => [
            'grade_level' => 'ثانية',
        ]);
    }

    /**
     * Indicate that the subject should be for third year.
     */
    public function thirdYear(): static
    {
        return $this->state(fn (array $attributes) => [
            'grade_level' => 'ثالثة',
        ]);
    }
}