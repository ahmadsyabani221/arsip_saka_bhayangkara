<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Arsip - Admin</title>
</head>
<body>
    <h1>Manajemen Arsip</h1>

    <h2>Daftar Arsip</h2>
    <ul>
        <?php foreach ($arsip as $item): ?>
            <li><?php echo $item->nama_arsip; ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Daftar Pengguna</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?php echo $user->username; ?> (<?php echo $user->email; ?>)</li>
        <?php endforeach; ?>
    </ul>

    <a href="<?php echo site_url('admin/add_arsip'); ?>">Tambah Arsip</a>
    <a href="<?php echo site_url('auth/logout'); ?>">Logout</a>
</body>
</html>