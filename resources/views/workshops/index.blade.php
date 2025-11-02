<x-app-layout>
    <x-slot name="header">
        قائمة الورش
    </x-slot>

    <!-- أزرار الإجراءات -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <a href="{{ route('workshops.create') }}" 
           class="inline-flex items-center gap-2 px-6 py-2.5 bg-success-600 hover:bg-success-700 text-white font-medium rounded-lg transition-colors shadow-sm">
            <x-icon-plus />
            <span>إضافة ورشة جديدة</span>
        </a>

        <!-- إحصائيات -->
        <div class="flex gap-4">
            <div class="bg-white rounded-lg shadow-soft px-4 py-2 border-r-4 border-secondary-500">
                <p class="text-xs text-gray-500">إجمالي الورش</p>
                <p class="text-lg font-bold text-gray-800">{{ $workshops->total() }}</p>
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
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">اسم الورشة</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الموقع</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الوصف</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($workshops as $workshop)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-primary-600">
                                {{ $loop->iteration + ($workshops->currentPage() - 1) * $workshops->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-secondary-400 to-secondary-600 flex items-center justify-center text-white font-semibold">
                                        <x-icon-workshop class="w-5 h-5" />
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ $workshop->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $workshop->location ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ Str::limit($workshop->description ?? '-', 50) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('workshops.show', $workshop) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors"
                                       title="عرض">
                                        <x-icon-eye />
                                    </a>
                                    <a href="{{ route('workshops.edit', $workshop) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-warning-500 hover:bg-warning-600 text-white rounded-lg transition-colors"
                                       title="تعديل">
                                        <x-icon-edit />
                                    </a>
                                    <form action="{{ route('workshops.destroy', $workshop) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذه الورشة؟');">
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
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <x-icon-workshop class="w-16 h-16 text-gray-300" />
                                    <p class="text-gray-500 font-medium">لا توجد ورش مسجلة حتى الآن</p>
                                    <a href="{{ route('workshops.create') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                        <x-icon-plus />
                                        <span>إضافة ورشة جديدة</span>
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
    @if($workshops->hasPages())
        <div class="mt-6">
            {{ $workshops->links() }}
        </div>
    @endif
</x-app-layout>