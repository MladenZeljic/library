function validateAndSendCopyForm(formId) {
	
	var form = document.getElementById(formId);
	
	var year_of_publication_input = form.getElementsByTagName('input')[0];
	var number_of_pages_input = form.getElementsByTagName('input')[1];
	if(year_of_publication_input.value.trim().length == 0){
		year_of_publication_input.value = '';
		year_of_publication_input.nextElementSibling.innerHTML = 'Year of publication is empty!';
	}
	else{
		year_of_publication_input.nextElementSibling.innerHTML = '';
		if(!year_of_publication_input.value.trim().match("[0-9]+$")){
			year_of_publication_input.value = '';
			year_of_publication_input.nextElementSibling.innerHTML = 'Year of publication is not correct!';
		}
	}
	if(number_of_pages_input.value.trim().length == 0){
		number_of_pages_input.value = '';
		number_of_pages_input.nextElementSibling.innerHTML = 'Number of pages is empty!';
	}
	else{
		number_of_pages_input.nextElementSibling.innerHTML = '';
		if(!number_of_pages_input.value.trim().match("[0-9]+$")){
			number_of_pages_input.value = '';
			number_of_pages_input.nextElementSibling.innerHTML = 'Number of pages is not correct!';
		}
	}
	if(year_of_publication_input.innerHTML.length == 0 && number_of_pages_input.nextElementSibling.innerHTML.length == 0){
		sendCopyData(formId);
	}
}

function sendCopyData(formId){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var form = document.getElementById(formId);
	
	var year_of_publication_input = form.getElementsByTagName('input')[0];
	var number_of_pages_input = form.getElementsByTagName('input')[1];
	var book_select = form.getElementsByTagName('select')[0];
	var book_id = book_select.options[book_select.selectedIndex].value;
	var publisher_select = form.getElementsByTagName('select')[1];
	var publisher_id = publisher_select.options[publisher_select.selectedIndex].value;
	
	var params = 'year-of-publication-input='+year_of_publication_input.value+'&number-of-pages-input='+number_of_pages_input.value+'&id-book='+book_id+"&id-publisher="+publisher_id;	
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var new_table = getElement("table",this.responseText);
			var old_table = document.getElementById("table");
			document.getElementById("datagrid").replaceChild(new_table,old_table);
			var new_nav_span = getElement("table-nums",this.responseText).firstChild;
			var old_nav_span = document.getElementById("table-nums").firstChild;
			document.getElementById("table-nums").replaceChild(new_nav_span,old_nav_span);
			var message = getElement("message",this.responseText).innerHTML;
			year_of_publication_input.value = '';
			number_of_pages_input.value = '';
			
			alert(message);
		}
	};
	
	xhttp.open('POST', 'book-copy-management.php', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(params); 
	
}
