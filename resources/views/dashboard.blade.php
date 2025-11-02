<x-app-layout>
    <x-slot name="header">
        لوحة التحكم
    </x-slot>

    <!-- إحصائيات سريعة -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- عدد الطلاب -->
        <div class="bg-white rounded-xl shadow-soft p-6 border-r-4 border-primary-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">إجمالي الطلاب</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Student::count() }}</h3>
                    <p class="text-xs text-gray-400 mt-1">طالب نشط</p>
                </div>
                <div class="bg-primary-100 p-4 rounded-xl">
                    <x-icon-students class="w-8 h-8 text-primary-600" />
                </div>
            </div>
        </div>
        
        <!-- عدد المعلمين -->
        <div class="bg-white rounded-xl shadow-soft p-6 border-r-4 border-secondary-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">إجمالي المعلمين</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Teacher::count() }}</h3>
                    <p class="text-xs text-gray-400 mt-1">معلم نشط</p>
                </div>
                <div class="bg-secondary-100 p-4 rounded-xl">
                    <x-icon-teachers class="w-8 h-8 text-secondary-600" />
                </div>
            </div>
        </div>
        
        <!-- معدل الحضور -->
        <div class="bg-white rounded-xl shadow-soft p-6 border-r-4 border-success-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">معدل الحضور</p>
                    <h3 class="text-3xl font-bold text-gray-800">
                        @php
                            $totalAttendance = \App\Models\Attendance::count();
                            $presentAttendance = \App\Models\Attendance::where('status', 'حاضر')->count();
                            $attendanceRate = $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100) : 0;
                        @endphp
                        {{ $attendanceRate }}%
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">هذا الشهر</p>
                </div>
                <div class="bg-success-100 p-4 rounded-xl">
                    <x-icon-attendance class="w-8 h-8 text-success-600" />
                </div>
            </div>
        </div>
        
        <!-- إجمالي الرسوم -->
        <div class="bg-white rounded-xl shadow-soft p-6 border-r-4 border-warning-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">الرسوم المحصلة</p>
                    <h3 class="text-3xl font-bold text-gray-800">
                        {{ number_format(\App\Models\FeePayment::sum('amount_paid'), 0) }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">ريال سعودي</p>
                </div>
                <div class="bg-warning-100 p-4 rounded-xl">
                    <x-icon-fees class="w-8 h-8 text-warning-600" />
                </div>
            </div>
        </div>
    </div>

    <!-- الأقسام الرئيسية -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- إدارة الطلاب -->
        <div class="bg-white rounded-xl shadow-soft p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <x-icon-students class="text-primary-600" />
                إدارة الطلاب
            </h3>
            <div class="space-y-3">
                <a href="{{ route('students.index') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-primary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-primary-600">قائمة الطلاب</span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <a href="{{ route('students.create') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-primary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-primary-600">إضافة طالب جديد</span>
                    <x-icon-plus class="text-gray-400 group-hover:text-primary-600" />
                </a>
                <a href="{{ route('students.print') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-primary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-primary-600">طباعة قائمة الطلاب</span>
                    <x-icon-print class="text-gray-400 group-hover:text-primary-600" />
                </a>
            </div>
        </div>
        
        <!-- إدارة المعلمين -->
        <div class="bg-white rounded-xl shadow-soft p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <x-icon-teachers class="text-secondary-600" />
                إدارة المعلمين
            </h3>
            <div class="space-y-3">
                <a href="{{ route('teachers.index') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-secondary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-secondary-600">قائمة المعلمين</span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <a href="{{ route('teachers.create') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-secondary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-secondary-600">إضافة معلم جديد</span>
                    <x-icon-plus class="text-gray-400 group-hover:text-secondary-600" />
                </a>
            </div>
        </div>
    </div>

    <!-- الوحدات الأكاديمية والمالية -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- الدرجات والحضور -->
        <div class="bg-white rounded-xl shadow-soft p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <x-icon-grades class="text-primary-600" />
                الوحدات الأكاديمية
            </h3>
            <div class="space-y-3">
                <a href="{{ route('grades.index') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-primary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-primary-600">إدارة الدرجات</span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <a href="{{ route('attendance.index') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-primary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-primary-600">الحضور والغياب</span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <a href="{{ route('attendance.reports') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-primary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-primary-600">تقارير الحضور</span>
                    <x-icon-reports class="text-gray-400 group-hover:text-primary-600" />
                </a>
            </div>
        </div>
        
        <!-- المالية والرسوم -->
        <div class="bg-white rounded-xl shadow-soft p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <x-icon-fees class="text-warning-600" />
                الوحدة المالية
            </h3>
            <div class="space-y-3">
                <a href="{{ route('fees.index') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-warning-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-warning-600">إدارة الرسوم</span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <a href="{{ route('fees.create') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-warning-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-warning-600">إضافة رسوم جديدة</span>
                    <x-icon-plus class="text-gray-400 group-hover:text-warning-600" />
                </a>
            </div>
        </div>
    </div>

    <!-- الورش والتقارير -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- إدارة الورش -->
        <div class="bg-white rounded-xl shadow-soft p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <x-icon-workshop class="text-secondary-600" />
                إدارة الورش والمستودعات
            </h3>
            <div class="space-y-3">
                <a href="{{ route('workshops.index') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-secondary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-secondary-600">قائمة الورش</span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <a href="{{ route('assets.index') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-secondary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-secondary-600">الأصول الثابتة</span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <a href="{{ route('consumables.index') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-secondary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-secondary-600">المواد المستهلكة</span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- التقارير -->
        <div class="bg-white rounded-xl shadow-soft p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <x-icon-reports class="text-primary-600" />
                التقارير والإحصائيات
            </h3>
            <div class="space-y-3">
                <a href="{{ route('reports.consumables') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-primary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-primary-600">تقرير المستهلكات</span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <a href="{{ route('reports.assets') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-primary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-primary-600">تقرير الأصول</span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <a href="{{ route('reports.assignments') }}" 
                   class="flex items-center justify-between p-4 bg-gray-50 hover:bg-primary-50 rounded-lg transition-colors group">
                    <span class="font-medium text-gray-700 group-hover:text-primary-600">تقرير العُهد</span>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>