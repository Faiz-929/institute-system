<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">📋 تقرير شامل بالعُهد</h2>
    </x-slot>

    <div class="p-6">
        <table class="w-full border text-center">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">الورشة</th>
                    <th class="p-2 border">الأصل</th>
                    <th class="p-2 border">المستهلكة</th>
                    <th class="p-2 border">المعهود إليه</th>
                    <th class="p-2 border">تاريخ التسليم</th>
                    <th class="p-2 border">تاريخ الاسترجاع</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignments as $assignment)
                    <tr>
                        <td class="p-2 border">{{ $loop->iteration }}</td>
                        <td class="p-2 border">{{ $assignment->workshop->name ?? '-' }}</td>
                        <td class="p-2 border">{{ $assignment->asset->name ?? '-' }}</td>
                        <td class="p-2 border">{{ $assignment->consumable->name ?? '-' }}</td>
                        <td class="p-2 border">{{ $assignment->assigned_to }}</td>
                        <td class="p-2 border">{{ $assignment->assigned_date }}</td>
                        <td class="p-2 border">{{ $assignment->return_date ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
