<x-app-layout>
    <x-slot name="header">
        قائمة المعلمين
    </x-slot>

    <!-- أزرار الإجراءات -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <a href="{{ route('teachers.create') }}" 
           class="inline-flex items-center gap-2 px-6 py-2.5 bg-success-600 hover:bg-success-700 text-white font-medium rounded-lg transition-colors shadow-sm">
            <x-icon-plus />
            <span>إضافة معلم جديد</span>
        </a>

        <div class="flex gap-3">
            <button onclick="window.print()" 
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                <x-icon-print />
                <span>طباعة</span>
            </button>
        </div>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-soft p-6 border-r-4 border-primary-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">إجمالي المعلمين</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ is_object($teachers) && method_exists($teachers, 'total') ? $teachers->total() : count($teachers) }}</h3>
                </div>
                <div class="bg-primary-100 p-4 rounded-xl">
                    <x-icon-teachers class="w-8 h-8 text-primary-600" />
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft p-6 border-r-4 border-success-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">معلمين نشطين</p>
                    <h3 class="text-3xl font-bold text-gray-800">
                        {{ \App\Models\Teacher::count() }}
                    </h3>
                </div>
                <div class="bg-success-100 p-4 rounded-xl">
                    <svg class="w-8 h-8 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-soft p-6 border-r-4 border-secondary-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">التخصصات</p>
                    <h3 class="text-3xl font-bold text-gray-800">
                        {{ \App\Models\Teacher::distinct('subject')->count('subject') }}
                    </h3>
                </div>
                <div class="bg-secondary-100 p-4 rounded-xl">
                    <x-icon-document class="w-8 h-8 text-secondary-600" />
                </div>
            </div>
        </div>
    </div>

    <!-- الجدول -->
    <div class="bg-white rounded-xl shadow-soft overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الاسم</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">المؤهل</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">المادة</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">رقم الجوال</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">هاتف المنزل</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">العنوان</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($teachers as $teacher)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-primary-600">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center text-white font-semibold">
                                        {{ mb_substr($teacher->name, 0, 2) }}
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ $teacher->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-secondary-50 text-secondary-700">
                                    {{ $teacher->qualification ?? 'غير محدد' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $teacher->subject ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700" dir="ltr">
                                {{ $teacher->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700" dir="ltr">
                                {{ $teacher->home_phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $teacher->address ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('teachers.edit', $teacher) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-warning-500 hover:bg-warning-600 text-white rounded-lg transition-colors"
                                       title="تعديل">
                                        <x-icon-edit />
                                    </a>
                                    <form action="{{ route('teachers.destroy', $teacher) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المعلم؟');">
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
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <x-icon-teachers class="w-16 h-16 text-gray-300" />
                                    <p class="text-gray-500 font-medium">لا يوجد معلمين حتى الآن</p>
                                    <a href="{{ route('teachers.create') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                        <x-icon-plus />
                                        <span>إضافة معلم جديد</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>