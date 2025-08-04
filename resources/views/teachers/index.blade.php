<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight text-right">قائمة المعلمين</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-right">
            <a href="{{ route('teachers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">➕ إضافة معلم</a>

            @if(session('success'))
                <div class="mt-4 text-green-600">{{ session('success') }}</div>
            @endif

            <div class="mt-6 bg-white p-4 shadow rounded overflow-x-auto">
                <table class="w-full border text-sm text-right">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-2 py-1">الاسم</th>
                            <th class="border px-2 py-1">المؤهل</th>
                            <th class="border px-2 py-1">المادة</th>
                            <th class="border px-2 py-1">الهاتف</th>
                            <th class="border px-2 py-1">هاتف المنزل</th>
                            <th class="border px-2 py-1">العنوان</th>
                            <th class="border px-2 py-1">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                        <tr class="border-t">
                            <td class="border px-2 py-1">{{ $teacher->name }}</td>
                            <td class="border px-2 py-1">{{ $teacher->qualification }}</td>
                            <td class="border px-2 py-1">{{ $teacher->subject }}</td>
                            <td class="border px-2 py-1">{{ $teacher->phone }}</td>
                            <td class="border px-2 py-1">{{ $teacher->home_phone }}</td>
                            <td class="border px-2 py-1">{{ $teacher->address }}</td>
                            <td class="border px-2 py-1">
                                <div class="border px-3 py-2 flex gap-2 justify-center">
                                    <a href="{{ route('teachers.edit', $teacher) }}" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">تعديل</a>
                                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('هل أنت متأكد من الحذف؟')" class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">لا يوجد معلمين حتى الآن</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
