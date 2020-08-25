
	loadShow = function(){
		$("#loading").show();
	}
	loadFadeOut=function(){
		$("#loading").fadeOut(500);
	}


renderStatus=function(status){
	let str = '';
	
	switch(status){
		case '0':
			str = '停用';
			break;
		case '1':
			str = '啟用';
			break;
		case '-1':
			str = '刪除';
			break;
	}

	return str;
}

renderRoleType=function(status){
	let str = '';
	
	switch(status){
		case '0':
			str = '總公司';
			break;
		case '1':
			str = '分店';
			break;
	}

	return str;
}

renderCustomerProjectTarget=function(target){
	let str = '';
	
	switch(target){
		case '0':
			str = '客戶';
			break;
		case '1':
			str = '車號';
			break;
	}

	return str;
}