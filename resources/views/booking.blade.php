<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Book Now & Pay with Crypto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-tr from-indigo-100 via-purple-100 to-pink-100 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white max-w-md w-full rounded-3xl shadow-2xl p-10 sm:p-12">
        <h1 class="text-3xl font-extrabold text-center mb-8 text-indigo-700 relative inline-block">
            Book Now & Pay with Crypto
            <span class="block h-1 w-20 bg-indigo-500 rounded-full mx-auto mt-2"></span>
        </h1>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-300 text-red-700 p-4 rounded-lg shadow-sm">
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
    $presetPrice = request()->query('price') ? number_format(request()->query('price'), 2, '.', '') : '';
@endphp


        <form action="/checkout" method="POST" class="space-y-7" id="paymentForm">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                <input type="text" name="name" id="name" class="w-full rounded-xl border border-gray-300 p-3 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition hover:border-indigo-400" placeholder="Your full name" required />
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" class="w-full rounded-xl border border-gray-300 p-3 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition hover:border-indigo-400" placeholder="you@example.com" required />
            </div>

            <!-- Select Crypto -->
            <div>
                <label for="crypto_currency" class="block text-sm font-semibold text-gray-700 mb-2">Preferred Crypto</label>
                <select name="crypto_currency" id="crypto_currency" class="w-full rounded-xl border border-gray-300 p-3 text-gray-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition hover:border-indigo-400" required>
                    <option value="bitcoin">Bitcoin (BTC)</option>
                    <option value="ethereum">Ethereum (ETH)</option>
                    <option value="usd-coin">USD Coin (USDC)</option>
                    <option value="dai">Dai (DAI)</option>
                    <option value="dogecoin">Dogecoin (DOGE)</option>
                    <option value="litecoin">Litecoin (LTC)</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Note: Final payment options depend on wallet and Coinbase support.</p>
            </div>

            <!-- Enter amount in crypto -->
            <div>
                <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">Amount (Crypto)</label>
                <input type="number" name="amount" id="amount" class="w-full rounded-xl border border-gray-300 p-3 text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition hover:border-indigo-400" placeholder="Enter amount in selected crypto" value="1" required />
            </div>


                 <input type="hidden" name="amount" value="1" id="amount" />

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold py-3 rounded-xl shadow-lg flex items-center justify-center gap-2 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m4-4H8" />
                </svg>
                Pay with Crypto
            </button>
        </form>
    </div>
</body>
</html>
