<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <style>
        .profile-container {
            display: flex;
            align-items: flex-start; /* Align items to the start */
            margin-top: 20px;
        }
        .profile-picture {
            margin-right: 20px; /* Space between picture and data */
        }
        .profile-data {
            flex: 1; /* Allow this section to take the remaining space */
        }
        .profile-data h5 {
            margin-bottom: 15px; /* Space below the title */
        }
        .btn {
            margin-top: 10px; /* Space above the button */
        }
    </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>">Saka Bhayangkara</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?php echo site_url('admin/profile'); ?>">Profil Admin</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo site_url('auth/logout'); ?>">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Profil Admin</h2>
        <!-- Tampilkan pesan sukses atau error -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- Kontainer Profil -->
        <div class="profile-container">
            <!-- Foto Profil -->
            <div class="profile-picture">
                <?php 
                if (isset($user) && isset($user->profile_picture) && !empty($user->profile_picture)) {
                    $profile_picture = base_url('uploads/profile_pics/' . $user->profile_picture);
                } else {
                    $profile_picture = base_url('assets/images/default_profile.png');
                }
                ?>
                <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" width="150" class="img-thumbnail">
            </div>

            <!-- Data Diri -->
            <div class="profile-data">
                <h5>Data Diri</h5>
                <form action="<?php echo site_url('admin/profile/update/' . $user->id); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?php echo $user->username; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $user->email; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="profile_picture">Foto Profil</label>
                        <input type="file" class="form-control" name="profile_picture" id="profile_picture">
                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui Profil</button>
                </form>
            </div>
        </div>

        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    </body>
</html>