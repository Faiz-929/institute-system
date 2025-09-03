<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📋 تفاصيل مادة</h2>
    </x-slot>

    <div class="p-6">
        <p><strong>الاسم:</strong> {{ $consumable->name }}</p>
        <p><strong>الكمية:</strong> {{ $consumable->quantity }} {{ $consumable->unit }}</p>
        <p><strong>الورشة:</strong> {{ $consumable->workshop->name ?? '-' }}</p>

        <div class="mt-4">
            <a href="{{ route('consumables.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">⬅ رجوع</a>
        </div>
    </div>
</x-app-layout>
