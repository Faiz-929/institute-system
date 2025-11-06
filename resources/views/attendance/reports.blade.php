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
                    <label class="block text-sm font-medium text-gray-700 mb-1">المستوى (اختياري)</label>
                    <input type="number" name="level" value="{{ request('level') }}" min="1" max="12" placeholder="المستوى الدراسي" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">التخصص (اختياري)</label>
                    <input type="text" name="major" value="{{ request('major') }}" placeholder="التخصص الدراسي" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <i class="fas fa-list-alt text-blue-500 ml-2"></i>
                        نوع التقرير
                    </label>
                    <select name="type" id="reportTypeSelect" onchange="toggleStudentField()" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="daily" {{ $reportType == 'daily' ? 'selected' : '' }}>تقرير يومي</option>
                        <option value="student" {{ $reportType == 'student' ? 'selected' : '' }}>تقرير طالب</option>
                        <option value="teacher" {{ $reportType == 'teacher' ? 'selected' : '' }}>تقرير معلم</option>
                    </select>
                </div>

                <div id="studentField" style="display: {{ $reportType == 'student' ? 'block' : 'none' }};">
                    <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <i class="fas fa-user-graduate text-green-500 ml-2"></i>
                        اسم الطالب
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="text" name="student_name" value="{{ request('student_name') }}" placeholder="اكتب اسم الطالب..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
                            <i class="fas fa-search ml-1"></i> بحث
                        </button>
                    </div>
                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-calendar-day text-purple-500 ml-2"></i>
                            من تاريخ
                        </label>
                        <input type="date" name="date_from" value="{{ $dateFrom }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-calendar-check text-indigo-500 ml-2"></i>
                            إلى تاريخ
                        </label>
                        <input type="date" name="date_to" value="{{ $dateTo }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div id="dateFromField" style="display: {{ $reportType == 'student' ? 'none' : 'block' }};">
                    <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <i class="fas fa-calendar-day text-purple-500 ml-2"></i>
                        من تاريخ
                    </label>
                    <input type="date" name="date_from" value="{{ $dateFrom }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div id="dateToField" style="display: {{ $reportType == 'student' ? 'none' : 'block' }};">
                    <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center">
                        <i class="fas fa-calendar-check text-indigo-500 ml-2"></i>
                        إلى تاريخ
                    </label>
                    <input type="date" name="date_to" value="{{ $dateTo }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <script>
                function toggleStudentField() {
                    var type = document.getElementById('reportTypeSelect').value;
                    document.getElementById('studentField').style.display = (type === 'student') ? 'block' : 'none';
                    document.getElementById('dateFromField').style.display = (type === 'student') ? 'none' : 'block';
                    document.getElementById('dateToField').style.display = (type === 'student') ? 'none' : 'block';
                }
                </script>

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
                <!-- مخطط دائري للإحصائيات -->
                @if(isset($data) && is_iterable($data) && $reportType != 'student')
                <div class="flex justify-center mb-8">
                    <canvas id="attendanceChart" width="320" height="180"></canvas>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var ctx = document.getElementById('attendanceChart').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['حضور', 'غياب', 'تأخير', 'مُعفى'],
                            datasets: [{
                                data: [{{ $present }}, {{ $absent }}, {{ $late }}, {{ $excused }}],
                                backgroundColor: [
                                    '#22c55e', // green
                                    '#ef4444', // red
                                    '#eab308', // yellow
                                    '#a855f7'  // purple
                                ],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'bottom',
                                    labels: {
                                        font: { size: 14 },
                                        color: '#374151'
                                    }
                                }
                            }
                        }
                    });
                });
                </script>
                @endif
                <!-- ملخص إحصائي أعلى الجدول -->
                @if(isset($data) && is_iterable($data) && $reportType != 'student')
                @php
                    $total = count($data);
                    $present = 0; $absent = 0; $late = 0; $excused = 0;
                    foreach($data as $row) {
                        if($row->status == 'حاضر') $present++;
                        elseif($row->status == 'غائب') $absent++;
                        elseif($row->status == 'متأخر') $late++;
                        elseif($row->status == 'مُعفى') $excused++;
                    }
                    $percentage = $total ? round(($present/$total)*100, 1) : 0;
                @endphp
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                    <div class="bg-blue-100 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $total }}</div>
                        <div class="text-sm text-blue-800 flex items-center justify-center"><i class="fas fa-list-alt ml-1"></i>إجمالي الحصص</div>
                    </div>
                    <div class="bg-green-100 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $present }}</div>
                        <div class="text-sm text-green-800 flex items-center justify-center"><i class="fas fa-check ml-1"></i>الحضور</div>
                    </div>
                    <div class="bg-red-100 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $absent }}</div>
                        <div class="text-sm text-red-800 flex items-center justify-center"><i class="fas fa-times ml-1"></i>الغياب</div>
                    </div>
                    <div class="bg-yellow-100 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $late }}</div>
                        <div class="text-sm text-yellow-800 flex items-center justify-center"><i class="fas fa-clock ml-1"></i>التأخير</div>
                    </div>
                    <div class="bg-purple-100 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $excused }}</div>
                        <div class="text-sm text-purple-800 flex items-center justify-center"><i class="fas fa-user-shield ml-1"></i>المُعفى</div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-4 text-center col-span-2 md:col-span-1">
                        <div class="text-2xl font-bold text-gray-600">{{ $percentage }}%</div>
                        <div class="text-sm text-gray-800 flex items-center justify-center"><i class="fas fa-percentage ml-1"></i>نسبة الحضور</div>
                    </div>
                </div>
                @endif
                <!-- بحث فوري باسم الطالب أو المادة (لا يظهر في تقرير الطالب) -->
                @if($reportType != 'student')
                <div class="flex flex-col md:flex-row items-center justify-between mb-4">
                    <div class="flex items-center mb-2 md:mb-0">
                        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="بحث باسم الطالب أو المادة..." class="w-64 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-search text-gray-400 ml-2"></i>
                    </div>
                </div>
                @endif
                        <table class="min-w-full divide-y divide-gray-200">
                <script>
                // Pagination for table
                document.addEventListener('DOMContentLoaded', function() {
                    paginateTable(10);
                });

                function paginateTable(rowsPerPage) {
                    var table = document.querySelector('table');
                    var rows = table.querySelectorAll('tbody tr');
                    var totalRows = rows.length;
                    var pageCount = Math.ceil(totalRows / rowsPerPage);
                    var currentPage = 1;

                    function showPage(page) {
                        for (var i = 0; i < totalRows; i++) {
                            rows[i].style.display = (i >= (page-1)*rowsPerPage && i < page*rowsPerPage) ? '' : 'none';
                        }
                        renderPagination(page);
                    }

                    function renderPagination(page) {
                        var pagination = document.getElementById('tablePagination');
                        if (!pagination) {
                            pagination = document.createElement('div');
                            pagination.id = 'tablePagination';
                            pagination.className = 'flex justify-center items-center mt-4';
                            table.parentNode.appendChild(pagination);
                        }
                        pagination.innerHTML = '';
                        for (var i = 1; i <= pageCount; i++) {
                            var btn = document.createElement('button');
                            btn.textContent = i;
                            btn.className = 'mx-1 px-3 py-1 rounded border border-gray-300 bg-white hover:bg-blue-100 text-sm ' + (i === page ? 'bg-blue-500 text-white' : '');
                            btn.onclick = (function(p){ return function(){ showPage(p); }; })(i);
                            pagination.appendChild(btn);
                        }
                    }

                    showPage(currentPage);
                }
                </script>
                <script>
                function filterTable() {
                    var input = document.getElementById('searchInput');
                    if (!input) return; // guard: no search field (e.g., student report)
                    var filter = input.value.toLowerCase();
                    var table = input.closest('div').nextElementSibling;
                    var rows = table.getElementsByTagName('tr');
                    for (var i = 1; i < rows.length; i++) {
                        var cells = rows[i].getElementsByTagName('td');
                        if (cells.length > 1) {
                            var student = cells[1].textContent.toLowerCase();
                            var subject = cells[4].textContent.toLowerCase();
                            if (student.indexOf(filter) > -1 || subject.indexOf(filter) > -1) {
                                rows[i].style.display = '';
                            } else {
                                rows[i].style.display = 'none';
                            }
                        }
                    }
                }
                </script>
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