<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../middleware/csrf.php';
$adminName = $_SESSION['user']['name'] ?? 'Admin';
$csrf = generate_csrf_token();
$currentModule = $_GET['module'] ?? 'dashboard';
?>
<style>
  .admin-navbar {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto 28px auto;
    background: #ffffff;
    border-radius: 20px;
    padding: 20px 28px;
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
  }
  .admin-navbar .admin-brand {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .admin-navbar .admin-brand strong {
    font-size: 1rem;
    font-weight: 800;
    letter-spacing: 0.12em;
    color: #111111;
    text-transform: uppercase;
  }
  .admin-navbar .admin-brand span {
    color: #6b6b6b;
    font-size: 0.88rem;
    font-weight: 400;
    letter-spacing: 0;
  }
  .admin-nav {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
  }
  .admin-nav a,
  .admin-nav button,
  .admin-nav-link,
  .admin-logout-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #333333;
    font-size: 0.95rem;
    font-weight: 600;
    text-decoration: none;
    background: transparent;
    border: 1px solid transparent;
    padding: 10px 14px;
    border-radius: 14px;
    cursor: pointer;
    position: relative;
    font: inherit;
    line-height: 1;
    transition: background 0.18s ease, color 0.18s ease, transform 0.18s ease, border-color 0.18s ease;
  }
  .admin-nav a:hover,
  .admin-nav button:hover,
  .admin-nav-link:hover,
  .admin-logout-btn:hover {
    background: rgba(17, 17, 17, 0.05);
    color: #111111;
    transform: translateY(-1px);
  }
  .admin-nav a.active,
  .admin-nav a.active:hover,
  .admin-nav-link.active,
  .admin-nav-link.active:hover {
    background: #111111;
    color: #ffffff;
    border-color: #111111;
  }
  .admin-nav button {
    background: transparent;
    border: 1px solid rgba(17, 17, 17, 0.08);
  }
</style>
<div class="admin-navbar">
  <div class="admin-brand">
    <strong>WIJAYA TRANSPORT</strong>
    <span>Admin Panel</span>
  </div>
  <div class="admin-nav">
    <a href="/wijaya_transport/admin.php?module=dashboard" class="<?= $currentModule === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
    <a href="/wijaya_transport/admin.php?module=cars" class="<?= $currentModule === 'cars' ? 'active' : '' ?>">Cars</a>
    <a href="/wijaya_transport/admin.php?module=payments" class="<?= $currentModule === 'payments' ? 'active' : '' ?>">Payments</a>
    <a href="/wijaya_transport/logout.php" class="admin-logout-btn">Logout</a>
  </div>
</div>
