<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📦 تقرير المواد المستهلكة لكل ورشة</h2>
    </x-slot>

    <div class="p-6 space-y-6">
        @foreach($workshops as $workshop)
            <div class="border p-4 rounded shadow">
                <h3 class="font-bold text-lg">🔧 {{ $workshop->name }}</h3>

                @if($workshop->assignments->whereNotNull('consumable_id')->count())
                    <ul class="list-disc pr-6 mt-2">
                        @foreach($workshop->assignments->whereNotNull('consumable_id') as $assignment)
                            <li>
                                {{ $assignment->consumable->name ?? '-' }} 
                                (📅 {{ $assignment->assigned_date }})
                                - 👤 {{ $assignment->assigned_to }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600 mt-2">❌ لا توجد مواد مسلّمة</p>
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>
