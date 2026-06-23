<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Available Cars</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
</head>
<body>
  <div class="container">
    <h1>Available Cars</h1>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px">
      <?php foreach($cars as $c): ?>
        <div style="background:#111;padding:16px">
          <?php if(!empty($c['image'])): ?><img src="/wijaya_transport/<?=htmlspecialchars($c['image'])?>" style="width:100%;height:160px;object-fit:cover;display:block;margin-bottom:8px"><?php endif; ?>
          <strong style="display:block;color:#fff"><?=htmlspecialchars($c['brand'].' '.$c['model'])?></strong>
          <div style="color:#7D7D7D">Year: <?=htmlspecialchars($c['year'])?></div>
          <div style="margin-top:8px"><a href="/wijaya_transport/index.php?page=car&action=detail&id=<?=$c['id']?>" class="btn btn-ghost">View</a></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
