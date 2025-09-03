<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">👁 تفاصيل العهدة</h2>
    </x-slot>

    <div class="p-6 space-y-2">
        <p><strong>🔧 الورشة:</strong> {{ $assignment->workshop->name ?? '-' }}</p>
        <p><strong>💻 الأصل:</strong> {{ $assignment->asset->name ?? '-' }}</p>
        <p><strong>📦 المادة المستهلكة:</strong> {{ $assignment->consumable->name ?? '-' }}</p>
        <p><strong>👤 المعهود إليه:</strong> {{ $assignment->assigned_to }}</p>
        <p><strong>📅 تاريخ التسليم:</strong> {{ $assignment->assigned_date }}</p>
        <p><strong>📅 تاريخ الاسترجاع:</strong> {{ $assignment->return_date ?? '-' }}</p>
        <p><strong>📝 ملاحظات:</strong> {{ $assignment->note ?? '-' }}</p>

        {{-- زر رجوع --}}
        <a href="{{ route('assignments.index') }}" class="mt-4 inline-block bg-gray-600 text-white px-4 py-2 rounded">⬅ رجوع</a>
    </div>
</x-app-layout>
