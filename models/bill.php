<?php
require_once('models/billDetail.php');
class bill {
    private $idBill;
    private $phone;
    private $email;
    private $totalQuanty;
    private $address;
    private $orderDate;
    private $status; // Pending confirmation , Confirmed , cancel
    private $totalPrice;
    private $billDetail;

    public function __construct($idBill, $phone, $email, $totalQuanty, $address, $orderDate, $status, $totalPrice, $billDetail) {
        $this->idBill = $idBill;
        $this->phone = $phone;
        $this->email = $email;
        $this->totalQuanty = $totalQuanty;
        $this->address = $address;
        $this->orderDate = $orderDate;
        $this->status = $status;
        $this->totalPrice = $totalPrice;
        $this->billDetail = $billDetail;
    }

    public function hasNullFields() {
        if ($this->address == "" || $this->phone == "" || $this->email == "") {
            return true;
        } else {
            return $this->address == null || $this->phone == null || $this->email == null;
        }
    }

    public function getBillDetail() {
        return $this->billDetail;
    }

    public function setBillDetail($billDetail) {
        $this->billDetail = $billDetail;
    }

    public function getIdBill() {
        return $this->idBill;
    }

    public function setIdBill($idBill) {
        $this->idBill = $idBill;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getTotalQuanty() {
        return $this->totalQuanty;
    }

    public function setTotalQuanty($totalQuanty) {
        $this->totalQuanty = $totalQuanty;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getOrderDate() {
        return $this->orderDate;
    }

    public function setOrderDate($orderDate) {
        $this->orderDate = $orderDate;
    }

    public function getTotalPrice() {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice) {
        $this->totalPrice = $totalPrice;
    }

    public function getStatus() {
        return $this->status;
    }

    public function isStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    // Phương thức lấy danh sách tất cả hóa đơn
    public static function getAllBill() {
        $db = DB::getInstance();
        // Chuẩn bị truy vấn SQL
        $sql = "SELECT * FROM Bill";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        // Lấy kết quả
        $result = $stmt->fetchAll();

        // Khởi tạo mảng chứa các đối tượng Bill
        $bills = [];
        // Duyệt qua kết quả và ánh xạ vào các đối tượng Bill
        foreach ($result as $row) {
            // Lấy chi tiết hóa đơn cho mỗi hóa đơn
            $billDetail = billDetail::getBillDetail($row['idBill']);
            // Tạo đối tượng Bill mới và thêm vào mảng
            $bill = new bill(
                $row['idBill'],
                $row['phone'],
                $row['email'],
                $row['totalQuanty'],
                $row['address'],
                $row['orderDate'],
                $row['status'],
                $row['totalPrice'],
                $billDetail
            );
            $bills[] = $bill;
        }
        // Trả về danh sách hóa đơn
        return $bills;
    }

    // Phương thức xác nhận hóa đơn
    public static function confirmBill($idBill) {
        $db = DB::getInstance();
        // Chuẩn bị truy vấn SQL
        $sql = "UPDATE Bill SET status = 'Confirmed' WHERE idBill = ?";
        $stmt = $db->prepare($sql);
        // Bind tham số và thực thi truy vấn
        return $stmt->execute([$idBill]);
    }

    // Phương thức hủy hóa đơn
    public static function cancelBill($idBill) {
        $db = DB::getInstance();
        // Chuẩn bị truy vấn SQL
        $sql = "UPDATE Bill SET status = 'Cancel' WHERE idBill = ?";
        $stmt = $db->prepare($sql);
        // Bind tham số và thực thi truy vấn
        return $stmt->execute([$idBill]);
    }

    public static function addBill($bill) {
        $db = DB::getInstance();
        $sql = "INSERT INTO bill (phone, email, totalQuanty, address, orderDate, status, totalPrice) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$bill->getPhone(), $bill->getEmail(), $bill->getTotalQuanty(), $bill->getAddress(), $bill->getOrderDate(), $bill->getStatus(), $bill->getTotalPrice()]);     
        $stmt->closeCursor();
    }
    
    
    public static function getIdNewBill() {
        $db = DB::getInstance();
        $sql = "SELECT MAX(idBill) AS idNewBill FROM bill"; // Use alias for clarity
        $req = $db->query($sql);
      
        // Fetch a single value (the maximum ID)
        $idNewBill = $req->fetchColumn();
      
        return $idNewBill;
      }


      public static function getcountpurchasesforallcategory($start_date,$end_date){
        $list = [];
        $db = DB::getInstance();
        $sql = " SELECT billdetail.idCategory,category.nameCategory, SUM(billdetail.quanty) AS purchases
        FROM bill
        INNER JOIN billdetail ON billdetail.idBill = bill.idBill JOIN category on category.idCategory = billdetail.idCategory
        WHERE bill.orderDate BETWEEN '$start_date' AND '$end_date'
        GROUP BY billdetail.idCategory,category.nameCategory;";
        $req = $db->query($sql);
    
        foreach ($req->fetchAll() as $item) {
            $list[] = [
            // 'idCategory' => $item['idCategory'],
            'purchases' => $item['purchases'],
            'nameCategory'=>$item['nameCategory'],
                
            ];
        }
        return $list;
    }


    public static function getcountpurchasesforallproduct($start_date,$end_date){
        $list = [];
        $db = DB::getInstance();
        $sql = " SELECT billdetail.idProduct,product.nameProduct, SUM(billdetail.quanty) AS purchases
        FROM bill
        INNER JOIN billdetail ON billdetail.idBill = bill.idBill JOIN product on billdetail.idProduct=product.idProduct
        WHERE bill.orderDate BETWEEN '$start_date' AND '$end_date'
        GROUP BY billdetail.idProduct,product.nameProduct;";
        $req = $db->query($sql);
    
        foreach ($req->fetchAll() as $item) {
            $list[] = [
            // 'idCategory' => $item['idCategory'],
            'nameProduct'=>$item['nameProduct'],
            'purchases' => $item['purchases']
                
            ];
        }
        return $list;
    }

}
?>
