<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PharmaFEFO - Authentication Gateway</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f1f3f7; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 100%; max-width: 400px; border: none; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="card login-card p-4 bg-white">
    <div class="text-center mb-4">
        <h3 class="text-primary font-weight-bold"><img src="" alt="" class="d-none"> PharmaFEFO</h3>
        <p class="text-muted small">Log in to manage pharmaceutical shelf-life optimizations</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger p-2 small text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="/index.php?route=login" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label text-secondary small font-weight-bold">Username</label>
            <input type="text" name="username" id="username" class="form-control rounded-pill px-3" required autofocus>
        </div>
        <div class="mb-4">
            <label for="password" class="form-label text-secondary small font-weight-bold">Password</label>
            <input type="password" name="password" id="password" class="form-control rounded-pill px-3" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">Authorize Session</button>
    </form>
</div>

</body>
</html>