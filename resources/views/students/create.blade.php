<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            إضافة طالب جديد
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6 text-right">
                <ul class="list-disc pr-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4 text-right">
            @csrf

            <div>
                <label class="block mb-1 font-semibold">اسم الطالب</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full border rounded px-3 py-2" />
            </div>

            <div>
                <label class="block mb-1 font-semibold">الحالة</label>
                {{-- <input type="text" name="status" value="{{ old('status') }}"
                       class="w-full border rounded px-3 py-2" placeholder="منتظم، منقطع..." /> --}}
                 <select name="gender" class="w-full border rounded px-3 py-2">
                    <option value="">اختر الحالة</option>
                    <option value="منتظم" {{ old('status') == 'منتظم' ? 'selected' : '' }}>منتظم</option>
                    <option value="منقطع" {{ old('status') == 'منقطع' ? 'selected' : '' }}>منقطع</option>
                 </select>      
            </div>

            <div>
                <label class="block mb-1 font-semibold">الجنس</label>
                <select name="gender" class="w-full border rounded px-3 py-2">
                    <option value="">اختر الجنس</option>
                    <option value="ذكر" {{ old('gender') == 'ذكر' ? 'selected' : '' }}>ذكر</option>
                    <option value="أنثى" {{ old('gender') == 'أنثى' ? 'selected' : '' }}>أنثى</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">صورة الطالب</label>
                <input type="file" name="photo" accept="image/*" class="w-full" />
            </div>

            <div>
                <label class="block mb-1 font-semibold">عنوان السكن</label>
                <input type="text" name="address" value="{{ old('address') }}"
                       class="w-full border rounded px-3 py-2" />
            </div>

            <div>
                <label class="block mb-1 font-semibold">رقم هاتف البيت</label>
                <input type="text" name="home_phone" value="{{ old('home_phone') }}"
                       class="w-full border rounded px-3 py-2" />
            </div>

            <div>
                <label class="block mb-1 font-semibold">رقم جوال الطالب</label>
                <input type="text" name="mobile_phone" value="{{ old('mobile_phone') }}"
                       class="w-full border rounded px-3 py-2" />
            </div>

            <div>
                <label class="block mb-1 font-semibold">المستوى الدراسي</label>
                <select name="level" class="w-full border rounded px-3 py-2">
                    <option value="أولى" {{ old('level') == 'أولى' ? 'selected' : '' }}>أولى</option>
                    <option value="ثانية" {{ old('level') == 'ثانية' ? 'selected' : '' }}>ثانية</option>
                    <option value="ثالثة" {{ old('level') == 'ثالثة' ? 'selected' : '' }}>ثالثة</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">التخصص</label>
                <select name="major" class="w-full border rounded px-3 py-2">
                    <option value="كهرباء عام" {{ old('major') == 'كهرباء عام' ? 'selected' : '' }}>كهرباء عام</option>
                    <option value="تبريد وتكييف" {{ old('major') == 'تبريد وتكييف' ? 'selected' : '' }}>تبريد وتكييف</option>
                    <option value="كهرباء سيارات" {{ old('major') == 'كهرباء سيارات' ? 'selected' : '' }}>كهرباء سيارات</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">ملاحظات</label>
                <textarea name="notes" rows="3" class="w-full border rounded px-3 py-2">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('students.index') }}"
                   class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">إلغاء</a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">حفظ</button>
            </div>
        </form>
    </div>
</x-app-layout>
