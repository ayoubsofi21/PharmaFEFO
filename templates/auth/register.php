<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <title>PharmaFEFO - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full flex items-center justify-center py-12 px-4">

<div class="max-w-md w-full space-y-6 bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
    <div class="text-center">
        <h3 class="text-3xl font-extrabold text-blue-600 tracking-tight">PharmaFEFO</h3>
        <p class="mt-2 text-sm text-gray-500">Create a new account</p>
    </div>

    <?php if ($success): ?>
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg p-3 text-center">
            Account created successfully. <a href="index.php?route=login" class="font-semibold underline">Login now</a>
        </div>
    <?php endif; ?>

    <?php if (isset($errors['global'])): ?>
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg p-3 text-center">
            <?= htmlspecialchars($errors['global']) ?>
        </div>
    <?php endif; ?>

    <?php if (!$success): ?>
    <form class="space-y-4" action="index.php?route=register" method="POST">

        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                class="mt-1 block w-full px-3 py-2 border rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                <?= isset($errors['username']) ? 'border-red-300' : 'border-gray-300' ?>">
            <?php if (isset($errors['username'])): ?>
                <p class="mt-1 text-xs text-red-600"><?= $errors['username'] ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                class="mt-1 block w-full px-3 py-2 border rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                <?= isset($errors['email']) ? 'border-red-300' : 'border-gray-300' ?>">
            <?php if (isset($errors['email'])): ?>
                <p class="mt-1 text-xs text-red-600"><?= $errors['email'] ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Role</label>
            <select name="role"
                class="mt-1 block w-full px-3 py-2 border rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                <?= isset($errors['role']) ? 'border-red-300' : 'border-gray-300' ?>">
                <option value="">Select a role...</option>
                <?php foreach (['ADMINISTRATEUR', 'PHARMACIEN', 'PREPARATEUR'] as $r): ?>
                    <option value="<?= $r ?>" <?= (($_POST['role'] ?? '') === $r) ? 'selected' : '' ?>>
                        <?= ucfirst(strtolower($r)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['role'])): ?>
                <p class="mt-1 text-xs text-red-600"><?= $errors['role'] ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Password</label>
            <input type="password" name="password"
                class="mt-1 block w-full px-3 py-2 border rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                <?= isset($errors['password']) ? 'border-red-300' : 'border-gray-300' ?>">
            <?php if (isset($errors['password'])): ?>
                <p class="mt-1 text-xs text-red-600"><?= $errors['password'] ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Confirm Password</label>
            <input type="password" name="confirm_password"
                class="mt-1 block w-full px-3 py-2 border rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                <?= isset($errors['confirm_password']) ? 'border-red-300' : 'border-gray-300' ?>">
            <?php if (isset($errors['confirm_password'])): ?>
                <p class="mt-1 text-xs text-red-600"><?= $errors['confirm_password'] ?></p>
            <?php endif; ?>
        </div>

        <button type="submit"
            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
            Create Account
        </button>

        <p class="text-center text-sm text-gray-500">
            Already have an account?
            <a href="index.php?route=login" class="text-blue-600 font-semibold hover:underline">Login</a>
        </p>
    </form>
    <?php endif; ?>
</div>

</body>
</html>