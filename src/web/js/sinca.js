//--- ARCHIVO JAVASCRIPT PRINCIPAL DEL SISTEMA SINCA.
//--- ALBERGA LAS FUNCIONALIDADES DE CADA PANTALLA DEL MISMO.

//--- FUNCIONES ESTABLECIDAS PARA EL INICIO DEL DOCUMENTO (COLOCAR LAS FUNCIONES QUE SEAN CREADAS PARA LAS VISTAS).
$(document).ready(function()
{
    genExcel();
    genEmail();
    genPrint();
    newEC();
    addKid();
    deleteKid();
    getListEmployee();
    $("#Detallegasto_category").change(function () {
            selectGasto();
    });

});

    function newEC(){
        $('img.botonAgregar').on('click',function(event)
        {

                    var id = $(this).attr('id');

                    $('#vista_'+id).css({display:'none'});
                    $('#oculta_'+id).css({display:'inline'});
                    
                    $('img#'+id+'2').on('click',function(event)
                    {
                        $('#vista_'+id).css({display:'inline'});
                        $('#oculta_'+id).css({display:'none'});
                    });
                    
                    ValidateDate();
        });
    }


//--- FUNCION PARA CAPTURAR LOS IDs DEL GRIDVIEW Y LOS ENVIA A LA ActionExcel DEL CONTROLADOR 'SITE'.

    function genExcel()
    {
        $('img.botonExcel').on('click',function(event)//Al pulsar la imagen de Excel, es Generada la siguiente Funcion:
        {    

            $("#loading").html("Generando Excel... !!");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
             
            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            
            $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]=$(this).text(); //incluimos los ids de la columna en el array.
            });
            
            if(ids != ''){
            var response = $.ajax({ type: "GET",   
                                    url: '/site/excel?ids='+ids+'&name='+name+"&table="+gridview,   
                                    async: false,
                                    succes: alert,
                                  }).responseText;

             

             //Abrimos una Ventana (sin recargarla pagina) al controlador "Site", que a su ves llama a la funcion actionExcel().
             setTimeout("window.open('/site/excel?ids="+ids+"&name="+name+"&table="+gridview+"','_top');",500);

             //Mostramos los Mensajes y despues de la Descarga se Ocultan Automaticamente.
             $("#complete").html("Archivo Excel Generado... !!");
             setTimeout('$("#complete").css("display", "inline");', 1000);
             setTimeout('$("#loading").css("display", "none");', 1000); 
             setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
             setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
             }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#loading").css("display", "none");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }

        });
        
        $('img.botonExcelComplete').on('click',function(event)//Al pulsar la imagen de Print, es Generada la siguiente Funcion:
        {    
            
            $("#loading").html("Generando Excel... !!");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
             
            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="completa"]').filter(function(){return $(this).css('display') == "none" }).attr('id');
            var name = genNameFile(gridview);
            //alert(gridview);
            $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]=$(this).text(); //incluimos los ids de la columna en el array.
            });
            //alert(ids);
            if(ids != ''){
            var response = $.ajax({ type: "GET",   
                                    url: '/site/excel?ids='+ids+'&name='+name+"&table="+gridview,   
                                    async: false,
                                    succes: alert,
                                  }).responseText;

             

             //Abrimos una Ventana (sin recargarla pagina) al controlador "Site", que a su ves llama a la funcion actionExcel().
             setTimeout("window.open('/site/excel?ids="+ids+"&name="+name+"&table="+gridview+"','_top');",500);

             //Mostramos los Mensajes y despues de la Descarga se Ocultan Automaticamente.
             $("#complete").html("Archivo Excel Generado... !!");
             setTimeout('$("#complete").css("display", "inline");', 1000);
             setTimeout('$("#loading").css("display", "none");', 1000); 
             setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
             setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
            }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#loading").css("display", "none");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        }); 
        
        $('img.botonExcelT').on('click',function(event)//Al pulsar la imagen de Excel, es Generada la siguiente Funcion:
        {    

            $("#loading").html("Generando Excel... !!");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
             
            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            
            $("#"+gridview+" td#fecha").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]="'"+$(this).text()+"'"; //incluimos los ids de la columna en el array.
            });
            if(ids != ''){
            var response = $.ajax({ type: "GET",   
                                    url: '/site/excel?ids='+ids+'&name='+name+"&table="+gridview,   
                                    async: false,
                                    succes: alert,
                                  }).responseText;

             

             //Abrimos una Ventana (sin recargarla pagina) al controlador "Site", que a su ves llama a la funcion actionExcel().
             setTimeout('window.open("/site/excel?ids='+ids+'&name='+name+'&table='+gridview+'","_top");',500);

             //Mostramos los Mensajes y despues de la Descarga se Ocultan Automaticamente.
             $("#complete").html("Archivo Excel Generado... !!");
             setTimeout('$("#complete").css("display", "inline");', 1000);
             setTimeout('$("#loading").css("display", "none");', 1000); 
             setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
             setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
             }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#loading").css("display", "none");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }

        });
        
        $('img.botonExcelMatriz').on('click',function(event)//Al pulsar la imagen de Excel, es Generada la siguiente Funcion:
        {    

            $("#loading").html("Generando Excel... !!");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
             
            var gridview = $('table.matrizGastos').attr('id');
            var mes = $('div#fecha2').text();
            var cabina = $('div#cabina').text();
            var name = genNameFile(gridview);
            
            //alert(mes);
            
            
            var response = $.ajax({ type: "GET",   
                                    url: '/site/excel?name='+name+"&table="+gridview+"&mes="+mes+"&cabina="+cabina,    
                                    async: false,
                                    succes: alert,
                                  }).responseText;

             //alert(response);
             if($('table#'+gridview).length){
             //Abrimos una Ventana (sin recargarla pagina) al controlador "Site", que a su ves llama a la funcion actionExcel().
             var win = false;
             win = window.open("/site/excel?name="+name+"&table="+gridview+"&mes="+mes+"&cabina="+cabina,"_top");

            if (win.closed == false)
            {
 
             //Mostramos los Mensajes y despues de la Descarga se Ocultan Automaticamente.
             $("#complete").html("Archivo Excel Generado... !!");
             setTimeout('$("#complete").css("display", "inline");', 1000);
             setTimeout('$("#loading").css("display", "none");', 1000); 
             setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
             setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
            }
             }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#loading").css("display", "none");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }

        });
    }


//--- FUNCION PARA CAPTURAR LOS VALORES PARA ENVIAR LOS EMAILs DESDE EL ActionSendEmail DEL CONTROLADOR 'SITE'.

    function genEmail()
    {
        $('img.botonCorreo').on('click',function(event)//Al pulsar la imagen de Email, es Generada la siguiente Funcion:
        {    


            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            
            $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]=$(this).text(); //incluimos los ids de la columna en el array.
            });
            //alert(name);
            if(ids != ''){
            
                                $.ajax({ 
                                    type: "GET",   
                                    url: '/site/sendemail?ids='+ids+'&name='+name+"&table="+gridview,   
                                    async: false,
                                    beforeSend: function () {
                                            //window.open('/site/sendemail?ids='+ids+'&name=Balance%20Cabinas','_top');
//                                            $("#nombreContenedor").css("display", "inline");
//                                            $("#loading").css("display", "inline");
                                    },
                                    success:  function (response) {
                                            $("#complete").html("Correo Enviado con Exito... !!");
                                            $("#nombreContenedor").css("display", "inline");
                                            $("#complete").css("display", "inline");
                                            setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                            setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  });
            }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        });  
        
        $('img.botonCorreoComplete').on('click',function(event)//Al pulsar la imagen de Email, es Generada la siguiente Funcion:
        {    


            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="completa"]').filter(function(){return $(this).css('display') == "none" }).attr('id');
            var name = genNameFile(gridview);
            
            $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]=$(this).text(); //incluimos los ids de la columna en el array.
            });
            //alert(name);
            if(ids != ''){
            
                                $.ajax({ 
                                    type: "GET",   
                                    url: '/site/sendemail?ids='+ids+'&name='+name+"&table="+gridview,   
                                    async: false,
                                    beforeSend: function () {
                                            //window.open('/site/sendemail?ids='+ids+'&name=Balance%20Cabinas','_top');
//                                            $("#nombreContenedor").css("display", "inline");
//                                            $("#loading").css("display", "inline");
                                    },
                                    success:  function (response) {
                                            $("#complete").html("Correo Enviado con Exito... !!");
                                            $("#nombreContenedor").css("display", "inline");
                                            $("#complete").css("display", "inline");
                                            setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                            setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  });
            }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        }); 
        
        $('img.botonCorreoTotal').on('click',function(event)//Al pulsar la imagen de Email, es Generada la siguiente Funcion:
        {    


            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            
            $("#"+gridview+" td#fecha").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]= "'"+$(this).text()+"'"; //incluimos los ids de la columna en el array.
            });
            //alert(name);
            if(ids != ''){
            
                                $.ajax({ 
                                    type: "GET",   
                                    url: '/site/sendemail?ids='+ids+'&name='+name+"&table="+gridview,   
                                    async: false,
                                    beforeSend: function () {
                                            //window.open('/site/sendemail?ids='+ids+'&name=Balance%20Cabinas','_top');
//                                            $("#nombreContenedor").css("display", "inline");
//                                            $("#loading").css("display", "inline");
                                    },
                                    success:  function (response) {
                                            $("#complete").html("Correo Enviado con Exito... !!");
                                            $("#nombreContenedor").css("display", "inline");
                                            $("#complete").css("display", "inline");
                                            setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                            setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  });
            }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        }); 
        
        $('img.botonCorreoMatriz').on('click',function(event)//Al pulsar la imagen de Email, es Generada la siguiente Funcion:
        {    


            var gridview = $('table.matrizGastos').attr('id');
            var mes = $('div#fecha2').text();
            var cabina = $('div#cabina').text();
            var name = genNameFile(gridview);
            //alert(mes);
            
            if($('table#'+gridview).length){
            //Creamos la variable que contiene la tabla generada.
            var response = $.ajax({ type: "GET",   
                                    url: "/site/sendemail?name="+name+"&table="+gridview+"&mes="+mes+"&cabina="+cabina,  
                                    async: false,
                                    beforeSend: function () {
                                            //window.open('/site/sendemail?ids='+ids+'&name=Balance%20Cabinas','_top');
//                                            $("#nombreContenedor").css("display", "inline");
//                                            $("#loading").css("display", "inline");
                                    },
                                    success:  function (response) {
                                            $("#complete").html("Correo Enviado con Exito... !!");
                                            $("#nombreContenedor").css("display", "inline");
                                            $("#complete").css("display", "inline");
                                            setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                            setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  });
            }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        });  
        
    }

//--- FUNCION PARA IMPIRMIR.

    function genPrint()
    {
        $('img.printButton').on('click',function(event)//Al pulsar la imagen de Print, es Generada la siguiente Funcion:
        {    

            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]=$(this).text(); //incluimos los ids de la columna en el array.
            });
            //alert(ids);
            
            if(ids != ''){
                
            //Creamos la variable que contiene la tabla generada.
            var response = $.ajax({ type: "GET",   
                                    url: "/site/print?ids="+ids+"&table="+gridview,   
                                    async: false,
                                  }).responseText;
            //Creamos la variable que alberga la pagina con la tabla generada.
            var content = '<!DOCTYPE html><html><meta charset="es">'+
            '<head><link href="/css/print.css" media="all" rel="stylesheet" type="text/css"></head>'+
            '<body><h1 style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;">'+name+'</h1><br>'
            //Tabla con Formato
            +response+

            '<script type="text/javascript">function printPage() { window.focus(); window.print();return; }</script>'+
            '</body></html>';
    
//    
//            $.fancybox.open({
//		href : 'iframe.html',
//		type : 'iframe',
//		padding : 5
//				});
                        
            //Creamos un 'iframe' para simular la apertura de una pagina nueva sin recargar ni alterar la anterior.
            var newIframe = document.createElement('iframe');
            newIframe.width = '0';
            newIframe.height = '0';
            newIframe.src = 'about:blank';
            document.body.appendChild(newIframe);
            newIframe.contentWindow.contents = content;
            newIframe.src = 'javascript:window["contents"]';
            newIframe.focus();
            //setTimeout(function() {
            newIframe.contentWindow.printPage();
            //}, 10);
            return;
            }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        });  
        
        $('img.printButtonComplete').on('click',function(event)//Al pulsar la imagen de Print, es Generada la siguiente Funcion:
        {    
            
            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="completa"]').filter(function(){return $(this).css('display') == "none" }).attr('id');
            var name = genNameFile(gridview);
            $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]=$(this).text(); //incluimos los ids de la columna en el array.
            });
            //alert(ids);
            if(ids != ''){
            //Creamos la variable que contiene la tabla generada.
            var response = $.ajax({ type: "GET",   
                                    url: "/site/print?ids="+ids+"&table="+gridview,   
                                    async: false,
                                  }).responseText;
            //Creamos la variable que alberga la pagina con la tabla generada.
            var content = '<html lang="es"><meta charset="latin1">'+
            '<head><link href="/css/print.css" media="all" rel="stylesheet" type="text/css"></head>'+
            '<body><h1 style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;">'+name+'</h1><br>'
            //Tabla con Formato
            +response+

            '<script type="text/javascript">function printPage() { window.focus(); window.print();return; }</script>'+
            '</body></html>';
    
            //Creamos un 'iframe' para simular la apertura de una pagina nueva sin recargar ni alterar la anterior.
            var newIframe = document.createElement('iframe');
            newIframe.width = '0';
            newIframe.height = '0';
            newIframe.src = 'about:blank';
            document.body.appendChild(newIframe);
            newIframe.contentWindow.contents = content;
            newIframe.src = 'javascript:window["contents"]';
            newIframe.focus();
            //setTimeout(function() {
            newIframe.contentWindow.printPage();
            //}, 10);
            return;
            }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
            
        }); 
        
        $('img.printButtonTotal').on('click',function(event)//Al pulsar la imagen de Print, es Generada la siguiente Funcion:
        {    

            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            $("#"+gridview+" td#fecha").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]= "'"+$(this).text()+"'"; //incluimos los ids de la columna en el array.
            });
            //alert(ids);
            
            if(ids != ''){
            //Creamos la variable que contiene la tabla generada.
            var response = $.ajax({ type: "GET",   
                                    url: "/site/print?ids="+ids+"&table="+gridview,   
                                    async: false,
                                  }).responseText;
            //Creamos la variable que alberga la pagina con la tabla generada.
            var content = '<html lang="es"><meta charset="latin1">'+
            '<head><link href="/css/print.css" media="all" rel="stylesheet" type="text/css"></head>'+
            '<body><h1 style="font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;letter-spacing: -1px;text-transform: uppercase;">'+name+'</h1><br>'
            //Tabla con Formato
            +response+

            '<script type="text/javascript">function printPage() { window.focus(); window.print();return; }</script>'+
            '</body></html>';
    
            //Creamos un 'iframe' para simular la apertura de una pagina nueva sin recargar ni alterar la anterior.
            var newIframe = document.createElement('iframe');
            newIframe.width = '0';
            newIframe.height = '0';
            newIframe.src = 'about:blank';
            document.body.appendChild(newIframe);
            newIframe.contentWindow.contents = content;
            newIframe.src = 'javascript:window["contents"]';
            newIframe.focus();
            //setTimeout(function() {
            newIframe.contentWindow.printPage();
            //}, 10);
            return;
            }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        
        }); 
            
        $('img.printButtonMatriz').on('click',function(event)//Al pulsar la imagen de Print, es Generada la siguiente Funcion:
        {    

           
            var gridview = $('table.matrizGastos').attr('id');
            var mes = $('div#fecha2').text();
            var cabina = $('div#cabina').text();
            var name = genNameFile(gridview);
            //alert(name);
            
            
            //Creamos la variable que contiene la tabla generada.
            var response = $.ajax({ type: "GET",   
                                    url: "/site/print?table="+gridview+"&mes="+mes+"&name="+name+"&cabina="+cabina,   
                                    async: false,
                                  }).responseText;
            //Creamos la variable que alberga la pagina con la tabla generada.
            //alert(response);
            if($('table#'+gridview).length){
            var content = '<html lang="es"><meta charset="latin1">'+
            '<head><link href="/css/print.css" media="all" rel="stylesheet" type="text/css"></head>'+
            '<body>'
            //Tabla con Formato
            +response+

            '<script type="text/javascript">function printPage() { window.focus(); window.print();return; }</script>'+
            '</body></html>';
    
            //Creamos un 'iframe' para simular la apertura de una pagina nueva sin recargar ni alterar la anterior.
            var newIframe = document.createElement('iframe');
            newIframe.id = "plotFrame";
            newIframe.name = "displayData";
            newIframe.width = '0';
            newIframe.height = '0';
            newIframe.src = 'about:blank';
            document.body.appendChild(newIframe);
            newIframe.contentWindow.contents = content;
            newIframe.src = 'javascript:window["contents"]';
            newIframe.focus();
            setTimeout(function() {
            newIframe.contentWindow.printPage();
            }, 10);
            return;
            }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        }); 
    }


//---  OTRAS FUNCIONES.

    function genNameFile(gridview){
        
        var name = '';
        var fecha = new String($('#fecha').text());
        var cabina = $('div#cabina2').text();
        //alert(fecha);
        if(gridview=='balance-grid' || gridview=='balance-grid-oculta'){
            name = 'SINCA Administrar Balance de Cabinas';
        }
        if(gridview=='balanceLibroVentas' || gridview=='balanceLibroVentasOculta'){
            name = 'SINCA Reporte Libro de Ventas '+fecha;
        }
        if(gridview=='balanceReporteDepositos' || gridview=='balanceReporteDepositosOculta'){
            name = 'SINCA Reporte de Depositos Bancarios '+fecha;
        }
        if(gridview=='balanceReporteBrighstar' || gridview=='balanceReporteBrighstarOculta'){
            name = 'SINCA Reporte de Ventas Recargas Brighstar '+fecha;
        }
        if(gridview=='balanceReporteCaptura' || gridview=='balanceReporteCapturaOculta'){
            name = 'SINCA Reporte de Trafico Captura '+fecha;
        }
        if(gridview=='balanceCicloIngresosResumido' || gridview=='balanceCicloIngresosResumidoOculta'){
            name = 'SINCA Ciclo de Ingresos Resumido '+fecha;
        }
        if(gridview=='balanceCicloIngresosCompletoActivas' || gridview=='balanceCicloIngresosCompletoInactivas'){
            name = 'SINCA Ciclo de Ingresos Completo '+fecha;
        }
        if(gridview=='balanceCicloIngresosTotalResumido' || gridview=='balanceCicloIngresosTotalResumidoOculta'){
            name = 'SINCA Ciclo de Ingresos Total '+fecha;
        }
        if(gridview=='tabla'){
            name = 'SINCA Matriz de Gastos '+fecha;
        }
        if(gridview=='tabla2'){
            name = 'SINCA Matriz de Gastos Evolucion '+cabina+' '+fecha;
        }
        if(gridview=='estadogasto-grid'){
            name = 'SINCA Estado de Gastos '+fecha;
        }
        
        return name;   
    }

    function ValidateDate(){
        
     $( "#yw1" ).change(function(){
                            
           var fecha_entrada = $( "#yw0" ).val();
           var fecha_salida =   $( "#yw1" ).val();

           if(fecha_salida <= fecha_entrada && fecha_entrada!=''){
               $( "#yw1" ).val('');

               $("#yw1").css("background", "#FEE");
               $("#yw1").css("border-color", "#C00");
               $("#yw0").css("background", "#FEE");
               $("#yw0").css("border-color", "#C00");

               $("#Employee_employee_hours_end_em_").html("La Salida debe ser Mayor");
               $("#Employee_employee_hours_end_em_").css("display", "block");
           }else{

               $("#yw1").css("background", "#E6EFC2");
               $("#yw1").css("border-color", "#C6D880");
               $("#yw0").css("background", "#E6EFC2");
               $("#yw0").css("border-color", "#C6D880");

               $("#Employee_employee_hours_end_em_").html("");
               $("#Employee_employee_hours_end_em_").css("display", "none");
           }

    });

    $( "#yw0" ).change(function(){

           var fecha_entrada = $( "#yw0" ).val();
           var fecha_salida =   $( "#yw1" ).val();

           if(fecha_salida <= fecha_entrada && fecha_salida!=''){
               //$( "#yw0" ).val('');

               $("#yw1").css("background", "#FEE");
               $("#yw1").css("border-color", "#C00");
               $("#yw0").css("background", "#FEE");
               $("#yw0").css("border-color", "#C00");

               $("#Employee_employee_hours_start_em_").html("La Entrada debe ser Menor");
               $("#Employee_employee_hours_start_em_").css("display", "block");
           }else{

               $("#yw1").css("background", "#E6EFC2");
               $("#yw1").css("border-color", "#C6D880");
               $("#yw0").css("background", "#E6EFC2");
               $("#yw0").css("border-color", "#C6D880");

               $("#Employee_employee_hours_start_em_").html("");
               $("#Employee_employee_hours_start_em_").css("display", "none");
           }

    });
    }
    
    
    function selectGasto(){
        
        var dato = $("#Detallegasto_category").val();
        var seleccion = $("#Detallegasto_category option:selected").text();
        if(seleccion != 'Seleccionar...'){
            var response = $.ajax({ type: "GET",   
                                    url: '/Detallegasto/DynamicCategoria?category='+dato,   
                                    async: false,
                                    succes: alert,
                                  }).responseText;
            //alert(response);                   
            $("#Detallegasto_TIPOGASTO_Id").html(response);    
        }else{
            $("#Detallegasto_TIPOGASTO_Id").html('<option value="">Seleccionar Categoria</option>');  
            $("#DetalleGasto").slideUp("slow");
        }

    }
    

    function addKid() {
        
        $("[name=yt0]").on('click', function(){
         
            var clickID = parseInt($("#DatosHijos td#col div.row").length);
            var newID = (clickID+1);
            
            //alert(newID);
 
            var newInput = $("#DatosHijos td#col div#row1").clone();
            newInput.attr("id",'row'+newID);
            newInput.find('input').attr('name', 'Kids[age' +(newID-1)+']');
            newInput.find('label').text('Edad del Hijo #'+newID);
            newInput.find('input').attr('id', 'Kids_age' +(newID-1));
            newInput.find('img').attr('id', 'row'+newID);
            newInput.appendTo("#datosEmpleado tr#DatosHijos td#col");
            
            //alert(newInput);

        });

    }
    
    function deleteKid() {
        
        $("img.botonQuitar").on('click', function(){
         
            var parent = $(this).attr("id");
            alert(parent);
	    //$(parent).remove();
    
        });

    }
    
    //Asigna los Valores de la NOmina por Empleado Registrado
    function getListEmployee() {
        
        $("select#beneficiario2").css('display','none');
        //Capturar Seleccion de la Categoria
        $("#Detallegasto_category").change(function () {
            var selc_nomina = $("#Detallegasto_category option:selected").text();
            
            if(selc_nomina == 'NOMINA'){
                //Capturar Seleccion del Tipo de Gasto
                $("#Detallegasto_TIPOGASTO_Id").change(function () {
                var selc_tipo_gasto = $("#Detallegasto_TIPOGASTO_Id option:selected").text();
                
                    if(selc_tipo_gasto == 'Pago a Empleado'){
                        //Capturar Seleccion de la Cabina
                        $("#Detallegasto_CABINA_Id").change(function () {
                            
                        $("#Detallegasto_Monto").val('');     
                        $("#Detallegasto_moneda option[value='empty']").attr("selected", "selected");    
                        
                        var selc_cabina = $("#Detallegasto_CABINA_Id option:selected").val();
                        
                        var response = $.ajax({ type: "GET",   
                                    url: '/Nomina/DynamicEmployee?cabina='+selc_cabina,   
                                    async: false,
                                    succes: alert,
                                  }).responseText;
                        //alert(response);                   
                        $("#Detallegasto_beneficiario").val('');
                        $("#Detallegasto_beneficiario").css('display','none');
                        $("select#beneficiario2").css('display','inline');
                        $("select#beneficiario2").html(response);   
                            //Capturar Seleccion del Empleado
                            $("select#beneficiario2").change(function () {
                                var selc_empleado = $("select#beneficiario2 option:selected").val();
                                var selc_empleado_name = $("select#beneficiario2 option:selected").text();

                                  //Obtener el Salario del empleado Seleccionado
                                  var salary = $.ajax({ type: "GET",   
                                    url: '/Nomina/GetSalary?id='+selc_empleado,   
                                    async: false,
                                    succes: alert,
                                  }).responseText;
                                  
                                  //Obtener la Moneda del empleado Seleccionado
                                  var currency = $.ajax({ type: "GET",   
                                    url: '/Nomina/GetCurrency?id='+selc_empleado,   
                                    async: false,
                                    succes: alert,
                                  }).responseText;
                                  
                                  var cuenta = $.ajax({ type: "GET",   
                                    url: '/Detallegasto/DynamicCuentaEmployee?moneda='+currency,   
                                    async: false,
                                    succes: alert,
                                  }).responseText;

                                  //Solo Asignar Valores  Cuando se Selecciones a un Empleado
                                  if(selc_empleado!='empty'){
                                    $("#Detallegasto_Monto").val(salary);
                                    $("#Detallegasto_moneda option[value='"+currency+"']").attr("selected", "selected");
                                    $("#Detallegasto_CUENTA_Id").html(cuenta); 
                                    $("#Detallegasto_beneficiario").val(selc_empleado_name);
                                    
                                  }else{
                                    $("#Detallegasto_Monto").val('');  
                                    $("#Detallegasto_moneda option[value='empty']").attr("selected", "selected");
                                    $("#Detallegasto_CUENTA_Id option[value='empty']").attr("selected", "selected");
                                    $("#Detallegasto_CUENTA_Id").html('<option value="empty">Seleccionar Moneda</option>');
                                  }

                                  
                            });
                        
                        });
                    }
                
                
                });
            }else{
                $("#Detallegasto_Monto").val(''); 
                $("#beneficiario2").css('display','inline');
                $("select#beneficiario2").css('display','none');
                $("#Detallegasto_moneda option[value='empty']").attr("selected", "selected");
            }
            
            
    
        });

    }
    