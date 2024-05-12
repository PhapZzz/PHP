<?php
session_start();
require_once('controllers/base_controller.php');
require_once('models/login.php');

class LoginController extends BaseController
{
  function __construct() {

      $this->folder = 'pages';
}

public function login() {
    // Load view
    if (isset($_SESSION['user_id'])) {
        header("Location: http://localhost:8008/PHP/index.php?controller=pages&action=home");
    }
    $this->render('login', null, null);
}

public function loginAuthentication()
{   
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (isset($_SESSION['user_id'])) {
        echo json_encode(array("status" => "redirect", "url" => "http://localhost:8008/PHP/index.php?controller=pages&action=home"));
        exit();
    }
  
    // Kết nối CSDL - Đảm bảo bạn đã thực hiện kết nối trước đó
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Lấy thông tin người dùng từ CSDL
        $user = login::getAccountUser($username);

        if ($user) {
            // Kiểm tra mật khẩu
            if (password_verify($password, $user->getPassword())) {
                // Mật khẩu đúng, lưu thông tin người dùng vào session và trả về phản hồi JSON
                $_SESSION['user_id'] = $user->getIdUser();
                $_SESSION['role'] = $user->getRole()->getIdRole();
                $_SESSION['user'] = serialize($user);
                $status = "success";
                exit(json_encode($status));
            } else {
                // Mật khẩu không đúng, trả về phản hồi JSON với thông báo lỗi
                $status = "failed";
                exit(json_encode($status));
            }
        }
        else{
            $status = "nonuser";
            exit(json_encode($status));}
    }
}


public function logout() {
    // Xóa session
    session_destroy();
    // Chuyển hướng về trang đăng nhập
    header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
}

public function error()
{
    $this->render('error', null , null);
}

}