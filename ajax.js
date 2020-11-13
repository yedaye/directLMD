// JavaScript Document
var rep;

function GetRequest()
{
	if(window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();	
	}else{
		xmlhttp=new XMLHttpRequest("Microsoft.XMLHTTP");	
	}	
	return xmlhttp;
}

function showHint(str){
	var xmlhttp;
	if(str.length==0){
			
	}	
}
function showText(){
	//var xmlhttp=GetRequest();
	if(window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();	
	}else{
		xmlhttp=new XMLHttpRequest("Microsoft.XMLHTTP");	
	}
	xmlhttp.onreadystatechange=function()
	{
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('rechercher').value=xmlhttp.responseText;
			document.getElementById('EnterText').innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","ajax.txt",true);
	xmlhttp.send();
}