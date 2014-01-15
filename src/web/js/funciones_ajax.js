//<script type="text/javascript">
function mostrarResultados(str) {
if (str.length==0) {
document.getElementById("buscador_dinamico").innerHTML="";
document.getElementById("buscador_dinamico").style.border="0px";
return;
}
if (window.XMLHttpRequest) {
// para el IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else {
// para el IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function() {
if (xmlhttp.readyState==4 && xmlhttp.status==200) {
document.getElementById("buscador_dinamico").innerHTML=xmlhttp.responseText;
document.getElementById("buscador_dinamico").style.border="1px solid #A5ACB2";
}
}
xmlhttp.open("GET","\\assets\\sugerencias.php?q="+str, true);
xmlhttp.send();
}
//</script>