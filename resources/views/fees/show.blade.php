<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-bold">تفاصيل الرسوم #{{ $fee->id }}</h2></x-slot>

    <div class="py-6 max-w-5xl mx-auto px-4 space-y-6">

        <div class="bg-white rounded shadow p-4">
            <div class="grid md:grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-500">الطالب:</span> {{ $fee->student->name ?? '-' }}</div>
                <div><span class="text-gray-500">العنوان:</span> {{ $fee->title }}</div>
                <div><span class="text-gray-500">المستحق:</span> {{ number_format($fee->amount_due,2) }}</div>
                <div><span class="text-gray-500">المدفوع:</span> {{ number_format($fee->paid_total,2) }}</div>
                <div><span class="text-gray-500">المتبقي:</span> {{ number_format($fee->remaining,2) }}</div>
                <div><span class="text-gray-500">الاستحقاق:</span> {{ $fee->due_date }}</div>
                <div><span class="text-gray-500">الحالة:</span>
                    {{ ['pending'=>'قيد السداد','partial'=>'سداد جزئي','paid'=>'مدفوع'][$fee->status] ?? $fee->status }}
                </div>
                <div class="md:col-span-2"><span class="text-gray-500">ملاحظات:</span> {{ $fee->notes }}</div>
            </div>
        </div>

        <div class="bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-3">إضافة دفعة</h3>
            <form method="POST" action="{{ route('fees.payments.store', $fee) }}" class="grid md:grid-cols-5 gap-3 items-end">
                @csrf
                <div>
                    <label class="block mb-1">المبلغ</label>
                    <input type="number" step="0.01" min="0.01" name="amount" class="w-full border rounded p-2" required>
                    @error('amount') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block mb-1">تاريخ الدفع</label>
                    <input type="date" name="paid_at" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block mb-1">الطريقة</label>
                    <input type="text" name="method" class="w-full border rounded p-2" placeholder="نقدي / حوالة">
                </div>
                <div>
                    <label class="block mb-1">مرجع</label>
                    <input type="text" name="reference" class="w-full border rounded p-2" placeholder="رقم إيصال">
                </div>
                <div>
                    <label class="block mb-1">ملاحظة</label>
                    <input type="text" name="note" class="w-full border rounded p-2">
                </div>
                <div class="md:col-span-5">
                    <button class="px-4 py-2 bg-green-600 text-white rounded">إضافة الدفعة</button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-3">سجل الدفعات</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-right">
                        <tr>
                            <th class="p-2">#</th>
                            <th class="p-2">المبلغ</th>
                            <th class="p-2">التاريخ</th>
                            <th class="p-2">الطريقة</th>
                            <th class="p-2">المرجع</th>
                            <th class="p-2">المستلم</th>
                            <th class="p-2">ملاحظة</th>
                            <th class="p-2">حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fee->payments as $p)
                            <tr class="border-t">
                                <td class="p-2">{{ $p->id }}</td>
                                <td class="p-2">{{ number_format($p->amount,2) }}</td>
                                <td class="p-2">{{ $p->paid_at }}</td>
                                <td class="p-2">{{ $p->method }}</td>
                                <td class="p-2">{{ $p->reference }}</td>
                                <td class="p-2">{{ $p->receiver->name ?? '-' }}</td>
                                <td class="p-2">{{ $p->note }}</td>
                                <td class="p-2">
                                    <form method="POST" action="{{ route('fees.payments.destroy',$p) }}" onsubmit="return confirm('حذف الدفعة؟')">
                                        @csrf @method('DELETE')
                                        <button class="px-2 py-1 text-white bg-red-600 rounded">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td class="p-4 text-center text-gray-500" colspan="8">لا توجد دفعات</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('fees.edit',$fee) }}" class="px-4 py-2 bg-amber-600 text-white rounded">تعديل</a>
            <form method="POST" action="{{ route('fees.destroy',$fee) }}" onsubmit="return confirm('حذف الرسوم؟')">
                @csrf @method('DELETE')
                <button class="px-4 py-2 bg-red-600 text-white rounded">حذف</button>
            </form>
            <a href="{{ route('fees.index') }}" class="px-4 py-2 border rounded">رجوع</a>
        </div>

    </div>
</x-app-layout>
