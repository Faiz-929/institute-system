<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقارير الحضور والغياب</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg mb-8 p-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-chart-bar text-blue-600 ml-3"></i>
                    تقارير الحضور والغياب
                </h1>
                <a href="/attendance" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm">
                    <i class="fas fa-arrow-right ml-1"></i>
                    العودة لتسجيل الحضور
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-lg mb-8 p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                <i class="fas fa-filter text-purple-600 ml-2"></i>
                فلتر التقارير
            </h2>
            
            <form method="GET" action="{{ route('attendance.reports') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">نوع التقرير</label>
                    <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="daily" {{ $reportType == 'daily' ? 'selected' : '' }}>تقرير يومي</option>
                        <option value="student" {{ $reportType == 'student' ? 'selected' : '' }}>تقرير طالب</option>
                        <option value="teacher" {{ $reportType == 'teacher' ? 'selected' : '' }}>تقرير معلم</option>
                    </select>
                </div>

                @if($reportType == 'student')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">الطالب</label>
                        <select name="student_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">اختر الطالب</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ $studentId == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">التاريخ</label>
                        <input type="date" name="date" value="{{ $date }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">المادة (اختياري)</label>
                    <input type="text" name="subject" value="{{ $subject }}" 
                           placeholder="اسم المادة"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">المعلم (اختياري)</label>
                    <select name="teacher_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">جميع المعلمين</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ $teacherId == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 lg:col-span-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-search ml-1"></i>
                        عرض التقرير
                    </button>
                    <button type="button" onclick="exportReport()" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 mr-2">
                        <i class="fas fa-download ml-1"></i>
                        تصدير
                    </button>
                </div>
            </form>
        </div>

        <!-- Report Content -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            @if($reportType == 'student' && isset($data['stats']))
                <!-- Student Report -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">إحصائيات الطالب</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
                        <div class="bg-blue-100 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $data['stats']['total'] }}</div>
                            <div class="text-sm text-blue-800">إجمالي الحصص</div>
                        </div>
                        <div class="bg-green-100 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $data['stats']['present'] }}</div>
                            <div class="text-sm text-green-800">الحضور</div>
                        </div>
                        <div class="bg-red-100 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-red-600">{{ $data['stats']['absent'] }}</div>
                            <div class="text-sm text-red-800">الغياب</div>
                        </div>
                        <div class="bg-yellow-100 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-yellow-600">{{ $data['stats']['late'] }}</div>
                            <div class="text-sm text-yellow-800">التأخير</div>
                        </div>
                        <div class="bg-purple-100 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $data['stats']['excused'] }}</div>
                            <div class="text-sm text-purple-800">المُعفى</div>
                        </div>
                        <div class="bg-gray-100 rounded-lg p-4 text-center">
                            <div class="text-2xl font-bold text-gray-600">{{ $data['stats']['percentage'] }}%</div>
                            <div class="text-sm text-gray-800">نسبة الحضور</div>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">تفاصيل الحضور</h4>
                    <div class="overflow-hidden rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التاريخ</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الوقت</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المادة</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الفصل</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المعلم</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($data['attendances'] as $attendance)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $attendance->session_date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $attendance->session_time }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $attendance->subject_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $attendance->class_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($attendance->status == 'حاضر')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check ml-1"></i>{{ $attendance->status }}
                                            </span>
                                        @elseif($attendance->status == 'غائب')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times ml-1"></i>{{ $attendance->status }}
                                            </span>
                                        @elseif($attendance->status == 'متأخر')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock ml-1"></i>{{ $attendance->status }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                <i class="fas fa-user-shield ml-1"></i>{{ $attendance->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $attendance->teacher->name ?? 'غير محدد' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $attendance->notes ?? '-' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        لا توجد سجلات حضور
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- General Report -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        تقرير {{ $reportType == 'daily' ? 'يومي' : ($reportType == 'teacher' ? 'المعلم' : 'عام') }}
                        @if($date)
                            - {{ $date }}
                        @endif
                    </h3>
                </div>

                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">اسم الطالب</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التاريخ</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الوقت</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المادة</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الملاحظات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($data as $index => $attendance)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-medium">
                                                {{ substr($attendance->student->name ?? '؟', 0, 2) }}
                                            </div>
                                        </div>
                                        <div class="mr-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $attendance->student->name ?? 'غير محدد' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $attendance->session_date }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $attendance->session_time }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $attendance->subject_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($attendance->status == 'حاضر')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check ml-1"></i>{{ $attendance->status }}
                                        </span>
                                    @elseif($attendance->status == 'غائب')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times ml-1"></i>{{ $attendance->status }}
                                        </span>
                                    @elseif($attendance->status == 'متأخر')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock ml-1"></i>{{ $attendance->status }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            <i class="fas fa-user-shield ml-1"></i>{{ $attendance->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $attendance->notes ?? '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    لا توجد سجلات حضور
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script>
        function exportReport() {
            // هذا سيطبق قريباً - تصدير Excel, PDF
            alert('سيتم تطبيق ميزة التصدير قريباً');
        }
    </script>
</body>
</html>