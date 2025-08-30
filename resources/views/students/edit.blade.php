<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            تعديل بيانات الطالب
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

        <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data" 
              class="bg-white p-6 rounded shadow space-y-4 text-right">
            @csrf
            @method('PUT')

            {{-- ✅ بيانات الطالب --}}
            <div>
                <label class="block mb-1 font-semibold">اسم الطالب</label>
                <input type="text" name="name" value="{{ old('name', $student->name) }}" required
                       class="w-full border rounded px-3 py-2" />
            </div>

            <div>
                <label class="block mb-1 font-semibold">الحالة</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="">اختر الحالة</option>
                    <option value="منتظم" {{ old('status', $student->status) == 'منتظم' ? 'selected' : '' }}>منتظم</option>
                    <option value="منقطع" {{ old('status', $student->status) == 'منقطع' ? 'selected' : '' }}>منقطع</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">الجنس</label>
                <select name="gender" class="w-full border rounded px-3 py-2">
                    <option value="">اختر الجنس</option>
                    <option value="ذكر" {{ old('gender', $student->gender) == 'ذكر' ? 'selected' : '' }}>ذكر</option>
                    <option value="أنثى" {{ old('gender', $student->gender) == 'أنثى' ? 'selected' : '' }}>أنثى</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">صورة الطالب</label>
                <input type="file" name="photo" accept="image/*" class="w-full" />
                @if($student->photo)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $student->photo) }}" alt="صورة الطالب" class="h-20 rounded shadow">
                    </div>
                @endif
            </div>

            <div>
                <label class="block mb-1 font-semibold">عنوان السكن</label>
                <input type="text" name="address" value="{{ old('address', $student->address) }}"
                       class="w-full border rounded px-3 py-2" />
            </div>

            <div>
                <label class="block mb-1 font-semibold">رقم هاتف البيت</label>
                <input type="text" name="home_phone" value="{{ old('home_phone', $student->home_phone) }}"
                       class="w-full border rounded px-3 py-2" />
            </div>

            <div>
                <label class="block mb-1 font-semibold">رقم جوال الطالب</label>
                <input type="text" name="mobile_phone" value="{{ old('mobile_phone', $student->mobile_phone) }}"
                       class="w-full border rounded px-3 py-2" />
            </div>

            <div>
                <label class="block mb-1 font-semibold">المستوى الدراسي</label>
                <select name="level" class="w-full border rounded px-3 py-2">
                    <option value="أولى" {{ old('level', $student->level) == 'أولى' ? 'selected' : '' }}>أولى</option>
                    <option value="ثانية" {{ old('level', $student->level) == 'ثانية' ? 'selected' : '' }}>ثانية</option>
                    <option value="ثالثة" {{ old('level', $student->level) == 'ثالثة' ? 'selected' : '' }}>ثالثة</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">التخصص</label>
                <select name="major" class="w-full border rounded px-3 py-2">
                    <option value="كهرباء عام" {{ old('major', $student->major) == 'كهرباء عام' ? 'selected' : '' }}>كهرباء عام</option>
                    <option value="تبريد وتكييف" {{ old('major', $student->major) == 'تبريد وتكييف' ? 'selected' : '' }}>تبريد وتكييف</option>
                    <option value="كهرباء سيارات" {{ old('major', $student->major) == 'كهرباء سيارات' ? 'selected' : '' }}>كهرباء سيارات</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">ملاحظات</label>
                <textarea name="notes" rows="3" class="w-full border rounded px-3 py-2">{{ old('notes', $student->notes) }}</textarea>
            </div>

            {{-- ✅ بيانات ولي الأمر --}}
            <div class="border-t pt-4">
                <h3 class="font-bold text-lg mb-3">بيانات ولي الأمر</h3>

                <div>
                    <label class="block mb-1 font-semibold">اسم ولي الأمر الرباعي</label>
                    <input type="text" name="parent_name" value="{{ old('parent_name', $student->parent_name) }}"
                           class="w-full border rounded px-3 py-2" />
                </div>

                <div>
                    <label class="block mb-1 font-semibold">رقم الجوال</label>
                    <input type="text" name="parent_mobile" value="{{ old('parent_mobile', $student->parent_mobile) }}"
                           class="w-full border rounded px-3 py-2" />
                </div>

                <div>
                    <label class="block mb-1 font-semibold">رقم الواتس</label>
                    <input type="text" name="parent_whatsapp" value="{{ old('parent_whatsapp', $student->parent_whatsapp) }}"
                           class="w-full border rounded px-3 py-2" />
                </div>

                <div>
                    <label class="block mb-1 font-semibold">رقم البيت</label>
                    <input type="text" name="parent_home_phone" value="{{ old('parent_home_phone', $student->parent_home_phone) }}"
                           class="w-full border rounded px-3 py-2" />
                </div>

                <div>
                    <label class="block mb-1 font-semibold">الوظيفة</label>
                    <input type="text" name="parent_job" value="{{ old('parent_job', $student->parent_job) }}"
                           class="w-full border rounded px-3 py-2" />
                </div>
            </div>

            {{-- ✅ الأزرار --}}
            <div class="flex justify-end space-x-2">
                <a href="{{ route('students.index') }}"
                   class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">إلغاء</a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">تحديث</button>
            </div>
        </form>
    </div>
</x-app-layout>
