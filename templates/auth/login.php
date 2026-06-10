<?php require __DIR__ . '/../layout/header.php'; ?>
<head>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<div class="max-w-md mx-auto my-12 bg-white p-8 border border-slate-200 rounded-2xl shadow-xl shadow-slate-100/70">
    <div class="text-center mb-6">
        <div class="inline-flex bg-emerald-600 text-white p-3 rounded-xl mb-3"><i class="fa-solid fa-shield-halved text-xl"></i></div>
        <h2 class="text-xl font-bold text-slate-900">Secure Entry Gateway</h2>
    </div>
    
    <?php if ($error): ?>
        <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-800 p-3 rounded-xl text-xs font-semibold flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-rose-600"></i> <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/login" class="space-y-4">
        <div>
            <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Clinical Email</label>
            <input type="email" name="email" required placeholder="user@pharma.com" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase text-slate-500 mb-1">Security Key String</label>
            <input type="password" name="password" required placeholder="••••••••" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-xl text-sm transition-all shadow-md">Authenticate Portal</button>
    </form>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>