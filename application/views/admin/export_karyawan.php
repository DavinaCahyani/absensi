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

    <style>
    body {
        padding-bottom: 30px;
        position: relative;
        min-height: 100%;
    }

    a {
        transition: background 0.2s, color 0.2s;
    }

    a:hover,
    a:focus {
        text-decoration: none;
    }

    #wrapper {
        padding-left: 0;
        transition: all 0.5s ease;
        position: relative;
    }

    #sidebar-wrapper {
        z-index: 1000;
        position: fixed;
        left: 250px;
        width: 0;
        height: 100%;
        margin-left: -250px;
        overflow-y: auto;
        overflow-x: hidden;
        background: #F7F6FB;
        /* Warna ungu muda */
        transition: all 0.5s ease;
    }

    #wrapper.toggled #sidebar-wrapper {
        width: 250px;
    }

    .sidebar-brand {
        position: absolute;
        top: 0;
        width: 250px;
        text-align: center;
        padding: 20px 0;
        background: #4723D9;

    }

    .sidebar-brand h2 {
        margin: 0;
        font-weight: 600;
        font-size: 25px;
        background: #4723D9;
        color: white;
        /* Warna ungu */
    }

    .sidebar-nav {
        position: absolute;
        top: 75px;
        width: 250px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    /* Gaya saat item dihover */
    .sidebar-nav>li:hover {
        background: #4723D9;
        text-indent: 10px;
        line-height: 42px;
        /* Warna ungu */
    }

    /* Gaya saat item mendapatkan fokus (diklik) */
    .sidebar-nav>li:focus {
        background: #4723D9;
        /* Warna ungu */
    }

    /* Warna teks untuk item di dalam sidebar */
    .sidebar-nav>li>a {
        text-decoration: none;
        color: #4723D9;
        /* Warna ungu untuk teks */
        font-weight: 600;
        font-size: 18px;
        text-indent: 10px;
        line-height: 42px;
    }

    /* Warna teks saat item dihover */
    .sidebar-nav>li:hover>a {
        color: #F7F6FB;
        text-indent: 10px;
        line-height: 42px;
        /* Warna putih untuk teks saat dihover */
    }

    .sidebar-nav a i {
        margin-right: 10px;
        /* Atur margin sesuai kebutuhan */
    }

    .button-container {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }


    .navbar-profile {
        position: absolute;
        right: 15px;
        top: 5px;
        font-size: 50px;
        /* Ubah ukuran ikon sesuai keinginan Anda */
        color: #F7F6FB;
        text-decoration: none;
    }


    #navbar-wrapper {
        width: 100%;
        position: absolute;
        z-index: 2;
    }

    #wrapper.toggled #navbar-wrapper {
        position: absolute;
        margin-right: -250px;
    }

    #navbar-wrapper .navbar {
        border-width: 0 0 0 0;
        background-color: #4723D9;
        /* Warna ungu */
        height: 75px;
        font-size: 24px;
        margin bottom: 0;
        border-radius: 0;
    }

    #navbar-wrapper .navbar a {
        color: #F7F6FB;
        /* Warna putih */
    }

    #navbar-wrapper .navbar a:hover {
        color: #F7F6FB;
        /* Warna putih */
    }

    #content-wrapper {
        width: 100%;
        position: absolute;
        padding: 15px;
        top: 100px;
    }

    #wrapper.toggled #content-wrapper {
        position: absolute;
        margin-right: -250px;
    }

    @media (min-width: 992px) {
        #wrapper {
            padding-left: 250px;
        }

        #wrapper.toggled {
            padding-left: 60px;
        }

        #sidebar-wrapper {
            width: 250px;
        }

        #wrapper.toggled #sidebar-wrapper {
            width: 60px;
        }

        #wrapper.toggled #navbar-wrapper {
            position: absolute;
            margin-right: -190px;
        }

        #wrapper.toggled #content-wrapper {
            position: absolute;
            margin-right: -190px;
        }

        #navbar-wrapper {
            position: relative;
        }

        #wrapper.toggled {
            padding-left: 60px;
        }

        #content-wrapper {
            position: relative;
            top: 0;
        }

        #wrapper.toggled #navbar-wrapper,
        #wrapper.toggled #content-wrapper {
            position: relative;
            margin-right: 60px;
        }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        #wrapper {
            padding-left: 60px;
        }

        #sidebar-wrapper {
            width: 60px;
        }

        #wrapper.toggled #navbar-wrapper {
            position: absolute;
            margin-right: -250px;
        }

        #wrapper.toggled #content-wrapper {
            position: absolute;
            margin-right: -250px;
        }

        #navbar-wrapper {
            position: relative;
        }

        #wrapper.toggled {
            padding-left: 250px;
        }

        #content-wrapper {
            position: relative;
            top: 0;
        }

        #wrapper.toggled #navbar-wrapper,
        #wrapper.toggled #content-wrapper {
            position: relative;
            margin-right: 250px;
        }
    }

    @media (max-width: 767px) {
        #wrapper {
            padding-left: 0;
        }

        #sidebar-wrapper {
            width: 0;
        }

        #wrapper.toggled #sidebar-wrapper {
            width: 250px;
        }

        #wrapper.toggled #navbar-wrapper {
            position: absolute;
            margin-right: -250px;
        }

        #wrapper.toggled #content-wrapper {
            position: absolute;
            margin-right: -250px;
        }

        #navbar-wrapper {
            position: relative;
        }

        #wrapper.toggled {
            padding-left: 250px;
        }

        #content-wrapper {
            position: relative;
            top: 0;
        }

        #wrapper.toggled #navbar-wrapper,
        #wrapper.toggled #content-wrapper {
            position: relative;
            margin-right: 250px;
        }
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
                    <a href="<?php echo base_url('admin/admin')?>"><i class="fa fa-user"></i>Rekap Keseluruhan</a>
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
            </ul>
        </aside>


        <div id="navbar-wrapper">
            <nav class="navbar navbar-inverse" style="background: #4723D9; border: none;">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand text-white" href="">
                            Data Karyawan
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <br>
        <div class="">
            <a href="<?php echo base_url('admin/export_karyawan')?>" class="btn btn-primary">Export</a>

        </div>
        <section id="content-wrapper">
            <div class="row">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
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