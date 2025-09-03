<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-bold">📘 تفاصيل الأصل</h2></x-slot>

    <div class="p-6 max-w-4xl mx-auto space-y-4">

        {{-- بطاقة التفاصيل --}}
        <div class="bg-white p-4 rounded shadow">
            @php
                $colors = [
                    'available' => 'bg-green-100 text-green-800',
                    'in_use' => 'bg-blue-100 text-blue-800',
                    'maintenance' => 'bg-amber-100 text-amber-800',
                    'retired' => 'bg-gray-200 text-gray-700',
                ];
            @endphp

            <div class="grid sm:grid-cols-2 gap-3 text-sm">
                <div><span class="text-gray-500">الاسم:</span> {{ $asset->name }}</div>
                <div><span class="text-gray-500">الورشة:</span> {{ $asset->workshop->name ?? '-' }}</div>
                <div><span class="text-gray-500">الرقم التسلسلي:</span> {{ $asset->serial_number ?: '-' }}</div>
                <div><span class="text-gray-500">تاريخ الشراء:</span> {{ optional($asset->purchase_date)->format('Y-m-d') ?: '-' }}</div>
                <div class="sm:col-span-2">
                    <span class="text-gray-500">الحالة:</span>
                    <span class="px-2 py-1 rounded text-xs {{ $colors[$asset->status] ?? 'bg-gray-100' }}">
                        {{ $statusLabels[$asset->status] ?? $asset->status }}
                    </span>
                </div>
            </div>
        </div>

        {{-- أزرار الإجراء --}}
        <div class="flex gap-2">
            <a class="px-4 py-2 rounded bg-amber-600 text-white" href="{{ route('assets.edit',$asset) }}">تعديل</a>
            <form method="POST" action="{{ route('assets.destroy',$asset) }}" onsubmit="return confirm('حذف الأصل؟')">
                @csrf @method('DELETE')
                <button class="px-4 py-2 rounded bg-red-600 text-white">حذف</button>
            </form>
            <a class="px-4 py-2 rounded border" href="{{ route('assets.index') }}">رجوع</a>
        </div>

    </div>
</x-app-layout>
