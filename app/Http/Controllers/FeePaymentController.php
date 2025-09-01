<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use App\Models\StudentFee;
use Illuminate\Http\Request;

class FeePaymentController extends Controller
{
    public function store(Request $request, StudentFee $fee)
    {
        $data = $request->validate([
            'amount'    => ['required','numeric','min:0.01'],
            'paid_at'   => ['nullable','date'],
            'method'    => ['nullable','string','max:100'],
            'reference' => ['nullable','string','max:100'],
            'note'      => ['nullable','string'],
        ]);

        $data['student_fee_id'] = $fee->id;
        //$data['received_by'] = auth()->id();

        // منع تجاوز المبلغ
        $remaining = $fee->remaining;
        if ($data['amount'] > $remaining) {
            return back()->withErrors(['amount' => 'المبلغ المدفوع أكبر من المتبقي ('.number_format($remaining,2).').'])->withInput();
        }

        FeePayment::create($data);

        return back()->with('success','تم تسجيل الدفعة بنجاح');
    }

    public function destroy(FeePayment $payment)
    {
        $feeId = $payment->student_fee_id;
        $payment->delete();
        return redirect()->route('fees.show', $feeId)->with('success','تم حذف الدفعة');
    }
}
