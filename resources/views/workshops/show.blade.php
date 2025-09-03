<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📋 تفاصيل الورشة</h2>
    </x-slot>

    <div class="p-6">
        <p><strong>اسم الورشة:</strong> {{ $workshop->name }}</p>
        <p><strong>الوصف:</strong> {{ $workshop->description }}</p>
        <p><strong>الموقع:</strong> {{ $workshop->location }}</p>

        <div class="mt-4">
            <a href="{{ route('workshops.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">⬅ رجوع</a>
        </div>
    </div>
</x-app-layout>
