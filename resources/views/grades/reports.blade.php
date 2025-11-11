<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تقارير الدرجات
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- إحصائيات عامة -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-soft p-6 border-r-4 border-primary-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">إجمالي الدرجات</p>
                            <p class="text-3xl font-bold text-primary-600">{{ $stats['total_grades'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                            <x-icon-grades class="w-6 h-6 text-primary-600" />
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-soft p-6 border-r-4 border-success-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">الدرجات الناجحة</p>
                            <p class="text-3xl font-bold text-success-600">{{ $stats['passed_grades'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-success-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-success-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-soft p-6 border-r-4 border-danger-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">الدرجات الراسبة</p>
                            <p class="text-3xl font-bold text-danger-600">{{ $stats['failed_grades'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-danger-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-danger-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-soft p-6 border-r-4 border-warning-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">نسبة النجاح</p>
                            <p class="text-3xl font-bold text-warning-600">{{ round($stats['success_rate'], 1) }}%</p>
                        </div>
                        <div class="w-12 h-12 bg-warning-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-warning-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- متوسط الدرجات -->
                <div class="bg-white rounded-xl shadow-soft p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <x-icon-chart class="w-5 h-5 text-primary-600" />
                        متوسط الدرجات العام
                    </h3>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-primary-600 mb-2">
                            {{ round($stats['average_grade'], 2) }}
                        </div>
                        <p class="text-gray-500">من 100</p>
                        <div class="mt-4 bg-gray-200 rounded-full h-3">
                            <div class="bg-primary-600 h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ $stats['average_grade'] }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- أفضل الطلاب -->
                <div class="bg-white rounded-xl shadow-soft p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <x-icon-students class="w-5 h-5 text-success-600" />
                        أفضل 5 طلاب
                    </h3>
                    <div class="space-y-3">
                        @forelse($stats['top_students'] as $index => $student)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center text-sm font-semibold text-primary-600">
                                        {{ $index + 1 }}
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $student->name }}</span>
                                </div>
                                <span class="text-lg font-bold text-success-600">
                                    {{ round($student->average_grade, 1) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">لا توجد درجات بعد</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- إحصائيات حسب المادة -->
            <div class="mt-8 bg-white rounded-xl shadow-soft p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <x-icon-book class="w-5 h-5 text-info-600" />
                    إحصائيات حسب المادة
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">المادة</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">إجمالي الطلاب</th>
                                <th class="px-6 py-3 text-right text-semibold text-gray-600 uppercase tracking-wider">الطلاب الناجحون</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">نسبة النجاح</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">متوسط الدرجات</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الحالة</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($subjectStats as $subject)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900">{{ $subject->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $subject->code }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $subject->grades_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $subject->grades_passed_count }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                            {{ $subject->success_rate >= 80 ? 'bg-success-100 text-success-800' : 
                                               ($subject->success_rate >= 60 ? 'bg-warning-100 text-warning-800' : 'bg-danger-100 text-danger-800') }}">
                                            {{ round($subject->success_rate, 1) }}%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        {{ round($subject->average_grade, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($subject->is_active)
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-success-100 text-success-800">
                                                <div class="w-2 h-2 bg-success-500 rounded-full"></div>
                                                نشط
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                                <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                                غير نشط
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <x-icon-book class="w-16 h-16 text-gray-300" />
                                            <p class="text-gray-500 font-medium">لا توجد مواد مسجلة بعد</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- أزرار إجراءات -->
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('grades.index') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                    <x-icon-arrow-right />
                    العودة للدرجات
                </a>
                <a href="{{ route('grades.export') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-success-600 hover:bg-success-700 text-white font-medium rounded-lg transition-colors">
                    <x-icon-download />
                    تصدير التقرير
                </a>
            </div>

        </div>
    </div>
</x-app-layout>