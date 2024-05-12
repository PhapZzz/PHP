<link rel="stylesheet"  href="./assets/css/register.css">
<link rel="stylesheet"  href="./assets/icon/themify-icons/themify-icons.css">
<link rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

<div id="content">
    <div id="background_regis">

        <div id="register">
            <h2 id="title_register">Đăng ký</h2>
            <!-- Form đăng ký -->
            <div id="register_form">
                <input id="phone_number" name="phone_number" type="text" placeholder="Số điện thoại" required>
                <input id="name" name="name" type="text" placeholder="Tên" required>
                <input id="passwd" name="password" type="password" placeholder="Mật khẩu" required>
                <input id="re_passwd" name="re_passwd" type="password" placeholder="Nhập lại mật khẩu" required>
                <button id="btn_register" class="btn btn-primary">Đăng ký</button>
            </divrm>
        </div>
    </div>
</div>

<script src="./assets/JavaScript/header.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
 $(document).ready(function(){
    $("#btn_register").click(function(){
        // Lấy dữ liệu từ form
        var phoneNumber = $("#phone_number").val();
        var name = $("#name").val();
        var password = $("#passwd").val();
        var rePassword = $("#re_passwd").val();
        var regex = /^0\d{9}$/;

        // Kiểm tra số điện thoại có phải là 10 số không
        if (!regex.test(phoneNumber)) {
            alert("Số điện thoại không hợp lệ! Vui lòng nhập lại.");
            return;
        }

        // Kiểm tra độ dài mật khẩu
        if (password.length < 3) {
            alert("Mật khẩu phải chứa ít nhất 3 ký tự!");
            return;
        }

        // Kiểm tra hai mật khẩu có giống nhau không
        if (password != rePassword) {
            alert("Hai mật khẩu không trùng khớp!");
            return;
        }

        // Gửi dữ liệu đến server bằng AJAX
        $.post("http://localhost:8008/PHP/index.php?controller=register&action=registerAccountUser",{
            phoneNumber: phoneNumber, 
            name: name ,
            password : password
        },
         function(response){
            var data = JSON.parse(response);
            // Xử lý phản hồi từ server
            if (data == "success") {
                // Đăng ký thành công
                alert("Đăng ký thành công!");
                window.location.href = "http://localhost:8008/PHP/index.php?controller=login&action=login";
                // Redirect hoặc thực hiện các hành động khác
            }
            else {
                // Xử lý các trường hợp khác
                alert("Đã xảy ra lỗi. Vui lòng thử lại sau.");
            }
        });
    });
});


</script>
