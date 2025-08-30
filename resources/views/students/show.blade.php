<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            عرض بيانات الطالب
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 px-6 lg:px-8">

        {{-- بطاقة الطالب --}}
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden mb-8">
            <div class="bg-blue-600 text-white px-6 py-4 text-lg font-semibold text-right">
                🧑‍🎓 بيانات الطالب
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-right">
                
                {{-- صورة الطالب --}}
                <div class="flex justify-center items-center">
                    @if($student->photo)
                        <img src="{{ asset('storage/'.$student->photo) }}" 
                             alt="صورة الطالب" 
                             class="w-40 h-40 rounded-full object-cover shadow-md border-4 border-blue-200">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 text-3xl shadow-md">
                            ؟
                        </div>
                    @endif
                </div>

                {{-- بيانات الطالب --}}
                <div class="space-y-3">
                    <p><span class="font-bold text-gray-700">الاسم:</span> {{ $student->name }}</p>
                    <p><span class="font-bold text-gray-700">الحالة:</span> {{ $student->status }}</p>
                    <p><span class="font-bold text-gray-700">الجنس:</span> {{ $student->gender }}</p>
                    <p><span class="font-bold text-gray-700">المستوى:</span> {{ $student->level }}</p>
                    <p><span class="font-bold text-gray-700">التخصص:</span> {{ $student->major }}</p>
                    <p><span class="font-bold text-gray-700">العنوان:</span> {{ $student->address }}</p>
                    <p><span class="font-bold text-gray-700">جوال الطالب:</span> {{ $student->mobile_phone }}</p>
                    <p><span class="font-bold text-gray-700">رقم البيت:</span> {{ $student->home_phone }}</p>
                </div>
            </div>
        </div>

        {{-- بطاقة ولي الأمر --}}
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="bg-green-600 text-white px-6 py-4 text-lg font-semibold text-right">
                👨‍👩‍👦 بيانات ولي الأمر
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-right">
                <p><span class="font-bold text-gray-700">اسم ولي الأمر:</span> {{ $student->parent_name }}</p>
                <p><span class="font-bold text-gray-700">رقم الجوال:</span> {{ $student->parent_mobile }}</p>
                <p><span class="font-bold text-gray-700">رقم الواتس:</span> {{ $student->parent_whatsapp }}</p>
                <p><span class="font-bold text-gray-700">رقم الهاتف الثابت:</span> {{ $student->parent_phone }}</p>
                <p><span class="font-bold text-gray-700">الوظيفة:</span> {{ $student->parent_job }}</p>
            </div>
        </div>

        {{-- ملاحظات --}}
        @if($student->notes)
            <div class="bg-yellow-50 border-r-4 border-yellow-400 mt-6 p-4 rounded text-right">
                <h3 class="font-semibold text-yellow-700 mb-2">📝 ملاحظات:</h3>
                <p class="text-gray-700">{{ $student->notes }}</p>
            </div>
        @endif

        {{-- أزرار التحكم --}}
        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('students.index') }}" 
               class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">⬅️ رجوع</a>
            <a href="{{ route('students.edit', $student) }}" 
               class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">✏️ تعديل</a>
        </div>
    </div>
</x-app-layout>
