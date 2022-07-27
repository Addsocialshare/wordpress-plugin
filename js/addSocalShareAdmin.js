// get trim() working in IE 
if(typeof String.prototype.trim !== 'function') {
      String.prototype.trim = function() {
        return this.replace(/^\s+|\s+$/g, ''); 
      }
}
var addSocalShareSharingHorizontalSharingTheme = document.getElementsByName('addSocalShare_sharing_settings[horizontalSharing_theme]');
var addSocalShareSharingVerticalSharingTheme = document.getElementsByName('addSocalShare_sharing_settings[verticalSharing_theme]');
var addSocalShareSharingHorizontalSharingProviders;
var addSocalShareSharingVerticalSharingProviders;
// validate numeric data 
function addSocalShareSharingIsNumber(n){
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function addSocalShareCheckElement(arr, obj){
	for(var i=0; i<arr.length; i++) {
		if (arr[i] == obj) return true;
	}
	return false
}

window.onload = function(){
	addSocalShareAdminUI2();
	addSocalShareSharingHorizontalSharingProviders = document.getElementsByName('addSocalShare_sharing_settings[horizontal_sharing_providers][]');
	addSocalShareSharingVerticalSharingProviders = document.getElementsByName('addSocalShare_sharing_settings[vertical_sharing_providers][]');
	addSocalShareAdminUI();
}
// toggle between login and registration form
function addSocalShareToggleForm(val){
	if(val == 'login'){
		document.getElementById('addSocialSharesiteRow').style.display = 'none';
		document.getElementById('addSocialShareSiteMessageRow').style.display = 'none';
		document.getElementById('confirmPasswordRow').style.display = 'none';
		document.getElementById('addSocalShareToggleFormLink').innerHTML = 'New to addSocalShare, Register Now!';
		document.getElementById('addSocalShareToggleFormLink').setAttribute('onclick', 'addSocalShareToggleForm("register")');
		document.getElementById('addSocalShareSubmit').value = 'Login';
		document.getElementById('addSocalShareFormTitle').innerHTML = 'Login to your addSocalShare Account to change settings as per your requirements!';
	}else{
		document.getElementById('addSocialSharesiteRow').style.display = 'table-row';
		document.getElementById('addSocialShareSiteMessageRow').style.display = 'table-row';
		document.getElementById('confirmPasswordRow').style.display = 'table-row';
		document.getElementById('addSocalShareToggleFormLink').innerHTML = 'AaddSocialShareeady have an account?';
		document.getElementById('addSocalShareToggleFormLink').setAttribute('onclick', 'addSocalShareToggleForm("login")');
		document.getElementById('addSocalShareSubmit').value = 'Register';
		document.getElementById('addSocalShareFormTitle').innerHTML = 'Register addSocalShare Account to change settings as per your requirements!';
	}
	document.getElementById('addSocalShareMessage').innerHTML = '';
}
function addSocalShareAdminUI(){
	for(var key in addSocalShareSharingHorizontalSharingTheme){
		if(addSocalShareSharingHorizontalSharingTheme[key].checked){
			addSocalShareToggleHorizontalShareTheme(addSocalShareSharingHorizontalSharingTheme[key].value);
			break;
		}
	}
	for(var key in addSocalShareSharingVerticalSharingTheme){
		if(addSocalShareSharingVerticalSharingTheme[key].checked){
			addSocalShareToggleVerticalShareTheme(addSocalShareSharingVerticalSharingTheme[key].value);
			break;
		}
	}
	// if rearrange horizontal sharing icons option is empty, show seleted icons to rearrange
	if(document.getElementsByName('addSocalShare_sharing_settings[horizontal_rearrange_providers][]').length == 0){
		for(var i = 0; i < addSocalShareSharingHorizontalSharingProviders.length; i++){
			if(addSocalShareSharingHorizontalSharingProviders[i].checked){
				addSocalShareRearrangeProviderList(addSocalShareSharingHorizontalSharingProviders[i], 'Horizontal');
			}
		}
	}
	// if rearrange vertical sharing icons option is empty, show seleted icons to rearrange
	if(document.getElementsByName('addSocalShare_sharing_settings[vertical_rearrange_providers][]').length == 0){
		for(var i = 0; i < addSocalShareSharingVerticalSharingProviders.length; i++){
			if(addSocalShareSharingVerticalSharingProviders[i].checked){
				addSocalShareRearrangeProviderList(addSocalShareSharingVerticalSharingProviders[i], 'Vertical');
			}
		}
	}
}

jQuery(function(){
    jQuery("#addSocalShareHorizontalSortable, #addSocalShareVerticalSortable").sortable({
      revert: true
    });
});
// prepare rearrange provider list
function addSocalShareRearrangeProviderList(elem, sharingType){
	var ul = document.getElementById('addSocalShare'+sharingType+'Sortable');
	if(elem.checked){
		var listItem = document.createElement('li');
		listItem.setAttribute('id', 'addSocalShare'+sharingType+'LI'+elem.value);
		listItem.setAttribute('title', elem.value);
		listItem.setAttribute('class', 'addSocialShareshare_iconsprite32 addSocialShareshare_'+elem.value.toLowerCase());
		// append hidden field
		var provider = document.createElement('input');
		provider.setAttribute('type', 'hidden');
		provider.setAttribute('name', 'addSocalShare_sharing_settings['+sharingType.toLowerCase()+'_rearrange_providers][]');
		provider.setAttribute('value', elem.value);
		listItem.appendChild(provider);
		ul.appendChild(listItem);
	}else{
		if(document.getElementById('addSocalShare'+sharingType+'LI'+elem.value)){
			ul.removeChild(document.getElementById('addSocalShare'+sharingType+'LI'+elem.value));
		}
	}
}
// limit maximum number of providers selected in horizontal sharing
function addSocalShareHorizontalSharingLimit(elem){
	var checkCount = 0;
	for(var i = 0; i < addSocalShareSharingHorizontalSharingProviders.length; i++){
		if(addSocalShareSharingHorizontalSharingProviders[i].checked){
			// count checked providers
			checkCount++;
			if(checkCount >= 10){
				elem.checked = false;
				document.getElementById('addSocalShareHorizontalSharingLimit').style.display = 'block';
				setTimeout(function(){ document.getElementById('addSocalShareHorizontalSharingLimit').style.display = 'none'; }, 2000);
				return;
			}
		}
	}
}
// limit maximum number of providers selected in vertical sharing
function addSocalShareVerticalSharingLimit(elem){
	var checkCount = 0;
	for(var i = 0; i < addSocalShareSharingVerticalSharingProviders.length; i++){
		if(addSocalShareSharingVerticalSharingProviders[i].checked){
			// count checked providers
			checkCount++;
			if(checkCount >= 10){
				elem.checked = false;
				document.getElementById('addSocalShareVerticalSharingLimit').style.display = 'block';
				setTimeout(function(){ document.getElementById('addSocalShareVerticalSharingLimit').style.display = 'none'; }, 2000);
				return;
			}
		}
	}
}
// show/hide options according to the selected horizontal sharing theme
function addSocalShareToggleHorizontalShareTheme(theme){
	switch(theme){
		case '32':
		document.getElementById('login_radius_horizontal_rearrange_container').style.display = 'block';
		document.getElementById('login_radius_horizontal_sharing_providers_container').style.display = 'block';
		document.getElementById('login_radius_horizontal_counter_providers_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_providers_container').style.display = 'block';
		break;
		case '16':
		document.getElementById('login_radius_horizontal_rearrange_container').style.display = 'block';
		document.getElementById('login_radius_horizontal_sharing_providers_container').style.display = 'block';
		document.getElementById('login_radius_horizontal_counter_providers_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_providers_container').style.display = 'block';
		break;
		case 'single_large':
		document.getElementById('login_radius_horizontal_rearrange_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_providers_container').style.display = 'none';
		break;
		case 'single_small':
		document.getElementById('login_radius_horizontal_rearrange_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_providers_container').style.display = 'none';
		break;
		case 'counter_vertical':
		document.getElementById('login_radius_horizontal_rearrange_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_sharing_providers_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_counter_providers_container').style.display = 'block';
		document.getElementById('login_radius_horizontal_providers_container').style.display = 'block';
		break;
		case 'counter_horizontal':
		document.getElementById('login_radius_horizontal_rearrange_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_sharing_providers_container').style.display = 'none';
		document.getElementById('login_radius_horizontal_counter_providers_container').style.display = 'block';
		document.getElementById('login_radius_horizontal_providers_container').style.display = 'block';
	}
}

// display options according to the selected counter theme
function addSocalShareToggleVerticalShareTheme(theme){
	switch(theme){
		case '32':
		document.getElementById('login_radius_vertical_rearrange_container').style.display = 'block';
		document.getElementById('login_radius_vertical_sharing_providers_container').style.display = 'block';
		document.getElementById('login_radius_vertical_counter_providers_container').style.display = 'none';
		break;
		case '16':
		document.getElementById('login_radius_vertical_rearrange_container').style.display = 'block';
		document.getElementById('login_radius_vertical_sharing_providers_container').style.display = 'block';
		document.getElementById('login_radius_vertical_counter_providers_container').style.display = 'none';
		break;
		case 'counter_vertical':
		document.getElementById('login_radius_vertical_rearrange_container').style.display = 'none';
		document.getElementById('login_radius_vertical_sharing_providers_container').style.display = 'none';
		document.getElementById('login_radius_vertical_counter_providers_container').style.display = 'block';
		break;
		case 'counter_horizontal':
		document.getElementById('login_radius_vertical_rearrange_container').style.display = 'none';
		document.getElementById('login_radius_vertical_sharing_providers_container').style.display = 'none';
		document.getElementById('login_radius_vertical_counter_providers_container').style.display = 'block';
	}
}

// assign update code function onchange event of elements
function addSocalShareAttachFunction(elems){
	for(var i = 0; i < elems.length; i++){
		elems[i].onchange = addSocalShareToggleTheme;
	}
}
function addSocalShareGetChecked(elems){
	var checked = [];
	// loop over all 
	for(var i=0; i<elems.length; i++){
		if(elems[i].checked){
			checked.push(elems[i].value);
		}
	}
	return checked;
}
