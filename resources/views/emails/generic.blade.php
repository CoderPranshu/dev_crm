<!DOCTYPE html>
<html>
<head>
    <title>{{ $data['subject'] ?? 'Mail' }}</title>
</head>
<body>

    <h3>Hello {{ $data['name'] ?? 'User' }},</h3>

    <p>{!! $data['message'] ?? '' !!}</p>

    @if(isset($data['amount']))
        <p><strong>Amount:</strong> ₹{{ $data['amount'] }}</p>
    @endif

    <br>
    <p>Regards,</p>
    <p><strong>BMS Electronic</strong></p>

</body>
</html>
