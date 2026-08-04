<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Login</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
  <style>
    body{margin:0;min-height:100vh;background:#f8f6f0;color:#111;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;display:grid;place-items:center;padding:24px}
    .login-shell{width:100%;max-width:520px;background:#fff;border-radius:20px;box-shadow:0 32px 80px rgba(17,17,17,.12);padding:42px 36px;}
    .login-top{display:flex;align-items:flex-start;justify-content:flex-start;gap:16px;margin-bottom:32px}
    .login-title{margin:0;font-size:2.4rem;letter-spacing:.02em;font-weight:800;color:#111}
    .login-subtitle{margin:.5rem 0 0;color:#6b6b6b;font-size:.96rem;line-height:1.6;max-width:420px}
    .field-group{display:grid;gap:18px;margin-top:30px}
    .field{display:flex;flex-direction:column;gap:10px}
    .field label{font-size:.9rem;color:#6b6b6b;font-weight:600}
    .field input{width:100%;padding:14px 16px;border:1px solid rgba(17,17,17,.12);border-radius:14px;background:#faf9f6;color:#111;font-size:1rem;outline:none;transition:border-color .18s ease,box-shadow .18s ease}
    .field input:focus{border-color:rgba(17,17,17,.24);box-shadow:0 0 0 6px rgba(255,230,170,.18)}
    .login-cta{margin-top:30px}
    .login-cta button{width:100%;padding:16px 20px;border:0;border-radius:14px;background:#111;color:#fff;font-size:1rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;cursor:pointer;transition:transform .16s ease,background .16s ease}
    .login-cta button:hover{transform:translateY(-1px);background:#222}
    .login-note{margin-top:22px;color:#7d7d7d;font-size:.9rem;line-height:1.6;border-top:1px solid rgba(17,17,17,.06);padding-top:18px}
    .alert{margin:0 0 18px;color:#c00000;font-size:.95rem;background:rgba(240,57,57,.08);padding:14px 16px;border-radius:14px;border:1px solid rgba(240,57,57,.16)}
    @media(max-width:560px){.login-shell{padding:32px 24px}.login-title{font-size:2rem}}
  </style>
</head>
<body>
  <div class="login-shell">
    <div class="login-top">
      <h1 class="login-title">Admin Login</h1>
    </div>
    <p class="login-subtitle">Masuk ke panel administrasi untuk mengelola transaksi, pembayaran, dan armada Wijaya Transport.</p>
    <?php if(isset($_GET['err'])): ?><div class="alert">Login gagal. Periksa username/email dan password Anda.</div><?php endif; ?>
    <form action="/wijaya_transport/admin.php?module=auth&action=authenticate" method="post">
      <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf)?>">
      <div class="field-group">
        <div class="field">
          <label for="username">Username atau Email</label>
          <input id="username" name="username" type="text" required autocomplete="username" placeholder="admin">
        </div>
        <div class="field">
          <label for="password">Password</label>
          <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••">
        </div>
      </div>
      <div class="login-cta">
        <button type="submit">Login</button>
      </div>
    </form>
  </div>
</body>
</html>
