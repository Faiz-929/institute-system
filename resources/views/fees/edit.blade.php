<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-bold">تعديل الرسوم</h2></x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">
        <form method="POST" action="{{ route('fees.update',$fee) }}" class="space-y-4 bg-white p-4 rounded shadow">
            @csrf @method('PUT')
            <div>
                <label class="block mb-1">الطالب</label>
                <select name="student_id" class="w-full border rounded p-2" required>
                    @foreach($students as $id=>$name)
                        <option value="{{ $id }}" @selected($fee->student_id==$id)>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1">العنوان</label>
                <input type="text" name="title" value="{{ old('title',$fee->title) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">المبلغ المستحق</label>
                <input type="number" step="0.01" min="0" name="amount_due" value="{{ old('amount_due',$fee->amount_due) }}" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block mb-1">تاريخ الاستحقاق</label>
                <input type="date" name="due_date" value="{{ old('due_date',$fee->due_date) }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1">ملاحظات</label>
                <textarea name="notes" class="w-full border rounded p-2" rows="3">{{ old('notes',$fee->notes) }}</textarea>
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">حفظ</button>
                <a href="{{ route('fees.show',$fee) }}" class="px-4 py-2 border rounded">إلغاء</a>
            </div>
        </form>
    </div>
</x-app-layout>
