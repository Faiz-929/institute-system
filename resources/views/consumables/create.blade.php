<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">➕ إضافة مادة مستهلكة</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('consumables.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-bold">اسم المادة</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-bold">الكمية</label>
                <input type="number" step="0.01" name="quantity" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-bold">الوحدة</label>
                <input type="text" name="unit" value="pcs" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-bold">الورشة</label>
                <select name="workshop_id" class="w-full border rounded p-2" required>
                    <option value="">-- اختر ورشة --</option>
                    @foreach ($workshops as $workshop)
                        <option value="{{ $workshop->id }}">{{ $workshop->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">💾 حفظ</button>
        </form>
    </div>
</x-app-layout>
