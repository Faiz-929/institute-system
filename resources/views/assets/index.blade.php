<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">🏷️ الأصول الثابتة</h2>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">

        {{-- أزرار وإشعارات --}}
        <div class="flex items-center gap-2 mb-4">
            <a href="{{ route('assets.create') }}" class="px-4 py-2 rounded bg-blue-600 text-white">➕ إضافة أصل</a>

            @if(session('success'))
                <div class="ml-auto px-3 py-2 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        {{-- فورم الفلاتر والبحث --}}
        <form method="GET" class="bg-white p-3 rounded shadow flex flex-wrap items-end gap-3 mb-4">
            {{-- فلتر الورشة --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">الورشة</label>
                <select name="workshop_id" class="border rounded px-2 py-1">
                    <option value="">الكل</option>
                    @foreach($workshops as $w)
                        <option value="{{ $w->id }}" @selected(request('workshop_id')==$w->id)>{{ $w->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- فلتر الحالة --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">الحالة</label>
                <select name="status" class="border rounded px-2 py-1">
                    <option value="">الكل</option>
                    @foreach($statusLabels as $key => $label)
                        <option value="{{ $key }}" @selected(request('status')===$key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- البحث العام --}}
            <div class="flex-1 min-w-[220px]">
                <label class="block text-sm text-gray-600 mb-1">بحث (اسم/رقم تسلسلي)</label>
                <input type="text" name="search" value="{{ request('search') }}" class="w-full border rounded px-2 py-1" placeholder="مثال: مكبس هواء / SN123...">
            </div>

            <button class="px-4 py-2 border rounded">تطبيق</button>
            <a href="{{ route('assets.index') }}" class="px-4 py-2 border rounded">تفريغ</a>
        </form>

        {{-- جدول النتائج --}}
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-right">
                    <tr>
                        <th class="p-2">#</th>
                        <th class="p-2">الاسم</th>
                        <th class="p-2">الرقم التسلسلي</th>
                        <th class="p-2">الحالة</th>
                        <th class="p-2">الورشة</th>
                        <th class="p-2">تاريخ الشراء</th>
                        <th class="p-2">خيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $asset)
                        @php
                            // ألوان الشارات حسب الحالة
                            $colors = [
                                'available' => 'bg-green-100 text-green-800',
                                'in_use' => 'bg-blue-100 text-blue-800',
                                'maintenance' => 'bg-amber-100 text-amber-800',
                                'retired' => 'bg-gray-200 text-gray-700',
                            ];
                        @endphp
                        <tr class="border-t">
                            <td class="p-2">{{ $asset->id }}</td>
                            <td class="p-2 font-medium">{{ $asset->name }}</td>
                            <td class="p-2">{{ $asset->serial_number ?: '-' }}</td>
                            <td class="p-2">
                                <span class="px-2 py-1 rounded text-xs {{ $colors[$asset->status] ?? 'bg-gray-100' }}">
                                    {{ $statusLabels[$asset->status] ?? $asset->status }}
                                </span>
                            </td>
                            <td class="p-2">{{ $asset->workshop->name ?? '-' }}</td>
                            <td class="p-2">{{ optional($asset->purchase_date)->format('Y-m-d') }}</td>
                            <td class="p-2">
                                <a href="{{ route('assets.show',$asset) }}" class="text-blue-600 hover:underline">عرض</a>
                                <span class="mx-1">|</span>
                                <a href="{{ route('assets.edit',$asset) }}" class="text-amber-600 hover:underline">تعديل</a>
                                <span class="mx-1">|</span>
                                <form action="{{ route('assets.destroy',$asset) }}" method="POST" class="inline" onsubmit="return confirm('حذف الأصل؟')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="p-4 text-center text-gray-500" colspan="7">لا توجد أصول</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ترقيم الصفحات --}}
        <div class="mt-4">
            {{ $assets->links() }}
        </div>
    </div>
</x-app-layout>
