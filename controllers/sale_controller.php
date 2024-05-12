<?php
session_start();
require_once('controllers/base_controller.php');
require_once('models/sale.php');
require_once('models/style.php');
// http://localhost:8008/PHP/index.php?controller=sale&action=sale&page=
//http://localhost:8008/PHP/index.php?controller=sale&action=sale
class SaleController extends BaseController
{
    function __construct()
    {
      $this->folder = 'pages';
    }

    public function sale() // Thay đổi tên hàm
    { 
    //   if (!isset($_SESSION['user_id'])) {
    //     header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
    //     exit; // Kết thúc chương trình sau khi chuyển hướng
    // }
  
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 8; // Số bài viết hiển thị trên mỗi trang
        $offset = ($page - 1) * $limit;

        // Lấy danh sách bài viết từ model
        $sale = sale::getPaginatedSale($limit, $offset); // Thay đổi tên phương thức
        $dataSale = array('sale' => $sale);

        $style = style::getStyleProduct(); // Lấy danh sách các style  
        $dataStyle = array('style' => $style);

        // Tính toán số trang
        $totalPage = sale::countAllSale(); // Thay đổi tên phương thức
        $totalPage = ceil($totalPage / $limit);


        // Truyền dữ liệu cho view
        $data = array(
            'dataSale' => $dataSale,
            'totalPage' => $totalPage,
            'currentPage' => $page,
            'dataStyle' => $dataStyle 
        );
        
        // Render view
        $this->render('sale', $data, null); // Thay đổi tên view
    }
  
    public function error()
    {
      $this->render('error', null , null);
    }
}

?>