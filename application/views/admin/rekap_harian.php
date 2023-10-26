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

    #navbar-wrapper {
        position: fixed;
        top: 0;
        width: 100%;
        background: #4723D9;
        /* Sesuaikan dengan warna latar belakang yang Anda inginkan */
        z-index: 100;
        /* Untuk mengatur urutan tampilan di atas elemen lain */
    }

    .navbar-profile {
        position: fixed;
        right: 5px;
        top: 5px;
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
                    <div class="navbar-profile">
                        <?php foreach ($profile as $users): ?><a href="<?php echo base_url('admin/profil') ?>"
                            class="text-light">
                            <img src="<?php echo base_url('images/karyawan/' . $users->image); ?>" alt="" width="50"
                                class="rounded-circle mb-3"></a>
                        <?php endforeach ?>
                    </div>
                </div>
            </nav>
        </div>

        <br><br><br>

        <section id="content-wrapper">
            <div class="p-3 card mx-3">
                <div class="row">
                    <div class="col-6">
                        <h1>Rekap Harian</h1>
                    </div>
                    <div class="col-6">
                        <form action="<?= base_url('admin/rekap_harian') ?>" method="get"
                            class="d-flex justify-content-end">
                            <input type="date" name="tanggal" id="tanggal" class="form-control w-50 mx-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    <div class="col-6">
                        <a href="<?php echo base_url('admin/export_rekap_harian')?>" class="btn btn-primary">Export</a>
                    </div>

                </div>

                <table class="table table-striped table-hover mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Jam masuk</th>
                            <th>Jam Pulang</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php if (!empty($absen)) {
            $no = 0;
            foreach ($absen as $row) {
                $no++;
                echo '<tr>';
                echo '<td>' . $no . '</td>';
                echo '<td>' . tampil_nama_karyawan_byid($row->id_karyawan) . '</td>';
                echo '<td>' . $row->kegiatan . '</td>';
                echo '<td>' . $row->date . '</td>';
                echo '<td>' . $row->jam_masuk . '</td>';
                echo '<td>' . $row->jam_pulang . '</td>';
                echo '<td>' . $row->keterangan_izin . '</td>';
                echo '<td>' . $row->status . '</td>';
                echo '<td><button onClick="hapus(' . $row->id_karyawan . ')" class="btn btn-sm btn-danger mx-1"><i class="fa-solid fa-trash"></i></button></td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="8">Tidak ada data untuk tanggal ini.</td></tr>';
        } ?>
                    </tbody>
                </table>
            </div>
    </div>
    </section>

    </div>
    <script>
    function hapus(id) {
        swal.fire({
            title: 'Yakin untuk menghapus data ini?',
            text: "Data ini akan terhapus permanen",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Dihapus',
                    showConfirmButton: false,
                    timer: 1500,

                }).then(function() {
                    window.location.href = "<?php echo base_url('admin/hapus_absen/')?>" + id +
                        "/rekap_harian";

                });
            }
        });
    }
    </script>

</body>

</html>