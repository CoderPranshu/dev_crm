<div class="eSection-wrap mt-4">

    <h5>
        Renewal History
    </h5>

    <table class="table eTable">

        <thead>

            <tr>

                <th>#</th>

                <th>Old Expiry</th>

                <th>New Expiry</th>

                <th>Duration</th>

                <th>Amount</th>

                <th>Date</th>

            </tr>

        </thead>

        <tbody>

            @foreach($subscription->renewals as $renewal)

            <tr>

                <td>
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $renewal->old_expiry_date }}
                </td>

                <td>
                    {{ $renewal->new_expiry_date }}
                </td>

                <td>
                    {{ $renewal->duration_months }} Months
                </td>

                <td>
                    ₹{{ number_format($renewal->amount,2) }}
                </td>

                <td>
                    {{ $renewal->renewal_date }}
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>