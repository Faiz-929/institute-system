<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">✏ تعديل مادة</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('consumables.update', $consumable) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-bold">اسم المادة</label>
                <input type="text" name="name" value="{{ $consumable->name }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-bold">الكمية</label>
                <input type="number" step="0.01" name="quantity" value="{{ $consumable->quantity }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-bold">الوحدة</label>
                <input type="text" name="unit" value="{{ $consumable->unit }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-bold">الورشة</label>
                <select name="workshop_id" class="w-full border rounded p-2" required>
                    @foreach ($workshops as $workshop)
                        <option value="{{ $workshop->id }}" 
                            {{ $consumable->workshop_id == $workshop->id ? 'selected' : '' }}>
                            {{ $workshop->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="bg-yellow-600 text-white px-4 py-2 rounded">💾 تحديث</button>
        </form>
    </div>
</x-app-layout>
