<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.3.4/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.3.4/dist/sweetalert2.min.js"></script>
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
                    <a href="<?php echo base_url('karyawan/karyawan')?>"><i class="fa-solid fa-gauge"></i></i>Dashboard
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
                        <!-- <a class="navbar-brand text-white" href="">
                            History Karyawan
                        </a> -->
                    </div>
                    <div class="navbar-profile">
                        <?php foreach ($profile as $users): ?><a href="<?php echo base_url('karyawan/profil') ?>"
                            class="text-light">
                            <img src="<?php echo base_url('images/karyawan/' . $users->image); ?>" alt="" width="50"
                                class="rounded-circle mb-3"></a>
                        <?php endforeach ?>
                    </div>
                </div>
            </nav>
        </div>

        <section id="content-wrapper">
            <br><br>
            <div class="card w-100 m-auto p-3">
                <div class="row">
                    <div class="text-center">
                        <h3>History Karyawan</h3>
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
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <br>
                        <br>
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

                                <td>
                                    <div class="d-flex">
                                        <?php if ($row->status !== 'Done') : ?>
                                        <a href="<?php echo base_url('karyawan/aksi_pulang/' . $row->id) ?>"
                                            class="btn btn-sm btn-warning mx-1"><i class="fa-solid fa-house"></i></a>
                                        <!-- UBAH -->
                                        <a href="<?php echo base_url('karyawan/ubah_absen/' . $row->id) ?>"
                                            class="btn btn-sm btn-primary mx-1"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <!-- HAPUS -->
                                        <!-- <button class="btn btn-sm btn-danger mx-1"><i class="fa-solid fa-trash"></i></button> -->
                                        <?php else : ?>
                                        <button type="button" class="btn btn-sm btn-warning mx-1" disabled><i
                                                class="fa-solid fa-house"></i></button>
                                        <!-- UBAH -->
                                        <a href="<?php echo base_url('karyawan/ubah_absen/' . $row->id) ?>"
                                            class="btn btn-sm btn-primary mx-1"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <!-- HAPUS -->
                                        <!-- <button onClick="hapus(<?php echo $row->id_karyawan ?>)"
                                    class="btn btn-sm btn-danger mx-1"><i class="fa-solid fa-trash"></i></button> -->
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>
</body>

</html>