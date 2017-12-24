(document.getElementById('idioma-select')).addEventListener('click', function(){
  var dic = ´{
    "con-ord":"Orden",
    "con-tit":"Title",
    "con-url":"URL"
    "accion" : "Action"
  }
	for(var i=0; i<dic.length; i++){
    document.getElementByClass(dic[i]['key']).InnerHtml = dic[i]['value'];
  }
});
