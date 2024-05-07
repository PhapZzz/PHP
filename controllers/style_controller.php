<?php
session_start();
require_once('controllers/base_controller.php');
require_once('models/style.php');

class StyleController extends BaseController
{
    function __construct()
    {
      $this->folder = 'pages';
    }

    public function style() // Thay đổi tên hàm
    {

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $idStyle = isset($_GET['idStyle']) ? $_GET['idStyle'] : 1;
        //$idStyle = 1 ; 
    
        
        $limit = 8; // Số bài viết hiển thị trên mỗi trang
        $offset = ($page - 1) * $limit;

        // Lấy danh sách bài viết từ model
        $allProductStyle = style::getProductStyleAndPaginated($idStyle,$limit, $offset); // Thay đổi tên phương thức
        $dataProductStyle = array('allProductStyle' => $allProductStyle);

        $style = style::getStyleProduct(); // Lấy danh sách các style  
        $dataStyle = array('style' => $style);

        // Tính toán số trang
        $totalPage = style::countProductStyle($idStyle); // Thay đổi tên phương thức
        $totalPage = ceil($totalPage / $limit);

        
        // Truyền dữ liệu cho view
        $data = array(
            'dataProductStyle' => $dataProductStyle,
            'totalPage' => $totalPage,
            'currentPage' => $page,
            'dataStyle' => $dataStyle 
        );

        // Render view
        $this->render('style', $data, null); // Thay đổi tên view
    }
  
    public function error()
    {
      $this->render('error', null , null);
    }
}

?>