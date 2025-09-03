<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">✏ تعديل عهدة</h2>
    </x-slot>

    <div class="p-6">
        {{-- ✅ فورم التعديل --}}
        <form action="{{ route('assignments.update', $assignment) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- نفس الحقول مثل create مع قيم افتراضية من $assignment --}}
            <div>
                <label class="block font-bold">🔧 الورشة</label>
                <select name="workshop_id" class="w-full border rounded p-2">
                    <option value="">-- اختر ورشة --</option>
                    @foreach ($workshops as $workshop)
                        <option value="{{ $workshop->id }}" {{ $assignment->workshop_id == $workshop->id ? 'selected' : '' }}>
                            {{ $workshop->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold">💻 الأصل الثابت</label>
                <select name="asset_id" class="w-full border rounded p-2">
                    <option value="">-- اختر أصل --</option>
                    @foreach ($assets as $asset)
                        <option value="{{ $asset->id }}" {{ $assignment->asset_id == $asset->id ? 'selected' : '' }}>
                            {{ $asset->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold">📦 المادة المستهلكة</label>
                <select name="consumable_id" class="w-full border rounded p-2">
                    <option value="">-- اختر مادة --</option>
                    @foreach ($consumables as $consumable)
                        <option value="{{ $consumable->id }}" {{ $assignment->consumable_id == $consumable->id ? 'selected' : '' }}>
                            {{ $consumable->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold">👤 المعهود إليه</label>
                <input type="text" name="assigned_to" value="{{ $assignment->assigned_to }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-bold">📅 تاريخ التسليم</label>
                <input type="date" name="assigned_date" value="{{ $assignment->assigned_date }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-bold">📅 تاريخ الاسترجاع</label>
                <input type="date" name="return_date" value="{{ $assignment->return_date }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-bold">📝 ملاحظات</label>
                <textarea name="note" class="w-full border rounded p-2">{{ $assignment->note }}</textarea>
            </div>

            <button class="bg-yellow-600 text-white px-4 py-2 rounded">💾 تحديث</button>
        </form>
    </div>
</x-app-layout>
