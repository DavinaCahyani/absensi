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
                    <a href="<?php echo base_url('admin/dashboard')?>"><i class="fa-solid fa-gauge"></i>Dashboard
                        Admin</a>
                </li>
                <li class="active mt-3">
                    <a href="<?php echo base_url('admin/data_karyawan')?>"><i class="fa fa-user"></i>Data Karyawan</a>
                </li>
                <li class="active mt-3">
                    <a href="<?php echo base_url('admin/rekap_keseluruhan')?>"><i
                            class="fa-solid fa-business-time"></i></i>Rekap
                        Keseluruhan</a>
                </li>
                <li class="active mt-3">
                    <a href="<?php echo base_url('admin/rekap_harian')?>"><i class="fa-solid fa-calendar-days"></i>
                        Rekap Harian
                    </a>
                </li>
                <li class="active mt-3">
                    <a href="<?php echo base_url('admin/rekap_mingguan')?>"><i class="fa-solid fa-calendar-week"></i>
                        Rekap Mingguan
                    </a>
                </li>
                <li class="active mt-3">
                    <a href="<?php echo base_url('admin/rekap_bulanan')?>"><i class="fa-regular fa-calendar"></i>
                        </i>Rekap Bulanan
                    </a>
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
                        <!-- <a class="navbar-brand text-white" href="">
                            Dashboard Admin
                        </a> -->
                    </div>
                    <p class="navbar-profile"><a href="<?php echo base_url('admin/profil') ?>" class="text-light"><i
                                class="fa-regular fa-circle-user"></i></a></p>
                </div>
            </nav>
        </div>

        <section id="content-wrapper">
            <div class="mt-4 row d-flex justify-content-center">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            Total Izin Kerja
                        </div>
                        <div class="card-body bg-primary text-white">
                            <h2 class="card-text"><?php echo $total_izin; ?>
                                Izin</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            Total Kerja
                        </div>
                        <div class="card-body bg-primary text-white">
                            <h2 class="card-text"><?php echo $total_absen; ?>
                                Kerja</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            Total Karyawan
                        </div>
                        <div class="card-body bg-primary text-white">
                            <h2 class="card-text"><?php echo $total_karyawan; ?>
                                Karyawan</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            Total Keseluruhan
                        </div>
                        <div class="card-body bg-primary text-white">
                            <h2 class="card-text"><?php echo $total_keseluruhan; ?>
                                Keseluruhan
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="card p-3 mx-3">
                <div class="col-6">
                    <h1>History Karyawan</h1>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Jam Izin</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php $no=0;foreach($absen as $row): $no++?>
                        <tr>
                            <td><?php echo $no ?></td>
                            <td><?php echo tampil_nama_karyawan_byid($row->id_karyawan) ?></td>
                            <td><?php echo $row->kegiatan ?></td>
                            <td><?php echo $row->date ?></td>
                            <td><?php echo $row->jam_masuk ?></td>
                            <td><?php echo $row->jam_pulang ?></td>
                            <td><?php echo $row->jam_izin ?></td>
                            <td><?php echo $row->keterangan_izin ?></td>
                            <td><?php echo $row->status ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <br><br>
            <div class="card p-3 mx-3">

                <div class="col-6">
                    <h1>Data Karyawan</h1>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php $no=0;foreach($user as $row): $no++?>
                        <tr>
                            <td><?php echo $no ?></td>
                            <td><?php echo $row->username ?></td>
                            <td><?php echo $row->email ?></td>
                            <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        </section>

    </div>
</body>

</html>