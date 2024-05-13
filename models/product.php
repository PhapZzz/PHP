<?php
require_once('models/shortInforProduct.php');
class product {
    private $idProduct;
    private $nameProduct;
    private $quantity;
    private $price;
    private $oldPrice;
    private $describe;
    private $idStyle;
    private $image;
    private $purchase; // lượt mua
    private $idCategory;
    private $createDate;


    public function __construct($idProduct, $nameProduct, $quantity, $price, $oldPrice, $describe, $idStyle, $image, $purchase, $idCategory, $createDate) {
        $this->idProduct = $idProduct;
        $this->nameProduct = $nameProduct;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->oldPrice = $oldPrice;
        $this->describe = $describe;
        $this->idStyle = $idStyle;
        $this->image = $image;
        $this->purchase = $purchase;
        $this->idCategory = $idCategory;
        $this->createDate= $createDate;
    }

    public function getIdProduct() {
        return $this->idProduct;
    }

    public function setIdProduct($idProduct) {
        $this->idProduct = $idProduct;
    }

    public function getNameProduct() {
        return $this->nameProduct;
    }

    public function setNameProduct($nameProduct) {
        $this->nameProduct = $nameProduct;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getOldPrice() {
        return $this->oldPrice;
    }

    public function setOldPrice($oldPrice) {
        $this->oldPrice = $oldPrice;
    }

    public function getDescribe() {
        return $this->describe;
    }

    public function setDescribe($describe) {
        $this->describe = $describe;
    }

    public function getIdStyle() {
        return $this->idStyle;
    }

    public function setIdStyle($idStyle) {
        $this->idStyle = $idStyle;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getPurchase() {
        return $this->purchase;
    }

    public function setPurchase($purchase) {
        $this->purchase = $purchase;
    }

    public function getidCategory() {
        return $this->idCategory;
    }

    public function setidCategory($idCategory) {
        $this->idCategory = $idCategory;
    }

    public function getCreateDate() {
        return $this->createDate;
    }

    public function setCreateDate($createDate) {
        $this->createDate = $createDate;
    }


    
    public static function getDetailProduct($idProduct)
    {
        $db = DB::getInstance();
        $sql = "SELECT idProduct, nameProduct, price, oldPrice, image,purchases ,  quantity, `describe`, idCategory, idStyle, `CreatedDate` FROM Product WHERE idProduct = " . $idProduct;
        $req = $db->query($sql);
    
        $item = $req->fetch(); // Sử dụng fetch() để chỉ trả về một dòng dữ liệu
    
        // Kiểm tra xem có dữ liệu không
        if ($item) {
            // Trả về một đối tượng ProductDTO mới
            return new product(
                $item['idProduct'],
                $item['nameProduct'],
                $item['quantity'],
                $item['price'],
                $item['oldPrice'],
                $item['describe'],
                $item['idStyle'],
                $item['image'],
                $item['purchases'],
                $item['idCategory'],
                $item['CreatedDate']
            );
        } else {
            return null; // Trả về null nếu không tìm thấy sản phẩm
        }
    }

    public static function getRelatedProduct($idCategory){
        $list = [];
        $db = DB::getInstance();
        $sql = "SELECT idProduct, nameProduct, image, price, oldPrice, idCategory, idStyle FROM Product
        WHERE idStyle = " . $idCategory;
        $req = $db->query($sql);
    
        foreach ($req->fetchAll() as $item) {
            $list[] = new shortInforProduct(
                $item['idProduct'],
                $item['nameProduct'],
                $item['image'],
                $item['price'],
                $item['oldPrice'],
                $item['idCategory'],
                $item['idStyle']
            );
        }
        return $list;
    }

    public static function getAllProduct(){
        $list = [];
        $db = DB::getInstance();
        $sql = " SELECT idProduct,nameProduct,quantity,price,oldPrice,`describe`,idStyle,`image`,purchases,idCategory, `CreatedDate`  FROM product  ";
        $req = $db->query($sql);
    
        foreach ($req->fetchAll() as $item) {
            $list[] = new product(
                $item['idProduct'],
                $item['nameProduct'],
                $item['quantity'],
                $item['price'],
                $item['oldPrice'],
                $item['describe'],
                $item['idStyle'],
                $item['image'],
                $item['purchases'],
                $item['idCategory'],
                $item['CreatedDate']
            );
        }
        return $list;
    }



    public static function getODERAllProduct($title, $oder){
        
        $list = [];
        $db = DB::getInstance();
        $sql = " SELECT idProduct,nameProduct,quantity,price,oldPrice,`describe`,idStyle,`image`,purchases,idCategory, `CreatedDate`  FROM product ORDER BY $title $oder ";
        $req = $db->query($sql);
    
        foreach ($req->fetchAll() as $item) {
            $list[] = new product(
                $item['idProduct'],
                $item['nameProduct'],
                $item['quantity'],
                $item['price'],
                $item['oldPrice'],
                $item['describe'],
                $item['idStyle'],
                $item['image'],
                $item['purchases'],
                $item['idCategory'],
                $item['CreatedDate']
            );
        }
        return $list;
    }
	
    // public static function findByIdProduct($idProduct){
    //     $db = DB::getInstance();
    //     $sql = "SELECT idProduct, nameProduct, quantity, price, oldPrice, `describe`, idStyle, `image`, purchases, idCategory, CreatedDate FROM product WHERE idProduct = ?";
    //     $stmt = $db->prepare($sql);
    //     $stmt->execute([$idProduct]);
    //     $item = $stmt->fetch();
    
    //     if ($item) {
    //         return new product(
    //             $item['idProduct'],
    //             $item['nameProduct'],
    //             $item['quantity'],
    //             $item['price'],
    //             $item['oldPrice'],
    //             $item['describe'],
    //             $item['idStyle'],
    //             $item['image'],
    //             $item['purchases'],
    //             $item['idCategory'],
    //             $item['CreatedDate']
    //         );
    //     } else {
    //         return null; // Trả về null nếu không tìm thấy sản phẩm
    //     }
    // }   

    public static function findByIdProduct($idProducts){
        $db = DB::getInstance();
        // nếu ko phải 1 mảng thì Chuyển đổi idProduct thành một mảng gồm một phần tử
        if (!is_array($idProducts)) {
            $idProducts = [$idProducts];
        }
        $placeholders = rtrim(str_repeat('?, ', count($idProducts)), ', '); // Tạo chuỗi ? tương ứng với số lượng phần tử trong mảng idProducts
        $sql = "SELECT idProduct, nameProduct, quantity, price, oldPrice, `describe`, idStyle, `image`, purchases, idCategory, CreatedDate FROM product WHERE idProduct IN ($placeholders)";
        $stmt = $db->prepare($sql);
        $stmt->execute($idProducts); // Truyền mảng idProducts vào execute
        $items = $stmt->fetchAll();
    
        $products = [];
        foreach ($items as $item) {
            $products[] = new Product(
                $item['idProduct'],
                $item['nameProduct'],
                $item['quantity'],
                $item['price'],
                $item['oldPrice'],
                $item['describe'],
                $item['idStyle'],
                $item['image'],
                $item['purchases'],
                $item['idCategory'],
                $item['CreatedDate']
            );
        }
        return $products;
    }
    
    public static function search($keySearch,$idcaregory,$price_max,$limit,$offset){
        $db = DB::getInstance();
        if ($idcaregory) {
            $sql = "SELECT * FROM Product WHERE nameProduct LIKE ? AND idCategory = ? AND price BETWEEN 0 AND $price_max LIMIT $limit OFFSET $offset";
            $stmt = $db->prepare($sql);
            $stmt->execute(["%$keySearch%", $idcaregory]);
            // $stmt->execute(array('price_max' => $price_max));
        } else {
            $sql = "SELECT * FROM Product WHERE nameProduct LIKE ? AND price BETWEEN 0 AND $price_max LIMIT $limit OFFSET $offset";
            $stmt = $db->prepare($sql);
            $stmt->execute(["%$keySearch%"]);
        }
        $items = $stmt->fetchAll();
    
        $result = [];
        foreach ($items as $item) {
            $product = new product(
                $item['idProduct'],
                $item['nameProduct'],
                $item['quantity'],
                $item['price'],
                $item['oldPrice'],
                $item['describe'],
                $item['idStyle'],
                $item['image'],
                $item['purchases'],
                $item['idCategory'],
                $item['CreatedDate']
            );
            $result[] = $product;
        }
        return $result;
    }

    public static function getcountpurchasesforallcategory(){
        $list = [];
        $db = DB::getInstance();
        $sql = " SELECT idCategory, COUNT(*) AS purchases
        FROM product
        GROUP BY idCategory";
        $req = $db->query($sql);
    
        foreach ($req->fetchAll() as $item) {
            $list[] = [
            // 'idCategory' => $item['idCategory'],
            'purchases' => $item['purchases']
                
            ];
        }
        return $list;
    }


    public static function countAfroduct($keySearch,$idcategory,$price_max)
    {
        $db = DB::getInstance();
        if ($idcategory) {
            $sql = "SELECT COUNT(*) FROM Product WHERE nameProduct LIKE ? AND idCategory=? AND price BETWEEN 0 AND $price_max";
            $stmt = $db->prepare($sql);
            $stmt->execute(["%$keySearch%", $idcategory]);
            
        } else {
            $sql = "SELECT COUNT(*) FROM Product WHERE nameProduct LIKE ? AND price BETWEEN 0 AND $price_max";
            $stmt = $db->prepare($sql);
            $stmt->execute(["%$keySearch%"]);
        }
        
        $count = $stmt->fetchColumn();
        return $count;
    }
    

// ham tang lượt bán
    public static function increasePurchases($idProduct, $quantity) {
        // Kết nối đến cơ sở dữ liệu
        $db = DB::getInstance();
    
        try {
            // Bắt đầu một giao dịch để đảm bảo tính toàn vẹn của dữ liệu
            $db->beginTransaction();
    
            // Truy vấn để tăng lượt mua cho sản phẩm có id là $idProduct
            $sql = "UPDATE product SET purchases = purchases + :quantity WHERE idProduct = :idProduct";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);   // là giá trị được ràng buộc. PDO::PARAM_INT chỉ định kiểu dữ liệu của tham số là một số nguyên, điều này giúp PDO biết cách xử lý giá trị khi thực thi truy vấn SQL.
            $stmt->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
            $stmt->execute();
    
            // Commit giao dịch
            $db->commit();
    
            // Trả về true nếu tăng lượt mua thành công
            return true;
        } catch (PDOException $e) {
            // Nếu có lỗi, rollback giao dịch và trả về false
            $db->rollBack();
            return false;
        }
    }
}
