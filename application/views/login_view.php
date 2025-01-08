<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            background: white;
        }
        .btn-primary {
            background-color: #2575fc;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #6a11cb;
        }
        .form-control:focus {
            box-shadow: 0 0 5px #6a11cb;
        }
        .input-group-text {
            background-color: transparent;
            border: 1px solid #ced4da;
            border-right: none;
            color: #6a11cb;
            transition: color 0.3s ease;
            height: 100%; /* Pastikan tinggi ikon sama dengan input */
            display: flex;
            align-items: center; /* Pusatkan ikon secara vertikal */
        }
        .input-group-text:hover {
            color: #2575fc;
        }
        .input-group-text i {
            font-size: 1rem; /* Sesuaikan ukuran ikon */
            padding: 0.375rem; /* Sesuaikan padding agar ikon sejajar dengan input */
        }
        #togglePassword {
            cursor: pointer;
        }
    </style>
    <script>
        // Fungsi untuk menghilangkan pesan setelah 1 detik
        function hideMessage() {
            setTimeout(function() {
                var message = document.getElementById(' error-message');
                if (message) {
                    message.style.display = 'none';
                }
            }, 1000); // 1000 ms = 1 detik
        }
    </script>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 w-50">
            <h3 class="text-center mb-4">Login</h3>
            <?php if ($this->session->flashdata('error')): ?>
                <div id="error-message" class="alert alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
                <script>
                    // Panggil fungsi untuk menyembunyikan pesan
                    hideMessage();
                </script>
            <?php endif; ?>
            <form action="<?php echo site_url('auth/validate_login'); ?>" method="post">
                <div class="form-group mb-3">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <span class="input-group-text mt-1">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username" required>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" required>
                        <span class="input-group-text" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <!-- Link Lupa Password -->
            <div class="mt-3 text-center">
                <a href="<?php echo site_url('auth/forgot_password'); ?>">Lupa Password?</a>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>