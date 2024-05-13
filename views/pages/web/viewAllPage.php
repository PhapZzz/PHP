<link rel="stylesheet"  href="./assets/css/viewAll.css">
<link rel="stylesheet"  href="./assets/css/sale.css">
<link rel="stylesheet"  href="./assets/icon/themify-icons/themify-icons.css">
<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
		
	<div id="content">
	<div id="div_slider_sale"></div>
		<hr id="line_sale">
		<div id="div_sale">
		<?php if(isset($title)):?>
		
			<h1 id="title_sale" name="<?php echo $category_id;?>"><?php echo $title?></h1>
			
			<?php endif; ?>

			<!-- <h1 id="title_sale"></h1> -->

		</div>

		<?php if($title =='TOP BÁN CHẠY' || $title =='SẢN PHẨM MỚI' ):?>
			<h1 id="title_sale"></h1>
			<?php else: ?>
		<div id="menu_search">
			<div class="range_slider_div">
				<h3 id="title_price">Khoảng giá: <span id="value_price1"></span></h3>
				<input type="range" min="0" max="10000" value="0" class="slider_range" id="range1">
            </div>

			<?php if(!isset($title) || $title==NULL): ?>
			<div class="category">
				<h3 id="title_price">Danh mục</h3>
				<button class="drop_category" onclick="showMenu_Category()">Chọn danh mục</button>
				<div id="drop_contentcategory" class="dropdown-contentcategory">
					<ul>
					<?php foreach ($datacategory['category'] as $item): ?>
						<li class="name_Category" name="<?php echo $item->getIdCategory() ?>"><?php echo $item->getNameCategory() ?></li>
					<?php endforeach; ?>	
					</ul>
				</div>
			</div>
			<?php endif; ?>
            <input class="search_name" placeholder="Tìm kiếm ..">
			
			<button id="sort">Lọc</button>

		</div>
		<?php endif; ?>



		<div id="list_product_sale">
			<?php foreach ($viewAllProduct['viewAllProduct'] as $item): ?>
				<div class="product">
					<a href="http://localhost:8008/PHP/index.php?controller=product&action=product&idProduct=<?php echo $item->getIdProduct(); ?>&idStyle=<?php echo $item->getIdStyle();?>">
						<div class="img_product" style="background-image: url(./assets/product/<?php echo $item->getImage(); ?>" alt="<?php echo $item->getNameProduct(); ?>)"> </div>
					</a>
					<div class="infor_product">
						<a class="name_product"><?php echo $item->getNameProduct(); ?></a>
						<div class="div_price">
							<a class="price"><?php echo $item->getPrice(); ?></a> 
							<a class="old_price"><?php echo $item->getOldPrice(); ?></a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			</div>
					
	<?php if (isset($currentPage)): ?>
		<div class="pagination">
                <a id="<?php echo ($currentPage > 1) ? ($currentPage - 1) : $currentPage; ?>" href="#">&laquo;</a>
                <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                    
                    <a id="<?php echo $i;?>" href="#" <?php if ($i == $currentPage) echo 'class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>
                <a id="<?php echo ($currentPage < $totalPage) ? ($currentPage + 1) : $currentPage; ?>" href="#">&raquo;</a>
            </div>
	<?php endif; ?>

	</div>
	<script src="assets/JavaScript/xulyajax.js"></script>
	<script src="assets/JavaScript/xulyajax_find.js"></script>

