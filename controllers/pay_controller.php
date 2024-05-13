<?php
session_start();
require_once('controllers/base_controller.php');
require_once('models/style.php');
require_once('models/cart.php');
require_once('models/bill.php');
require_once('models/billDetail.php');

class PayController extends BaseController
{
  function __construct()
  {
    $this->folder = 'pages';
  }
  
  public function pay(){   
    if (!isset($_SESSION['user_id'])) {
        header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
        exit; // Kết thúc chương trình sau khi chuyển hướng
    }

    $style = style::getStyleProduct(); // Lấy danh sách các style  
    $dataStyle = array('style' => $style);
    $errorMessage = ""; // Khởi tạo thông báo lỗi

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy thông tin từ biểu mẫu
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $paymentMethod = $_POST['paymentMethod'];

        // Kiểm tra số điện thoại
        if (!preg_match('/^0[0-9]{9}$/', $phone)) {
            $errorMessage .= "Số điện thoại không hợp lệ! ";
        }

        // Kiểm tra email
        if (substr($email, -10) !== "@gmail.com") {
            $errorMessage .= "Email không hợp lệ! ";
        }

        // Kiểm tra xem checkbox trong div có id="check_box_pay" đã được chọn hay không
        if (empty($paymentMethod)) {
            $errorMessage .= "Vui lòng chọn phương thức thanh toán!";
        }

        // Nếu có lỗi, hiển thị thông báo lỗi và yêu cầu nhập lại
        if (!empty($errorMessage)) {
            echo "<script>alert('$errorMessage');</script>";
        } else {
            // Tiếp tục xử lý đơn hàng nếu không có lỗi
            $timeOrder = date("Y-m-d");
            $status = "Pending confirmation";
            $cart = unserialize($_SESSION['cart']);

            $bill = new bill(0,$phone,$email,$cart['totalCart']->getQuantity(),$address,$timeOrder,$status,$cart['totalCart']->getTotalPrice(),$cart['itemCart']);
            bill::addBill($bill);

            $idNewBill = bill::getIdNewBill();
            foreach ($cart['itemCart'] as $item){
                $billDetail = new billDetail(0,$item->getQuantity(), $item->getTotalPrice(), $item->getProduct()->getIdProduct(), $item->getProduct()->getNameProduct(), $item->getProduct()->getIdCategory(), $idNewBill, $item->getProduct()->getImage());
                billDetail::addBillDetail($billDetail);
            }

            // tăng lượt mua khi người dùng ấn thanh toán
            foreach ($cart['itemCart'] as $item){
                $idproduct = $item->getProduct()->getIdProduct();
                $quantity = $item->getQuantity();
                product::increasePurchases($idproduct,$quantity);

            }




            // Sau khi xử lý đơn hàng thành công, redirect lại trang giỏ hàng và xóa toàn bộ giỏ hàng
            header("Location: http://localhost:8008/PHP/index.php?controller=cart&action=deleteAllCart&pay=true");
            exit();
        }
    }

    $data = array(
        'dataStyle' => $dataStyle, // Truyền danh sách tên style vào dữ liệu để sử dụng trong view
        'name' => isset($_POST['name']) ? $_POST['name'] : "",
        'phone' => isset($_POST['phone']) ? $_POST['phone'] : "",
        'address' => isset($_POST['address']) ? $_POST['address'] : "",
        'email' => isset($_POST['email']) ? $_POST['email'] : ""
    );
    $this->render('pay', $data,null);
}  

  public function error()
  {
    $this->render('error', null , null);
  }

}
