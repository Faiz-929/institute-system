<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-bold">إضافة رسوم</h2></x-slot>

    <div class="py-6 max-w-3xl mx-auto px-4">
        <form method="POST" action="{{ route('fees.store') }}" class="space-y-4 bg-white p-4 rounded shadow">
            @csrf
            <div>
                <label class="block mb-1">الطالب</label>
                <select name="student_id" class="w-full border rounded p-2" required>
                    <option value="">اختر الطالب</option>
                    @foreach($students as $id=>$name)
                        <option value="{{ $id }}" @selected(old('student_id')==$id)>{{ $name }}</option>
                    @endforeach
                </select>
                @error('student_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">عنوان الرسوم (اختياري)</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block mb-1">المبلغ المستحق</label>
                <input type="number" step="0.01" min="0" name="amount_due" value="{{ old('amount_due') }}" class="w-full border rounded p-2" required>
                @error('amount_due') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block mb-1">تاريخ الاستحقاق</label>
                <input type="date" name="due_date" value="{{ old('due_date') }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block mb-1">ملاحظات</label>
                <textarea name="notes" class="w-full border rounded p-2" rows="3">{{ old('notes') }}</textarea>
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">حفظ</button>
                <a href="{{ route('fees.index') }}" class="px-4 py-2 border rounded">إلغاء</a>
            </div>
        </form>
    </div>
</x-app-layout>
