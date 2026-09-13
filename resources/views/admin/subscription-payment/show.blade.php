<div class="eSection-wrap mt-4">

    <h5>
        Payment History
    </h5>

    <div class="table-responsive">

        <table class="table eTable">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Date</th>

                    <th>Amount</th>

                    <th>Method</th>

                    <th>Transaction ID</th>

                </tr>

            </thead>

            <tbody>

                @foreach($subscription->payments as $payment)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $payment->payment_date }}
                        </td>

                        <td>
                            ₹{{ number_format($payment->amount,2) }}
                        </td>

                        <td>
                            {{ $payment->payment_method }}
                        </td>

                        <td>
                            {{ $payment->transaction_id }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>