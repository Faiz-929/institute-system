<x-app-layout>
    <x-slot name="header">
        الأصول الثابتة
    </x-slot>

    <!-- أزرار الإجراءات -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <a href="{{ route('assets.create') }}" 
           class="inline-flex items-center gap-2 px-6 py-2.5 bg-success-600 hover:bg-success-700 text-white font-medium rounded-lg transition-colors shadow-sm">
            <x-icon-plus />
            <span>إضافة أصل جديد</span>
        </a>

        <!-- إحصائيات -->
        <div class="flex gap-4">
            <div class="bg-white rounded-lg shadow-soft px-4 py-2 border-r-4 border-primary-500">
                <p class="text-xs text-gray-500">إجمالي الأصول</p>
                <p class="text-lg font-bold text-gray-800">{{ $assets->total() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-soft px-4 py-2 border-r-4 border-success-500">
                <p class="text-xs text-gray-500">متاح</p>
                <p class="text-lg font-bold text-gray-800">
                    {{ \App\Models\Asset::where('status', 'available')->count() }}
                </p>
            </div>
        </div>
    </div>

    <!-- فلاتر البحث -->
    <div class="bg-white rounded-xl shadow-soft p-6 mb-6">
        <form method="GET" action="{{ route('assets.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">الورشة</label>
                <select name="workshop_id" class="block w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                    <option value="">جميع الورش</option>
                    @foreach($workshops as $w)
                        <option value="{{ $w->id }}" {{ request('workshop_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
                <select name="status" class="block w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                    <option value="">جميع الحالات</option>
                    @foreach($statusLabels as $key => $label)
                        <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">بحث</label>
                <div class="relative">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <x-icon-search class="text-gray-400" />
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="اسم أو رقم تسلسلي"
                           class="block w-full pr-10 border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                    تطبيق
                </button>
                <a href="{{ route('assets.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
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
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الاسم</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الرقم التسلسلي</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الحالة</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الورشة</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">تاريخ الشراء</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($assets as $asset)
                        @php
                            $statusColors = [
                                'available' => 'bg-success-100 text-success-800',
                                'in_use' => 'bg-primary-100 text-primary-800',
                                'maintenance' => 'bg-warning-100 text-warning-800',
                                'retired' => 'bg-gray-100 text-gray-800',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-primary-600">
                                {{ $loop->iteration + ($assets->currentPage() - 1) * $assets->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $asset->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $asset->serial_number ?: '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$asset->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$asset->status] ?? $asset->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $asset->workshop->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ optional($asset->purchase_date)->format('Y-m-d') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('assets.show', $asset) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors"
                                       title="عرض">
                                        <x-icon-eye />
                                    </a>
                                    <a href="{{ route('assets.edit', $asset) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-warning-500 hover:bg-warning-600 text-white rounded-lg transition-colors"
                                       title="تعديل">
                                        <x-icon-edit />
                                    </a>
                                    <form action="{{ route('assets.destroy', $asset) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا الأصل؟');">
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
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <x-icon-document class="w-16 h-16 text-gray-300" />
                                    <p class="text-gray-500 font-medium">لا توجد أصول مسجلة حتى الآن</p>
                                    <a href="{{ route('assets.create') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                        <x-icon-plus />
                                        <span>إضافة أصل جديد</span>
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
    @if($assets->hasPages())
        <div class="mt-6">
            {{ $assets->links() }}
        </div>
    @endif
</x-app-layout>