<x-app-layout>
    <x-slot name="header">
        المواد المستهلكة
    </x-slot>

    <!-- أزرار الإجراءات -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <a href="{{ route('consumables.create') }}" 
           class="inline-flex items-center gap-2 px-6 py-2.5 bg-success-600 hover:bg-success-700 text-white font-medium rounded-lg transition-colors shadow-sm">
            <x-icon-plus />
            <span>إضافة مادة جديدة</span>
        </a>

        <!-- إحصائيات -->
        <div class="flex gap-4">
            <div class="bg-white rounded-lg shadow-soft px-4 py-2 border-r-4 border-secondary-500">
                <p class="text-xs text-gray-500">إجمالي المواد</p>
                <p class="text-lg font-bold text-gray-800">{{ $consumables->total() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-soft px-4 py-2 border-r-4 border-warning-500">
                <p class="text-xs text-gray-500">إجمالي الكمية</p>
                <p class="text-lg font-bold text-gray-800">{{ $consumables->sum('quantity') }}</p>
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
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">اسم المادة</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الكمية</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الوحدة</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الورشة</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($consumables as $consumable)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-primary-600">
                                {{ $loop->iteration + ($consumables->currentPage() - 1) * $consumables->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-warning-400 to-warning-600 flex items-center justify-center text-white font-semibold">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ $consumable->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                    {{ $consumable->quantity > 100 ? 'bg-success-100 text-success-800' : 
                                       ($consumable->quantity > 20 ? 'bg-warning-100 text-warning-800' : 'bg-danger-100 text-danger-800') }}">
                                    {{ $consumable->quantity }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $consumable->unit }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $consumable->workshop->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('consumables.show', $consumable) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors"
                                       title="عرض">
                                        <x-icon-eye />
                                    </a>
                                    <a href="{{ route('consumables.edit', $consumable) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-warning-500 hover:bg-warning-600 text-white rounded-lg transition-colors"
                                       title="تعديل">
                                        <x-icon-edit />
                                    </a>
                                    <form action="{{ route('consumables.destroy', $consumable) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذه المادة؟');">
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
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <p class="text-gray-500 font-medium">لا توجد مواد مسجلة حتى الآن</p>
                                    <a href="{{ route('consumables.create') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                        <x-icon-plus />
                                        <span>إضافة مادة جديدة</span>
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
    @if($consumables->hasPages())
        <div class="mt-6">
            {{ $consumables->links() }}
        </div>
    @endif
</x-app-layout>