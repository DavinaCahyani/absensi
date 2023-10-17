<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php echo link_tag('style/style.css');?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    .image-container {
        text-align: center;
    }

    .image-container img {
        display: block;
        margin: 0 auto;
    }
    </style>
</head>


<body>
    <div id="wrapper">

        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <h2>Dashboard</h2>
            </div>
            <ul class="sidebar-nav">
                <li class="active mt-3">
                    <a href="<?php echo base_url('admin/data_karyawan')?>"><i class="fa fa-user"></i>Data Karyawan</a>
                </li>
                <li class="active mt-3">
                    <a href="<?php echo base_url('admin/rekap_keseluruhan')?>"><i class="fa fa-user"></i>Rekap
                        Keseluruhan</a>
                </li>
                <li class="active mt-3">
                    <a href="<?php echo base_url('admin/rekap_harian')?>"><i class="fa fa-user"></i>Rekap Harian
                    </a>
                </li>
                <li class="active mt-3">
                    <a href="<?php echo base_url('admin/rekap_mingguan')?>"><i class="fa fa-user"></i>Rekap Mingguan
                    </a>
                </li>
                <li class="active mt-3">
                    <a href="<?php echo base_url('admin/rekap_bulanan')?>"><i class="fa fa-user"></i>Rekap Bulanan
                    </a>
                </li>
                <div class="logout">
                    <a href="<?php echo base_url('auth')?>" style="color: #4723D9; text-decoration: none;">
                        <img src="https://media.istockphoto.com/id/1268956056/id/vektor/ikon-vektor-logout-terisolasi-pada-latar-belakang-putih-garis-besar-ikon-logout-garis-tipis.jpg?s=170667a&w=0&k=20&c=UgA9skSIk-m-ENdmH2_2KSaCTPbg1lSCERAvTL3Qosc="
                            alt="Logout" style="width: 30px; opacity: 0.5; margin-right: 10px;" />Logout
                    </a>
                </div>
            </ul>
        </aside>

        <div id="navbar-wrapper">
            <nav class="navbar navbar-inverse" style="background: #4723D9; border: none;">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand text-white" href="">
                            Profil Karyawan
                        </a>
                    </div>
                    <p class="navbar-profile"><a href="<?php echo base_url('admin/profil') ?>" class="text-light"><i
                                class="fa-regular fa-circle-user"></i></a></p>
                </div>
            </nav>
        </div>

        <section id="content-wrapper">
            <?php foreach ($user as $users) : ?>
            <div class="row mx-3">
                <div class="card col-4 p-3">
                    <form action="<?php echo base_url('admin/aksi_image') ?>" enctype="multipart/form-data"
                        method="post">
                        <div class="d-flex justify-content-center">
                            <div class="row">
                                <h5>Ubah Foto Profil</h5>
                                <hr>
                                <div class="mb-3 px-5 col-md-12 image-container">
                                    <img class="rounded-circle"
                                        src="<?php echo base_url('images/karyawan/'.$users->image) ?>" width="150" />
                                </div>
                                <div class="mb-3 px-3 col-md-12">
                                    <input type="file" class="form-control" id="foto" name="foto">
                                </div>
                                <div class="mb-3 px-3 col-md-12">
                                    <h5>Preview Image : </h5>
                                </div>
                                <div class="mb-3 px-5 col-md-12 image-container">
                                    <img class="rounded-circle" id="preview-image" src="#" alt="Preview" width="150" />
                                </div>
                                <div class="mb-3 px-3 col-md-12">
                                    <button type="submit" class="btn btn-primary w-100">Ubah</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
            <div class="col-1"></div>
            <div class="card col-6 p-3">
                <form action="<?php echo base_url('admin/aksi_ubah_profil') ?>" enctype="multipart/form-data"
                    method="post">
                    <div class="row">
                        <h5>Ubah Data Admin</h5>
                        <hr>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                value="<?php echo $users->email; ?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?php echo $users->username; ?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="nama_depan" class="form-label">Nama Depan</label>
                            <input type="text" class="form-control" id="nama_depan" name="nama_depan"
                                value="<?php echo $users->nama_depan; ?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="nama_belakang" class="form-label">Nama Belakang</label>
                            <input type="text" class="form-control" id="nama_belakang" name="nama_belakang"
                                value="<?php echo $users->nama_belakang; ?>">
                        </div>
                        <h5>Ubah Password</h5>
                        <hr>
                        <div class="mb-3 col-md-6">
                            <label for="new-password" class="form-label">Password Baru</label>
                            <input type="text" class="form-control" id="password_baru" name="password_baru">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="confirm-password" class="form-label">Konfirmasi Password</label>
                            <input type="text" class="form-control" id="konfirmasi_password" name="konfirmasi_password">
                        </div>
                    </div>
                    <div class="mb-3 col-12">
                        <button type="submit" class="btn btn-primary w-100">Ubah</button>
                    </div>
                </form>
            </div>
    </div>
    <?php endforeach ; ?>
    </section>
    </div>
    <script>
    $(document).ready(function() {
        // Ketika input file berubah
        $('#foto').on('change', function(e) {
            var fileInput = $(this)[0];
            var file = fileInput.files[0];
            var reader = new FileReader();

            // Jika ada file yang dipilih
            if (file) {
                reader.onload = function(e) {
                    // Menampilkan pratinjau gambar
                    $('#preview-image').attr('src', e.target.result);
                    $('#preview-container').show();
                }
                // Membaca data gambar sebagai URL
                reader.readAsDataURL(file);
            } else {
                // Jika tidak ada file yang dipilih, sembunyikan pratinjau
                $('#preview-container').hide();
            }
        });
    });
    </script>
</body>

</html>