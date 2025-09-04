<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Models\Assignment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // 📦 تقرير المواد المستهلكة لكل ورشة
    public function consumablesByWorkshop()
    {
        // ✅ تحميل الورش مع العهد والمواد المستهلكة
        $workshops = Workshop::with(['assignments.consumable'])->get();

        return view('reports.consumables_by_workshop', compact('workshops'));
    }

    // 💻 تقرير الأصول لكل ورشة
    public function assetsByWorkshop()
    {
        // ✅ تحميل الورش مع العهد والأصول
        $workshops = Workshop::with(['assignments.asset'])->get();

        return view('reports.assets_by_workshop', compact('workshops'));
    }

    // 📋 تقرير شامل
    public function assignmentsReport()
    {
        // ✅ جلب جميع العهد مع العلاقات
        $assignments = Assignment::with(['workshop','asset','consumable'])
            ->orderBy('assigned_date','desc')
            ->get();

        return view('reports.assignments_report', compact('assignments'));
    }
}
