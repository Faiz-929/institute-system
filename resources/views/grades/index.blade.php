<x-app-layout>
    <x-slot name="header">
        قائمة الدرجات
    </x-slot>

    <!-- شريط الأدوات -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <!-- أزرار الإجراءات -->
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('grades.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-2.5 bg-success-600 hover:bg-success-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                <x-icon-plus />
                <span>إضافة درجة جديدة</span>
            </a>
            <button onclick="window.print()" 
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                <x-icon-print />
                <span>طباعة</span>
            </button>
            <button onclick="exportToExcel()" 
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                <x-icon-download />
                <span>تصدير Excel</span>
            </button>
        </div>

        <!-- إحصائيات سريعة -->
        <div class="flex gap-4">
            <div class="bg-white rounded-lg shadow-soft px-4 py-2 border-r-4 border-success-500">
                <p class="text-xs text-gray-500">نسبة النجاح</p>
                <p class="text-lg font-bold text-gray-800">
                    @php
                        $totalGrades = $grades->total();
                        $passedGrades = \App\Models\Grade::where('total', '>=', 50)->count();
                        $successRate = $totalGrades > 0 ? round(($passedGrades / $totalGrades) * 100) : 0;
                    @endphp
                    {{ $successRate }}%
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-soft px-4 py-2 border-r-4 border-primary-500">
                <p class="text-xs text-gray-500">إجمالي الدرجات</p>
                <p class="text-lg font-bold text-gray-800">{{ $totalGrades }}</p>
            </div>
        </div>
    </div>

    <!-- فلاتر البحث -->
    <div class="bg-white rounded-xl shadow-soft p-6 mb-6">
        <form method="GET" action="{{ route('grades.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">الفصل الدراسي</label>
                <select name="semester" class="block w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                    <option value="">جميع الفصول</option>
                    <option value="الأول" {{ request('semester') == 'الأول' ? 'selected' : '' }}>الفصل الأول</option>
                    <option value="الثاني" {{ request('semester') == 'الثاني' ? 'selected' : '' }}>الفصل الثاني</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">السنة الدراسية</label>
                <select name="year" class="block w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                    <option value="">جميع السنوات</option>
                    @foreach(range(date('Y') - 5, date('Y')) as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
                <select name="status" class="block w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                    <option value="">الكل</option>
                    <option value="pass" {{ request('status') == 'pass' ? 'selected' : '' }}>ناجح (50 فأكثر)</option>
                    <option value="fail" {{ request('status') == 'fail' ? 'selected' : '' }}>راسب (أقل من 50)</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                    تطبيق
                </button>
                <a href="{{ route('grades.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    إعادة
                </a>
            </div>
        </form>
    </div>

    <!-- الجدول -->
    <div class="bg-white rounded-xl shadow-soft overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="gradesTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الطالب</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">المادة</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">المعلم</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">المجموع</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الفصل</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">السنة</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($grades as $index => $grade)
                        <tr class="hover:bg-gray-50 transition-colors {{ $grade->total < 50 ? 'bg-danger-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-primary-600">
                                {{ $loop->iteration + ($grades->currentPage() - 1) * $grades->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold">
                                        {{ mb_substr($grade->student->name, 0, 2) }}
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ $grade->student->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $grade->subject->name ?? 'غير محدد' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $grade->teacher->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $grade->total >= 90 ? 'bg-success-100 text-success-800' : 
                                       ($grade->total >= 75 ? 'bg-primary-100 text-primary-800' : 
                                       ($grade->total >= 50 ? 'bg-warning-100 text-warning-800' : 'bg-danger-100 text-danger-800')) }}">
                                    {{ $grade->total }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($grade->total >= 50)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-success-100 text-success-800">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        ناجح
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-danger-100 text-danger-800">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        راسب
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $grade->semester }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $grade->year }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('grades.edit', $grade->id) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-warning-500 hover:bg-warning-600 text-white rounded-lg transition-colors"
                                       title="تعديل">
                                        <x-icon-edit />
                                    </a>
                                    <form action="{{ route('grades.destroy', $grade->id) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذه الدرجة؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-3 py-2 bg-danger-600 hover:bg-danger-700 text-white rounded-lg transition-colors"
                                                title="حذف">
                                            <x-icon-delete />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <x-icon-grades class="w-16 h-16 text-gray-300" />
                                    <p class="text-gray-500 font-medium">لا توجد درجات حتى الآن</p>
                                    <a href="{{ route('grades.create') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                        <x-icon-plus />
                                        <span>إضافة درجة جديدة</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($grades->hasPages())
        <div class="mt-6">
            {{ $grades->links() }}
        </div>
    @endif

    <script>
        function exportToExcel() {
            const table = document.getElementById('gradesTable');
            let html = table.outerHTML;
            const url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
            const downloadLink = document.createElement("a");
            document.body.appendChild(downloadLink);
            downloadLink.href = url;
            downloadLink.download = 'grades_' + new Date().toISOString().slice(0,10) + '.xls';
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }
    </script>
</x-app-layout>