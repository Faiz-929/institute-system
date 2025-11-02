<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'نظام إدارة المعهد') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div x-data="{ sidebarOpen: true, mobileMenuOpen: false }" class="min-h-screen">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="fixed right-0 top-0 h-full bg-white shadow-lg transition-all duration-300 z-30 hidden lg:block">
            <!-- Logo -->
            <div class="h-16 flex items-center justify-center border-b border-gray-200">
                <h1 x-show="sidebarOpen" class="text-xl font-bold text-primary-600">نظام إدارة المعهد</h1>
                <span x-show="!sidebarOpen" class="text-2xl font-bold text-primary-600">ن</span>
            </div>
            
            <!-- Navigation -->
            <nav class="p-4 space-y-2">
                <!-- لوحة التحكم -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-dashboard class="flex-shrink-0" />
                    <span x-show="sidebarOpen" class="font-medium">لوحة التحكم</span>
                </a>
                
                <!-- إدارة الطلاب -->
                <a href="{{ route('students.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('students.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-students class="flex-shrink-0" />
                    <span x-show="sidebarOpen" class="font-medium">الطلاب</span>
                </a>
                
                <!-- إدارة المعلمين -->
                <a href="{{ route('teachers.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('teachers.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-teachers class="flex-shrink-0" />
                    <span x-show="sidebarOpen" class="font-medium">المعلمين</span>
                </a>
                
                <!-- الدرجات -->
                <a href="{{ route('grades.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('grades.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-grades class="flex-shrink-0" />
                    <span x-show="sidebarOpen" class="font-medium">الدرجات</span>
                </a>
                
                <!-- الحضور والغياب -->
                <a href="{{ route('attendance.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('attendance.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-attendance class="flex-shrink-0" />
                    <span x-show="sidebarOpen" class="font-medium">الحضور والغياب</span>
                </a>
                
                <!-- الرسوم -->
                <a href="{{ route('fees.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('fees.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-fees class="flex-shrink-0" />
                    <span x-show="sidebarOpen" class="font-medium">الرسوم</span>
                </a>
                
                <!-- الورش -->
                <a href="{{ route('workshops.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('workshops.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-workshop class="flex-shrink-0" />
                    <span x-show="sidebarOpen" class="font-medium">الورش</span>
                </a>
                
                <!-- التقارير -->
                <a href="{{ route('reports.consumables') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('reports.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-reports class="flex-shrink-0" />
                    <span x-show="sidebarOpen" class="font-medium">التقارير</span>
                </a>
            </nav>
            
            <!-- Toggle Button -->
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="absolute left-0 top-20 transform translate-x-1/2 bg-white border border-gray-200 rounded-full p-1.5 shadow-md hover:bg-gray-50">
                <svg class="w-4 h-4 text-gray-600" :class="{ 'rotate-180': !sidebarOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
        </aside>
        
        <!-- Mobile Sidebar -->
        <aside x-show="mobileMenuOpen" 
               @click.away="mobileMenuOpen = false"
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="opacity-0 transform translate-x-full"
               x-transition:enter-end="opacity-100 transform translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="opacity-100 transform translate-x-0"
               x-transition:leave-end="opacity-0 transform translate-x-full"
               class="fixed right-0 top-0 h-full w-64 bg-white shadow-xl z-50 lg:hidden">
            <div class="h-16 flex items-center justify-between px-4 border-b border-gray-200">
                <h1 class="text-lg font-bold text-primary-600">نظام إدارة المعهد</h1>
                <button @click="mobileMenuOpen = false" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <nav class="p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-dashboard />
                    <span class="font-medium">لوحة التحكم</span>
                </a>
                <a href="{{ route('students.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('students.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-students />
                    <span class="font-medium">الطلاب</span>
                </a>
                <a href="{{ route('teachers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('teachers.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-teachers />
                    <span class="font-medium">المعلمين</span>
                </a>
                <a href="{{ route('grades.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('grades.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-grades />
                    <span class="font-medium">الدرجات</span>
                </a>
                <a href="{{ route('attendance.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('attendance.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-attendance />
                    <span class="font-medium">الحضور والغياب</span>
                </a>
                <a href="{{ route('fees.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('fees.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-fees />
                    <span class="font-medium">الرسوم</span>
                </a>
                <a href="{{ route('workshops.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('workshops.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-workshop />
                    <span class="font-medium">الورش</span>
                </a>
                <a href="{{ route('reports.consumables') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('reports.*') ? 'bg-primary-50 text-primary-600' : 'text-gray-700 hover:bg-gray-50' }}">
                    <x-icon-reports />
                    <span class="font-medium">التقارير</span>
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div :class="sidebarOpen ? 'lg:mr-64' : 'lg:mr-20'" class="transition-all duration-300">
            <!-- Header -->
            <header class="bg-white shadow-sm sticky top-0 z-20">
                <div class="flex items-center justify-between h-16 px-4 lg:px-8">
                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    
                    <!-- Page Title -->
                    <div class="flex-1 lg:flex-none">
                        @isset($header)
                            <h2 class="font-bold text-lg lg:text-xl text-gray-800">{{ $header }}</h2>
                        @endisset
                    </div>
                    
                    <!-- User Menu -->
                    <div class="flex items-center gap-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg">
                            <x-icon-bell />
                            <span class="absolute top-1 right-1 w-2 h-2 bg-danger-500 rounded-full"></span>
                        </button>
                        
                        <!-- User Dropdown -->
                        <div x-data="{ userMenuOpen: false }" class="relative">
                            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                                <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr(Auth::user()->name, 0, 2) }}
                                </div>
                                <span class="hidden md:inline-block font-medium">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <div x-show="userMenuOpen" 
                                 @click.away="userMenuOpen = false"
                                 x-transition
                                 class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 border border-gray-200">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">الملف الشخصي</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-right px-4 py-2 text-danger-600 hover:bg-gray-50">تسجيل الخروج</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="p-4 lg:p-8">
                <!-- Success Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-success-50 border border-success-200 text-success-800 px-4 py-3 rounded-lg flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                
                <!-- Error Messages -->
                @if(session('error'))
                    <div class="mb-6 bg-danger-50 border border-danger-200 text-danger-800 px-4 py-3 rounded-lg flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
