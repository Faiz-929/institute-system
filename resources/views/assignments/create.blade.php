<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">➕ إضافة عهدة جديدة</h2>
    </x-slot>

    <div class="p-6">
        {{-- ✅ فورم إضافة عهدة --}}
        <form action="{{ route('assignments.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- اختيار الورشة --}}
            <div>
                <label class="block font-bold">🔧 الورشة</label>
                <select name="workshop_id" class="w-full border rounded p-2">
                    <option value="">-- اختر ورشة --</option>
                    @foreach ($workshops as $workshop)
                        <option value="{{ $workshop->id }}">{{ $workshop->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- اختيار الأصل --}}
            <div>
                <label class="block font-bold">💻 الأصل الثابت</label>
                <select name="asset_id" class="w-full border rounded p-2">
                    <option value="">-- اختر أصل --</option>
                    @foreach ($assets as $asset)
                        <option value="{{ $asset->id }}">{{ $asset->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- اختيار المادة المستهلكة --}}
            <div>
                <label class="block font-bold">📦 المادة المستهلكة</label>
                <select name="consumable_id" class="w-full border rounded p-2">
                    <option value="">-- اختر مادة --</option>
                    @foreach ($consumables as $consumable)
                        <option value="{{ $consumable->id }}">{{ $consumable->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- المعهود إليه --}}
            <div>
                <label class="block font-bold">👤 المعهود إليه</label>
                <input type="text" name="assigned_to" class="w-full border rounded p-2" required>
            </div>

            {{-- تاريخ التسليم --}}
            <div>
                <label class="block font-bold">📅 تاريخ التسليم</label>
                <input type="date" name="assigned_date" class="w-full border rounded p-2">
            </div>

            {{-- تاريخ الاسترجاع --}}
            <div>
                <label class="block font-bold">📅 تاريخ الاسترجاع</label>
                <input type="date" name="return_date" class="w-full border rounded p-2">
            </div>

            {{-- الملاحظات --}}
            <div>
                <label class="block font-bold">📝 ملاحظات</label>
                <textarea name="note" class="w-full border rounded p-2"></textarea>
            </div>

            {{-- زر الحفظ --}}
            <button class="bg-green-600 text-white px-4 py-2 rounded">💾 حفظ</button>
        </form>
    </div>
</x-app-layout>
