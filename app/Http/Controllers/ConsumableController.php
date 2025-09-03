<?php

namespace App\Http\Controllers;

use App\Models\Consumable;
use App\Models\Workshop;
use Illuminate\Http\Request;

class ConsumableController extends Controller
{
    /**
     * عرض قائمة المواد المستهلكة
     */
    public function index()
    {
        $consumables = Consumable::with('workshop')->latest()->paginate(10);
        return view('consumables.index', compact('consumables'));
    }

    /**
     * عرض فورم إنشاء مادة
     */
    public function create()
    {
        $workshops = Workshop::all();
        return view('consumables.create', compact('workshops'));
    }

    /**
     * تخزين مادة جديدة
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'workshop_id' => 'required|exists:workshops,id',
        ]);

        Consumable::create($request->all());

        return redirect()->route('consumables.index')
            ->with('success', 'تمت إضافة المادة المستهلكة بنجاح ✅');
    }

    /**
     * عرض مادة معينة
     */
    public function show(Consumable $consumable)
    {
        return view('consumables.show', compact('consumable'));
    }

    /**
     * عرض فورم التعديل
     */
    public function edit(Consumable $consumable)
    {
        $workshops = Workshop::all();
        return view('consumables.edit', compact('consumable', 'workshops'));
    }

    /**
     * تحديث مادة
     */
    public function update(Request $request, Consumable $consumable)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'workshop_id' => 'required|exists:workshops,id',
        ]);

        $consumable->update($request->all());

        return redirect()->route('consumables.index')
            ->with('success', 'تم تعديل بيانات المادة المستهلكة ✅');
    }

    /**
     * حذف مادة
     */
    public function destroy(Consumable $consumable)
    {
        $consumable->delete();
        return redirect()->route('consumables.index')
            ->with('success', 'تم حذف المادة بنجاح ❌');
    }
}
