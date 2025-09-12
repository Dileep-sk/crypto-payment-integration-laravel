<!DOCTYPE html>
<html>
<head>
    <title>Crypto Payment</title>
</head>
<body>
    <h1>Pay with Crypto</h1>
    <form action="/pay" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Product Name" required><br>
        <input type="text" name="description" placeholder="Description"><br>
        <input type="number" name="amount" step="0.01" placeholder="Amount" required><br>
        <select name="currency">
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
        </select><br>
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
