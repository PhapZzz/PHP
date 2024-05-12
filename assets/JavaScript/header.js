window.addEventListener("keydown", function(event) {
	if (event.keyCode === 123) { // kiểm tra nếu phím F12 được nhấn
		event.preventDefault(); // ngăn chặn hành động mặc định của trình duyệt khi nhấn phím F12
		window.resizeTo(screen.availWidth, screen.availHeight); // co dãn kích thước của trang web để phù hợp với màn hình hiện tại
	}
});


//// Event tab menu
const openMenu = document.querySelector('#icon_menu')
const tagMenu = document.querySelector('.tab_menu')
const btnClose = document.querySelector('.close')

function showMenu() {
	if (tagMenu.classList.contains('open')) {
		tagMenu.classList.remove('open')
	} else {
		tagMenu.classList.add('open')
	}
}
function closeMenu() {
	tagMenu.classList.remove('open')
}
openMenu.addEventListener('click', showMenu)
btnClose.addEventListener('click', closeMenu)

// ////// bắt sự kiện thẻ lọc danh sách sản phẩm
// var listItems = document.getElementsByClassName('tab_list_menu');
// for (var i = 0; i < listItems.length; i++) {
// 	listItems[i].addEventListener('click', function() {
// 		var sublist = this.getElementsByClassName('list_clothes')[0];
// 		if (sublist.style.display === 'block') {
// 			sublist.style.display = 'none';
// 			this.classList.remove('openlist');
// 		} else {
// 			sublist.style.display = 'block';
// 			this.classList.add('openlist');
// 			var otherSublists = document.getElementsByClassName('list_clothes');
// 			for (var j = 0; j < otherSublists.length; j++) {
// 				if (otherSublists[j] !== sublist) {
// 					otherSublists[j].style.display = 'none';
// 					otherSublists[j].parentNode.classList.remove('openlist');
// 				}
// 			}
// 		}
// 	});
// 	// Ngăn chặn sự kiện lan ra đến thẻ cha
// 	listItems[i].getElementsByClassName('list_clothes')[0].addEventListener('click', function(event) {
// 		event.stopPropagation();
// 	});
// }


//// Event thanh price ( tab menu ) 
// var slider = document.getElementById('range');
// var output = document.getElementById('value_price')

// output.innerHTML = slider.value
// slider.oninput = function() {
// 	output.innerHTML = "0 - " + this.value + ".000 đ"
// }

//////////////////////////////////////////////////////// Event Search /////////////////////////////////////////////

let check = false ;
  const searchBox = document.querySelector('.search-box');
  const divSearchBox = document.querySelector('.search-container');
  const iconSearchBox = document.querySelector('.fa-magnifying-glass');
  const closeSearchBox = document.querySelector('.hide');

  function startToSearch(){
    if(!check){ 
    divSearchBox.classList.add('big');
    searchBox.classList.add('search-box-click');
    iconSearchBox.style.backgroundColor = 'white';
    closeSearchBox.style.display  = 'block';
    check = true ;
  }
}

function CloseSearch(){
  divSearchBox.classList.remove('big');
  searchBox.classList.remove('search-box-click');
  iconSearchBox.style.backgroundColor = 'rgba(255, 255, 255, 0)';
  closeSearchBox.style.display  = 'none';
  check = false ;
}

  searchBox.addEventListener('click',startToSearch)
  iconSearchBox.addEventListener('click',startToSearch)
  divSearchBox.addEventListener('click',startToSearch)
  closeSearchBox.addEventListener('click',CloseSearch)





