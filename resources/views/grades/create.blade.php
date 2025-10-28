<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            إضافة درجة جديدة
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                {{-- فورم إضافة درجة --}}
                <form method="POST" action="{{ route('grades.store') }}">
                    @csrf

                    {{-- اختيار الطالب --}}
                    <div class="mb-4">
                        <label for="student_id" class="block font-medium text-sm text-gray-700">الطالب</label>
                        <select name="student_id" id="student_id" class="w-full border-gray-300 rounded-md">
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- اختيار المادة --}}
                    <div class="mb-4">
                        <label for="subject_id" class="block font-medium text-sm text-gray-700">المادة</label>
                        <select name="subject_id" id="subject_id" class="w-full border-gray-300 rounded-md">
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- اختيار المعلم --}}
                    <div class="mb-4">
                        <label for="teacher_id" class="block font-medium text-sm text-gray-700">المعلم</label>
                        <select name="teacher_id" id="teacher_id" class="w-full border-gray-300 rounded-md">
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- إدخال الدرجات (نصف أول + نصف ثاني + نهائي) --}}
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block">واجبات الشهر الأول</label>
                            <input type="number" step="0.01" name="homework1" class="w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block">مشاركة الشهر الأول</label>
                            <input type="number" step="0.01" name="participation1" class="w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block">تحريري الشهر الأول</label>
                            <input type="number" step="0.01" name="written_exam1" class="w-full border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label class="block">واجبات الشهر الثاني</label>
                            <input type="number" step="0.01" name="homework2" class="w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block">مشاركة الشهر الثاني</label>
                            <input type="number" step="0.01" name="participation2" class="w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block">تحريري الشهر الثاني</label>
                            <input type="number" step="0.01" name="written_exam2" class="w-full border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-3">
                            <label class="block">الاختبار النصفي</label>
                            <input type="number" step="0.01" name="midterm1" class="w-full border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label class="block">واجبات الشهر الثالث</label>
                            <input type="number" step="0.01" name="homework3" class="w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block">مشاركة الشهر الثالث</label>
                            <input type="number" step="0.01" name="participation3" class="w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block">تحريري الشهر الثالث</label>
                            <input type="number" step="0.01" name="written_exam3" class="w-full border-gray-300 rounded-md">
                        </div>

                        <div>
                            <label class="block">واجبات الشهر الرابع</label>
                            <input type="number" step="0.01" name="homework4" class="w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block">مشاركة الشهر الرابع</label>
                            <input type="number" step="0.01" name="participation4" class="w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block">تحريري الشهر الرابع</label>
                            <input type="number" step="0.01" name="written_exam4" class="w-full border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-3">
                            <label class="block">الاختبار النهائي</label>
                            <input type="number" step="0.01" name="final_exam" class="w-full border-gray-300 rounded-md">
                        </div>
                    </div>

                    {{-- بيانات إضافية --}}
                    <div class="mt-4">
                        <label class="block">الفصل الدراسي</label>
                        <input type="text" name="semester" class="w-full border-gray-300 rounded-md">
                    </div>
                    <div class="mt-4">
                        <label class="block">السنة الدراسية</label>
                        <input type="text" name="year" class="w-full border-gray-300 rounded-md">
                    </div>

                    {{-- زر الحفظ --}}
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">
                            حفظ الدرجة
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
