<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Arsip</title>
</head>
<body>
    <h1>Tambah Arsip</h1>
    <form action="<?php echo site_url('arsip/store'); ?>" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Tambah Arsip</button>
    </form>
    <a href="<?php echo site_url('arsip'); ?>">Kembali</a>
</body>
</html>
