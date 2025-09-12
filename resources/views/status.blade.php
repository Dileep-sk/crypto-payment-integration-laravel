<!DOCTYPE html>
<html>

<head>
    <title>Payments</title>
</head>

<body>
    <h1>Payment Status</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Product</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Status</th>
                <th>Link</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->name }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->currency }}</td>
                    <td>{{ $payment->status }}</td>
                    <td><a href="{{ $payment->hosted_url }}" target="_blank">View</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
