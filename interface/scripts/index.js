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
			value_div.nextElementSibling.innerHTML = "You have already entered this value. Please try with another one!";  
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
		li_div_close.innerHTML = "x";
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
