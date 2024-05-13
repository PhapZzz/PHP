<?php
session_start();
require_once('controllers/base_controller.php');
require_once('models/product.php');
require_once('models/style.php');
require_once('models/category.php');
require_once('models/bill.php');
require_once('models/role.php');
require_once('models/billDetail.php');
require_once('models/login.php');

class AdminController extends BaseController
{
  private $data;

  function __construct()
  {
    $this->folder = 'pages';
  }
  
  public function admin()
  {   
    if (!isset($_SESSION['user_id']) && $_SESSION['role']->getIdRole() == 2) {
      header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
    exit; 
  }

    if(isset($_GET["title"]) && isset($_GET["oder"])){
      $title = $_GET["title"];
      $oder = $_GET["oder"];
      $product = product::getODERAllProduct($title,$oder);
      $dataAllProduct = array('product' => $product);
      $data = array( 'dataAllProduct'=>$dataAllProduct);

      $layout = 'admin'; // Đặt layout là 'admin'
      $this->render('admin', $data,$layout); 
    }
    else{
      $product = product::getAllProduct();
      $dataAllProduct = array('product' => $product);
      
      $data = array('dataAllProduct'=>$dataAllProduct);
      $layout = 'admin'; // Đặt layout là 'admin'
      $this->render('admin', $data,$layout); 
    }
  }

  public function update()
  {   
    if (!isset($_SESSION['user_id']) && $_SESSION['role']->getIdRole() == 2) {
        header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
      exit; 
    }

    $idProduct = isset($_GET['idProduct']) ? $_GET['idProduct'] : null;
    $idCategory = isset($_GET['idCategory']) ? $_GET['idCategory'] : null;

    $category = category::getCategory();
    $dataCategory = array('category' => $category);

    $style = style::getStyleProduct(); 
    $dataStyle = array('style' => $style);

    $product = product::findByIdProduct($idProduct);

    $data = array(
      'dataCategory' => $dataCategory,
      'dataStyle' => $dataStyle,
      'product'=>$product,
      'idProduct' => $idProduct
    );
    $layout = 'admin';
    $this->render('edit', $data , $layout); 
  }

public function add()
{   
    if (!isset($_SESSION['user_id']) && $_SESSION['role']->getIdRole() == 2) {
        header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
      exit; 
    }

    $category = category::getCategory();
    $dataCategory = array('category' => $category);

    $style = style::getStyleProduct(); 
    $dataStyle = array('style' => $style);

    $data = array(
      'dataCategory' => $dataCategory,
      'dataStyle' => $dataStyle,
    );
    $layout = 'admin';
    $this->render('edit', $data , $layout); 
  } 

  public function addProduct()
  {  

    if(isset($_POST["post"])){

      $nameProduct = $_POST["nameProduct"];  
      $quantity = $_POST["quantity"];  
      $price = $_POST["price"];  
      $describe = $_POST["describe"];  
      $idStyle = $_POST["idStyle"];  
      $image = $_POST["image"];  
      $idCategory = $_POST["idCategory"];  

      $db = DB::getInstance();
      $sql = "INSERT INTO product (nameProduct, quantity, price, `describe`, idStyle, image, idCategory)
              VALUES ('$nameProduct','$quantity','$price','$describe','$idStyle','$image','$idCategory')";
      $db->query($sql);

      $response = true;
      exit(json_encode($response));
    }

  }

public function updateProduct()
{   
  if(isset($_POST["post"])){

    $nameProduct = $_POST["nameProduct"];  
    $quantity = $_POST["quantity"];  
    $price = $_POST["price"];  
    $describe = $_POST["describe"];  
    $idStyle = $_POST["idStyle"];  
    $image = $_POST["image"];  
    $idCategory = $_POST["idCategory"];  
    $idProduct = $_POST["idProduct"];
    
    $db = DB::getInstance();
    $sql = "UPDATE product SET 
                  nameProduct = '$nameProduct', 
                  quantity = '$quantity', 
                  price = '$price', 
                  `describe` = '$describe', 
                  idStyle = '$idStyle', 
                  image = '$image', 
                  idCategory = '$idCategory'
                  WHERE idProduct = $idProduct";
    $db->query($sql);
    
    $response = true;
    exit(json_encode($response));
  }
} 

public function deleteProduct()
{   
  if(isset($_POST["idProduct"])){

    $db = DB::getInstance();
    $listIdProduct = $_POST["idProduct"];

    foreach ($listIdProduct as $idProduct) {
      $sql = "DELETE FROM product WHERE idProduct = $idProduct" ;
      $db->query($sql);
    }

    $response = true;
    exit(json_encode($response));
  }
} 



public function dashBoard()
{   
  if (!isset($_SESSION['user_id']) && $_SESSION['role']->getIdRole() == 2) {
      header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
    exit; 
  }

  if(isset($_POST['start_date']) && isset($_POST['end_date'])){
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
  }
  else{
    $start_date = '2022-01-01';
    $end_date = '2050-12-31';
  }
  $layout = 'admin';
  $purchase = bill::getcountpurchasesforallcategory($start_date,$end_date);
  $datapurchase = array('datapurchase'=>$purchase);

  $title = category::getCategory();
  $datatitle = array('datatitle'=> $title); //ham nay khong sài nữa, nhưng mà cứ để vì không ảnh hưởng, chủ yếu để học

  $idproduct = billDetail::getALLBillDetail();
  $idProducts = [];
  
  foreach ($idproduct as $product) {
    $idProducts[] = $product->getIdProduct();
}
  
  $nameProduct = product::findByIdProduct($idProducts);
  $datanameProduct = array('datanameproduct'=>$nameProduct); // ham nay khong sài nữa, nhưng mà cứ để vì không ảnh hưởng, chủ yếu để học



  $purchase_product = bill::getcountpurchasesforallproduct($start_date,$end_date);
  $datapurchase_product = array('datapurchase_product'=>$purchase_product);


  $data= array(
    'datatitle' => $datatitle,
    'datapurchase'=>$datapurchase,
    // 'datanameproduct'=>$datanameProduct ,
    'datapurchase_product'=>$datapurchase_product,
    
  );
  $this->render_test('dashBoard', $data,$layout); 
}



public function billAdminPage()
{   
  if (!isset($_SESSION['user_id']) && $_SESSION['role']->getIdRole() == 2) {
      header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
    exit; 
  }

  $bill = bill::getAllBill();
  $dataBill = array('dataBill' => $bill);
  
  $layout = 'admin'; // Đặt layout là 'admin'
  $data = array(
    'dataBill'=>$dataBill
  );
  $this->render('bill', $data,$layout); 
}

public function billDetailAdminPage()
{   
  if (!isset($_SESSION['user_id']) && $_SESSION['role']->getIdRole() == 2) {
      header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
    exit; 
  }

  $idBill = isset($_GET['idBill']) ? $_GET['idBill'] : null;
  $billDetail = billDetail::getBillDetail($idBill);
  $dataBillDetail = array('dataBillDetail' => $billDetail);
  
  $layout = 'admin'; // Đặt layout là 'admin'
  $data = array(
    'dataBillDetail'=>$dataBillDetail
  );
  $this->render('billDetail', $data,$layout); 
}

public function confirmBill()
{   
  if (!isset($_SESSION['user_id']) && $_SESSION['role']->getIdRole() == 2) {
      header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
    exit; 
  }

  $idBill = isset($_GET['idBill']) ? $_GET['idBill'] : null;
  bill::confirmBill($idBill);
  header("Location: http://localhost:8008/PHP/index.php?controller=admin&action=billAdminPage");
  exit;
}

public function cancelBill()
{   
  if (!isset($_SESSION['user_id']) && $_SESSION['role']->getIdRole() == 2) {
      header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
    exit; 
  }

  $idBill = isset($_GET['idBill']) ? $_GET['idBill'] : null;
  bill::cancelBill($idBill);
  header("Location: http://localhost:8008/PHP/index.php?controller=admin&action=billAdminPage");
  exit;
}

public function user()
{   
  if (!isset($_SESSION['user_id']) && $_SESSION['role']->getIdRole() == 2) {
      header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
    exit; 
  }
  $user = login::getFullUser();
  $dataUser = array('dataUser' => $user);

  $data = array(
    'dataUser'=>$dataUser
  );
  $layout = 'admin';
  $this->render('user', $data , $layout); 
}

public function updateRoleUser()
{   
  if (!isset($_SESSION['user_id']) && $_SESSION['role']->getIdRole() == 2) {
      header("Location: http://localhost:8008/PHP/index.php?controller=login&action=login");
    exit; 
  }

  $idUser = $_GET['idUser'];  
  $role = $_GET['newRole'];
  role::updateRole($idUser,$role);
  header("Location: http://localhost:8008/PHP/index.php?controller=admin&action=user");
}

  public function error()
  {
    $this->render('error', null , null);
  }

}