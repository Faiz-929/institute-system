{{-- ✅ نستخدم الـ Layout العام --}}
<x-app-layout>
    {{-- ✅ عنوان الصفحة --}}
    <x-slot name="header">
        <h2 class="text-xl font-bold">📋 قائمة العُهد</h2>
    </x-slot>

    <div class="p-6">
        {{-- ✅ زر إضافة عهدة جديدة --}}
        <a href="{{ route('assignments.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded">➕ إضافة عهدة</a>

        {{-- ✅ رسالة نجاح بعد أي عملية --}}
        @if(session('success'))
            <div class="mt-4 p-2 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- ✅ جدول عرض العُهد --}}
        <table class="w-full mt-6 border text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">الورشة</th>
                    <th class="p-2 border">الأصل</th>
                    <th class="p-2 border">المادة المستهلكة</th>
                    <th class="p-2 border">المعهود إليه</th>
                    <th class="p-2 border">تاريخ التسليم</th>
                    <th class="p-2 border">تاريخ الاسترجاع</th>
                    <th class="p-2 border">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                {{-- ✅ نمر على جميع العُهد --}}
                @foreach ($assignments as $assignment)
                    <tr>
                        <td class="p-2 border">{{ $loop->iteration }}</td>
                        <td class="p-2 border">{{ $assignment->workshop->name ?? '-' }}</td>
                        <td class="p-2 border">{{ $assignment->asset->name ?? '-' }}</td>
                        <td class="p-2 border">{{ $assignment->consumable->name ?? '-' }}</td>
                        <td class="p-2 border">{{ $assignment->assigned_to }}</td>
                        <td class="p-2 border">{{ $assignment->assigned_date }}</td>
                        <td class="p-2 border">{{ $assignment->return_date ?? '-' }}</td>
                        <td class="p-2 border space-x-2">
                            {{-- 👁 عرض --}}
                            <a href="{{ route('assignments.show', $assignment) }}" class="text-blue-600">👁</a>
                            {{-- ✏ تعديل --}}
                            <a href="{{ route('assignments.edit', $assignment) }}" class="text-yellow-600">✏</a>
                            {{-- ❌ حذف --}}
                            <form action="{{ route('assignments.destroy', $assignment) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('هل أنت متأكد من الحذف؟')" class="text-red-600">❌</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ✅ روابط الصفحات (Pagination) --}}
        <div class="mt-4">
            {{ $assignments->links() }}
        </div>
    </div>
</x-app-layout>
