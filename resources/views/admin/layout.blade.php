<!DOCTYPE html>
<html>
<head>
    <title>Ride Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body{font-family:Arial;margin:0;background:#f7f7f7}
        .container{max-width:1100px;margin:0 auto;padding:20px}
        .card{background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.1)}
        table{width:100%;border-collapse:collapse}
        th,td{padding:10px;border-bottom:1px solid #eee;text-align:left}
        a{color:#0d6efd;text-decoration:none}
        .badge{padding:4px 10px;border-radius:20px;font-size:12px;background:#eee}
        .badge.pending{background:#ffeeba}
        .badge.claimed{background:#cce5ff}
        .badge.approved{background:#d4edda}
        .badge.completed{background:#e2e3e5}
    </style>
</head>
<body>
<div class="container">
    <h2>Ride Booking - Admin Panel</h2>
    <hr>
    @yield("content")
</div>
</body>
</html>
