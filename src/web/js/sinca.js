//--- ARCHIVO JAVASCRIPT PRINCIPAL DEL SISTEMA SINCA.
//--- ALBERGA LAS FUNCIONALIDADES DE CADA PANTALLA DEL MISMO.

//--- FUNCIONES ESTABLECIDAS PARA EL INICIO DEL DOCUMENTO (COLOCAR LAS FUNCIONES QUE SEAN CREADAS PARA LAS VISTAS).

$(document).ready(function()
{
    genExcel();
    genEmail();
    genPrint();
    newEC();
//    ValidateDate(1);
//    ValidateDate(2);
//    ValidateDate(3);
    manipulateKids();
    getListEmployee();
    setKids();
    removeImg();
    changeCheckbox(1);
    changeCheckbox(2);
    changeCheckbox(3);
    
    changeCheckboxCabinas(1);
    changeCheckboxCabinas(2);
    changeCheckboxLocutorio();
    changeStatus();
    canbioCuenta();
//    changeStatusNovedad();
    $("#Detallegasto_category").change(function () {
            selectGasto();
    });

    $(".info").animate({opacity: 1.0}, 3000).fadeOut("slow");
    
    gentotalsBalance();
    addFieldVenta();
    removeFieldVenta();
    
    //Verifica que Existe el Balance de la Fecha Seleccionada
    FechaBalance();
    
    $(this).ajaxComplete(function()
    {
        gentotalsBalance();

    });
    
});
    
    function FechaBalance()
    {
        verificarFechaBalance('Ventas','Detalleingreso_FechaMes');
        verificarFechaBalance('SaldoApertura','SaldoCabina_Fecha_Apertura');
        verificarFechaBalance('SaldoCierre','SaldoCabina_Fecha');
        verificarFechaBalance('Deposito','Deposito_FechaCorrespondiente');
        verificarFechaTraficoCaptura('TraficoCaptura','FechaTrafico');
    }

    function changeStatusNovedad()
    {
        
          $("select[id^='status_'].Estatus").each(function(){

            var id = '';
            var id_numero = '';
            var estatus = '';

            id = $(this).attr('id');
            estatus = $(this).val();
            id_numero = id.split("status_");

            if(estatus == '2'){
                $('textarea#Observaciones_'+id_numero[1]).attr('readonly', 'readonly');
                $('input#Destino_'+id_numero[1]).attr('readonly', 'readonly');
            }else{
                $('textarea#Observaciones_'+id_numero[1]).removeAttr('disabled');
                $('input#Destino_'+id_numero[1]).removeAttr('readonly');
            }

          });
            
        $("select[id^='status_'].Estatus").change(function(){

            var id = '';
            var id_numero = '';
            var estatus = '';

            id = $(this).attr('id');
            estatus = $(this).val();
            id_numero = id.split("status_");

            if(estatus == '2'){
                $('textarea#Observaciones_'+id_numero[1]).attr('readonly', 'readonly');
                $('input#Destino_'+id_numero[1]).attr('readonly', 'readonly');
            }else{
                $('textarea#Observaciones_'+id_numero[1]).removeAttr('readonly');
                $('input#Destino_'+id_numero[1]).removeAttr('readonly');
            }

         });
    }
    
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
                    
                    
        });
    }
    
    function gentotalsBalance(){
        
        var arrayCols = new Array('ServDirecTv','ServNextel','diferencialFullCarga','diferencialBrightstarMovistar',
                                  'diferencialBrightstarClaro','diferencialBrightstarDirecTv','diferencialBrightstarNextel',
                                  'diferencialCapturaSoles','diferencialCapturaDollar','acumulado','sobrante','sobranteAcum',
                                  'otrosServiciosFullCarga','traficoCapturaDollar','traficoCapturaSoles','diferencialCapturaSoles','diferencialCapturaDollar');
        var diferente=['No Declarado','No Declarado','0.00','0.00','0.00','&nbsp;','&nbsp;','0.00','0.00','0.00','0.00','&nbsp;','0.00','&nbsp;','0.00','&nbsp;','0.00','0.00','0.00','0.00','&nbsp;','0.00','&nbsp;','0.00','0.00','0.00','0.00',''];
        for(var i=0;i<arrayCols.length;i++){
            totalsBalance(arrayCols[i],diferente[i]);
        }
        
        
    }
    
    function totalsBalance(columna,diferente){
        var suma = 0;
        $('table.items tbody tr td#'+columna).filter(function(){ return $(this).html() != diferente }).each(function(){ 
            suma = suma + parseFloat($(this).html()) ; 
        });
        if(suma==0){
            $('div#totales table tr td#total'+columna).text('No Declarados');
        }else{
            $('div#totales tr td#total'+columna).text(suma.toFixed(2));
        }
        suma = 0;
    }


//--- FUNCION PARA CAPTURAR LOS IDs DEL GRIDVIEW Y LOS ENVIA A LA ActionExcel DEL CONTROLADOR 'SITE'.

    function genExcel()
    {
        $('img.botonExcelNew').on('click',function(event)//Al pulsar la imagen de Excel, es Generada la siguiente Funcion:
        {    

            //$("#loading").html("Generando Excel... !!");
            $("#loading").html("Generando Excel... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
             
            var fechas = new Array();//Creamos un Array como contenedor de los ids.
            var cabinas = new Array();
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            
            if($('div#id').length){
                fechas[0]=$('div#id').text();
                gridview = $('div[rel="total"] table').attr('id');
                name = genNameFile(gridview);
            }else{
                $("#"+gridview+" td#fecha").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                            fechas[index]=$(this).text(); //incluimos los ids de la columna en el array.
                });
                $("#"+gridview+" td#cabinas").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                            cabinas[index]=$(this).text(); //incluimos los ids de la columna en el array.
                });
            }
            
            //alert(cabinas);
            
            if(fechas != ''){
            var response = $.ajax({ type: "GET",   
                                    url: "/site/excel?fechas="+fechas+"&cabinas="+cabinas+"&table="+gridview+"&name="+name,   
                                    async: true,
                                    success:  function (response) {
                                            //Abrimos una Ventana (sin recargarla pagina) al controlador "Site", que a su ves llama a la funcion actionExcel().
                                             setTimeout("window.open('/site/excel?fechas="+fechas+"&cabinas="+cabinas+"&table="+gridview+"&name="+name+"','_top');",500);

                                             //Mostramos los Mensajes y despues de la Descarga se Ocultan Automaticamente.
                                             $("#complete").html("Archivo Excel Generado... !!");
                                             setTimeout('$("#complete").css("display", "inline");', 1000);
                                             setTimeout('$("#loading").css("display", "none");', 1000); 
                                             setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                             setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  }).responseText;

             

             
             }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#loading").css("display", "none");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }

        });
        
        $('img.botonExcel').on('click',function(event)//Al pulsar la imagen de Excel, es Generada la siguiente Funcion:
        {    

            //$("#loading").html("Generando Excel... !!");
            $("#loading").html("Generando Excel... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
             
            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            
            if($('div#id').length){
                ids[0]=$('div#id').text();
                gridview = $('div[rel="total"] table').attr('id');
                name = genNameFile(gridview);
            }else{
                $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                            ids[index]=$(this).text(); //incluimos los ids de la columna en el array.
                });
            }
            
            if(ids != ''){
            var response = $.ajax({ type: "GET",   
                                    url: '/site/excel?ids='+ids+'&name='+name+"&table="+gridview,   
                                    async: true,
                                    success:  function (response) {
                                            //Abrimos una Ventana (sin recargarla pagina) al controlador "Site", que a su ves llama a la funcion actionExcel().
                                             setTimeout("window.open('/site/excel?ids="+ids+"&name="+name+"&table="+gridview+"','_top');",500);

                                             //Mostramos los Mensajes y despues de la Descarga se Ocultan Automaticamente.
                                             $("#complete").html("Archivo Excel Generado... !!");
                                             setTimeout('$("#complete").css("display", "inline");', 1000);
                                             setTimeout('$("#loading").css("display", "none");', 1000); 
                                             setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                             setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  }).responseText;

             

             
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
            
            $("#loading").html("Generando Excel... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
             
            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile('balanceCicloIngresosCompleto');
            //alert(gridview);
            $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]=$(this).text(); //incluimos los ids de la columna en el array.
            });
            //alert(ids);
            if(ids != ''){
            var response = $.ajax({ type: "GET",   
                                    url: '/site/excel?ids='+ids+'&name='+name+'&table=balanceCicloIngresosCompleto',   
                                    async: true,
                                    success:  function (response) {
                                            //Abrimos una Ventana (sin recargarla pagina) al controlador "Site", que a su ves llama a la funcion actionExcel().
                                             setTimeout("window.open('/site/excel?ids="+ids+"&name="+name+"&table=balanceCicloIngresosCompleto','_top');",500);

                                             //Mostramos los Mensajes y despues de la Descarga se Ocultan Automaticamente.
                                             $("#complete").html("Archivo Excel Generado... !!");
                                             setTimeout('$("#complete").css("display", "inline");', 1000);
                                             setTimeout('$("#loading").css("display", "none");', 1000); 
                                             setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                             setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  }).responseText;

            }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#loading").css("display", "none");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        }); 
        
        $('img.botonExcelTotal').on('click',function(event)//Al pulsar la imagen de Excel, es Generada la siguiente Funcion:
        {    

            $("#loading").html("Generando Excel... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
             
            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            
            $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]="'"+$(this).text()+"'"; //incluimos los ids de la columna en el array.
            });
            if(ids != ''){
            var response = $.ajax({ type: "GET",   
                                    url: '/site/excel?ids='+ids+'&name='+name+"&table="+gridview,   
                                    async: true,
                                    success:  function (response) {
                                            //Abrimos una Ventana (sin recargarla pagina) al controlador "Site", que a su ves llama a la funcion actionExcel().
                                             setTimeout('window.open("/site/excel?ids='+ids+'&name='+name+'&table='+gridview+'","_top");',500);

                                             //Mostramos los Mensajes y despues de la Descarga se Ocultan Automaticamente.
                                             $("#complete").html("Archivo Excel Generado... !!");
                                             setTimeout('$("#complete").css("display", "inline");', 1000);
                                             setTimeout('$("#loading").css("display", "none");', 1000); 
                                             setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                             setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  }).responseText;

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

            $("#loading").html("Generando Excel... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
             
            var gridview = $('table.matrizGastos').attr('id');
            var mes = $('div#fecha2').text();
            var cabina = $('div#cabina').text();
            var name = genNameFile(gridview);
            
            //alert(mes);
            
            if($('table#'+gridview).length){
            var response = $.ajax({ type: "GET",   
                                    url: '/site/excel?name='+name+"&table="+gridview+"&mes="+mes+"&cabina="+cabina,    
                                    async: true,
                                    success:  function (response) {
                                            //Abrimos una Ventana (sin recargarla pagina) al controlador "Site", que a su ves llama a la funcion actionExcel().
                                             setTimeout("window.open('/site/excel?name="+name+"&table="+gridview+"&mes="+mes+"&cabina="+cabina+"','_top');",500);

                                             //Mostramos los Mensajes y despues de la Descarga se Ocultan Automaticamente.
                                             $("#complete").html("Archivo Excel Generado... !!");
                                             setTimeout('$("#complete").css("display", "inline");', 1000);
                                             setTimeout('$("#loading").css("display", "none");', 1000); 
                                             setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                             setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  }).responseText;

             }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#loading").css("display", "none");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }

        });
        
        $('img.botonExcelPanel').on('click',function(event)//Al pulsar la imagen de Excel, es Generada la siguiente Funcion:
        {    

            $("#loading").html("Generando Excel... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
             
            var gridview = 'tabla3';
            var date = $('div#fecha2').text();
            var name = genNameFile(gridview);

            //Creamos la variable que contiene la tabla generada.
            if($('table#'+gridview).length){
            var response = $.ajax({ type: "GET",   
                                    url: "/site/excel?table="+gridview+'&date='+date+'&name='+name,    
                                    async: true,
                                    success:  function (response) {
                                            //Abrimos una Ventana (sin recargarla pagina) al controlador "Site", que a su ves llama a la funcion actionExcel().
                                             setTimeout("window.open('/site/excel?table="+gridview+'&date='+date+'&name='+name+"','_top');",500);

                                             //Mostramos los Mensajes y despues de la Descarga se Ocultan Automaticamente.
                                             $("#complete").html("Archivo Excel Generado... !!");
                                             setTimeout('$("#complete").css("display", "inline");', 1000);
                                             setTimeout('$("#loading").css("display", "none");', 1000); 
                                             setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                             setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  }).responseText;

             //alert(response);
             

             }else{
                        $("#error").html("No Existen Datos... !!");
                        $("#loading").css("display", "none");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }

        });
        $('img.botonExcelConsolidado').on('click',function(event)//Al pulsar la imagen de Excel, es Generada la siguiente Funcion:
        {    

            $("#loading").html("Generando Excel... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
             
             
            var gridview = '';
            
            if($(this).attr('id') == 'ExcelCompleto')
                gridview = 'reporteConsolidado';
            else
                gridview = 'reporteConsolidadoResumido';
            
            var name = genNameFile(gridview);
            var mes = $('div#fecha2').text();
            //Creamos la variable que contiene la tabla generada.
            if($('div#fecha2').length){
            var response = $.ajax({ type: "GET",   
                                    url: "/site/excel?name="+name+"&table="+gridview+"&mes="+mes,    
                                    async: true,
                                    success:  function (response) {
                                            //Abrimos una Ventana (sin recargarla pagina) al controlador "Site", que a su ves llama a la funcion actionExcel().
                                             setTimeout("window.open('/site/excel?name="+name+"&table="+gridview+"&mes="+mes+"','_top');",0);

                                             //Mostramos los Mensajes y despues de la Descarga se Ocultan Automaticamente.
                                             $("#complete").html("Archivo Excel Generado... !!");
                                             setTimeout('$("#complete").css("display", "inline");', 1000);
                                             setTimeout('$("#loading").css("display", "none");', 1000); 
                                             setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                             setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  }).responseText;

             //alert(response);
             

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
        $('img.botonCorreoNew').on('click',function(event)//Al pulsar la imagen de Email, es Generada la siguiente Funcion:
        {    
//
            $("#loading").html("Enviando Correo... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
//            
            var fechas = new Array();//Creamos un Array como contenedor de los ids.
            var cabinas = new Array();
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            
            if($('div#id').length){
                fechas[0]=$('div#id').text();
                gridview = $('div[rel="total"] table').attr('id');
                name = genNameFile(gridview);
            }else{
                $("#"+gridview+" td#fecha").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                            fechas[index]=$(this).text(); //incluimos los ids de la columna en el array.
                });
                $("#"+gridview+" td#cabinas").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                            cabinas[index]=$(this).text(); //incluimos los ids de la columna en el array.
                });
            }
            
            //alert(cabinas);
            
            if(fechas != ''){

                                $.ajax({ 
                                    type: "GET",   
                                    url: "/site/sendemail?fechas="+fechas+"&cabinas="+cabinas+"&table="+gridview+"&name="+name,   
                                    async: true,
                                    beforeSend: function () {
                                            //window.open('/site/sendemail?ids='+ids+'&name=Balance%20Cabinas','_top');
//                                            $("#nombreContenedor").css("display", "inline");
//                                            $("#loading").css("display", "inline");
                                    },
                                    success:  function (response) {
                                            $("#nombreContenedor").css("display", "NONE");
                                            $("#loading").css("display", "NONE");
                                            $("#complete").html("Correo Enviado con Exito... !!");
                                            $("#nombreContenedor").css("display", "inline");
                                            $("#complete").css("display", "inline");
                                            setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                            setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  });
            }else{
                        $("#nombreContenedor").css("display", "NONE");
                        $("#loading").css("display", "NONE");
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        }); 
        
        $('img.botonCorreo').on('click',function(event)//Al pulsar la imagen de Email, es Generada la siguiente Funcion:
        {    
//
            $("#loading").html("Enviando Correo... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
//            
            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            
            if($('div#id').length){
                ids[0]=$('div#id').text();
                gridview = $('div[rel="total"] table').attr('id');
                name = genNameFile(gridview);
            }else{
                $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                            ids[index]=$(this).text(); //incluimos los ids de la columna en el array.
                });
            }
//            alert(ids);
            if(ids != ''){

                                $.ajax({ 
                                    type: "GET",   
                                    url: '/site/sendemail?ids='+ids+'&name='+name+"&table="+gridview,   
                                    async: true,
                                    beforeSend: function () {
                                            //window.open('/site/sendemail?ids='+ids+'&name=Balance%20Cabinas','_top');
//                                            $("#nombreContenedor").css("display", "inline");
//                                            $("#loading").css("display", "inline");
                                    },
                                    success:  function (response) {
                                            $("#nombreContenedor").css("display", "NONE");
                                            $("#loading").css("display", "NONE");
                                            $("#complete").html("Correo Enviado con Exito... !!");
                                            $("#nombreContenedor").css("display", "inline");
                                            $("#complete").css("display", "inline");
                                            setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                            setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  });
            }else{
                        $("#nombreContenedor").css("display", "NONE");
                        $("#loading").css("display", "NONE");
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        });  
        
        $('img.botonCorreoComplete').on('click',function(event)//Al pulsar la imagen de Email, es Generada la siguiente Funcion:
        {    

            $("#loading").html("Enviando Correo... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
            
            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile('balanceCicloIngresosCompleto');
            
            $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]=$(this).text(); //incluimos los ids de la columna en el array.
            });
            //alert(name);
            if(ids != ''){
            
                                $.ajax({ 
                                    type: "GET",   
                                    url: '/site/sendemail?ids='+ids+'&name='+name+"&table=balanceCicloIngresosCompleto",   
                                    async: true,
                                    beforeSend: function () {
                                            //window.open('/site/sendemail?ids='+ids+'&name=Balance%20Cabinas','_top');
//                                            $("#nombreContenedor").css("display", "inline");
//                                            $("#loading").css("display", "inline");
                                    },
                                    success:  function (response) {
                                            $("#nombreContenedor").css("display", "NONE");
                                            $("#loading").css("display", "NONE");
                                            $("#complete").html("Correo Enviado con Exito... !!");
                                            $("#nombreContenedor").css("display", "inline");
                                            $("#complete").css("display", "inline");
                                            setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                            setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  });
            }else{
                        $("#nombreContenedor").css("display", "NONE");
                        $("#loading").css("display", "NONE");
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        }); 
        
        $('img.botonCorreoTotal').on('click',function(event)//Al pulsar la imagen de Email, es Generada la siguiente Funcion:
        {    

            $("#loading").html("Enviando Correo... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
            
            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            
            $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]= "'"+$(this).text()+"'"; //incluimos los ids de la columna en el array.
            });
            //alert(name);
            if(ids != ''){
            
                                $.ajax({ 
                                    type: "GET",   
                                    url: '/site/sendemail?ids='+ids+'&name='+name+"&table="+gridview,   
                                    async: true,
                                    beforeSend: function () {
                                            //window.open('/site/sendemail?ids='+ids+'&name=Balance%20Cabinas','_top');
//                                            $("#nombreContenedor").css("display", "inline");
//                                            $("#loading").css("display", "inline");
                                    },
                                    success:  function (response) {
                                            $("#nombreContenedor").css("display", "NONE");
                                            $("#loading").css("display", "NONE");
                                            $("#complete").html("Correo Enviado con Exito... !!");
                                            $("#nombreContenedor").css("display", "inline");
                                            $("#complete").css("display", "inline");
                                            setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                            setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  });
            }else{
                        $("#nombreContenedor").css("display", "NONE");
                        $("#loading").css("display", "NONE");
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        }); 
        
        $('img.botonCorreoMatriz').on('click',function(event)//Al pulsar la imagen de Email, es Generada la siguiente Funcion:
        {    

            $("#loading").html("Enviando Correo... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
            
            var gridview = $('table.matrizGastos').attr('id');
            var mes = $('div#fecha2').text();
            var cabina = $('div#cabina').text();
            var name = genNameFile(gridview);
            //alert(mes);
            
            if($('table#'+gridview).length){
            //Creamos la variable que contiene la tabla generada.
            var response = $.ajax({ type: "GET",   
                                    url: "/site/sendemail?name="+name+"&table="+gridview+"&mes="+mes+"&cabina="+cabina,  
                                    async: true,
                                    beforeSend: function () {
                                            //window.open('/site/sendemail?ids='+ids+'&name=Balance%20Cabinas','_top');
//                                            $("#nombreContenedor").css("display", "inline");
//                                            $("#loading").css("display", "inline");
                                    },
                                    success:  function (response) {
                                            $("#nombreContenedor").css("display", "NONE");
                                            $("#loading").css("display", "NONE");
                                            $("#complete").html("Correo Enviado con Exito... !!");
                                            $("#nombreContenedor").css("display", "inline");
                                            $("#complete").css("display", "inline");
                                            setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                            setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  });
            }else{
                        $("#nombreContenedor").css("display", "NONE");
                        $("#loading").css("display", "NONE");
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        });  
        
        $('img.botonCorreoPanel').on('click',function(event)//Al pulsar la imagen de Email, es Generada la siguiente Funcion:
        {    

            $("#loading").html("Enviando Correo... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
            
            var gridview = 'tabla3';
            var date = $('div#fecha2').text();
            var name = genNameFile(gridview);
            //alert(mes);
            
            if($('table#'+gridview).length){
            //Creamos la variable que contiene la tabla generada.
                    $.ajax({ type: "GET",   
                                    url: "/site/sendemail?table="+gridview+'&date='+date+'&name='+name,     
                                    async: true,
                                    beforeSend: function () {
                                            //window.open('/site/sendemail?ids='+ids+'&name=Balance%20Cabinas','_top');
//                                            $("#nombreContenedor").css("display", "inline");
//                                            $("#loading").css("display", "inline");
                                    },
                                    success:  function (response) {
                                            $("#nombreContenedor").css("display", "NONE");
                                            $("#loading").css("display", "NONE");
                                            $("#complete").html("Correo Enviado con Exito... !!");
                                            $("#nombreContenedor").css("display", "inline");
                                            $("#complete").css("display", "inline");
                                            setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                            setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  });
            }else{
                        $("#nombreContenedor").css("display", "NONE");
                        $("#loading").css("display", "NONE");
                        $("#error").html("No Existen Datos... !!");
                        $("#nombreContenedor").css("display", "inline");
                        $("#error").css("display", "inline");
                        setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                        setTimeout('$("#error").animate({ opacity: "hide" }, "slow");', 1800);
            }
        });
        
        $('img.botonCorreoConsolidado').on('click',function(event)//Al pulsar la imagen de Email, es Generada la siguiente Funcion:
        {    

            $("#loading").html("Enviando Correo... !!<div id='gif_loading'>"+
            "<div id='spinningSquaresG_1' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_2' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_3' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_4' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_5' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_6' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_7' class='spinningSquaresG'>"+
                "</div>"+
                "<div id='spinningSquaresG_8' class='spinningSquaresG'>"+
                "</div>"+
            "</div>");
            $("#nombreContenedor").css("display", "inline");
            $("#loading").css("display", "inline");
            
            var gridview = '';
            
            if($(this).attr('id') == 'CorreoCompleto')
                gridview = 'reporteConsolidado';
            else
                gridview = 'reporteConsolidadoResumido';
            
            var date = $('div#fecha2').text();
            var name = genNameFile(gridview);
            //alert(mes);
            
            if($('div#fecha2').length){
            //Creamos la variable que contiene la tabla generada.
                    $.ajax({ type: "GET",   
                                    url: "/site/sendemail?table="+gridview+'&date='+date+'&name='+name,     
                                    async: true,
                                    beforeSend: function () {
                                            //setTimeout("window.open('/site/sendemail?name="+name+"&table="+gridview+"&mes="+date+"','_top');",0);
//                                            $("#nombreContenedor").css("display", "inline");
//                                            $("#loading").css("display", "inline");
                                    },
                                    success:  function (response) {
                                            $("#nombreContenedor").css("display", "NONE");
                                            $("#loading").css("display", "NONE");
                                            $("#complete").html("Correo Enviado con Exito... !!");
                                            $("#nombreContenedor").css("display", "inline");
                                            $("#complete").css("display", "inline");
                                            setTimeout('$("#nombreContenedor").animate({ opacity: "hide" }, "slow");', 1800);
                                            setTimeout('$("#complete").animate({ opacity: "hide" }, "slow");', 1800);
                                    }
                                  });
            }else{
                        $("#nombreContenedor").css("display", "NONE");
                        $("#loading").css("display", "NONE");
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
        
        $(document).on("click",".printButtonNew",function(){
            
            var fechas = new Array();//Creamos un Array como contenedor de los ids.
            var cabinas = new Array();
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            
            if($('div#id').length){
                ids[0]=$('div#id').text();
                gridview = $('div[rel="total"] table').attr('id');
                name = genNameFile(gridview);
            }else{
                $("#"+gridview+" td#fecha").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                            fechas[index]=$(this).text(); //incluimos los ids de la columna en el array.
                });
                $("#"+gridview+" td#cabinas").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                            cabinas[index]=$(this).text(); //incluimos los ids de la columna en el array.
                });
            }
            
            //alert(cabinas);
            
            if(fechas != ''){
                
            //Creamos la variable que contiene la tabla generada.
            var response = $.ajax({ type: "GET",   
                                    url: "/site/print?fechas="+fechas+"&cabinas="+cabinas+"&table="+gridview+"&name="+name,   
                                    async: false,
                                  }).responseText;
            //Creamos la variable que alberga la pagina con la tabla generada.
            var content = '<!DOCTYPE html><html><meta charset="es">'+
            '<head><link href="/css/print.css" media="all" rel="stylesheet" type="text/css"></head>'+
            '<body>'
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
        
        $(document).on("click",".printButton",function(){
            
            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            
            if($('div#id').length){
                ids[0]=$('div#id').text();
                gridview = $('div[rel="total"] table').attr('id');
                name = genNameFile(gridview);
            }else{
                $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                            ids[index]=$(this).text(); //incluimos los ids de la columna en el array.
                });
            }
            
            //alert(cabinas);
            
            if(ids != ''){
                
            //Creamos la variable que contiene la tabla generada.
            var response = $.ajax({ type: "GET",   
                                    url: "/site/print?ids="+ids+"&table="+gridview+"&name="+name,   
                                    async: false,
                                  }).responseText;
            //Creamos la variable que alberga la pagina con la tabla generada.
            var content = '<!DOCTYPE html><html><meta charset="es">'+
            '<head><link href="/css/print.css" media="all" rel="stylesheet" type="text/css"></head>'+
            '<body>'
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
        
        $(document).on("click",".printButtonComplete",function(){
            
            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile('balanceCicloIngresosCompleto');
            $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]=$(this).text(); //incluimos los ids de la columna en el array.
            });
            //alert(ids);
            if(ids != ''){
            //Creamos la variable que contiene la tabla generada.
            var response = $.ajax({ type: "GET",   
                                    url: "/site/print?ids="+ids+"&table=balanceCicloIngresosCompleto&name="+name,   
                                    async: false,
                                  }).responseText;
            //Creamos la variable que alberga la pagina con la tabla generada.
            var content = '<html lang="es"><meta charset="latin1">'+
            '<head><link href="/css/print.css" media="all" rel="stylesheet" type="text/css"></head>'+
            '<body>'
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
        
        $(document).on("click",".printButtonTotal",function(){

            var ids = new Array();//Creamos un Array como contenedor de los ids.
            var gridview = $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
            var name = genNameFile(gridview);
            $("#"+gridview+" td#ids").each(function(index){ //Con esta funcion de jquery recorremis la columna (oculta) de los ids.
                        ids[index]= "'"+$(this).text()+"'"; //incluimos los ids de la columna en el array.
            });
            console.log(ids);
            
            if(ids != ''){
            //Creamos la variable que contiene la tabla generada.
            var response = $.ajax({ type: "GET",   
                                    url: "/site/print?ids="+ids+"&table="+gridview+"&name="+name,   
                                    async: false,
                                  }).responseText;
            //Creamos la variable que alberga la pagina con la tabla generada.
            var content = '<html lang="es"><meta charset="latin1">'+
            '<head><link href="/css/print.css" media="all" rel="stylesheet" type="text/css"></head>'+
            '<body>'
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
        
        $(document).on("click",".printButtonMatriz",function(){

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
        
        $(document).on("click",".printButtonPanel",function(){

            var gridview = 'tabla3';
            var date = $('div#fecha2').text();
            var name = genNameFile(gridview);
            //Creamos la variable que contiene la tabla generada.
            var response = $.ajax({ type: "GET",   
                                    url: "/site/print?table="+gridview+'&date='+date+'&name='+name,   
                                    async: false,
                                  }).responseText;
            //Creamos la variable que alberga la pagina con la tabla generada.
            var content = '<!DOCTYPE html><html><meta charset="es">'+
            '<head><link href="/css/print.css" media="all" rel="stylesheet" type="text/css"></head>'+
            '<body>'
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

        }); 
    }


//---  OTRAS FUNCIONES.

    function genNameFile(gridview){
        
        var name = '';
        var fecha_format = new String($('#fecha').text());
        if(fecha_format == '')
            var fecha = '';
        else
            var fecha = new String(' '+$('#fecha').text());
        
        var cabina_format = $('div#cabina2').text();
        if(cabina_format == '')
            var cabina = '';
        else
            var cabina = new String(' '+$('div#cabina2').text());
        //alert(fecha);
        if(gridview=='balance-grid' || gridview=='balance-grid-oculta'){
            name = 'SINCA Administrar Balance de Cabinas';
        }
        if(gridview=='balanceLibroVentas' || gridview=='balanceLibroVentasOculta'){
            name = 'SINCA Reporte Libro de Ventas'+cabina+' '+fecha;
        }
        if(gridview=='balanceReporteDepositos' || gridview=='balanceReporteDepositosOculta'){
            name = 'SINCA Reporte de Depositos Bancarios'+cabina+' '+fecha;
        }
        if(gridview=='balanceReporteBrighstar' || gridview=='balanceReporteBrighstarOculta'){
            name = 'SINCA Reporte de Ventas Recargas Brighstar'+cabina+' '+fecha;
        }
        if(gridview=='balanceReporteCaptura' || gridview=='balanceReporteCapturaOculta'){
            name = 'SINCA Reporte de Trafico Captura'+cabina+' '+fecha;
        }
        if(gridview=='balanceCicloIngresosResumido' || gridview=='balanceCicloIngresosResumidoOculta'){
            name = 'SINCA Ciclo de Ingresos Resumido'+cabina+' '+fecha;
        }
        if(gridview=='balanceCicloIngresosCompleto'){
            name = 'SINCA Ciclo de Ingresos Completo'+cabina+' '+fecha;
        }
        if(gridview=='balanceCicloIngresosTotalResumido' || gridview=='balanceCicloIngresosTotalResumidoOculta'){
            name = 'SINCA Ciclo de Ingresos Total'+fecha;
        }
        if(gridview=='tabla'){
            name = 'SINCA Matriz de Gastos'+fecha;
        }
        if(gridview=='tabla2'){
            name = 'SINCA Matriz de Gastos Evolucion'+cabina+' '+fecha;
        }
        if(gridview=='tablaIngresos'){
            name = 'SINCA Matriz de Ingresos'+fecha;
        }
        if(gridview=='tabla3'){
            name = 'SINCA Tablero de Control de Actividades'+fecha;
        }
        if(gridview=='estadogasto-grid'){
            name = 'SINCA Estado de Gastos'+cabina+' '+fecha;
        }
        if(gridview=='detalleingreso-grid'){
            name = 'SINCA Administrar Ingresos'+cabina+' '+fecha;
        }
        if(gridview=='novedad-grid'){
            name = 'SINCA Administrar Novedades y Fallas';
        }
        if(gridview=='log-grid'){
            name = 'SINCA Administrar Logs';
        }
        if(gridview=='employee-grid'){
            name = 'SINCA Administrar Empleados';
        }
        if(gridview=='reportePaBrightstar'){
            name = 'SINCA Reporte P.A. Brighstar';
        }
        if(gridview=='tablaNomina'){
            name = 'SINCA Matriz de Nomina'+fecha;
        }
        if(gridview=='cabina-grid'){
            name = 'SINCA Horarios Cabinas';
        }
        if(gridview=='banco-grid'){
            name = 'SINCA Administrar Bancos'+cabina+' '+fecha;
        }
        if(gridview=='DetailretesoMov'){
            name = 'SINCA Reteso Movimientos'+cabina+' '+fecha;
        }
        if(gridview=='estadonovedad-grid'){
            name = 'SINCA Estado de Fallas'+cabina+' '+fecha;
        }
        if(gridview=='tablaNovedadSemana'){
            name = 'SINCA Matriz Total de TTs por Cabina'+fecha;
        }
        if(gridview=='tablaNovedad'){
            name = 'SINCA Matriz General de Fallas'+fecha;
        }
        if(gridview=='reporteConsolidado'){
            name = 'SINCA Reporte Consolidado de Fallas'+fecha;
        }
        if(gridview=='reporteConsolidadoResumido'){
            name = 'SINCA Reporte Consolidado Resumido de Fallas'+fecha;
        }

        return name;   
    }

    function ValidateDate(day){ 
        
     $('#EmployeeHours_end_time_'+day).change(function(){
                            
           var fecha_entrada = $('#EmployeeHours_start_time_'+day).val();
           var fecha_salida =   $('#EmployeeHours_end_time_'+day).val();

           if(fecha_salida <= fecha_entrada && fecha_entrada!=''){
               //$( "#"+salida ).val('');

               $('#EmployeeHours_end_time_'+day).css("background", "#FEE");
               $('#EmployeeHours_end_time_'+day).css("border-color", "#C00");
               $('#EmployeeHours_start_time_'+day).css("background", "#FEE");
               $('#EmployeeHours_start_time_'+day).css("border-color", "#C00");

               $("#EmployeeHours_hours_end_"+day+"_em_").html("La Salida debe ser Mayor");
               $("#EmployeeHours_hours_end_"+day+"_em_").css("display", "block");
           }else{

               $('#EmployeeHours_end_time_'+day).css("background", "#E6EFC2");
               $('#EmployeeHours_end_time_'+day).css("border-color", "#C6D880");
               $('#EmployeeHours_start_time_'+day).css("background", "#E6EFC2");
               $('#EmployeeHours_start_time_'+day).css("border-color", "#C6D880");

               $("#EmployeeHours_hours_end_"+day+"_em_").html("");
               $("#EmployeeHours_hours_end_"+day+"_em_").css("display", "none");
           }

    });

    $( '#EmployeeHours_start_time_'+day ).change(function(){

           var fecha_entrada = $( '#EmployeeHours_start_time_'+day ).val();
           var fecha_salida =   $('#EmployeeHours_end_time_'+day).val();

           if(fecha_salida <= fecha_entrada && fecha_salida!=''){
               //$( "#yw0" ).val('');

               $('#EmployeeHours_end_time_'+day).css("background", "#FEE");
               $('#EmployeeHours_end_time_'+day).css("border-color", "#C00");
               $('#EmployeeHours_start_time_'+day).css("background", "#FEE");
               $('#EmployeeHours_start_time_'+day).css("border-color", "#C00");

               $("#EmployeeHours_hours_start_"+day+"_em_").html("La Entrada debe ser Menor");
               $("#EmployeeHours_hours_start_"+day+"_em_").css("display", "block");
           }else{

               $('#EmployeeHours_end_time_'+day).css("background", "#E6EFC2");
               $('#EmployeeHours_end_time_'+day).css("border-color", "#C6D880");
               $('#EmployeeHours_start_time_'+day).css("background", "#E6EFC2");
               $('#EmployeeHours_start_time_'+day).css("border-color", "#C6D880");

               $("#EmployeeHours_hours_start_"+day+"_em_").html("");
               $("#EmployeeHours_hours_start_"+day+"_em_").css("display", "none");
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
    
    function manipulateKids(){
        $(document).on("click",".botonAdd",function(){
            
            addKid();

        });
 	// Evento que selecciona la fila y la elimina 
	$(document).on("click",".botonQuitar",function(){
            var parent = $(this).attr("id");

            $('div#'+parent).remove();

            $("#DatosHijos td#col div#row"+(parent.substring(3,4)-1)+" img.botonQuitar").css('display', 'inline');
            $("#DatosHijos td#col div#row"+(parent.substring(3,4)-1)+" img.botonAdd").css('display', 'inline');

            if(parent.substring(3,4) == 2){
                $("#DatosHijos td#col div#row"+(parent.substring(3,4)-1)+" img.botonQuitar").css('display', 'none');
            }else{
                $("#DatosHijos td#col div#row"+(parent.substring(3,4)-1)+" img.botonQuitar").css('display', 'inline');
            }
	});
    }
    
    function addKid() {

            var clickID = parseInt($("#DatosHijos td#col div.row").length);
            var newID = (clickID+1);
            var newInput = $("#DatosHijos td#col div#row"+clickID).clone();
            newInput.attr("id",'row'+newID);
            //newInput.find('input').attr('id','age'+newID);
            newInput.find('input').attr('name', 'Kids[age' +newID+']');
            newInput.find('input').val('');
            newInput.find('label').text('Edad del Hijo #'+newID);
            newInput.find('input').attr('id', 'age'+newID);
            newInput.find('img.botonQuitar').attr('id', 'row'+newID);
            newInput.find('img.botonQuitar').css('display', 'inline');
            newInput.find('img.botonAdd').attr('id', 'row'+newID);
            if(clickID > 1){
              $("#DatosHijos td#col div#row"+(newID)+" img.botonQuitar").css('display', 'inline');
              $("#DatosHijos td#col div#row"+(newID)+" img.botonAdd").css('display', 'inline');
              
              $("#DatosHijos td#col div#row"+(clickID)+" img.botonQuitar").css('display', 'none');
              $("#DatosHijos td#col div#row"+(clickID)+" img.botonAdd").css('display', 'none');
            }else{
              $("#DatosHijos td#col div#row"+(clickID)+" img.botonQuitar").css('display', 'none');
              $("#DatosHijos td#col div#row"+(clickID)+" img.botonAdd").css('display', 'none');  
            }
            newInput.find('img.botonAdd').css('display', 'inline');
            newInput.appendTo("tr#DatosHijos td#col"); 

    }
    
    function removeImg() {

            var clickID = parseInt($("#DatosHijos td#col div.row").length);
            var newID = (clickID+1);

            if(clickID > 1){
              //$("#DatosHijos td#col div#row1 img.botonQuitar").css('display', 'none');  
              $("#DatosHijos td#col div#row"+(newID-1)+" img.botonQuitar").css('display', 'inline');
              $("#DatosHijos td#col div#row"+(newID-1)+" img.botonAdd").css('display', 'inline');
              
              $("#DatosHijos td#col div#row"+(clickID-1)+" img.botonQuitar").css('display', 'none');
              $("#DatosHijos td#col div#row"+(clickID-1)+" img.botonAdd").css('display', 'none');
            }else{
              $("#DatosHijos td#col div#row"+(clickID)+" img.botonQuitar").css('display', 'none');
              $("#DatosHijos td#col div#row"+(clickID)+" img.botonAdd").css('display', 'inline');  
            }
           

    }
    
    
    //Asigna los Valores de la NOmina por Empleado Registrado
    function getListEmployee() {
        
        $("#Detallegasto_category").change(function () {
              resetField(false);
        });
        
        $("select#beneficiario2").css('display','none');
        //Capturar Seleccion de la Categoria

                //Capturar Seleccion del Tipo de Gasto
                $("#Detallegasto_TIPOGASTO_Id").change(function () {
                var selc_categoria = $("#Detallegasto_category option:selected").text();
                var selc_tipo_gasto = $("#Detallegasto_TIPOGASTO_Id option:selected").text();
                
                resetField(false);
                
                    if(selc_categoria == 'NOMINA' && (selc_tipo_gasto != 'Seleccione uno')){
                        //Capturar Seleccion de la Cabina
                        $("#Detallegasto_CABINA_Id").change(function () {
                        var selc_categoria = $("#Detallegasto_category option:selected").text();
                        var selc_cabina = $("#Detallegasto_CABINA_Id option:selected").text();
                        var selc_tipo_gasto = $("#Detallegasto_TIPOGASTO_Id option:selected").text();
                        var id_tipo_gasto = $("#Detallegasto_TIPOGASTO_Id option:selected").val();
                        
                        if(selc_cabina != 'Seleccionar..' && selc_categoria == 'NOMINA' && (selc_tipo_gasto != 'Seleccione uno')){     
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
                                  
                                  var gastoAnterior = $.ajax({ type: "GET",   
                                    url: '/Detallegasto/DynamicGastoAnteriorNomina?idGasto='+id_tipo_gasto+'&idCabina='+selc_cabina+'&beneficiario='+selc_empleado_name,   
                                    async: false,
                                    succes: alert,
                                  }).responseText;

                                  //Solo Asignar Valores  Cuando se Selecciones a un Empleado
                                  if(selc_empleado!='empty'){
                                    $("#Detallegasto_Monto").val(salary);
                                    $("#Detallegasto_moneda option[value='"+currency+"']").attr("selected", "selected");
                                    $("#Detallegasto_CUENTA_Id").html(cuenta); 
                                    $("#GastoMesAnterior").html(gastoAnterior); 
                                    $("#Detallegasto_beneficiario").val(selc_empleado_name);
                                    
                                  }else{
                                    resetField(true);
                                  }

                                  
                            });
                        }else{
                            $("#Detallegasto_beneficiario").css('display','inline');
                            $("select#beneficiario2").css('display','none');
                        }
                        
                        });
                    }else{
                        resetField(false);
                        
                    }
                
                
                });

            
            
    
   

    }
    
    function enableHoursCabinas(day){
        
        var checkbox = $('#Cabina_day_'+day).attr('checked');
        if(day == 1){
            if(checkbox != 'checked'){
                $('#Cabina_HoraIni').prop('disabled', true);
                $('#Cabina_HoraFin').prop('disabled', true);        
            }else{
                $('#Cabina_HoraIni').prop('disabled', false);
                $('#Cabina_HoraFin').prop('disabled', false); 
            }
        }else{
            if(checkbox != 'checked'){
                $('#Cabina_HoraIniDom').prop('disabled', true);
                $('#Cabina_HoraFinDom').prop('disabled', true);        
            }else{
                $('#Cabina_HoraIniDom').prop('disabled', false);
                $('#Cabina_HoraFinDom').prop('disabled', false); 
            }
        }
        
    }
    
    function changeCheckboxCabinas(day){
        
        enableHoursCabinas(day);
        $('#Cabina_day_'+day).change(function () {

                enableHoursCabinas(day);

        });
        
        $('#IdCheckBox').change(function () {

               var checkbox = $(this).attr('checked');
               
                if(checkbox != 'checked'){
                    $('#Deposito_TiempoCierre').prop('disabled', true);      
                }else{
                    $('#Deposito_TiempoCierre').prop('disabled', false);
                }

        });
    }
    
    function resetField(beneficiario){
        $("#Detallegasto_Monto").val(''); 
        $("#Detallegasto_beneficiario").val('');
        
        if(beneficiario != true){
        $("#Detallegasto_beneficiario").css('display','inline');
        $("select#beneficiario2").css('display','none');
        }
        
        $("#Detallegasto_moneda option[value='empty']").attr("selected", "selected");
        $("#Detallegasto_CUENTA_Id option[value='empty']").attr("selected", "selected");
        $("#Detallegasto_CUENTA_Id").html('<option value="empty">Seleccionar Moneda</option>');
        //$("select#Detallegasto_TIPOGASTO_Id").prop('selectedIndex', 0);
        $("select#Detallegasto_CABINA_Id").prop('selectedIndex', 0);
    }
    
    function setKids(){
        $('input[type=submit]').on('click',function(event)
        {
            var clickID = parseInt($("#DatosHijos td#col div.row").length);
            
            //alert(clickID);
            var kids = new Array();
            var i = 0;
            for(i= 0;i<clickID;i++){
                kids[i] = $("#DatosHijos td#col input#age"+(i+1)).val();
            }
            
            if(cleanArray(kids) != null){
            $('#Employee_kids').val(cleanArray(kids));
            }else{
            $('#Employee_kids').val('');    
            }
            
            //alert($('#Employee_kids').val());
        });
    }
    
    function enableHours(day){
        
        var checkbox = $('#EmployeeHours_day_'+day).attr('checked');
        if(checkbox != 'checked'){
            $('#EmployeeHours_start_time_'+day).prop('disabled', true);
            $('#EmployeeHours_end_time_'+day).prop('disabled', true);        
        }else{
            $('#EmployeeHours_start_time_'+day).prop('disabled', false);
            $('#EmployeeHours_end_time_'+day).prop('disabled', false);  
        }
        
    }
    
    function changeCheckbox(day){
        
        enableHours(day);
        $('#EmployeeHours_day_'+day).change(function () {
        
                enableHours(day);

        });
    }
    
    function changeCheckboxLocutorio(){
        
        //desactivarLocutorio();
        $('#Novedad_Puesto_10').change(function () {

           var checkbox = $(this).attr('checked');
            if(checkbox == 'checked'){
                for(var i = 0;i<10;i++){
                    $('#Novedad_Puesto_'+i).prop('disabled', true);
                    $('#Novedad_Puesto_'+i).attr('checked', true);
                }
            }else{
                for(var i = 0;i<10;i++){
                    $('#Novedad_Puesto_'+i).prop('disabled', false);
                    $('#Novedad_Puesto_'+i).attr('checked', false);
                } 
            }

        });
    }
    
    function changeStatus(){
        if($('#Employee_status').length){
            if($("select#Employee_status option:selected").text() == 'Inactivo'){
                
//                $('#Employee_admission_date').val('');
                $('#CrearEmpleado-form').find('input, textarea, button, select, checkbox').attr('disabled','disabled');
                $('#Employee_status').prop('disabled', false);
            }
            
            $("select#Employee_status").change(function () {
                if($("select#Employee_status option:selected").text() == 'Inactivo'){
                    
                    $('#CrearEmpleado-form').find('input, textarea, button, select, checkbox').attr('disabled','disabled');
                    $('#Employee_status').prop('disabled', false);
                }else{
                    $('#Employee_admission_date').val('');
                    $('#CrearEmpleado-form').find('input, textarea, button, select, checkbox').prop('disabled', false);
                }
            });
            
        }
    }
    
    function cleanArray( actual ){
        var newArray = new Array();
        for( var i = 0, j = actual.length; i < j; i++ ){
            if ( actual[ i ] ){
              newArray.push( actual[ i ] );
          }
        }
        return newArray;
      }
      
      function canbioCuenta(){
          $("select#Detalleingreso_moneda").change(function () {
                var selc_moneda = $("select#Detalleingreso_moneda").val();

                  //Obtener el Salario del empleado Seleccionado
                  var cuenta = $.ajax({ type: "GET",   
                    url: '/Detallegasto/DynamicCuentaEmployee?moneda='+selc_moneda,   
                    async: false,
                    succes: alert,
                  }).responseText;
                  
                  $("#Detalleingreso_CUENTA_Id").html(cuenta);
                                  
          });                      
      }
      
      function addFieldVenta()
      {
          $('input#genVenta').on('click',function () {
                var select = '';
                var arrayServicios = new Array();
                select = $('select#Detalleingreso_Ventas option:selected').text();

                if(select != 'Seleccionar..'){

                var arrayServicios = JSON.parse($.ajax({ type: "GET",   
                  url: '/Detalleingreso/DynamicTipoIngreso?compania='+select,   
                  async: false,
                  succes: alert,
                }).responseText);
                
                if($('div#'+select.replace(" ","")).length){
                
                    
                }else{
                    $('div#ventasServicios').append(
                    '<div id="'+select.replace(" ","")+'" style="">'+
                    '<h2>'+select.replace(" ","")+'</h2>'+
                    '<table id="'+select.replace(" ","")+'" width="200" border="1">'+
                      '<tr>'+
                        '<td colspan="'+arrayServicios.length+'">'+
                          '<img id="'+select.replace(" ","")+'" class="removeDiv" title="Quitar Servicio" src="/themes/mattskitchen/img/close.png" style="float:right;" />'+
                        '</td>'+
                      '</tr>'+
                      '<tr id="'+select.replace(" ","")+'">'+
                      '</tr>'+
                    '</table>'+
                    '</div>'+
                    '<br>');

                    for(var i=0;i<arrayServicios.length;i++){
                        $('div#ventasServicios table#'+select.replace(" ","")+' tr#'+select.replace(" ","")).append(
                                    '<td> ' +	
                                        '<div class="row">'+
                                            '<label for="Detalleingreso_'+arrayServicios[i]+'"> '+changeNameVentas(arrayServicios[i])+' (S/.)</label>'+
                                            '<input id="Detalle_'+arrayServicios[i]+'" name="Detalle['+arrayServicios[i]+']" type="text">'+
                                        '</div>'+
                                    '</td>'); 
                    }    


                        removeFieldVenta();
                        
                        var FechaBalance = $('input#Detalleingreso_FechaMes').val();
                        if(FechaBalance != ''){
                            var ventasExistentes = verificaVentaExistente(FechaBalance);
                            if(ventasExistentes.length > 0)
                            {
                                for(var i = 0;i<ventasExistentes.length;i++){
                                    $('form#balance-form input#Detalle_'+ventasExistentes[i]).prop('disabled', true);
                                }
                            }else{
                                $('form#balance-form input,form#balance-form select').prop('disabled', false);
                            }
                        }
                        
                }  

              }
                    
          }); 
          
          

      }
                
      
      
      function removeFieldVenta()
      {
          $('img.removeDiv').on('click',function () {
              
              var id = ''; 
              id = $(this).attr('id');
              $('div#'+id).remove();
              $('div#ventasServicios br').remove();
              
          });      
      }
      
      function changeNameVentas(name)
      {
            var nameFormate = new Array();

                //Movistar
                nameFormate['RecargaCelularMov']='Recarga Celular Movistar';
                nameFormate['RecargaFonoYaMov']='Recarga Fono Ya Movistar';
                nameFormate['RecargasVentasMov']='Recargas Ventas Movistar';
                nameFormate['CobrosMov']='Cobros Movistar';
                nameFormate['Linea147-hp']='Linea 147-hp';

                //Claro
                nameFormate['RecargaCelularClaro']='Recarga Celular Claro';
                nameFormate['RecargaFonoClaro']='Recarga Fono Claro';
                nameFormate['RecargasVentasClaro']='Recargas Ventas Claro';
                nameFormate['TarjetaClaro']='Tarjeta Claro';
                nameFormate['CobrosClaro']='Cobros Claro';
                
                //Nextel
                nameFormate['RecargaNextelCelulares']='Recarga Nextel Celulares';
                nameFormate['TarjetaNextel']='Tarjeta Nextel';
                
                //DirecTv
                nameFormate['RecargaDirectv']='Recarga Directv';
                nameFormate['CobrosDirectv']='Cobros Directv';
                
                //IDT
                nameFormate['PeruGlobal']='Peru Global';
                nameFormate['NumeroUNO']='Numero UNO';
                
                //Convergia
                nameFormate['HablaSympatico']='Habla Sympatico';
                nameFormate['LaRendidora']='La Rendidora';
                
                //Sedapal
                nameFormate['ServicioAgua']='Servicio de Agua';
                
                //Pago Efecto
                nameFormate['PeriodicoElComercio']='Periodico El Comercio';
                
                //Juego
                nameFormate['Juega8']='Juega8';


            return nameFormate[name];
      }
      
      function verificarFechaTraficoCaptura(vista,inputDate)
      {
              $("input#"+inputDate).change(function () {
                  
                  var FechaBalance = '';
                  var verificar = '';
                  var mensaje = '';
                  var dias_semana = new Array("","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
                  
                  FechaBalance = $(this).val();
                  var arrayFecha = FechaBalance.split("/");
                  
                  var NuevaFecha = arrayFecha[2]+'-'+arrayFecha[1]+'-'+arrayFecha[0];

                  verificar = JSON.parse($.ajax({ type: "GET",   
                    url: '/Detalleingreso/DynamicTraficoCaptura?fecha='+FechaBalance+'&vista='+vista, 
                    cache: true,
                    async: false,
                    succes: alert,
                  }).responseText);

              if(vista == 'TraficoCaptura'){    
                  mensaje = 'ERROR: No se han Cargado los Archivos Definitivos de las Rutas Internal y External para la Fecha Seleccionada';
              }
              
              $("#diaSemana").text(dias_semana[(new Date(NuevaFecha).getDay()+1)]);
              
              if(verificar.length < 2){
                  if($('div#errorDiv').length){

                  }else{
                      $('table#dateTraficoCaptura div.row').append('<div id="errorDiv" style="color: red;max-width: 100%;text-align: left;"></div>');
                      $('div#errorDiv').text(mensaje);
                  }
                  $('form#traficoCaptura-form input#submitTrafico').prop('disabled', true);
              }else{

                  $('form#traficoCaptura-form input#submitTrafico').prop('disabled', false);
                  $('table#dateTraficoCaptura div#errorDiv').remove();
              }

              }); 
   
      }
      
      function verificarFechaBalance(vista,inputDate)
      {
              $("input#"+inputDate).change(function () {
                  
                  var FechaBalance = '';
                  var verificar = '';
                  var mensaje = '';
                  var dias_semana = new Array("","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo");
                  
                  FechaBalance = $(this).val();
                  var arrayFecha = FechaBalance.split("/");
                  
                  var NuevaFecha = arrayFecha[2]+'-'+arrayFecha[1]+'-'+arrayFecha[0];

                  verificar = $.ajax({ type: "GET",   
                    url: '/Detalleingreso/DynamicBalanceAnterios?fecha='+FechaBalance+'&vista='+vista, 
                    cache: true,
                    async: false,
                    succes: alert,
                  }).responseText;
                  
                  

              if(vista == 'Ventas'){    
                  mensaje = 'ERROR: No Existe El Balance para la Fecha Indicada';
              }
              
              if(vista == 'SaldoApertura'){
                  mensaje = 'ERROR: El Saldo de Apertura Ya Fue Declarado para la Fecha Indicada';
              }
              
              if(vista == 'SaldoCierre'){
                  if(verificar == 'false'){
                    mensaje = 'ERROR:El Saldo de Cierre Ya Fue Declarado para la Fecha Indicada';  
                  }
                  if(verificar == 'EmptyBalance'){
                    mensaje = 'ERROR: No Existe El Balance para la Fecha Indicada';
                  }
              }
              
              if(vista == 'Deposito'){
                  if(verificar == 'false'){
                    mensaje = 'ERROR: El Deposito Ya Fue Declarado para la Fecha Indicada';  
                  }
                  if(verificar == 'EmptyBalance'){
                    mensaje = 'ERROR: No Existe El Balance para la Fecha Indicada';
                  }
              } 
              
              if(verificar == 'false' || verificar == 'EmptyBalance'){
                  
                  if($('div#errorDiv').length && mensaje != ''){
                      $('div#errorDiv').text(mensaje);
                  }else{
                      $('table#dateBalance div.row').append('<div id="errorDiv" style="color: red;max-width: 60%;text-align: left;"></div>');
                      $('div#errorDiv').text(mensaje);
                  }
                  $("#diaSemana").text(dias_semana[(new Date(NuevaFecha).getDay()+1)]);
                  //$('form#balance-form input#'+inputDate).css('float','left');
                  $('form#balance-form input,form#balance-form select').prop('disabled', true);
                  $('form#balance-form input#'+inputDate).prop('disabled', false);
              }
              if(verificar == 'true'){
                  
                  $('form#balance-form input#'+inputDate).css('float','none');
                  $("#diaSemana").text(dias_semana[(new Date(NuevaFecha).getDay()+1)]);
                  
                  $('form#balance-form input,form#balance-form select').prop('disabled', false);
                  $('form#balance-form select#Deposito_TiempoCierre').prop('disabled', true);
                  $('table#dateBalance div#errorDiv').remove();
                  
                  var ventasExistentes = verificaVentaExistente(FechaBalance);
                  if(ventasExistentes.length > 0)
                  {
                      for(var i = 0;i<ventasExistentes.length;i++){
                          $('form#balance-form input#Detalle_'+ventasExistentes[i]).prop('disabled', true);
                      }
                      if(vista == 'Ventas'){   
                        $('#diaSemana').append('<div id="fieldB" style="color: #ff9900;max-width: 60%;text-align: left;">Los Campos Bloqueados Ya Fueron Registrados</div>');
                      }
                      if(vista == 'SaldoCierre'){
                        $('div#fieldB').remove();
                      }
                  }else{
                      $('form#balance-form input,form#balance-form select').prop('disabled', false);
                  }
              }

              }); 
   
      }
      
      function verificaVentaExistente(FechaBalance) 
      {
          var arrayServicios = '';
          
          arrayServicios = JSON.parse($.ajax({ type: "GET",   
            url: '/Detalleingreso/DynamicIngresosRegistrado?fechaBalance='+FechaBalance,   
            async: false,
            succes: alert,
          }).responseText);
          
          return arrayServicios;
      }
      
    
