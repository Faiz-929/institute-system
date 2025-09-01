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

        {{-- أزرار البحث والفلترة --}}
        <div class="bg-white p-4 rounded shadow mb-4">
            <form method="GET" action="{{ route('students.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end text-right">
                
                {{-- البحث --}}
                <div>
                    <label class="block mb-1 font-semibold">🔍 بحث</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث باسم الطالب أو ولي الأمر"
                    class="w-full border rounded px-3 py-2">
                </div>

                {{-- فلترة حسب التخصص --}}
                <div>
                    <label class="block mb-1 font-semibold">📘 التخصص</label>
                    <select name="major" class="w-full border rounded px-3 py-2">
                        <option value="">الكل</option>
                        <option value="كهرباء عام" {{ request('major') == 'كهرباء عام' ? 'selected' : '' }}>كهرباء عام</option>
                        <option value="تبريد وتكييف" {{ request('major') == 'تبريد وتكييف' ? 'selected' : '' }}>تبريد وتكييف</option>
                        <option value="كهرباء سيارات" {{ request('major') == 'كهرباء سيارات' ? 'selected' : '' }}>كهرباء سيارات</option>
                    </select>
                </div>

                {{-- فلترة حسب المستوى --}}
                <div>
                    <label class="block mb-1 font-semibold">🎓 المستوى</label>
                    <select name="level" class="w-full border rounded px-3 py-2">
                        <option value="">الكل</option>
                        <option value="أولى" {{ request('level') == 'أولى' ? 'selected' : '' }}>أولى</option>
                        <option value="ثانية" {{ request('level') == 'ثانية' ? 'selected' : '' }}>ثانية</option>
                        <option value="ثالثة" {{ request('level') == 'ثالثة' ? 'selected' : '' }}>ثالثة</option>
                    </select>
                </div>

                {{-- زر البحث والطباعة --}}
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        🔎 تطبيق
                    </button>
                    <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                        🔄 إعادة
                    </a>
                    <a href="{{ route('students.print', request()->query()) }}" target="_blank"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                     🖨️ طباعة
                    </a>

                </div>
            </form>
        </div>

        {{-- زر إضافة طالب --}}
        <div class="flex justify-between mb-4">
            <a href="{{ route('students.create') }}" class="bg-green-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                ➕ إضافة طالب جديد
            </a>
        </div>

        {{-- الجدول --}}
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-right">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-2 bg-blue-100 text-blue-800 font-bold text-center">#</th>
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
                        {{-- الرقم التسلسلي --}}
    <td class="px-4 py-2 text-center font-semibold text-blue-600">
        {{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}
    </td>
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
                        <td class="px-4 py-2">{{ $student->parent_mobile }}</td>
                        <td class="px-4 py-2">{{ $student->home_phone }}</td>
                        <td class="px-4 py-2 space-x-2 whitespace-nowrap">
                            <a href="{{ route('students.show', $student) }}" class="bg-blue-600 text-white py-1 px-3 rounded hover:bg-blue-700">👁️ عرض</a>
                            <a href="{{ route('students.edit', $student) }}" class="bg-green-600 text-white py-1 px-3 rounded hover:bg-green-700">✏️ تعديل</a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطالب؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white py-1 px-3 rounded hover:bg-red-700">🗑️ حذف</button>
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
