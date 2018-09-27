function validateAndSendBookForm(formId) {
	
	var form = document.getElementById(formId);
	
	var book_title_input = form.getElementsByTagName('input')[0];
	var original_book_title_input = form.getElementsByTagName('input')[1];
	var category_select = form.getElementsByTagName('select')[0];
	var category_id = category_select.options[category_select.selectedIndex].value;
	var author_selects = form.getElementsByTagName('ul')[0].getElementsByTagName('li');
	var genre_selects = form.getElementsByTagName('ul')[1].getElementsByTagName('li');
	if(book_title_input.value.trim().length == 0){
		book_title_input.value = '';
		book_title_input.nextElementSibling.innerHTML = 'Book title is empty!';
	}
	else{
		book_title_input.nextElementSibling.innerHTML = '';
	}
	if(original_book_title_input.value.trim().length == 0){
		original_book_title_input.value = '';
		original_book_title_input.nextElementSibling.innerHTML = 'Original book title is empty!';
	}
	else{
		original_book_title_input.nextElementSibling.innerHTML = '';
	}
	if(author_selects.length == 0){
		form.getElementsByTagName('span')[3].innerHTML = 'Please select at least one author!';
	}
	else{
		form.getElementsByTagName('span')[3].innerHTML = '';
	}
	if(book_title_input.nextElementSibling.innerHTML.length == 0 && original_book_title_input.nextElementSibling.innerHTML.length == 0 && (form.getElementsByTagName('span')[3].innerHTML.length == 0 || form.getElementsByTagName('span')[3].innerHTML == "You have already entered this value. Please try with another one!")){
		sendBookData(formId);
	}
}

function sendBookData(formId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var form = document.getElementById(formId);
	
	var book_title_input = form.getElementsByTagName('input')[0];
	var original_book_title_input = form.getElementsByTagName('input')[1];
	var category_select = form.getElementsByTagName('select')[0];
	var category_id = category_select.options[category_select.selectedIndex].value;
	var author_selects = form.getElementsByTagName('ul')[0].getElementsByTagName('li');
	var genre_selects = form.getElementsByTagName('ul')[1].getElementsByTagName('li');
	
	var params = 'book-title-input='+book_title_input.value+'&original-book-title-input='+original_book_title_input.value+'&id-category='+category_id+"&author-size="+author_selects.length;
	
	for(i=0; i<author_selects.length;i++){
		var selected_id = author_selects[i].firstElementChild.children[2].innerHTML;
		params+="&author"+(i+1)+"="+selected_id;
	}
	params+="&genre-size="+genre_selects.length;
	for(i=0; i<genre_selects.length;i++){
		var selected_id = genre_selects[i].firstElementChild.children[2].innerHTML;
		params+="&genre"+(i+1)+"="+selected_id;
	}	
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var new_table = getElement("table",this.responseText);
			var old_table = document.getElementById("table");
			document.getElementById("datagrid").replaceChild(new_table,old_table);
			var new_nav_span = getElement("table-nums",this.responseText).firstChild;
			var old_nav_span = document.getElementById("table-nums").firstChild;
			document.getElementById("table-nums").replaceChild(new_nav_span,old_nav_span);
			var message = getElement("message",this.responseText).innerHTML;
			book_title_input.value = '';
			original_book_title_input.value = '';
			var author_list = form.getElementsByTagName('ul')[0];
			while (author_list.firstChild) {
				author_list.removeChild(author_list.firstChild);
			}
			var genre_list = form.getElementsByTagName('ul')[1];
			while (genre_list.firstChild) {
				genre_list.removeChild(genre_list.firstChild);
			}
			alert(message);
		}
	};
	
	xhttp.open('POST', 'book-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params); 
	
}
