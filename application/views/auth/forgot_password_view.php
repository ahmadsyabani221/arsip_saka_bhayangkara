<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <script>
        // Fungsi untuk menghilangkan pesan setelah beberapa detik
        function hideMessage() {
            setTimeout(function() {
                var message = document.getElementById('message');
                if (message) {
                    message.style.display = 'none';
                }
            }, 3000); // 3 detik
        }
    </script>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 w-50">
            <h3 class="text-center mb-4">Lupa Password</h3>

            <!-- Pesan Sukses atau Error -->
            <?php if ($this->session->flashdata('message')): ?>
                <div id="message" class="alert alert-info">
                    <?php echo $this->session->flashdata('message'); ?>
                </div>
                <script>hideMessage();</script>
            <?php endif; ?>

            <!-- Form Lupa Password -->
            <form action="<?php echo site_url('auth/send_reset_email'); ?>" method="post">
                <!-- CSRF Token -->
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" 
                       value="<?php echo $this->security->get_csrf_hash(); ?>">

                <!-- Input Email -->
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan Email Anda" required>
                </div>

                <!-- Tombol Kirim -->
                <button type="submit" class="btn btn-primary w-100">Kirim Link Reset Password</button>
            </form>

            <!-- Link Kembali ke Login -->
            <div class="mt-3 text-center">
                <a href="<?php echo site_url('auth/login'); ?>">Kembali ke Login</a>
            </div>
        </div>
    </div>
</body>
</html>
