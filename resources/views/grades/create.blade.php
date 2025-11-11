<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            إضافة درجة جديدة
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                
                {{-- Header --}}
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">إضافة درجة جديدة</h3>
                    <p class="text-sm text-gray-500">أدخل بيانات الدرجة والدرجات التفصيلية</p>
                </div>

                <form method="POST" action="{{ route('grades.store') }}" class="p-6">
                    @csrf

                    {{-- معلومات أساسية --}}
                    <div class="mb-8">
                        <h4 class="text-md font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-5 bg-primary-500 rounded-full"></div>
                            المعلومات الأساسية
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">الطالب <span class="text-red-500">*</span></label>
                                <select name="student_id" id="student_id" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">اختر الطالب</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-2">المادة <span class="text-red-500">*</span></label>
                                <select name="subject_id" id="subject_id" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">اختر المادة</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-2">المعلم <span class="text-red-500">*</span></label>
                                <select name="teacher_id" id="teacher_id" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">اختر المعلم</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                                @error('teacher_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">الفصل الدراسي <span class="text-red-500">*</span></label>
                                <select name="semester" id="semester" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">اختر الفصل</option>
                                    <option value="الأول">الفصل الأول</option>
                                    <option value="الثاني">الفصل الثاني</option>
                                    <option value="الثالث">الفصل الثالث</option>
                                    <option value="الرابع">الفصل الرابع</option>
                                </select>
                                @error('semester')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700 mb-2">السنة الدراسية <span class="text-red-500">*</span></label>
                                <select name="year" id="year" class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">اختر السنة</option>
                                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                                @error('year')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- الدرجات --}}
                    <div class="mb-8">
                        <h4 class="text-md font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <div class="w-1 h-5 bg-success-500 rounded-full"></div>
                            الدرجات التفصيلية
                        </h4>
                        
                        {{-- النصف الأول --}}
                        <div class="mb-8">
                            <h5 class="text-sm font-medium text-gray-700 mb-4">النصف الأول من العام</h5>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">واجبات الشهر الأول (من 100)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="homework1" 
                                           class="w-full border-gray-300 rounded-lg focus:ring-success-500 focus:border-success-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">مشاركة الشهر الأول (من 100)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="participation1" 
                                           class="w-full border-gray-300 rounded-lg focus:ring-success-500 focus:border-success-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">تحريري الشهر الأول (من 100)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="written_exam1" 
                                           class="w-full border-gray-300 rounded-lg focus:ring-success-500 focus:border-success-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">واجبات الشهر الثاني (من 100)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="homework2" 
                                           class="w-full border-gray-300 rounded-lg focus:ring-success-500 focus:border-success-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">مشاركة الشهر الثاني (من 100)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="participation2" 
                                           class="w-full border-gray-300 rounded-lg focus:ring-success-500 focus:border-success-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">تحريري الشهر الثاني (من 100)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="written_exam2" 
                                           class="w-full border-gray-300 rounded-lg focus:ring-success-500 focus:border-success-500">
                                </div>
                            </div>
                            <div class="max-w-md">
                                <label class="block text-sm text-gray-600 mb-1">الاختبار النصفي (من 100)</label>
                                <input type="number" step="0.01" min="0" max="100" name="midterm1" 
                                       class="w-full border-gray-300 rounded-lg focus:ring-success-500 focus:border-success-500">
                            </div>
                        </div>

                        {{-- النصف الثاني --}}
                        <div class="mb-8">
                            <h5 class="text-sm font-medium text-gray-700 mb-4">النصف الثاني من العام</h5>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">واجبات الشهر الثالث (من 100)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="homework3" 
                                           class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">مشاركة الشهر الثالث (من 100)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="participation3" 
                                           class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">تحريري الشهر الثالث (من 100)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="written_exam3" 
                                           class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">واجبات الشهر الرابع (من 100)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="homework4" 
                                           class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">مشاركة الشهر الرابع (من 100)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="participation4" 
                                           class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">تحريري الشهر الرابع (من 100)</label>
                                    <input type="number" step="0.01" min="0" max="100" name="written_exam4" 
                                           class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                </div>
                            </div>
                            <div class="max-w-md">
                                <label class="block text-sm text-gray-600 mb-1">الاختبار النهائي (من 100)</label>
                                <input type="number" step="0.01" min="0" max="100" name="final_exam" 
                                       class="w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                    </div>

                    {{-- أزرار التحكم --}}
                    <div class="flex flex-wrap gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-success-600 hover:bg-success-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            حفظ الدرجة
                        </button>
                        
                        <a href="{{ route('grades.index') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                            </svg>
                            إلغاء
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
