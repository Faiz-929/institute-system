<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            لوحة التحكم
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-right space-y-6">

            <!-- روابط المعلمين -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('teachers.index') }}"
                   class="bg-blue-100 hover:bg-blue-200 transition rounded-xl p-5 shadow text-blue-800 font-semibold">
                    🧑‍🏫 قائمة المعلمين
                </a>

                <a href="{{ route('teachers.create') }}"
                   class="bg-green-100 hover:bg-green-200 transition rounded-xl p-5 shadow text-green-800 font-semibold">
                    ➕ إضافة معلم
                </a>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-right space-y-6">

            <!-- روابط الطلاب -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('students.index') }}"
                   class="bg-blue-100 hover:bg-blue-200 transition rounded-xl p-5 shadow text-blue-800 font-semibold">
                    👨‍🎓 قائمة الطلاب
                </a>

                <a href="{{ route('students.create') }}"
                   class="bg-green-100 hover:bg-green-200 transition rounded-xl p-5 shadow text-green-800 font-semibold">
                    ➕ إضافة طالب
                </a>

                <a href="{{ route('fees.index') }}"
                   class="bg-purple-100 hover:bg-purple-200 transition rounded-xl p-5 shadow text-purple-800 font-semibold">
                    💰 رسوم الطلاب
                </a>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-right space-y-6">

            <!-- روابط المستودع -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('workshops.index') }}"
                   class="bg-yellow-100 hover:bg-yellow-200 transition rounded-xl p-5 shadow text-yellow-800 font-semibold">
                    🏭 الورش
                </a>

                <a href="{{ route('assets.index') }}"
                   class="bg-cyan-100 hover:bg-cyan-200 transition rounded-xl p-5 shadow text-cyan-800 font-semibold">
                    💻 الأصول الثابتة
                </a>

                <a href="{{ route('consumables.index') }}"
                   class="bg-orange-100 hover:bg-orange-200 transition rounded-xl p-5 shadow text-orange-800 font-semibold">
                    📦 المواد المستهلكة
                </a>

                <a href="{{ route('assignments.index') }}"
                   class="bg-pink-100 hover:bg-pink-200 transition rounded-xl p-5 shadow text-pink-800 font-semibold">
                    📋 العُهد
                </a>

                <!-- روابط التقارير -->
                <a href="{{ route('reports.consumables') }}"
                   class="bg-indigo-100 hover:bg-indigo-200 transition rounded-xl p-5 shadow text-indigo-800 font-semibold">
                    📦 تقرير المستهلكات
                </a>

                <a href="{{ route('reports.assets') }}"
                   class="bg-teal-100 hover:bg-teal-200 transition rounded-xl p-5 shadow text-teal-800 font-semibold">
                    💻 تقرير الأصول
                </a>

                <a href="{{ route('reports.assignments') }}"
                   class="bg-gray-100 hover:bg-gray-200 transition rounded-xl p-5 shadow text-gray-800 font-semibold">
                    📊 تقرير شامل بالعُهد
                </a>
            </div>
        </div>
    <!-- روابط الدرجات -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-right space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="{{ route('grades.index') }}"
                    class="bg-red-100 hover:bg-red-200 transition rounded-xl p-5 shadow text-red-800 font-semibold">
                        📊 قائمة الدرجات
                    </a>
                    <a href="{{ route('grades.create') }}"
                    class="bg-green-100 hover:bg-green-200 transition rounded-xl p-5 shadow text-green-800 font-semibold">
                        ➕ إضافة درجة
                    </a>
                </div>
            </div>
</div>

    </div>
</x-app-layout>
