<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            background: white;
            padding: 2rem;
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
        .input-group {
            display: flex;
            align-items: center;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-right: none;
            color: #6a11cb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 38px; /* Tinggi seragam dengan input field */
            width: 40px; /* Lebar konsisten untuk ikon */
            padding: 0;
        }
        .form-control {
            height: 38px; /* Tinggi seragam dengan ikon */
            padding: 0.375rem 0.75rem;
        }
        #togglePassword {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card w-50">
            <h3 class="text-center mb-4">Login</h3>
            <?php if ($this->session->flashdata('error')): ?>
                <div id="error-message" class="alert alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
                <script>
                    setTimeout(() => document.getElementById('error-message').style.display = 'none', 1000);
                </script>
            <?php endif; ?>
            <form action="<?php echo site_url('auth/validate_login'); ?>" method="post">
                <!-- Username Input -->
                <div class="form-group mb-3">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username" required>
                    </div>
                </div>
                <!-- Password Input -->
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
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <!-- Forgot Password Link -->
            <div class="mt-3 text-center">
                <a href="<?php echo site_url('auth/forgot_password'); ?>">Lupa Password?</a>
            </div>
        </div>
    </div>
    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>