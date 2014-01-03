/**
 * Objeto global
 */
var $SINCA={};

/**
 * Submodulo encargado de las operaciones de la interfaz
 */
$SINCA.UI={};

/**
 * Submodulo encargado de los gridviews de sinca
 */
$SINCA.UI.GRIDVIEWS=(function()
{
	/**
	 * @access private
	 */
	var capa=null;

	/**
	 * @access private
	 * @param string name es el nombre de la capa que contiene el gridview
	 */
	function getCapa(name)
	{
		//obtengo todos los elementos con el nombre indicado
		var capas={},
			elementos=document.getElementsByName(name);
		//y me quedo con el que sean un div
		for(var i=0, j=elementos.length; i<=j; i++)
		{
			if(elementos[i].localName=="div")
			{
				capas[i]=elementos[i];
			};
		};
		//por ultimo confirmo que sea uno solo, sino arrojo un error
		if(capas.length>1) throw console.error('Hay mas de una capa');
			capa=capas[0];
		capas=elementos=null;
	}
})();

/*var total=0;
for(i=0,j=tds.length-1; i<=j;i++)
{
if(tds[i].id=="aperturaClaro"){total=total+parseFloat(tds[i].innerHTML)}
}*/