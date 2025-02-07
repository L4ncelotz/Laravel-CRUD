<?php

namespace Database\Factories;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition()
    {
        // หาค่า teacher_id ล่าสุดจากฐานข้อมูล
        $lastTeacher = Teacher::orderBy('teacher_id', 'desc')->first();
        $lastNumber = $lastTeacher ? (int)substr($lastTeacher->teacher_id, 1) : 0;
        
        // เพิ่มค่าต่อจากค่าล่าสุดที่มีในฐานข้อมูล
        $nextNumber = $lastNumber + 1;

        return [
            'teacher_id' => 'T' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('08########'),
            'position' => fake()->randomElement([
                'อาจารย์',
                'ผู้ช่วยศาสตราจารย์',
                'รองศาสตราจารย์',
                'ศาสตราจารย์'
            ]),
            'department' => 'วิทยาการคอมพิวเตอร์'
        ];
    }
}
