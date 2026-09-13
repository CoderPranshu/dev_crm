@php
    $p = App\Models\Proforma::where('id', $id)->first();
    $received = $p->payment->sum('amount');
@endphp


<form action="{{ route('admin.proforma.payment') }}" method="POST">
    @csrf
    <input type="hidden" name="proforma_id" value="{{ $p->id }}">

    <div class="row ">
        <div class="col-md-12">
            <label for="" class="eForm-label">{{ get_phrase('Amount') }}</label>
            <input type="number" step="1" name="amount" value="{{ $p->total - $received }}" class="eForm-control form-control" max="{{ $p->total - $received }}" required
                placeholder="Amount">
        </div>
        <div class="col-md-12 pt-2">
            <label for="" class="eForm-label">{{ get_phrase('Payment Method') }}</label>
            <select name="payment_method" class="eForm-control form-control" required>
                <option value="cash">Cash</option>
                <option value="upi">UPI</option>
                <option value="card">Card</option>
                <option value="bank">Bank Transfer</option>
            </select>
        </div>
        <div class="col-md-12 pt-2">
            <label for="" class="eForm-label">{{ get_phrase('Transaction No') }}</label>
            <input type="text" name="transaction_id" class="eForm-control form-control" placeholder="Transaction ID">
        </div>
        <div class="col-md-12 pt-2">
            <label for="" class="eForm-label">{{ get_phrase('Payment Date') }}</label>
            <input type="date" name="payment_date" class="eForm-control form-control" value="{{ date('Y-m-d') }}" required>
        </div>
    </div>

    <button class="btn-form btn-success mt-3 w-100">
        Receive Payment
    </button>
</form>
