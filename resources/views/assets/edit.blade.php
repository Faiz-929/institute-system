<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-bold">✏️ تعديل الأصل</h2></x-slot>

    <div class="p-6 max-w-3xl mx-auto">
        @if ($errors->any())
            <div class="mb-4 p-3 rounded bg-red-50 text-red-700">
                <ul class="list-disc ms-5">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('assets.update', $asset) }}" class="bg-white p-4 rounded shadow space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block mb-1 font-medium">اسم الأصل</label>
                <input type="text" name="name" value="{{ old('name',$asset->name) }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">الرقم التسلسلي</label>
                <input type="text" name="serial_number" value="{{ old('serial_number',$asset->serial_number) }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block mb-1 font-medium">تاريخ الشراء</label>
                <input type="date" name="purchase_date" value="{{ old('purchase_date', optional($asset->purchase_date)->format('Y-m-d')) }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block mb-1 font-medium">الحالة</label>
                <select name="status" class="w-full border rounded p-2" required>
                    @foreach($statusLabels as $key => $label)
                        <option value="{{ $key }}" @selected(old('status',$asset->status)===$key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">الورشة</label>
                <select name="workshop_id" class="w-full border rounded p-2" required>
                    @foreach($workshops as $w)
                        <option value="{{ $w->id }}" @selected(old('workshop_id',$asset->workshop_id)==$w->id)>{{ $w->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 bg-yellow-600 text-white rounded">💾 تحديث</button>
                <a href="{{ route('assets.show',$asset) }}" class="px-4 py-2 border rounded">إلغاء</a>
            </div>
        </form>
    </div>
</x-app-layout>
