<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentFee;
use Illuminate\Http\Request;

class StudentFeeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth']); // أضف صلاحياتك حسب نظامك
    // }

    public function index(Request $request)
    {
        $fees = StudentFee::with('student')
            ->when($request->status, fn($q)=>$q->where('status', $request->status))
            ->latest()->paginate(15);

        return view('fees.index', compact('fees'));
    }

    public function create()
    {
        $students = Student::orderBy('name')->pluck('name','id');
        return view('fees.create', compact('students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['required','exists:students,id'],
            'title'      => ['nullable','string','max:255'],
            'amount_due' => ['required','numeric','min:0'],
            'due_date'   => ['nullable','date'],
            'notes'      => ['nullable','string'],
        ]);

        $fee = StudentFee::create($data);

        return redirect()->route('fees.show', $fee)->with('success','تم إنشاء الرسوم بنجاح');
    }

    public function show(StudentFee $fee)
    {
        $fee->load(['student','payments.receiver']);
        return view('fees.show', compact('fee'));
    }

    public function edit(StudentFee $fee)
    {
        $students = \App\Models\Student::orderBy('name')->pluck('name','id');
        return view('fees.edit', compact('fee','students'));
    }

    public function update(Request $request, StudentFee $fee)
    {
        $data = $request->validate([
            'student_id' => ['required','exists:students,id'],
            'title'      => ['nullable','string','max:255'],
            'amount_due' => ['required','numeric','min:0'],
            'due_date'   => ['nullable','date'],
            'notes'      => ['nullable','string'],
            'status'     => ['nullable','in:pending,partial,paid'], // يسمح بالتعديل اليدوي إن لزم
        ]);

        $fee->update($data);

        return redirect()->route('fees.show', $fee)->with('success','تم تحديث الرسوم بنجاح');
    }

    public function destroy(StudentFee $fee)
    {
        $fee->delete();
        return redirect()->route('fees.index')->with('success','تم حذف الرسوم');
    }
}
