<link rel="stylesheet" href="./assets/css/login.css">
<link rel="stylesheet" href="./assets/icon/themify-icons/themify-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

<div id="content">
    <div id="background_login">

        <?php
        // Hiển thị thông báo nếu có
        if (isset($_GET['accessDenied'])) {
            echo '<div class="alert alert-warning" role="alert">Bạn không có quyền truy cập!</div>';
        } elseif (isset($_GET['sessionTimeout'])) {
            echo '<div class="alert alert-info" role="alert">Phiên làm việc hết hạn, yêu cầu đăng nhập lại!</div>';
        } elseif (isset($_GET['registerSuccess'])) {
            echo '<div class="alert alert-info" role="alert">Tạo tài khoản thành công</div>';
        }
        ?>
        
        <div id="login">
            <h2 id="title_login">Đăng nhập</h2>
            <h3 id="name_shop">Singed/Shop</h3>

            <div id="login_form">
                <input id="phone_number" name="username" type="text" placeholder="Số điện thoại" required>
                <input id="passwd" name="password" type="password" placeholder="Mật khẩu" required>
                <button id="btn_login">Đăng nhập</button>
            </div>

            <div id="login_google">
                <a id="or">hoặc</a>
                <img id="img_google" src="./assets/img/google.png">
            </div>
            <div id="reques_register">
                Chưa có tài khoản? <a href="http://localhost:8008/PHP/index.php?controller=register&action=register" id="text_register">Đăng ký</a> 
            </div>
            <a id="forgot_passwd" href="fogot_passwd.html">Quên mật khẩu</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./assets/JavaScript/header.js"></script>
<script>
$(document).ready(function(){
    $("#btn_login").click(function(){
        var username = $("#phone_number").val();
        var password = $("#passwd").val();
        
        $.post("http://localhost:8008/PHP/index.php?controller=login&action=loginAuthentication", { 
            username: username, 
            password: password 
        }, 
        function(response){
            var data = JSON.parse(response);
            if(data == "success"){
               alert("Đăng nhập thành công!");
               window.location.href = "http://localhost:8008/PHP/index.php";
            }
            // if(data = "nonuser"){alert("SDT không đúng hoặc không tồn tại");}
            else alert("SĐT hoặc mật khẩu không đúng");
        }
        );
    });
});
</script>
