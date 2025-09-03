<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Workshop;
use App\Models\Asset;
use App\Models\Consumable;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with(['workshop','asset','consumable'])
            ->latest()->paginate(10);

        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        $workshops   = Workshop::all();
        $assets      = Asset::all();
        $consumables = Consumable::all();

        return view('assignments.create', compact('workshops','assets','consumables'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'workshop_id'   => 'nullable|exists:workshops,id',
            'asset_id'      => 'nullable|exists:assets,id',
            'consumable_id' => 'nullable|exists:consumables,id',
            'assigned_to'   => 'required|string|max:255',
            'assigned_date' => 'nullable|date',
            'return_date'   => 'nullable|date',
            'note'          => 'nullable|string',
        ]);

        Assignment::create($data);

        return redirect()->route('assignments.index')->with('success','تم تسجيل العهدة بنجاح ✅');
    }

    public function show(Assignment $assignment)
    {
        $assignment->load(['workshop','asset','consumable']);
        return view('assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        $workshops   = Workshop::all();
        $assets      = Asset::all();
        $consumables = Consumable::all();

        return view('assignments.edit', compact('assignment','workshops','assets','consumables'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $data = $request->validate([
            'workshop_id'   => 'nullable|exists:workshops,id',
            'asset_id'      => 'nullable|exists:assets,id',
            'consumable_id' => 'nullable|exists:consumables,id',
            'assigned_to'   => 'required|string|max:255',
            'assigned_date' => 'nullable|date',
            'return_date'   => 'nullable|date',
            'note'          => 'nullable|string',
        ]);

        $assignment->update($data);

        return redirect()->route('assignments.index')->with('success','تم تحديث بيانات العهدة ✅');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignments.index')->with('success','تم حذف العهدة ❌');
    }
}
