<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../middleware/csrf.php';
$adminName = $_SESSION['user']['name'] ?? 'Admin';
$csrf = generate_csrf_token();
?>
<div style="background:#111;padding:12px;color:#fff;margin-bottom:18px;display:flex;justify-content:space-between;align-items:center">
  <div>
    <strong>Admin</strong> — <span style="opacity:0.8"><?=$adminName?></span>
  </div>
  <div>
    <a href="/wijaya_transport/admin.php" style="color:#fff;margin-right:12px">Dashboard</a>
    <a href="/wijaya_transport/admin.php?module=cars" style="color:#fff;margin-right:12px">Cars</a>
    <a href="/wijaya_transport/admin.php?module=payments" style="color:#fff;margin-right:12px">Payments</a>
    <form method="post" action="/wijaya_transport/admin.php?module=auth&action=logout" style="display:inline;margin:0;padding:0">
      <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf)?>">
      <button type="submit" style="background:none;border:none;color:#f88;cursor:pointer;padding:0;margin:0">Logout</button>
    </form>
  </div>
</div>
