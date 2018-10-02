function show_password(){
	var password_input = document.getElementById("log-password-input");
	if (password_input.type === "password") {
		password_input.type = "text";
	} 
	else {
		password_input.type = "password";
	}
}

function fade_element(elementIdFromFade,elementIdToFade){
	var fading_element = document.getElementById(elementIdFromFade);
	var replacing_element = document.getElementById(elementIdToFade);
	
	fading_element.classList.add("fade");
	setTimeout(function(){
		replacing_element.classList.remove("fade");
		replacing_element.classList.remove("form-hide");
		fading_element.classList.add("form-hide");
	},200);
}

function show_selected_view(element){
	
	var views=document.getElementById("views").children;
	var tabs=document.getElementById("tabs").getElementsByTagName('li');
	var numberOfTabs=tabs.length;
	var numberOfViews=views.length;
	if(numberOfTabs==numberOfViews){
		for(var i=0;i<numberOfViews;i++){
			tabs[i].classList.remove('active-tab');
			views[i].classList.remove('tab-view-hide');
			views[i].classList.add('tab-view-hide');
		}
		for(var i=0;i<numberOfTabs;i++){
			if(element.id===tabs[i].id){
				views[i].classList.remove('tab-view-hide');
				element.classList.add('active-tab');
				break;
			}
		}
	}
	else{
		alert("Bad HTML: Tab or tab view missing!");
	}
}

function validate_form(form){
	
	var inputs = form.getElementsByTagName("input");
	for(var i = 0; i < inputs.length; i++){
		if (inputs[i].type && inputs[i].type === 'checkbox') {
			break;
		}
		else{
			if(inputs[i].value==="" && inputs[i].value.length === 0 || inputs[i].value.trim().length === 0){
				return false;
			}
		}
	}
	return true;		
}

function mark_page_as_active(divId,link){
	var links = document.getElementById(divId).getElementsByTagName('a');
	for (var i = 0; i < links.length; i++) {
		links[i].classList.remove('page-active');
	}
	link.classList.add('page-active');
}

function getElement(id,html){
	var div = document.createElement('div');
	div.innerHTML = html;
	return div.querySelector('#'+id);
}

function change_page(page_name,page,search_input,search_flag){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var params = 'page='+page;
	if(search_input && search_flag){
		params+='&search-input='+search_input+'&search='+search_flag;
	}
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var new_table = getElement("table",this.responseText);
			var old_table = document.getElementById("table");
			document.getElementById("datagrid").replaceChild(new_table,old_table);
			var new_nav_span = getElement("table-nums",this.responseText).firstChild;
			var old_nav_span = document.getElementById("table-nums").firstChild;
			document.getElementById("table-nums").replaceChild(new_nav_span,old_nav_span);
		}
	};
	xhttp.open("GET", page_name+"?"+params, true);
	xhttp.send();
}

function do_search(page_name,id){
	var xhttp;
	if (window.XMLHttpRequest) {
		xhttp = new XMLHttpRequest();
	} 
	else {
		xhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	var search_input = document.getElementById(id);
	var params = 'search=search&search-input='+search_input.value;

	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var new_table = getElement("table",this.responseText);
			var old_table = document.getElementById("table");
			document.getElementById("datagrid").replaceChild(new_table,old_table);
			var new_nav_span = getElement("table-nums",this.responseText).firstChild;
			var old_nav_span = document.getElementById("table-nums").firstChild;
			document.getElementById("table-nums").replaceChild(new_nav_span,old_nav_span);
		}
	};
	xhttp.open("GET", page_name+"?"+params, true);
	xhttp.send();
}
function remove_selection_box_element(element){
	var element_to_remove = element.parentElement.parentElement;
	var parent = element.parentElement.parentElement.parentElement;
	parent.removeChild(element_to_remove);
}
function add_selection_box_element(fieldId){
	var value_div = document.getElementById(fieldId);
	var parent_elem = value_div.nextElementSibling.nextElementSibling;
	var div_list = value_div.getElementsByTagName('ul')[0];
	var select_elem = parent_elem.firstElementChild.firstElementChild;
	var list_elements = div_list.children;
	var insert = true;
	for(i = 0; i < list_elements.length; i++){
		if(list_elements[i].firstChild.firstChild.innerHTML == select_elem.options[select_elem.selectedIndex].innerHTML){
	    		insert = false;
			value_div.nextElementSibling.innerHTML = "You have already entered this value!";  
			break;
		}
	}
	if(insert){
		value_div.nextElementSibling.innerHTML = "";  
		var li = document.createElement('li');
		var li_div_container = document.createElement('div');
		var li_div_value = document.createElement('div');
		var li_div_close = document.createElement('div');
		var li_div_option_value = document.createElement('div');
		
		li_div_close.addEventListener("click", function(){
			remove_selection_box_element(this);
		});
		
		li_div_value.innerHTML = select_elem.options[select_elem.selectedIndex].innerHTML;
		li_div_value.classList.add("float-left");
		li_div_close.classList.add("close-div");
		li_div_close.innerHTML = "&times;";
		li_div_option_value.innerHTML = select_elem.options[select_elem.selectedIndex].value;
		li_div_option_value.classList.add("hide-option");
		li_div_container.classList.add("block");
		li_div_container.appendChild(li_div_value);
		li_div_close.classList.add("float-right");
		li_div_container.appendChild(li_div_close);
		li_div_container.appendChild(li_div_option_value);
		li.appendChild(li_div_container);
		div_list.appendChild(li);
	}
}
function maxLength(el) {	
	if (!('maxLength' in el)) {
		var max = el.attributes.maxLength.value;
		el.onkeypress = function () {
			if (this.value.length >= max) return false;
		};
	}
}
function setCharCount(area){
	maxLength(area);
	area.nextElementSibling.children[1].firstChild.nodeValue=area.maxLength-area.value.length;
}
function changeCheckValue(check){
	check.value = "off";
	if(check.checked){
		check.value = "on";
	}
}

function convertTableDate(table_date){
	var date = table_date.substring(0, table_date.length - 1);
	return date.split(".").reverse().join("-");
}

function setModalValues(modalId,row,username = null,user_role = null,author_string = null, genre_string = null){
	var modal = document.getElementById(modalId);
	var inputs = modal.getElementsByTagName("input");
	var selects = modal.getElementsByTagName("select");
	var buttons = modal.getElementsByTagName("button");
	var uls = modal.getElementsByTagName("ul")	
	var textareas = modal.getElementsByTagName("textarea");
	var row_data = row.children;
			
	inputs[0].parentElement.parentElement.style.display = 'none';
	inputs[0].value = row.id;
	for(var i = 1; i < row_data.length; i++){
		if(modalId == 'addressEditModal'){
			if(i == 1){
				inputs[i].value = row_data[i].innerHTML;
			}
			else if(i == 2){
				inputs[i].value = row_data[i+1].innerHTML;
			}
			else{
				inputs[i].value = row_data[i-1].innerHTML;
			}
		}
		else if(modalId == 'categoryEditModal' || modalId == 'genreEditModal'){
			inputs[i].value = row_data[i].innerHTML;
		}
		else if(modalId == 'userEditModal'){
			if(i == 5){
				var row_username = row_data[i].innerHTML;
				var row_role = row_data[i+3].innerHTML;
				if(username == row_username && user_role == row_role){
					selects[0].disabled = true;
					inputs[1].disabled = true;
					inputs[2].disabled = true;
					buttons[2].disabled = true;
					buttons[3].disabled = true;
				}
				else{
					selects[0].disabled = false;
					inputs[1].disabled = false;
					inputs[2].disabled = false;					
					buttons[2].disabled = false;
					buttons[3].disabled = false;
				}
			}
			if(i == 6){
				if(row_data[i].innerHTML == 'approved'){
					inputs[1].checked = true;
					inputs[1].value = 'on';
				}
				else{
					inputs[1].checked = false;
					inputs[1].value = 'off';
				}
			}
			if(i == 7){
				if(row_data[i].innerHTML == 'active'){
					inputs[2].checked = true;
					inputs[2].value = 'on';
				}
				else{
					inputs[2].checked = false;
					inputs[1].value = 'off';
				}
			}			
			if(i == 8){
				var options = selects[0].options;
				for(var j = 0; j < options.length; j++){
					if(row_data[i].innerHTML.trim() == options[j].innerHTML.trim()){
						options[j].selected=true;
						break;
					}
				}
				
			}
		}
		else if(modalId == 'authorEditModal'){
			if(i == 4){
				textareas[0].value = row_data[i].innerHTML;
				if(row_data[i].innerHTML == '-'){
					textareas[0].value = '';
				}				
				textareas[0].nextElementSibling.children[1].firstChild.nodeValue = textareas[0].maxLength - textareas[0].value.length;
			}
			
			else{
				if (inputs[i].type == "date") {
					inputs[i].value = convertTableDate(row_data[i].innerHTML);
				}
				else {
					inputs[i].value = row_data[i].innerHTML;
				}
			}
			
		}
		else if(modalId == 'bookEditModal'){
			if(i == 3){
				var author_json = JSON.parse(author_string);
				while(uls[0].firstChild){
					uls[0].removeChild(uls[0].firstChild);
				}
				uls[0].parentElement.nextElementSibling.innerHTML = '';
				selects[1].selectedIndex = 0;

				for(var j = 0; j < author_json.length; j++){
					var li = document.createElement('li');
					var li_div_container = document.createElement('div');
					var li_div_value = document.createElement('div');
					var li_div_close = document.createElement('div');
					var li_div_option_value = document.createElement('div');

					li_div_close.addEventListener("click", function(){
						remove_selection_box_element(this);
					});
		
					li_div_value.innerHTML = author_json[j].firstname+" "+author_json[j].lastname;
					li_div_value.classList.add("float-left");
					li_div_close.classList.add("close-div");
					li_div_close.innerHTML = "&times;";
					li_div_option_value.innerHTML = author_json[j].id_author;
					li_div_option_value.classList.add("hide-option");
					li_div_container.classList.add("block");
					li_div_container.appendChild(li_div_value);
					li_div_close.classList.add("float-right");
					li_div_container.appendChild(li_div_close);
					li_div_container.appendChild(li_div_option_value);
					li.appendChild(li_div_container);
					uls[0].appendChild(li);
				}
			}
			else if(i == 4){
				var genre_json = JSON.parse(genre_string);
				while(uls[1].firstChild){
					uls[1].removeChild(uls[1].firstChild);
				}
				uls[1].parentElement.nextElementSibling.innerHTML = '';
				selects[2].selectedIndex = 0;
									
				for(var j = 0; j < genre_json.length; j++){
					var li = document.createElement('li');
					var li_div_container = document.createElement('div');
					var li_div_value = document.createElement('div');
					var li_div_close = document.createElement('div');
					var li_div_option_value = document.createElement('div');
					
					li_div_close.addEventListener("click", function(){
						remove_selection_box_element(this);
					});
		
					li_div_value.innerHTML = genre_json[j].genre_title;
					li_div_value.classList.add("float-left");
					li_div_close.classList.add("close-div");
					li_div_close.innerHTML = "&times;";
					li_div_option_value.innerHTML = genre_json[j].id_genre;
					li_div_option_value.classList.add("hide-option");
					li_div_container.classList.add("block");
					li_div_container.appendChild(li_div_value);
					li_div_close.classList.add("float-right");
					li_div_container.appendChild(li_div_close);
					li_div_container.appendChild(li_div_option_value);
					li.appendChild(li_div_container);
					uls[1].appendChild(li);
				}
							
			}
			else if(i == 5){
				var options = selects[0].options;
				for(var j = 0; j < options.length; j++){
					if(row_data[i].innerHTML.trim() == options[j].innerHTML.trim()){
						options[j].selected=true;
						break;
					}
				}
			}
			else {
				inputs[i].value = row_data[i].innerHTML;
			}
		}
		else if(modalId == 'bookCopyEditModal'){
			if(i == 1){
				var options = selects[0].options;
				for(var j = 0; j < options.length; j++){
					if(row_data[i].innerHTML.trim() == options[j].innerHTML.trim()){
						options[j].selected=true;
						break;
					}
				}
			}
			else if(i == 2 || i == 3){
				inputs[i-1].value = row_data[i].innerHTML;
			}
			else{ 
				if(i == 4){
					var options = selects[1].options;
					for(var j = 0; j < options.length; j++){
						if(row_data[i].innerHTML.trim() == options[j].innerHTML.trim()){
							options[j].selected=true;
							break;
						}
					}
				}
			}
		}
		else if(modalId == 'bookLendEditModal'){
			if(i == 5){
				if(row_data[i].innerHTML == 'approved'){
					inputs[1].checked = true;
					inputs[1].value = 'on';
				}
				else{
					inputs[1].checked = false;
					inputs[1].value = 'off';
				}
			}		
		}
		else if(modalId == 'memberEditModal'){
			if(i == 2 || i == 3){
				inputs[i-1].value = row_data[i].innerHTML;
			}
			else if(i == 5){
				inputs[i-2].value = convertTableDate(row_data[i].innerHTML);
				
			}
			else if(i == 6){
				var options = selects[0].options;
				for(var j = 0; j < options.length; j++){
					if(row_data[i].innerHTML.trim() == options[j].innerHTML.trim()){
						options[j].selected=true;
						break;
					}
				}
			}
			else{
				if(i == 8){
					textareas[0].value = row_data[i].innerHTML;
					if(row_data[i].innerHTML == '-'){
						textareas[0].value = '';
					}				
					textareas[0].nextElementSibling.children[1].firstChild.nodeValue = textareas[0].maxLength - textareas[0].value.length;
				}			
			}
		}
		else{
			if(modalId == 'publisherEditModal'){
				if(i == 1){
					inputs[i].value = row_data[i].innerHTML;
				}
				else {
					if(i == 2){
						var options = selects[0].options;
						for(var j = 0; j < options.length; j++){
							if(row_data[i].innerHTML.trim() == options[j].innerHTML.trim()){
								options[j].selected=true;
								break;
							}
						}
					}
				}
			}
		}
	}
}

function deleteData(modalId,page){
	if(confirm("Are you sure that you want to delete this data? This action cannot be reversed!")){
		var xhttp;
		if (window.XMLHttpRequest) {
			xhttp = new XMLHttpRequest();
		} 
		else {
			xhttp = new ActiveXObject('Microsoft.XMLHTTP');
		}
		var modal = document.getElementById(modalId);
		
		var id = modal.getElementsByTagName('input')[0];
		var params = 'action=delete&id='+id.value;
			
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var new_table = getElement("table",this.responseText);
				var old_table = document.getElementById("table");
				document.getElementById("datagrid").replaceChild(new_table,old_table);
				var new_nav_span = getElement("table-nums",this.responseText).firstChild;
				var old_nav_span = document.getElementById("table-nums").firstChild;
				document.getElementById("table-nums").replaceChild(new_nav_span,old_nav_span);
				var message = getElement("message",this.responseText).innerHTML;
				if(modalId == 'memberEditModal'){
					var new_users = getElement("user-select",this.responseText);
					var old_users = document.getElementById("user-select");
					old_users.parentElement.replaceChild(new_users,old_users);
				
				}
				alert(message);
			}
		};
		
		xhttp.open('POST', page, true);
		xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhttp.send(params);
	}
}
