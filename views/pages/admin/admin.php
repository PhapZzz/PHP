<script src="./assets/JavaScript/admin.js"></script>
                <div id="header-content">
                    <i class="fa-solid fa-bars"></i>
                    <ul class="tab-list-product">
                        <li><a>Tất cả sản phẩm</a></li>
                        <li><a>Áo</a></li>
                        <li><a>Quần</a></li>
                        <li><a>Phụ kiện</a></li>
                    </ul>
                    <div class="container-list-product"></div>
                    <i class="fa-solid fa-sort-down"></i> <i class="fa-solid fa-user"></i>
                </div>
    
                <div id="func">
                    <a href="http://localhost:8008/PHP/index.php?controller=admin&action=add"><button id="add">Thêm</button></a>
                    <a><button id="delete"  onclick="warningBeforeDelete()">Xóa</button></a>
                </div>
                <div id="div-table">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th class="id">ID</th>
                                <th class="name">Tên </th>
                                <th class="img">Hình ảnh</th>
                                <th class="quantity">Số lượng
                                    <div>
                                        <button name="quantity_asc" class="btn btn-primary btn-sm">▲</button>
                                        <button  name="quantity_desc" class="btn btn-primary btn-sm">▼</button>
                                    </div>
                                </th>
                                <th class="price">Giá
                                    <div>
                                        <button name="price_asc" class="btn btn-primary btn-sm">▲</button>
                                        <button  name="price_desc" class="btn btn-primary btn-sm">▼</button>
                                    </div>
                                </th>
                                <th class="old-price">Giá cũ</th>
                                <th class="style">style</th>
                                <th class="type">Loại</th>
                                <th class="describe">Mô tả</th>
                                <th class="purchases">Lượt mua
                                    <div>
                                        <button name="purchases_asc" class="btn btn-primary btn-sm">▲</button>
                                        <button  name="purchases_desc" class="btn btn-primary btn-sm">▼</button>
                                    </div>
                                </th>
                                <th class="date">Ngày tạo</th>
                                <th class="edit"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($dataAllProduct) && is_array($dataAllProduct['product'])): ?>
                            <?php foreach ($dataAllProduct['product'] as $product): ?>
                                <tr>
                                    <td><input type="checkbox" id="checkbox_<?php echo $product->getIdProduct(); ?>" class="checkbox_idProduct" value="<?php echo $product->getIdProduct(); ?>"><a><?php echo $product->getIdProduct(); ?></a></td>
                                    <td><a class="input-cell" type="text" ><?php echo $product->getNameProduct(); ?></a></td>
                                    <td><a><?php echo $product->getImage(); ?></a></td>
                                    <td><a class="input-cell" type="text" ><?php echo $product->getQuantity(); ?></a></td>
                                    <td><a class="input-cell" type="text" ><?php echo $product->getPrice(); ?></a></td>
                                    <td><a class="input-cell" type="text" ><?php echo $product->getOldPrice(); ?></a></td>
                                    <td><a class="input-cell" type="text" ><?php echo $product->getIdStyle(); ?></a></td>
                                    <td><a class="input-cell" type="text" ><?php
                                    echo $product->getidCategory(); ?></a></td>
                                    <td><textarea class="input-cell" class="describe_edit" name="describe"><?php echo $product->getDescribe(); ?></textarea></td>
                                    <td><a class="input-cell" type="text"><?php echo $product->getPurchase(); ?></a></td>
                                    <td><a class="input-cell" type="text"><?php echo $product->getCreateDate(); ?></a></td>
                                    <td><a href="http://localhost:8008/PHP/index.php?controller=admin&action=update&idProduct=<?php echo $product->getIdProduct(); ?>&idCategory=<?php echo $product->getidCategory();?>"><button class="input-cell" type="button"><i class="fa-solid fa-pen-to-square"></i></button></a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                                <tr>
                                    <td colspan="12">Không có sản phẩm nào được tìm thấy.</td>
                                </tr>
                        <?php endif; ?>

                            <!-- Thêm các dòng khác tương tự cho các sản phẩm khác -->
                        </tbody>
                    </table>
                </div>
            </div>

    <script >
        if (typeof jQuery == 'undefined') {
        	console.log("jQuery is not loaded!");
    	} else {
        	console.log("jQuery is loaded!");
    	}
        
		function warningBeforeDelete() {
			swal({
				  title: "Xác nhận xóa",
				  text: "Bạn có chắc chắn muốn xóa hay không",
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-success",
				  cancelButtonClass: "btn-danger",
				  confirmButtonText: "Xác nhận",
				  cancelButtonText: "Hủy bỏ",
				}).then(function(isConfirm) {
				  if (isConfirm) {			// call api delete
					  	var ids = $('tbody input[type=checkbox]:checked').map(function () {
				            return $(this).val();
				        }).get();
                        if(ids == "" ) alert("Vui lòng chọn sản phẩm để xóa !");
                        else deleteProduct(ids);
				  }
				});
		}
		
		function deleteProduct(idProduct) {
            alert(idProduct);
	        $.ajax({
	            url: 'http://localhost:8008/PHP/index.php?controller=admin&action=deleteProduct',
	            data: {idProduct: idProduct
                },
                type: 'POST',
	            success: function (result) {
                    if (result) 
                        alert("Xóa sản phẩm thành công !");
	            },
	            error: function (error) {
	            	alert("Xóa sản phẩm thất bại !");
	            }
	        });
	    }
	</script>