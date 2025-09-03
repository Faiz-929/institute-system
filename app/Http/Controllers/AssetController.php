<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Workshop;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * قائمة الأصول مع فلاتر (الورشة، الحالة، بحث الاسم/الرقم التسلسلي)
     */
    public function index(Request $request)
    {
        // ✅ تجهيز استعلام مرن مع فلاتر اختيارية
        $query = Asset::with('workshop')
            ->when($request->workshop_id, fn($q) => $q->where('workshop_id', $request->workshop_id))
            ->when($request->status,      fn($q) => $q->where('status', $request->status))
            ->when($request->search,      function ($q) use ($request) {
                $s = '%' . trim($request->search) . '%';
                $q->where(function($qq) use ($s){
                    $qq->where('name', 'like', $s)
                    ->orWhere('serial_number', 'like', $s);
                });
            })
            ->latest();

        $assets    = $query->paginate(12)->withQueryString(); // ✅ ترقيم الصفحات مع الاحتفاظ بالفلاتر
        $workshops = Workshop::orderBy('name')->get();

        return view('assets.index', [
            'assets'        => $assets,
            'workshops'     => $workshops,
            'statusLabels'  => Asset::STATUS_LABELS,
        ]);
    }

    /**
     * صفحة إنشاء أصل جديد
     */
    public function create()
    {
        $workshops = Workshop::orderBy('name')->get();
        return view('assets.create', [
            'workshops'    => $workshops,
            'statusLabels' => Asset::STATUS_LABELS,
        ]);
    }

    /**
     * حفظ أصل جديد
     */
    public function store(Request $request)
    {
        // ✅ تحقق قوي من البيانات
        $data = $request->validate([
            'name'          => ['required','string','max:255'],
            'serial_number' => ['nullable','string','max:255'],
            'purchase_date' => ['nullable','date'],
            'status'        => ['required','in:available,in_use,maintenance,retired'],
            'workshop_id'   => ['required','exists:workshops,id'],
        ]);

        Asset::create($data);

        return redirect()->route('assets.index')->with('success','تمت إضافة الأصل بنجاح ✅');
    }

    /**
     * عرض تفاصيل أصل واحد
     */
    public function show(Asset $asset)
    {
        $asset->load('workshop'); // ✅ تحميل الورشة المرتبطة
        return view('assets.show', [
            'asset'        => $asset,
            'statusLabels' => Asset::STATUS_LABELS,
        ]);
    }

    /**
     * صفحة تعديل أصل
     */
    public function edit(Asset $asset)
    {
        $workshops = Workshop::orderBy('name')->get();
        return view('assets.edit', [
            'asset'        => $asset,
            'workshops'    => $workshops,
            'statusLabels' => Asset::STATUS_LABELS,
        ]);
    }

    /**
     * تحديث أصل
     */
    public function update(Request $request, Asset $asset)
    {
        $data = $request->validate([
            'name'          => ['required','string','max:255'],
            'serial_number' => ['nullable','string','max:255'],
            'purchase_date' => ['nullable','date'],
            'status'        => ['required','in:available,in_use,maintenance,retired'],
            'workshop_id'   => ['required','exists:workshops,id'],
        ]);

        $asset->update($data);

        return redirect()->route('assets.show', $asset)->with('success','تم تحديث بيانات الأصل ✅');
    }

    /**
     * حذف أصل
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success','تم حذف الأصل ❌');
    }
}
