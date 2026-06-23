<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin — Dashboard</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
</head>
<body>
  <div class="container">
    <?php include __DIR__ . '/_nav.php'; ?>
    <h1>Admin Dashboard</h1>
    <p><a href="/wijaya_transport/admin.php?module=cars">Manage Cars</a></p>
    <p>
      Exports:
      <a href="/wijaya_transport/controllers/export_controller.php?type=bookings">Export Bookings (CSV)</a> |
      <a href="/wijaya_transport/controllers/export_controller.php?type=payments">Export Payments (CSV)</a>
    </p>
  </div>
</body>
</html>
