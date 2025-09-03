<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📦 المواد المستهلكة</h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('consumables.create') }}" 
        class="bg-blue-600 text-white px-4 py-2 rounded">➕ إضافة مادة</a>

        @if(session('success'))
            <div class="mt-4 p-2 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full mt-6 border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">الاسم</th>
                    <th class="p-2 border">الكمية</th>
                    <th class="p-2 border">الوحدة</th>
                    <th class="p-2 border">الورشة</th>
                    <th class="p-2 border">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consumables as $consumable)
                    <tr>
                        <td class="p-2 border">{{ $loop->iteration }}</td>
                        <td class="p-2 border">{{ $consumable->name }}</td>
                        <td class="p-2 border">{{ $consumable->quantity }}</td>
                        <td class="p-2 border">{{ $consumable->unit }}</td>
                        <td class="p-2 border">{{ $consumable->workshop->name ?? '-' }}</td>
                        <td class="p-2 border">
                            <a href="{{ route('consumables.show', $consumable) }}" class="text-blue-600">👁 عرض</a> |
                            <a href="{{ route('consumables.edit', $consumable) }}" class="text-yellow-600">✏ تعديل</a> |
                            <form action="{{ route('consumables.destroy', $consumable) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('هل أنت متأكد من الحذف؟')" class="text-red-600">❌ حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $consumables->links() }}
        </div>
    </div>
</x-app-layout>
