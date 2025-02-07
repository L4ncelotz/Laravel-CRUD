import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import AppLayout from '@/Layouts/AppLayout';

export default function Create({ students, courses }) {
    const { data, setData, post, processing, errors } = useForm({
        student_id: '',
        course_id: '',
        semester: '',
        academic_year: new Date().getFullYear().toString(),
        grade: '0'
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        if (!data.student_id || !data.course_id || !data.semester || data.grade === '') {
            alert('กรุณากรอกข้อมูลให้ครบถ้วน');
            return;
        }
        
        const grade = parseFloat(data.grade);
        if (isNaN(grade) || grade < 0 || grade > 4) {
            alert('กรุณากรอกเกรดให้ถูกต้อง (0-4)');
            return;
        }   

        post(route('reg.store'), {
            onSuccess: () => {
                window.location = route('reg.index');
            },
            onError: (errors) => {
                console.error(errors);
                alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');
            }
        });
    };

    return (
        <AppLayout>
            <Head title="เพิ่มการลงทะเบียน" />
            
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h2 className="text-lg font-semibold mb-6">เพิ่มการลงทะเบียน</h2>
                            
                            <form onSubmit={handleSubmit}>
                                <div className="space-y-4">
                                    {/* Student Select */}
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700">
                                            นักศึกษา
                                        </label>
                                        <select
                                            value={data.student_id}
                                            onChange={e => setData('student_id', e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        >
                                            <option value="">เลือกนักศึกษา</option>
                                            {students.map(student => (
                                                <option key={student.id} value={student.id}>
                                                    {student.student_id} - {student.first_name} {student.last_name}
                                                </option>
                                            ))}
                                        </select>
                                        {errors.student_id && (
                                            <p className="mt-1 text-sm text-red-600">{errors.student_id}</p>
                                        )}
                                    </div>

                                    {/* Course Select */}
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700">
                                            วิชา
                                        </label>
                                        <select
                                            value={data.course_id}
                                            onChange={e => setData('course_id', e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                        >
                                            <option value="">เลือกวิชา</option>
                                            {courses.map(course => (
                                                <option key={course.id} value={course.id}>
                                                    {course.course_code} - {course.course_name}
                                                </option>
                                            ))}
                                        </select>
                                        {errors.course_id && (
                                            <p className="mt-1 text-sm text-red-600">{errors.course_id}</p>
                                        )}
                                    </div>

                                    {/* Semester Input */}
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700">
                                            ภาคการศึกษา
                                        </label>
                                        <input
                                            type="text"
                                            value={data.semester}
                                            onChange={e => setData('semester', e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                            placeholder="1/2567"
                                        />
                                        {errors.semester && (
                                            <p className="mt-1 text-sm text-red-600">{errors.semester}</p>
                                        )}
                                    </div>

                                    {/* Grade Input */}
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700">
                                            เกรด
                                        </label>
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            max="4"
                                            value={data.grade}
                                            onChange={e => setData('grade', e.target.value)}
                                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                            placeholder="0.00"
                                        />
                                        {errors.grade && (
                                            <p className="mt-1 text-sm text-red-600">{errors.grade}</p>
                                        )}
                                    </div>

                                    <div className="flex justify-end space-x-2">
                                        <button
                                            type="button"
                                            onClick={() => window.history.back()}
                                            className="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50"
                                        >
                                            ยกเลิก
                                        </button>
                                        <button
                                            type="submit"
                                            disabled={processing}
                                            className="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700"
                                        >
                                            บันทึก
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
} 