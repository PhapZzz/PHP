<?php
session_start();
require_once('controllers/base_controller.php');
require_once('models/style.php');
require_once('models/login.php');

class ProfileController extends BaseController
{
  function __construct()
  {
    $this->folder = 'pages';
  }
  
  public function profile(){   
    if (!isset($_SESSION['user_id'])) {
      header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
      exit; // Kết thúc chương trình sau khi chuyển hướng
  }

    $style = style::getStyleProduct(); // Lấy danh sách các style  
    $dataStyle = array('style' => $style);

    // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // }

    $data = array(
        'dataStyle' => $dataStyle // Truyền danh sách tên style vào dữ liệu để sử dụng trong view
    );
     $this->render('profile', $data,null);
  }

  public function updateProfile(){   
    if (!isset($_SESSION['user_id'])) {
      header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
      exit; // Kết thúc chương trình sau khi chuyển hướng
  }
    if(isset($_POST["post"])){
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $address = $_POST['address'];
      $age = $_POST['age'];
      $gender = $_POST['gender'];

      $db = DB::getInstance();
      $sql = "UPDATE users SET address = $address, email = $email, gender = $gender, age = $age WHERE phone = $phone";
      
      $db->query($sql);
      
      $response = true;
      exit(json_encode($response));
    }
  }

  public function error()
  {
    $this->render('error', null , null);
  }

}
