<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">➕ إضافة ورشة جديدة</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('workshops.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block font-bold">اسم الورشة</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-bold">الوصف</label>
                <textarea name="description" class="w-full border rounded p-2"></textarea>
            </div>

            <div>
                <label class="block font-bold">الموقع</label>
                <input type="text" name="location" class="w-full border rounded p-2">
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">💾 حفظ</button>
        </form>
    </div>
</x-app-layout>
