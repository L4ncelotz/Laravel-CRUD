<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RegistrationController extends Controller
{

    public function index()
    {
        $registrations = Register::with(['student', 'course.teacher'])
            ->latest()
            ->paginate();


        $allGrades = Register::select('grade')->get(); 

        // คำนวณการกระจายของเกรด
        $gradeDistribution = [
            'A' => $allGrades->filter(fn($reg) => $reg->grade >= 3.5)->count(),
            'B' => $allGrades->filter(fn($reg) => $reg->grade >= 2.5 && $reg->grade < 3.5)->count(),
            'C' => $allGrades->filter(fn($reg) => $reg->grade >= 1.5 && $reg->grade < 2.5)->count(),
            'D' => $allGrades->filter(fn($reg) => $reg->grade >= 1.0 && $reg->grade < 1.5)->count(),
            'F' => $allGrades->filter(fn($reg) => $reg->grade < 1.0)->count(),
        ];

        $total_students = Register::select('student_id')
            ->distinct()
            ->count();


        $total_registrations = Register::count();

        $average_grade = Register::avg('grade');


        return Inertia::render('Registration/Index', [
            'registrations' => $registrations,
            'total_students' => $total_students,
            'total_registrations' => $total_registrations,
            'average_grade' => round($average_grade, 2),
            'grade_distribution' => $gradeDistribution,
            'filters' => request()->all(['search', 'field', 'direction']),
        ]);
    }

    /**
     * แสดงหน้าเพิ่มข้อมูลการลงทะเบียน
     */
    public function create()
    {
        return Inertia::render('Registration/Create', [
            'students' => Student::select('id', 'student_id', 'first_name', 'last_name')->get(),
            'courses' => Course::select('id', 'course_code', 'course_name')->get(),
        ]);
    }

    /**
     * บันทึกข้อมูลการลงทะเบียนใหม่
     */
    public function store(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลที่รับเข้ามา
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'semester' => 'required|string',
            'academic_year' => 'required|integer',
            'grade' => 'required|numeric|min:0|max:4'
        ]);


        Register::create($validated);

        return redirect()->back()
            ->with('message', 'ลงทะเบียนสำเร็จ');
    }

    /**
     * แสดงรายละเอียดของข้อมูลการลงทะเบียน (ยังไม่ได้ใช้งาน)
     */
    public function show(string $id)
    {
        //
    }

    /**
     * แสดงหน้าแก้ไขข้อมูลการลงทะเบียน
     */
    public function edit(Register $registration)
    {
        return Inertia::render('Registration/Edit', [
            'registration' => $registration,
            'students' => Student::select('id', 'student_id', 'first_name', 'last_name')->get(),
            'courses' => Course::select('id', 'course_code', 'course_name')->get(),
        ]);
    }

    /**
     * อัพเดตข้อมูลการลงทะเบียน
     */
    public function update(Request $request, Register $registration)
    {
        // ตรวจสอบความถูกต้องของข้อมูล
        $validated = $request->validate([
            'grade' => 'required|numeric|min:0|max:4'
        ]);

        // อัพเดตข้อมูลในฐานข้อมูล
        $registration->update($validated);

        return redirect()->back()
            ->with('message', 'อัพเดทเกรดสำเร็จ');
    }

    /**
     * ลบข้อมูลการลงทะเบียน
     */
    public function destroy(Register $registration)
    {
        $registration->delete();

        return redirect()->back()
            ->with('message', 'ยกเลิกการลงทะเบียนสำเร็จ');
    }

    /**
     * แสดงสถิติเกี่ยวกับการลงทะเบียน
     */
    public function stats()
    {

        $courseStats = Course::select('courses.course_name')
            ->selectRaw('AVG(registers.grade) as average_grade')
            ->selectRaw('COUNT(registers.id) as student_count')
            ->leftJoin('registers', 'courses.id', '=', 'registers.course_id')
            ->groupBy('courses.id', 'courses.course_name')
            ->get();

        $semesterStats = Register::select('semester', 'academic_year')
            ->selectRaw('COUNT(DISTINCT student_id) as student_count')
            ->groupBy('semester', 'academic_year')
            ->orderBy('academic_year')
            ->orderBy('semester') 
            ->get();

        return view('registration.stats', compact('courseStats', 'semesterStats'));
    }
}
