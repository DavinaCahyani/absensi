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
                            Data Karyawan
                        </a>
                    </div>
                    <p class="navbar-profile"><a href="<?php echo base_url('admin/profil') ?>" class="text-light"><i
                                class="fa-regular fa-circle-user"></i></a></p>
                </div>
            </nav>
        </div>

        <br>
        <div class="">
            <a href="<?php echo base_url('admin/export_data_karyawan')?>" class="btn btn-primary">Export</a>

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