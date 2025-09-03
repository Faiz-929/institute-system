<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">✏ تعديل الورشة</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('workshops.update', $workshop) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold">اسم الورشة</label>
                <input type="text" name="name" value="{{ $workshop->name }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-bold">الوصف</label>
                <textarea name="description" class="w-full border rounded p-2">{{ $workshop->description }}</textarea>
            </div>

            <div>
                <label class="block font-bold">الموقع</label>
                <input type="text" name="location" value="{{ $workshop->location }}" class="w-full border rounded p-2">
            </div>

            <button class="bg-yellow-600 text-white px-4 py-2 rounded">💾 تحديث</button>
        </form>
    </div>
</x-app-layout>
