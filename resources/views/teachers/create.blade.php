<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight text-right">إضافة معلم</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto text-right">
            <form action="{{ route('teachers.store') }}" method="POST" class="bg-white p-6 rounded shadow">
                @csrf

                @foreach([
                    'name' => 'الاسم',
                    'qualification' => 'المؤهل',
                    'subject' => 'المادة',
                    'phone' => 'رقم الهاتف',
                    'home_phone' => 'رقم هاتف المنزل',
                    'address' => 'العنوان'
                ] as $field => $label)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                        <input type="text" name="{{ $field }}" value="{{ old($field) }}" class="mt-1 w-full border rounded px-3 py-2 text-right">
                        @error($field)
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                <button class="bg-green-600 text-white px-4 py-2 rounded">💾 حفظ المعلم</button>
            </form>
        </div>
    </div>
</x-app-layout>
