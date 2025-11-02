<x-app-layout>
    <x-slot name="header">
        نظام الحضور والغياب
    </x-slot>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-xl shadow-soft mb-6 overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex gap-4 px-6" x-data="{ activeTab: 'attendance' }">
                <button @click="activeTab = 'attendance'; showTab('attendance')"
                        :class="activeTab === 'attendance' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-4 px-4 border-b-2 font-medium text-sm transition-colors">
                    تسجيل الحضور
                </button>
                <button @click="activeTab = 'reports'; showTab('reports')" 
                        :class="activeTab === 'reports' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-4 px-4 border-b-2 font-medium text-sm transition-colors">
                    التقارير
                </button>
                <button @click="activeTab = 'stats'; showTab('stats')" 
                        :class="activeTab === 'stats' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                        class="py-4 px-4 border-b-2 font-medium text-sm transition-colors">
                    الإحصائيات
                </button>
            </nav>
        </div>
    </div>

    <!-- Attendance Tab -->
    <div id="attendanceSection" class="tab-content">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- معلومات الحصة -->
            <div class="bg-white rounded-xl shadow-soft p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    معلومات الحصة
                </h3>
                
                <form id="sessionForm" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">اسم المادة</label>
                        <input type="text" id="subjectName" name="subject_name" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="مثال: الرياضيات">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">اسم الفصل</label>
                        <input type="text" id="className" name="class_name" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="مثال: الصف الثالث">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">المعلم</label>
                        <select id="teacherId" name="teacher_id" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">اختر المعلم</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">تاريخ الحصة</label>
                        <input type="date" id="sessionDate" name="session_date" value="{{ $today }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">وقت الحصة</label>
                        <input type="time" id="sessionTime" name="session_time" value="{{ $currentTime }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </form>
            </div>

            <!-- تسجيل الحضور -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-soft p-6">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <x-icon-attendance class="text-success-600" />
                        تسجيل حضور الطلاب
                    </h3>
                    <button onclick="markAllPresent()" 
                            class="inline-flex items-center gap-2 px-4 py-2 bg-success-600 hover:bg-success-700 text-white rounded-lg transition-colors text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        حضور الكل
                    </button>
                </div>

                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">اسم الطالب</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الحالة</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">ملاحظات</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">دقائق التأخير</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="studentsTable">
                                @foreach($students as $index => $student)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-primary-600">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold text-sm">
                                                {{ mb_substr($student->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                                <div class="text-xs text-gray-500">ID: {{ $student->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <select name="status_{{ $student->id }}" 
                                                class="attendance-status px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                                data-student-id="{{ $student->id }}">
                                            <option value="حاضر" selected>حاضر</option>
                                            <option value="غائب">غائب</option>
                                            <option value="متأخر">متأخر</option>
                                            <option value="مُعفى">مُعفى</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="notes_{{ $student->id }}" 
                                               placeholder="سبب أو ملاحظة"
                                               class="attendance-notes w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" name="late_minutes_{{ $student->id }}" 
                                               placeholder="0" min="0"
                                               class="attendance-late w-20 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-3 justify-end">
                    <button onclick="clearForm()" 
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        مسح النموذج
                    </button>
                    <button onclick="saveAttendance()" 
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-success-600 hover:bg-success-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        حفظ الحضور
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Tab -->
    <div id="reportsSection" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-soft p-8">
            <div class="text-center">
                <x-icon-reports class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                <h3 class="text-lg font-semibold text-gray-800 mb-2">تقارير الحضور</h3>
                <p class="text-gray-600">سيتم إضافة تقارير تفصيلية قريباً...</p>
            </div>
        </div>
    </div>

    <!-- Stats Tab -->
    <div id="statsSection" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-soft p-8">
            <div class="text-center">
                <x-icon-grades class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                <h3 class="text-lg font-semibold text-gray-800 mb-2">إحصائيات الحضور</h3>
                <p class="text-gray-600">سيتم إضافة إحصائيات تفصيلية قريباً...</p>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div id="loadingModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-8 max-w-sm w-full mx-4 shadow-xl">
            <div class="text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600 mx-auto mb-4"></div>
                <p class="text-gray-700 font-medium">جاري حفظ الحضور...</p>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div id="toast" class="fixed top-4 left-4 z-50 hidden">
        <div id="toastContent" class="bg-white border border-gray-200 rounded-xl shadow-lg px-6 py-4 max-w-sm">
            <div class="flex items-center gap-3">
                <div id="toastIcon" class="flex-shrink-0"></div>
                <p id="toastMessage" class="text-sm font-medium text-gray-900"></p>
                <button onclick="hideToast()" class="mr-auto text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        // Tab switching
        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            document.getElementById(tabName + 'Section').classList.remove('hidden');
        }

        // Mark all present
        function markAllPresent() {
            document.querySelectorAll('.attendance-status').forEach(select => select.value = 'حاضر');
            showToast('تم تحديد حضور جميع الطلاب', 'success');
        }

        // Clear form
        function clearForm() {
            document.getElementById('sessionForm').reset();
            document.getElementById('sessionDate').value = '{{ $today }}';
            document.getElementById('sessionTime').value = '{{ $currentTime }}';
            document.querySelectorAll('.attendance-status').forEach(select => select.value = 'حاضر');
            document.querySelectorAll('.attendance-notes, .attendance-late').forEach(input => input.value = '');
            showToast('تم مسح النموذج', 'success');
        }

        // Save attendance
        async function saveAttendance() {
            const subjectName = document.getElementById('subjectName').value;
            const className = document.getElementById('className').value;
            const teacherId = document.getElementById('teacherId').value;
            const sessionDate = document.getElementById('sessionDate').value;
            const sessionTime = document.getElementById('sessionTime').value;

            if (!subjectName || !className || !teacherId || !sessionDate || !sessionTime) {
                showToast('يرجى إكمال جميع بيانات الحصة', 'error');
                return;
            }

            const students = @json($students);
            const attendanceData = students.map(student => ({
                student_id: student.id,
                status: document.querySelector(`[name="status_${student.id}"]`).value,
                notes: document.querySelector(`[name="notes_${student.id}"]`).value,
                late_minutes: document.querySelector(`[name="late_minutes_${student.id}"]`).value || null
            }));

            document.getElementById('loadingModal').classList.remove('hidden');

            try {
                const response = await fetch('/attendance/bulk-store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        attendance_data: attendanceData,
                        teacher_id: teacherId,
                        subject_name: subjectName,
                        class_name: className,
                        session_date: sessionDate,
                        session_time: sessionTime
                    })
                });

                const result = await response.json();
                showToast(result.success ? result.message : 'حدث خطأ أثناء حفظ الحضور', result.success ? 'success' : 'error');
                if (result.success) clearForm();
            } catch (error) {
                showToast('حدث خطأ في الاتصال بالخادم', 'error');
            } finally {
                document.getElementById('loadingModal').classList.add('hidden');
            }
        }

        // Toast notifications
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastContent = document.getElementById('toastContent');
            const toastMessage = document.getElementById('toastMessage');
            const toastIcon = document.getElementById('toastIcon');

            toastMessage.textContent = message;
            
            if (type === 'success') {
                toastContent.className = 'bg-white border border-success-200 rounded-xl shadow-lg px-6 py-4 max-w-sm';
                toastIcon.innerHTML = '<svg class="w-5 h-5 text-success-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>';
            } else {
                toastContent.className = 'bg-white border border-danger-200 rounded-xl shadow-lg px-6 py-4 max-w-sm';
                toastIcon.innerHTML = '<svg class="w-5 h-5 text-danger-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>';
            }

            toast.classList.remove('hidden');
            setTimeout(hideToast, 5000);
        }

        function hideToast() {
            document.getElementById('toast').classList.add('hidden');
        }
    </script>
</x-app-layout>
