<?php
$error_password = $this->session->flashdata('error_password');
$error_email = $this->session->flashdata('error_email');
?>
<!DOCTYPE html>

<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    html,
    body {
        display: grid;
        height: 100%;
        width: 100%;
        place-items: center;
        background: rgb(2, 0, 36);
        background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(71, 35, 217, 1) 100%);

    }

    ::selection {
        background: #fa4299;
        color: #fff;
    }

    .wrapper {
        overflow: hidden;
        max-width: 390px;
        background: #fff;
        padding: 30px;
        border-radius: 5px;
        box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.1);
    }

    .wrapper .title-text {
        display: flex;
        width: 200%;
    }

    .wrapper .title {
        width: 50%;
        font-size: 35px;
        font-weight: 600;
        text-align: center;
        transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .wrapper .slide-controls {
        position: relative;
        display: flex;
        height: 50px;
        width: 100%;
        overflow: hidden;
        margin: 30px 0 10px 0;
        justify-content: space-between;
        border: 1px solid lightgrey;
        border-radius: 5px;
    }

    .slide-controls .slide {
        height: 100%;
        width: 100%;
        color: #fff;
        font-size: 18px;
        font-weight: 500;
        text-align: center;
        line-height: 48px;
        cursor: pointer;
        z-index: 1;
        transition: all 0.6s ease;
    }

    .slide-controls label.signup {
        color: #000;
    }

    .slide-controls .slider-tab {
        position: absolute;
        height: 100%;
        width: 50%;
        left: 0;
        z-index: 0;
        border-radius: 5px;
        background: -webkit-linear-gradient(left, #a445b2, #fa4299);
        transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    input[type="radio"] {
        display: none;
    }

    #signup:checked~.slider-tab {
        left: 50%;
    }

    #signup:checked~label.signup {
        color: #fff;
        cursor: default;
        user-select: none;
    }

    #signup:checked~label.login {
        color: #000;
    }

    #login:checked~label.signup {
        color: #000;
    }

    #login:checked~label.login {
        cursor: default;
        user-select: none;
    }

    .wrapper .form-container {
        width: 100%;
        overflow: hidden;
    }

    .form-container .form-inner {
        display: flex;
        width: 200%;
    }

    .form-container .form-inner form {
        width: 50%;
        transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .form-inner form .field {
        height: 50px;
        width: 100%;
        margin-top: 20px;
    }

    .form-inner form .field input {
        height: 100%;
        width: 100%;
        outline: none;
        padding-left: 15px;
        border-radius: 5px;
        border: 1px solid lightgrey;
        border-bottom-width: 2px;
        font-size: 17px;
        transition: all 0.3s ease;
    }

    .form-inner form .field input:focus {
        border-color: #4723D9;
        /* box-shadow: inset 0 0 3px #fb6aae; */
    }

    .form-inner form .field input::placeholder {
        color: #999;
        transition: all 0.3s ease;
    }

    form .field input:focus::placeholder {
        color: #b3b3b3;
    }

    .form-inner form .pass-link {
        margin-top: 5px;
    }

    .form-inner form .signup-link {
        text-align: center;
        margin-top: 30px;
    }

    .form-inner form .pass-link a,
    .form-inner form .signup-link a {
        color: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(71, 35, 217, 1) 100%);

        text-decoration: none;
    }

    .form-inner form .pass-link a:hover,
    .form-inner form .signup-link a:hover {
        text-decoration: underline;
    }

    form .btn {
        height: 50px;
        width: 100%;
        border-radius: 5px;
        position: relative;
        overflow: hidden;
    }

    form .btn .btn-layer {
        height: 100%;
        width: 300%;
        position: absolute;
        left: -100%;
        background: rgb(2, 0, 36);
        background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(71, 35, 217, 1) 100%);
        border-radius: 5px;
        transition: all 0.4s ease;
        ;
    }

    form .btn:hover .btn-layer {
        left: 0;
    }

    form .btn input[type="submit"] {
        height: 100%;
        width: 100%;
        z-index: 1;
        position: relative;
        background: none;
        border: none;
        color: #fff;
        padding-left: 0;
        border-radius: 5px;
        font-size: 20px;
        font-weight: 500;
        cursor: pointer;
    }

    input[type="checkbox"] {
        transform: scale(0.8);
        /* Mengurangi skala checkbox */
    }

    .form-inner form .field {
        position: relative;
    }

    .form-inner form .field #password {
        padding-right: 40px;
    }

    .form-inner form .field #toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.6/dist/sweetalert2.all.min.js"></script>

</head>

<body>
    <div class="wrapper">
        <div class="title-text">
            <div class="title login">
                Register Form
            </div>
            <div class="title signup">
                Login Form
            </div>
        </div>
        <div class="form-container">

            <div class="form-inner">
                <form action="<?php echo base_url();?>auth/aksi_register_admin" method="post" class="signup">

                    <div class="row">
                        <div class="field col-6">
                            <input type="text" name="nama_depan" placeholder="Nama Depan" required>
                        </div>
                        <div class="field col-6">
                            <input type="text" name="nama_belakang" placeholder="Nama Belakang" required>
                        </div>
                        <div class="field col-6">
                            <input type="text" name="email" placeholder="Email" required>
                        </div>
                        <div class="field col-6">
                            <input type="text" name="username" placeholder="Username" required>
                        </div>
                        <div class="field col-12">
                            <input type="password" class="form-control" id="password" placeholder="Password"
                                name="password">
                            <i class="fas fa-eye-slash" id="toggle-password"></i>
                        </div>
                        <p>*Password minimal 8 karakter</p>
                    </div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="Register">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#toggle-password').click(function() {
            var passwordField = $('#password');
            var passwordToggle = $(this);

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                passwordToggle.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                passwordField.attr('type', 'password');
                passwordToggle.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });
    });

    // Panggil SweetAlert di luar dari $(document).ready()
    var error_email = "<?php echo $error_email; ?>";
    if (error_email) {
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan!!',
            text: "Alamat email sudah terdaftar!!",
            showConfirmButton: false,
            timer: 2000
        });
    }

    var error_password = "<?php echo $error_password; ?>";
    if (error_password) {
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan!!',
            text: "Password harus memiliki minimal 8 karakter!!",
            showConfirmButton: false,
            timer: 2000
        });
    }
    </script>
</body>

</html>