<x-app-layout>
    <x-slot name="header">📊 قائمة الدرجات</x-slot>

    <div class="p-6">
        <a href="{{ route('grades.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">➕ إضافة درجة</a>

        <table class="w-full mt-4 border text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th>الطالب</th>
                    <th>المادة</th>
                    <th>المعلم</th>
                    <th>المجموع</th>
                    <th>الفصل</th>
                    <th>السنة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                    <tr class="{{ $grade->total < 50 ? 'bg-red-100' : '' }}">
                        <td>{{ $grade->student->name }}</td>
                        <td>{{ $grade->subject->name }}</td>
                        <td>{{ $grade->teacher->name }}</td>
                        <td>{{ $grade->total }}</td>
                        <td>{{ $grade->semester }}</td>
                        <td>{{ $grade->year }}</td>
                        <td class="space-x-1">
                            <a href="{{ route('grades.edit',$grade->id) }}" class="px-2 py-1 bg-yellow-400 text-white rounded">✏️ تعديل</a>
                            <form action="{{ route('grades.destroy',$grade->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('هل أنت متأكد من الحذف؟')" class="px-2 py-1 bg-red-500 text-white rounded">🗑️ حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $grades->links() }}
        </div>
    </div>
</x-app-layout>
