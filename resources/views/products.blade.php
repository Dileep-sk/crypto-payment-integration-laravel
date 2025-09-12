<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Products - Buy with Crypto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-tr from-indigo-100 via-purple-100 to-pink-100 min-h-screen flex items-center justify-center p-10">
    <div class="max-w-4xl w-full bg-white rounded-3xl shadow-2xl p-10">
        <h1 class="text-4xl font-bold text-indigo-700 mb-10 text-center">Our Products</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Example product -->
            @php
                $products = [
                    ['id' => 1, 'name' => 'Product One', 'price' => 50.00],
                    ['id' => 2, 'name' => 'Product Two', 'price' => 75.00],
                    ['id' => 3, 'name' => 'Product Three', 'price' => 120.00],
                ];
            @endphp

            @foreach ($products as $product)
                <div class="border rounded-xl p-6 flex flex-col justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold mb-4">{{ $product['name'] }}</h2>
                        <p class="text-gray-600 mb-6">Price: <span class="font-bold">${{ number_format($product['price'], 2) }}</span></p>
                    </div>
                    <a href="{{ route('show.payment.form', ['price' => $product['price']]) }}" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold transition">
                        Buy Now
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
