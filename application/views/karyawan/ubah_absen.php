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
    <style>
    #foo {
        position: fixed;
        bottom: 10px;
        left: 10px;
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
                    <a href="<?php echo base_url('karyawan/karyawan')?>"><i class="fa fa-circle"></i>Dashboard
                        Karyawan</a>
                </li>
                <li class="active mt-3">
                    <a href="<?php echo base_url('karyawan/history_karyawan')?>"><i
                            class="fa fa-clock-rotate-left"></i>History
                        Karyawan</a>
                </li>
                <li class="active mt-3">

                    <a href="<?php echo base_url('karyawan/menu_absen')?>"><i class="fa fa-clock-rotate-left"></i>Absen
                        Karyawan</a>
                </li>
                <li class="active mt-3">

                    <a href="<?php echo base_url('karyawan/izin')?>"><i class="fa fa-clock-rotate-left"></i>Izin
                        Karyawan</a>
                </li>
            </ul>
            <div class="sidebar-nav m-4">
                <div id="foo" class="active fw-semibold">
                    <a href="<?php echo base_url('auth')?>" style="color: #4723D9; text-decoration: none;">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span style="font-size: 20px;">Logout</span>
                    </a>
                </div>
            </div>
        </aside>


        <div id="navbar-wrapper">
            <nav class="navbar navbar-inverse" style="background: #4723D9; border: none;">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand text-white" href="">
                            Absen Karyawan
                        </a>
                    </div>
                    <p class="navbar-profile"><a href="<?php echo base_url('karyawan/profil') ?>" class="text-light"><i
                                class="fa-regular fa-circle-user"></i></a></p>
                </div>
            </nav>
        </div>

        <section id="content-wrapper">
            <div class="row mt-4 p-4 mx-3 d-flex">
                <div class="card w-100 m-auto p-3">
                    <h3 class="text-center">Ubah Absen</h3>
                    <?php if ( $absen['keterangan_izin'] == '-' ) : ?>
                    <form action="<?php echo base_url('karyawan/aksi_ubah_absen') ?>" enctype="multipart/form-data"
                        method="post" class="row">
                        <input type="hidden" name="id" value="<?php echo $absen['id'] ?>">
                        <div class="form-group">
                            <label for="kegiatan">Kegiatan</label>
                            <input type="text" class="form-control" id="kegiatan" name="kegiatan"
                                value="<?php echo $absen['kegiatan']?>">
                        </div>
                        <div class="col-md-6 mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <?php else : ?>
                    <form action="<?php echo base_url('karyawan/aksi_ubah_izin') ?>" enctype="multipart/form-data"
                        method="post" class="row">
                        <input type="hidden" name="id" value="<?php echo $absen['id'] ?>">
                        <div class="form-group">
                            <label for="kegiatan">Kegiatan</label>
                            <input type="text" class="form-control" id="keterangan_izin" name="keterangan_izin"
                                value="<?php echo $absen['keterangan_izin']?>">

                        </div>
                        <div class="col-md-6 mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </section>

    </div>
</body>

</html>