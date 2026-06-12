<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <title>PharmaFEFO - Authentication Gateway</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">

<div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
    <div class="text-center">
        <h3 class="text-3xl font-extrabold text-blue-600 tracking-tight">PharmaFEFO</h3>
        <p class="mt-2 text-sm text-gray-500">Log in to manage pharmaceutical shelf-life optimizations</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg p-3 text-center">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form class="mt-8 space-y-6" action="/PharmaFEFO/public/index.php?route=login" method="POST">
        <div class="space-y-4">
            <div>
                <label for="username" class="block text-xs font-semibold uppercase tracking-wider text-gray-500">email</label>
                <input type="text" name="username" id="username" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" autofocus>
            </div>
            <div>
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Password</label>
                <input type="password" name="password" id="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                Authorize Session
            </button>
        </div>
        <p class="text-center text-sm text-gray-500 mt-4">
        Don't have an account?
        <a href="/PharmaFEFO/public/index.php?route=register" class="text-blue-600 font-semibold hover:underline">Register</a>
    </p>
    </form>
</div>

</body>
</html>