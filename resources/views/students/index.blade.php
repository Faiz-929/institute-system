<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            قائمة الطلاب
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6 text-right">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between mb-4">
            <a href="{{ route('students.create') }}" class="bg-green-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                ➕ إضافة طالب جديد
            </a>
        </div>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-right">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-2">الصورة</th>
                        <th class="px-4 py-2">الاسم</th>
                        <th class="px-4 py-2">الحالة</th>
                        <th class="px-4 py-2">الجنس</th>
                        <th class="px-4 py-2">المستوى</th>
                        <th class="px-4 py-2">التخصص</th>
                        <th class="px-4 py-2">جوال ولي الامر</th>
                        <th class="px-4 py-2">رقم البيت</th>
                        <th class="px-4 py-2">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($students as $student)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">
                            @if($student->photo)
                                <img src="{{ asset('storage/'.$student->photo) }}" alt="صورة الطالب" class="h-12 w-12 rounded-full object-cover">
                            @else
                                <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">
                                    ؟
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $student->name }}</td>
                        <td class="px-4 py-2">{{ $student->status }}</td>
                        <td class="px-4 py-2">{{ $student->gender }}</td>
                        <td class="px-4 py-2">{{ $student->level }}</td>
                        <td class="px-4 py-2">{{ $student->major }}</td>
                        <td class="px-4 py-2">{{ $student->mobile_phone }}</td>
                        <td class="px-4 py-2">{{ $student->home_phone }}</td>
                        <td class="px-4 py-2 space-x-2 whitespace-nowrap flex items-center gap-2">
                            {{-- زر عرض --}}
                            <a href="{{ route('students.show', $student) }}" 
                               class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                                عرض
                            </a>

                            {{-- زر تعديل --}}
                            <a href="{{ route('students.edit', $student) }}" 
                               class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                                تعديل
                            </a>

                            {{-- زر حذف --}}
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline-block" 
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الطالب؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">
                                    حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-6 text-gray-500">لا يوجد طلاب حتى الآن.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>
</x-app-layout>
