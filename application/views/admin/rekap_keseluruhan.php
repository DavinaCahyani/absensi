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
    <!-- Tautan ke Font Awesome CSS (jika Anda ingin menggunakannya) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- Tautan ke Bootstrap JavaScript (JQuery dan Popper.js diperlukan) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>

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

    /* Gaya awal untuk menyembunyikan ikon dropdown */
    .toggle-icon {
        transform: rotate(0deg);
        transition: transform 0.2s;
    }

    /* Gaya saat dropdown dibuka (ikon diputar) */
    #collapseExample1.show+.list-group-item .toggle-icon {
        transform: rotate(180deg);
    }

    /* Custom styles for the dropdown menu */
    .custom-dropdown {
        background-color: transparent;
        border: none;
        /* Remove the border */
        box-shadow: none;
        /* Remove the shadow */

        /* Adjust padding and spacing as needed */
        padding: 0px 15px 0px 15px;
        font-size: 18px;
        margin: 0;
    }

    /* Style for individual dropdown items */
    .custom-dropdown .dropdown-item {
        color: #4723D9;
        /* Text color */
        font-weight: 600;
        /* Font weight */
        text-indent: 0;
        /* Reset text indent */
        line-height: 1.5;
        /* Adjust line height as needed */
    }

    /* Hover/focus style for dropdown items */
    .custom-dropdown .dropdown-item:hover,
    .custom-dropdown .dropdown-item:focus {
        background-color: #4723D9;
        /* Highlight color on hover/focus */
        color: #fff;
        /* Text color on hover/focus */
    }

    /* Remove default bullet points */
    .custom-dropdown .dropdown-item::before {
        content: none;
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
                <!-- Menu dropdown -->
                <li class="nav-item dropdown active mt-3">

                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-business-time"></i>
                        Rekap </a>
                    <ul class="dropdown-menu custom-dropdown" aria-labelledby="navbarDropdown">
                        <li class="active mt-3">
                            <a class="dropdown-item" href="<?php echo base_url('admin/rekap_keseluruhan')?>"><i
                                    class="fa-solid fa-business-time"></i>Rekap
                                Keseluruhan</a>
                        </li>
                        <li class="active mt-3">
                            <a class="dropdown-item" href="<?php echo base_url('admin/rekap_harian')?>"><i
                                    class="fa-solid fa-calendar-days"></i>Rekap
                                Harian</a>
                        </li>
                        <li class="active mt-3">
                            <a class="dropdown-item" href="<?php echo base_url('admin/rekap_mingguan')?>"><i
                                    class="fa-solid fa-calendar-week"></i>Rekap
                                Mingguan</a>
                        </li>
                        <li class="active mt-3">
                            <a class="dropdown-item" href="<?php echo base_url('admin/rekap_bulanan')?>"><i
                                    class="fa-regular fa-calendar"></i>Rekap
                                Bulanan</a>
                        </li>
                    </ul>
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
            <div class="row p-3 card mx-3">
                <div class="col-6">
                    <h1>Rekap Keseluruhan</h1>
                </div>
                <a href="<?php echo base_url('admin/export_rekap_keseluruhan')?>"
                    class="btn btn-primary col-1 mx-3">Export</a>

                <table class="table table-striped table-hover">
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
                        <?php $no=0;foreach($absen as $row): $no++?>
                        <tr>
                            <td><?php echo $no ?></td>
                            <td><?php echo tampil_nama_karyawan_byid($row->id_karyawan) ?></td>

                            <td><?php echo $row->kegiatan ?></td>
                            <td><?php echo $row->date ?></td>
                            <td><?php echo $row->jam_masuk ?></td>
                            <td><?php echo $row->jam_pulang ?></td>
                            <td><?php echo $row->keterangan_izin ?></td>
                            <td><?php echo $row->status ?></td>
                            <td>
                                <!-- HAPUS -->
                                <button onClick="hapus(<?php echo $row->id_karyawan ?>)"
                                    class="btn btn-sm btn-danger mx-1"><i class="fa-solid fa-trash"></i></button>

                            </td>
                            <?php endforeach ?>
                    </tbody>
                </table>
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
                        "/rekap_keseluruhan";

                });
            }
        });
    }
    </script>

</body>

</html>