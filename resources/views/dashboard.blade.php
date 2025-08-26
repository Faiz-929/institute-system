<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            لوحة التحكم
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-right space-y-6">

            {{-- <!-- رسالة ترحيب -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                ✅ تم تسجيل الدخول بنجاح! أهلاً بك في لوحة التحكم.
            </div> --}}

            <!-- روابط سريعة -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <a href="{{ route('teachers.index') }}"
                   class="bg-blue-100 hover:bg-blue-200 transition rounded-xl p-5 shadow text-blue-800 font-semibold">
                    🧑‍🏫 قائمة المعلمين
                </a>

                <a href="{{ route('teachers.create') }}"
                   class="bg-green-100 hover:bg-green-200 transition rounded-xl p-5 shadow text-green-800 font-semibold">
                    ➕ إضافة معلم
                </a>

                {{-- <a href="{{ route('profile.edit') }}"
                   class="bg-yellow-100 hover:bg-yellow-200 transition rounded-xl p-5 shadow text-yellow-800 font-semibold">
                    ⚙️ تعديل الملف الشخصي
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="w-full bg-red-100 hover:bg-red-200 transition rounded-xl p-5 shadow text-red-800 font-semibold text-right">
                        🚪 تسجيل الخروج
                    </button>
                </form> --}}

            </div>

        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-right space-y-6">

            {{-- <!-- رسالة ترحيب -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                ✅ تم تسجيل الدخول بنجاح! أهلاً بك في لوحة التحكم.
            </div> --}}

            <!-- روابط سريعة -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <a href="{{ route('students.index') }}"
                   class="bg-blue-100 hover:bg-blue-200 transition rounded-xl p-5 shadow text-blue-800 font-semibold">
                    🧑‍🏫 قائمة الطلاب
                </a>

                <a href="{{ route('students.create') }}"
                   class="bg-green-100 hover:bg-green-200 transition rounded-xl p-5 shadow text-green-800 font-semibold">
                    ➕ إضافة طالب
                </a>

                {{-- <a href="{{ route('profile.edit') }}"
                   class="bg-yellow-100 hover:bg-yellow-200 transition rounded-xl p-5 shadow text-yellow-800 font-semibold">
                    ⚙️ تعديل الملف الشخصي
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="w-full bg-red-100 hover:bg-red-200 transition rounded-xl p-5 shadow text-red-800 font-semibold text-right">
                        🚪 تسجيل الخروج
                    </button>
                </form> --}}

            </div>

        </div>
    </div>
</x-app-layout>
