<x-app-layout>
    <x-slot name="header">
        رسوم الطلاب
    </x-slot>

    <!-- شريط الأدوات -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <a href="{{ route('fees.create') }}" 
           class="inline-flex items-center gap-2 px-6 py-2.5 bg-success-600 hover:bg-success-700 text-white font-medium rounded-lg transition-colors shadow-sm">
            <x-icon-plus />
            <span>إضافة رسوم جديدة</span>
        </a>

        <!-- إحصائيات سريعة -->
        <div class="flex gap-4">
            <div class="bg-white rounded-lg shadow-soft px-4 py-2 border-r-4 border-warning-500">
                <p class="text-xs text-gray-500">إجمالي المستحق</p>
                <p class="text-lg font-bold text-gray-800">
                    {{ number_format($fees->sum('amount_due'), 0) }} ريال
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-soft px-4 py-2 border-r-4 border-success-500">
                <p class="text-xs text-gray-500">إجمالي المدفوع</p>
                <p class="text-lg font-bold text-gray-800">
                    {{ number_format($fees->sum('paid_total'), 0) }} ريال
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-soft px-4 py-2 border-r-4 border-danger-500">
                <p class="text-xs text-gray-500">إجمالي المتبقي</p>
                <p class="text-lg font-bold text-gray-800">
                    {{ number_format($fees->sum('remaining'), 0) }} ريال
                </p>
            </div>
        </div>
    </div>

    <!-- فلاتر البحث -->
    <div class="bg-white rounded-xl shadow-soft p-6 mb-6">
        <form method="GET" action="{{ route('fees.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
                <select name="status" class="block w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                    <option value="">جميع الحالات</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد السداد</option>
                    <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>سداد جزئي</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>مدفوع</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">بحث عن طالب</label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <x-icon-search class="text-gray-400" />
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="ابحث باسم الطالب"
                           class="block w-full pr-10 border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                    تطبيق
                </button>
                <a href="{{ route('fees.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    إعادة
                </a>
            </div>
        </form>
    </div>

    <!-- الجدول -->
    <div class="bg-white rounded-xl shadow-soft overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الطالب</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">العنوان</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">المستحق</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">المدفوع</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">المتبقي</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($fees as $fee)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-primary-600">
                                {{ $loop->iteration + ($fees->currentPage() - 1) * $fees->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-warning-400 to-warning-600 flex items-center justify-center text-white font-semibold">
                                        {{ mb_substr($fee->student->name ?? 'غ', 0, 2) }}
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ $fee->student->name ?? 'غير محدد' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $fee->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ number_format($fee->amount_due, 2) }} ريال
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-success-600">
                                {{ number_format($fee->paid_total, 2) }} ريال
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-danger-600">
                                {{ number_format($fee->remaining, 2) }} ريال
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-warning-100 text-warning-800',
                                        'partial' => 'bg-primary-100 text-primary-800',
                                        'paid' => 'bg-success-100 text-success-800'
                                    ];
                                    $statusLabels = [
                                        'pending' => 'قيد السداد',
                                        'partial' => 'سداد جزئي',
                                        'paid' => 'مدفوع'
                                    ];
                                @endphp
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$fee->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$fee->status] ?? $fee->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('fees.show', $fee) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors"
                                       title="عرض">
                                        <x-icon-eye />
                                    </a>
                                    <a href="{{ route('fees.edit', $fee) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-warning-500 hover:bg-warning-600 text-white rounded-lg transition-colors"
                                       title="تعديل">
                                        <x-icon-edit />
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <x-icon-fees class="w-16 h-16 text-gray-300" />
                                    <p class="text-gray-500 font-medium">لا توجد رسوم مسجلة حتى الآن</p>
                                    <a href="{{ route('fees.create') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                        <x-icon-plus />
                                        <span>إضافة رسوم جديدة</span>
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
    @if($fees->hasPages())
        <div class="mt-6">
            {{ $fees->links() }}
        </div>
    @endif
</x-app-layout>