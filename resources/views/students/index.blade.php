<x-app-layout>
    <x-slot name="header">
        قائمة الطلاب
    </x-slot>

    <!-- شريط البحث والفلترة -->
    <div class="bg-white rounded-xl shadow-soft p-6 mb-6">
        <form method="GET" action="{{ route('students.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- البحث -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">البحث</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <x-icon-search class="text-gray-400" />
                        </div>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="ابحث بالاسم، رقم الهوية، أو اسم ولي الأمر"
                               class="block w-full pr-10 border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </div>

                <!-- التخصص -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">التخصص</label>
                    <div class="relative">
                        <select name="major" class="block w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            <option value="">جميع التخصصات</option>
                            <option value="كهرباء عام" {{ request('major') == 'كهرباء عام' ? 'selected' : '' }}>كهرباء عام</option>
                            <option value="تبريد وتكييف" {{ request('major') == 'تبريد وتكييف' ? 'selected' : '' }}>تبريد وتكييف</option>
                            <option value="كهرباء سيارات" {{ request('major') == 'كهرباء سيارات' ? 'selected' : '' }}>كهرباء سيارات</option>
                        </select>
                    </div>
                </div>

                <!-- المستوى -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">المستوى</label>
                    <div class="relative">
                        <select name="level" class="block w-full border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            <option value="">جميع المستويات</option>
                            <option value="أولى" {{ request('level') == 'أولى' ? 'selected' : '' }}>أولى</option>
                            <option value="ثانية" {{ request('level') == 'ثانية' ? 'selected' : '' }}>ثانية</option>
                            <option value="ثالثة" {{ request('level') == 'ثالثة' ? 'selected' : '' }}>ثالثة</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- أزرار التحكم -->
            <div class="flex flex-wrap gap-3">
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                    <x-icon-search />
                    <span>بحث</span>
                </button>
                <a href="{{ route('students.index') }}" 
                   class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                    <x-icon-refresh />
                    <span>إعادة تعيين</span>
                </a>
                <a href="{{ route('students.print', request()->query()) }}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 px-6 py-2.5 bg-secondary-600 hover:bg-secondary-700 text-white font-medium rounded-lg transition-colors">
                    <x-icon-print />
                    <span>طباعة</span>
                </a>
                <a href="{{ route('students.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-2.5 bg-success-600 hover:bg-success-700 text-white font-medium rounded-lg transition-colors mr-auto">
                    <x-icon-plus />
                    <span>إضافة طالب جديد</span>
                </a>
            </div>
        </form>
    </div>

    <!-- الجدول -->
    <div class="bg-white rounded-xl shadow-soft overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            #
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            الصورة
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            الاسم
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            الحالة
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            الجنس
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            المستوى
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            التخصص
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            جوال ولي الأمر
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            رقم البيت
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            العمليات
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($students as $student)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-primary-600">
                                {{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($student->photo)
                                    <img src="{{ asset('storage/'.$student->photo) }}" 
                                         alt="صورة {{ $student->name }}" 
                                         class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-100">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white font-semibold text-lg">
                                        {{ mb_substr($student->name, 0, 2) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $student->status == 'نشط' ? 'bg-success-100 text-success-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $student->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $student->gender }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-primary-50 text-primary-700">
                                    {{ $student->level }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $student->major }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700" dir="ltr">
                                {{ $student->parent_mobile }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700" dir="ltr">
                                {{ $student->home_phone }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('students.show', $student) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors"
                                       title="عرض">
                                        <x-icon-eye />
                                    </a>
                                    <a href="{{ route('students.edit', $student) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-warning-500 hover:bg-warning-600 text-white rounded-lg transition-colors"
                                       title="تعديل">
                                        <x-icon-edit />
                                    </a>
                                    <form action="{{ route('students.destroy', $student) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا الطالب؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-3 py-2 bg-danger-600 hover:bg-danger-700 text-white rounded-lg transition-colors"
                                                title="حذف">
                                            <x-icon-delete />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <x-icon-students class="w-16 h-16 text-gray-300" />
                                    <p class="text-gray-500 font-medium">لا يوجد طلاب حتى الآن</p>
                                    <a href="{{ route('students.create') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                        <x-icon-plus />
                                        <span>إضافة طالب جديد</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($students->hasPages())
        <div class="mt-6">
            {{ $students->links() }}
        </div>
    @endif
</x-app-layout>
