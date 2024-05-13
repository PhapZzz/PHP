<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>SINGED-SHOP</title>
        <link rel="stylesheet"  href="./assets/css/admin.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
        <link rel="stylesheet"  href="./assets/icon/themify-icons/themify-icons.css">
        <script src="./assets/JavaScript/sweetalert2.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="./assets/JavaScript/admin.js"></script>
    </head>

    <body>
        <div id="home-admin">
            <div id="menu">
                <div id="intro-admin">
                    <div id="row-intro">
                        <h1 id="title-admin">Admin</h1>
                        <img id="icon" src="./assets/img/iconsinged.webp">
                    </div>
                    <h3 id="hello-admin" >Chào  </h3>
                </div>
        
                <div id="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div id="div-list-menu">
                    <ul class="menu">
                        <li><i class="fa-solid fa-house-lock icon-list-menu"></i></i> <a
                            href="http://localhost:8008/PHP/index.php?controller=admin&action=admin">Home</a></li>
                        <li><i class="fa-solid fa-chart-line icon-list-menu"></i> <a
                            href="http://localhost:8008/PHP/index.php?controller=admin&action=dashBoard">Thống kê</a></li>
                        <li><i class="fa-solid fa-file icon-list-menu"></i> <a
                            href="http://localhost:8008/PHP/index.php?controller=pages&action=home">Pages</a></li>
                        <li><i class="fa-solid fa-file-invoice icon-list-menu"></i> <a
                            href="http://localhost:8008/PHP/index.php?controller=admin&action=billAdminPage">Duyệt đơn</a></li>
                        <?php if($_SESSION['role'] == 1 ) 
                        echo '<li><i class="fa-solid fa-gear icon-list-menu"></i> <a
                            href="http://localhost:8008/PHP/index.php?controller=admin&action=user">User</a></li>'
                        ?>
                        <li><i class="fa-solid fa-gear icon-list-menu"></i> <a
                            href="#">Cài đặt</a></li>
                        <li><i class="fa-solid fa-gear icon-list-menu"></i> <a
                            href="http://localhost:8008/PHP/index.php?controller=login&action=logout">Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
            <div id="content_1">
            <?= @$content ?>

        </div>
        </div>
            <footer>
                <h1 id="link-email"><i class="fa-solid fa-envelope"></i>Liên hệ email : huynhminhquan07072002@gmail.com</h1>
                <a id="link-facebook" href="https://www.facebook.com/profile.php?id=100040480342122"><i class="fa-brands fa-facebook"></i>Liên hệ Facebook</a>
            </footer>

    </body>
</html>
