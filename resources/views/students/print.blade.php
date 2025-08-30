<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-center">
            تقرير الطلاب - المعهد المهني
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded shadow">

            <table class="min-w-full border text-right">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">الصورة</th>
                        <th class="px-4 py-2">الاسم</th>
                        <th class="px-4 py-2">الحالة</th>
                        <th class="px-4 py-2">الجنس</th>
                        <th class="px-4 py-2">المستوى</th>
                        <th class="px-4 py-2">التخصص</th>
                        <th class="px-4 py-2">جوال ولي الامر</th>
                        <th class="px-4 py-2">رقم البيت</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr class="border-b">
                            <td class="p-2">
                                @if($student->photo)
                                    <img src="{{ asset('storage/'.$student->photo) }}" class="h-12 w-12 rounded-full object-cover">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">؟</div>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $student->name }}</td>
                            <td class="px-4 py-2">{{ $student->status }}</td>
                            <td class="px-4 py-2">{{ $student->gender }}</td>
                            <td class="px-4 py-2">{{ $student->level }}</td>
                            <td class="px-4 py-2">{{ $student->major }}</td>
                            <td class="px-4 py-2">{{ $student->parent_mobile }}</td>
                            <td class="px-4 py-2">{{ $student->parent_home_phone }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    {{-- <script>
        // عند فتح الصفحة يتم تشغيل الطباعة تلقائياً
        window.onload = function() {
            window.print();
        };
    </script> --}}
</x-app-layout>
