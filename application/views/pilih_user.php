<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih User</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Pilih User untuk Mengirim Arsip</h1>
        
        <form action="<?php echo site_url('arsip/proses_kirim/' . $arsip->id); ?>" method="post">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Detail Arsip</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama_arsip">Nama Arsip:</label>
                        <input type="text" name="nama_arsip" id="nama_arsip" class="form-control" value="<?php echo $arsip->nama_arsip; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori:</label>
                        <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $arsip->kategori; ?>" readonly>
                    </div>
                    <div class="form-group ">
                        <label for="user_ids">Pilih User:</label>
                        <select name="user_ids[]" id="user_ids" class="form-control" multiple>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user->id; ?>"><?php echo $user->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Kirim Arsip</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>