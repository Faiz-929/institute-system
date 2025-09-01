<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">رسوم الطلاب</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">
        <div class="mb-4 flex items-center gap-2">
            <a href="{{ route('fees.create') }}" class="px-3 py-2 rounded bg-blue-600 text-white">+ إضافة رسوم</a>
            <form method="GET" class="ml-auto flex gap-2">
                <select name="status" class="border rounded px-2 py-1">
                    <option value="">كل الحالات</option>
                    @foreach(['pending'=>'قيد السداد','partial'=>'سداد جزئي','paid'=>'مدفوع'] as $k=>$v)
                        <option value="{{ $k }}" @selected(request('status')===$k)>{{ $v }}</option>
                    @endforeach
                </select>
                <button class="px-3 py-1 border rounded">تصفية</button>
            </form>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-right">
                    <tr>
                        <th class="p-2">#</th>
                        <th class="p-2">الطالب</th>
                        <th class="p-2">العنوان</th>
                        <th class="p-2">المستحق</th>
                        <th class="p-2">المدفوع</th>
                        <th class="p-2">المتبقي</th>
                        <th class="p-2">الحالة</th>
                        <th class="p-2">خيارات</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($fees as $fee)
                    <tr class="border-t">
                        <td class="p-2">{{ $fee->id }}</td>
                        <td class="p-2">{{ $fee->student->name ?? '-' }}</td>
                        <td class="p-2">{{ $fee->title }}</td>
                        <td class="p-2">{{ number_format($fee->amount_due,2) }}</td>
                        <td class="p-2">{{ number_format($fee->paid_total,2) }}</td>
                        <td class="p-2">{{ number_format($fee->remaining,2) }}</td>
                        <td class="p-2">
                            @php $colors=['pending'=>'bg-yellow-100 text-yellow-800','partial'=>'bg-blue-100 text-blue-800','paid'=>'bg-green-100 text-green-800']; @endphp
                            <span class="px-2 py-1 rounded text-xs {{ $colors[$fee->status] ?? 'bg-gray-100' }}">
                                {{ ['pending'=>'قيد السداد','partial'=>'سداد جزئي','paid'=>'مدفوع'][$fee->status] ?? $fee->status }}
                            </span>
                        </td>
                        <td class="p-2">
                            <a href="{{ route('fees.show',$fee) }}" class="text-blue-600 hover:underline">عرض</a>
                            <span class="mx-1">|</span>
                            <a href="{{ route('fees.edit',$fee) }}" class="text-amber-600 hover:underline">تعديل</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $fees->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
