<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    /**
     * عرض جميع الورش
     */
    public function index()
    {
        $workshops = Workshop::latest()->paginate(10);
        return view('workshops.index', compact('workshops'));
    }

    /**
     * عرض فورم إنشاء ورشة
     */
    public function create()
    {
        return view('workshops.create');
    }

    /**
     * تخزين ورشة جديدة
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);

        Workshop::create($request->all());

        return redirect()->route('workshops.index')
            ->with('success', 'تمت إضافة الورشة بنجاح ✅');
    }

    /**
     * عرض ورشة محددة
     */
    public function show(Workshop $workshop)
    {
        return view('workshops.show', compact('workshop'));
    }

    /**
     * عرض فورم التعديل
     */
    public function edit(Workshop $workshop)
    {
        return view('workshops.edit', compact('workshop'));
    }

    /**
     * تحديث الورشة
     */
    public function update(Request $request, Workshop $workshop)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);

        $workshop->update($request->all());

        return redirect()->route('workshops.index')
            ->with('success', 'تم تعديل بيانات الورشة ✅');
    }

    /**
     * حذف ورشة
     */
    public function destroy(Workshop $workshop)
    {
        $workshop->delete();
        return redirect()->route('workshops.index')
            ->with('success', 'تم حذف الورشة بنجاح ❌');
    }
}
