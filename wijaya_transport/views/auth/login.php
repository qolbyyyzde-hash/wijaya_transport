<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin Login</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
  <style>body{background:#000;color:#fff}.login-box{max-width:420px;margin:80px auto;padding:24px;background:#111}</style>
</head>
<body>
  <div class="container login-box">
    <h1>Admin Login</h1>
    <?php if(isset($_GET['err'])): ?><p style="color:#f88">Login gagal</p><?php endif; ?>
    <form action="/wijaya_transport/admin.php?module=auth&action=authenticate" method="post">
      <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf)?>">
      <div><label>Email<input name="email" type="email" required></label></div>
      <div><label>Password<input name="password" type="password" required></label></div>
      <div style="margin-top:12px"><button class="btn btn-accent" type="submit">Login</button></div>
    </form>
  </div>
</body>
</html>
