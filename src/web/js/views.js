/**
* @file views.js
* archivo encargado de almacenar funciones para las vistas
*/
/**
* Variables globales
*/
var fondos={
        'log-grid':'rgba(64,152,8,1)',
        'list-user-grid':'rgba(64,152,8,1)',
        'user-grid':'rgba(64,152,8,1)',
        'novedad-grid':'rgba(64,152,8,1)',
        'balance-grid':'rgba(64,152,8,1)',
        'estadogasto-grid':'rgba(255,153,51,1)',
        'balance-grid-oculta':'rgba(64,152,8,1)',
        'balanceLibroVentas':'rgba(255,187,0,1)',
        'balanceLibroVentasOculta':'rgba(255,187,0,1)',
        'balanceReporteDepositos':'rgba(51,153,153,1)',
        'balanceReporteDepositosOculta':'rgba(51,153,153,1)',
        'balanceReporteBrighstar':'rgba(255,153,51,1)',
        'balanceReporteBrighstarOculta':'rgba(255,153,51,1)',
        'balanceReporteCaptura':'rgba(204,153,204,1)',
        'balanceReporteCapturaOculta':'rgba(204,153,204,1)',
        };



/**
* Clase encargada de generar datepickers
*/
var selectfecha = function()
{
    this.objeto=null;
}

selectfecha.prototype.escoge=function(id)
{
    var objeto=$(id);
    console.dir(objeto);
    if(objeto.length>0){
        objeto.datepicker({
            dateFormat: 'mm-yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,

            onClose: function(dateText, inst)
            {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val(); 
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val(); 
                $(this).val($.datepicker.formatDate('yy-mm', new Date(year, month, 1)));
            }
        });
        
        objeto.focus(function()
        {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });    
        });
    }

}
/**
* Clase creada para totalizar valores en los gridviews
* @param string origen = id del tipo de valor que se va a sumar.
* @param string destino = id donde se quiere colocar el resultado.
* @param string mensajeDestino = id de donde se va colocar el mensaje.
* @param mixed diferente = valor que sera omitido al sumar.
* @param string mensaje = el mensaje que sera colocado. 
*/
var totalGridView = function()
{
    this.resultado=0;  
}
totalGridView.prototype.run=function()
{
    this.objeto=$('div[name="vista"]');
    var colorear=['td#diferencialBancario','td#concilicacionBancaria','td#diferencialBrightstarMovistar','td#diferencialBrightstarClaro','td#diferencialCapturaSoles','td#diferencialCapturaDollar','td#acumulado','td#sobrante','td#sobranteAcum'];
    var origen=['td#aperturaMov','td#aperturaClaro','td#trafico','td#recargaMov','td#recargaClaro','td#montoDeposito','td#otrosServicios','td#totalVentas','td#montoBanco','td#diferencialBancario','td#concilicacionBancaria','td#recargasVentasMovistar','td#diferencialBrightstarMovistar','td#recargasVentasClaro','td#diferencialBrightstarClaro','td#minutos','td#traficoCapturaDollar','td#traficoCapturaSoles','td#diferencialCapturaSoles','td#diferencialCapturaDollar','td#acumulado','td#sobrante','td#sobranteAcum','td#totalVentaPronostico','td#ventaMaxima','td#comision','td#saldo','td#nuevoSaldo'];
    var destino=['td#vistaAdmin1','td#vistaAdmin2','td#totalTrafico','td#totalRecargaMov','td#totalRecargaClaro','td#totalMontoDeposito','td#balanceTotalesVentas4','td#totalVentas2','td#balanceTotalesDepositos3','td#totalDiferencialBancario','td#totalConcilicacionBancaria','td#balanceTotalesBrightstar1','td#totalesDiferencialBrightstarMovistar','td#balanceTotalesBrightstar3','td#totalesDiferencialBrightstarClaro','td#totalMinutos','td#balanceTotalesCaptura1','td#balanceTotalesCaptura2','td#totalesDiferencialCapturaSoles','td#totalesDiferencialCapturaDollar','td#totalAcumulado','td#totalSobrante','td#totalSobranteAcum','td#TotalVentasPronostico','td#totalVentaMaxima','td#totalComision','td#totalSaldo','td#totalNuevoSaldo'];
    var destinoMensaje=['th#vistaAdmin1','th#vistaAdmin2','th#totalTrafico','th#totalRecargaMov','th#totalRecargaClaro','th#totalMontoDeposito','th#balanceTotalesVentas4','th#totalVentas2','th#balanceTotalesDepositos3','th#totalDiferencialBancario','th#totalConcilicacionBancaria','th#balanceTotalesBrightstar1','th#totalesDiferencialBrightstarMovistar','th#balanceTotalesBrightstar3','th#totalesDiferencialBrightstarClaro','th#totalMinutos','th#balanceTotalesCaptura1','th#balanceTotalesCaptura2','th#totalesDiferencialCapturaSoles','th#totalesDiferencialCapturaDollar','th#totalAcumulado','th#totalSobrante','th#totalSobranteAcum','th#TotalVentasPronostico','th#totalVentaMaxima','th#totalComision','th#totalSaldo','th#totalNuevoSaldo'];
    var diferente=['No Declarado','No Declarado','0.00','0.00','0.00','&nbsp;','&nbsp;','0.00','0.00','0.00','0.00','&nbsp;','0.00','&nbsp;','0.00','&nbsp;','0.00','0.00','0.00','0.00','&nbsp;','0.00','&nbsp;','0.00','0.00','0.00','0.00',''];
    var mensaje=['Saldo Apertura Movistar','Saldo Apertura Claro','Trafico (S/.)','Recarga Movistar (S/.)','Recarga Claro (S/.)','Monto Deposito (S/.)','Otros Servicios (S/.)','Total Ventas (S/.)','Monto Banco (S/.)','Diferencial Bancario (S/.)','Conciliación Bancaria (S/.)','Recarga Ventas Movistar (S/.)','Diferencial Brightstar Movistar (S/.)','Recarga Ventas Claro (S/.)','Diferencial Brightstar Claro (S/.)','Minutos segun Captura','Trafico Captura (USD $)','Capt Soles','Diferencial Captura Soles (S/.)','Diferencial Captura Dollar (USD $)','Acumulado Dif. Captura (USD $)','Sobrante (USD $)','Sobrante Acumulado (USD $)','Total Venta', 'Venta Maxima','Comision','Saldo','Total Nuevo Saldo'];
    for(var i=0, t = origen.length - 1; i <= t; i++)
    {
        this.total(origen[i],destino[i],destinoMensaje[i],diferente[i],mensaje[i]);
    };
    for (var i=0, t = colorear.length - 1; i <= t; i++)
    {
        this.changeCSS(colorear[i]);
    };
    this.montoGasto();
    this.fecha();
    this.totalRecargas('td#propuesta','td#totalMontoRecargas','th#totalMontoRecargas','','Total Monto Recarga');

}
//totaliza
totalGridView.prototype.total=function(origen,destino,destinoMensaje,diferente,mensaje)
{
    var self=this;
    var acum=0;
    this.objeto.children('table').children('tbody').children().children(origen).filter(function(){return $(this).html() != diferente}).each(function()
    {
        acum=acum+parseFloat($(this).html());
    });
    if(diferente == '&nbsp;' || diferente == 'No Declarado')
    {
        if(acum==0)
        {
            $(destinoMensaje).html(mensaje);
            $(destino).html("No Declarados");
        }
        else
        {
            $(destinoMensaje).html(mensaje);
            $(destino).html(self.redondeo(acum));
        }
    }
    else
    {
        $(destinoMensaje).html(mensaje);
        $(destino).html(self.redondeo(acum));
    }
    acum=0;
}
//metodo para sumar los valores de los inputs
totalGridView.prototype.totalRecargas=function(origen,destino,destinoMensaje,diferente,mensaje)
{
    var self=this;
    var acum=0;
    this.objeto.children('table').children('tbody').children().children(origen).children('input').filter(function(){return $(this).val() != diferente}).each(function()
    {
        acum=acum+parseFloat($(this).val());
    });
    if(diferente == '&nbsp;' || diferente == 'No Declarado')
    {
        if(acum<=0)
        {
            $(destinoMensaje).html(mensaje);
            $(destino).html("No Declarados");
        }
        else
        {
            $(destinoMensaje).html(mensaje);
            $(destino).html(self.redondeo(acum));
        }
    }
    else
    {
        $(destinoMensaje).html(mensaje);
        $(destino).html(self.redondeo(acum));
    }
    acum=0;
}
//Metodo para redondear valores numericos
totalGridView.prototype.redondeo=function(numero)
{
    var original=parseFloat(numero);
    var resultado=Math.round(original * 100) / 100;
    if(resultado==null || resultado == undefined)
    {
        resultado='0.00';
    }
    return resultado;
}
//metodo creado para sumar los valores de estado de gastos
totalGridView.prototype.montoGasto=function()
{
    var soles=0;
    var dolares=0;
    this.objeto.children('table').children('tbody').children('tr').children('#monto').filter(function(){return $(this).html() != ""}).each(function()
    {
        var texto=$(this).parent().children('#moneda').text();
        switch(texto)
        {
            case "S/.":
                soles=soles+parseFloat($(this).text());
                break;
            case "USD$":
                dolares=dolares+parseFloat($(this).text());
                break;
        }
    });
    $('td#soles').html(soles);
    $('td#dolares').html(dolares);
}
//Metodo para cambiar de color los resultados de gridviews
totalGridView.prototype.changeCSS=function(ids)
{
    //Cambian de color los valores de los campos especificados con la clase dif
    this.objeto.children('table').children('tbody').children().children(ids).filter(function(){return $(this).html() < 0}).css('color','red');
    this.objeto.children('table').children('tbody').children().children(ids).filter(function(){return $(this).html() > 0}).css('color','green');
    this.objeto.children('table').children('tbody').children().children(ids).filter(function(){return $(this).html() == 0}).css('color','black');
}
//metodo encargado de colocar las fechas en los totales de los gridviews
totalGridView.prototype.fecha=function()
{
    var fecha=null, diferentes=0, iguales=0, nuevaFecha=null, meses=['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    this.objeto.children('table').children('tbody').children().children('td#fecha').each(function()
    {
        if(fecha!=$(this).html())
        {
            fecha=$(this).html();
            diferentes=diferentes+1;
        }
        else
        {
            iguales=iguales+1;
        }
    });
    if(iguales>diferentes)
    {
        $('td#totalFecha').html(fecha);
    }
    else
    {
        if(fecha!=null)
        {
            nuevaFecha=fecha.split("-");
            $('td#totalFecha').html(meses[parseInt(nuevaFecha[1])-1]);
        }
    }
}
/*********************************************************************
* Clase encargada de imprimir los reportes                           *
*********************************************************************/
var imprimir=function()
{
    this.paraImprimir='div[rel="total"]';
    this.fondos={
        'log-grid':'rgba(64,152,8,1)',
        'list-user-grid':'rgba(64,152,8,1)',
        'user-grid':'rgba(64,152,8,1)',
        'novedad-grid':'rgba(64,152,8,1)',
        'balance-grid':'rgba(64,152,8,1)',
        'estadogasto-grid':'rgba(255,153,51,1)',
        'balance-grid-oculta':'rgba(64,152,8,1)',
        'balanceLibroVentas':'rgba(255,187,0,1)',
        'balanceLibroVentasOculta':'rgba(255,187,0,1)',
        'balanceReporteDepositos':'rgba(51,153,153,1)',
        'balanceReporteDepositosOculta':'rgba(51,153,153,1)',
        'balanceReporteBrighstar':'rgba(255,153,51,1)',
        'balanceReporteBrighstarOculta':'rgba(255,153,51,1)',
        'balanceReporteCaptura':'rgba(204,153,204,1)',
        'balanceReporteCapturaOculta':'rgba(204,153,204,1)',
        };
};
imprimir.prototype.run=function()
{
    var self=this;
    $('.printButton').on('click',function()
    {
        self.reporte();
    });
    $('img.printButtonDetail').on('click',function()
    {
        self.detalle();
    });
}
//prepara las variables para imprimir un reporte
imprimir.prototype.reporte=function()
{
    var self=this;
    this.id1=$('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
    this.id2=$('div[rel="total"]').filter(function(){return $(this).css('display') == "none" }).attr('id');
    $(this.paraImprimir).filter(function(){return $(this).css('display') == "block"}).children('table').children('thead').children().children().each(function()
    {
        var temp=$(this).children('a.sort-link').text();
        if(temp)
        {
            $(this).children('a.sort-link').remove();
            $(this).html(temp);
            $('thead tr th').css('background',self.fondos[self.id1]);
        }
    });
    
    this.estilo="<style>.odd{background:rgba(229,241,244,1);}table.items thead tr th{background:"+fondo(this.id1)+"}</style>";
    $(".filters, .button-column, .pager, .summary").remove();
    $("table.items input" ).attr('disabled','disabled');
    if($("div#totales" ).length)
        this.div ="<h1>"+ $(".enviar").html() + "</h1>" + "<br/>" + $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).html() + "<br/>" +$("div#totales" ).clone().html();//seleccionamos el objeto
    else
        this.div ="<h1>"+ $(".enviar").html() + "</h1>" + "<br/>" + $('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).html() + "<br/>";//seleccionamos el objeto
    this.printo();
};
//prepara las variables para imprimir un detalle
imprimir.prototype.detalle=function()
{
    this.div="<h1>"+ $(".enviar").html() + "</h1>" + "<br/>" + $(".enviarTabla" ).clone().html();
    this.estilo="<style>.odd{background:rgba(229,241,244,1);}</style>";
    this.printo();
};
//accion de imprimir
imprimir.prototype.printo=function()
{
    this.imp = window.open(" ","Formato de Impresion");

    this.imp.document.open();
    this.imp.document.write(this.estilo);     //abrimos
    this.imp.document.write(this.div);//agregamos el objeto
    this.imp.document.close();
    this.imp.print();   //Abrimos la opcion de imprimir
    this.imp.close();

    if(this.id1!=undefined)
    {
        $.fn.yiiGridView.update(this.id1);
    }
    if(this.id2!=undefined)
    {
        $.fn.yiiGridView.update(this.id2);
    }
};



/**
* Clase encargada de totalizar el pronostico
*/
var totalPronostico = function(id)
{
    this.objeto=$(id).children('table.items').children('tbody');
    this.cambio="input#laborable, input#fin, input[id^='movistar'], input[id^='claro']";
    this.laborable=$('input#laborable').val();
    this.fin=$('input#fin').val();
    this.totalMontoRecargas=0;
    this.ids={
        laborable:'input#laborable',
        fin:'input#fin',
        movistar:'input[id^="movistar"]',
        claro:'input[id^="claro"]',
        dias:'td#dias'
    };
    
}
//metodo que arranca todo
totalPronostico.prototype.run=function()
{
    var mismo=this;
    this.totales=new totalGridView();
    this.totalesPronostico();
    this.alarmas();
    this.nuevoSaldo();
    $(this.cambio).change(function()
    {
        mismo.nuevoSaldo(this);
        mismo.alarmas();
        mismo.totalesPronostico();
        totales.totalRecargas('td#propuesta','td#totalMontoRecargas','th#totalMontoRecargas','','Total Monto Recarga');
        totales.total('#nuevoSaldo','td#totalNuevoSaldo','th#totalNuevoSaldo','',"Total Nuevo Saldo");
    });
}
//Se encarga de activar los iconos de alarmas
totalPronostico.prototype.alarmas=function(week,weekend,suma)
{
    var mismo=this;
    var laboral=$(this.ids.laborable).val();
    var fin=$(this.ids.fin).val();
    var dias=$(this.ids.dias);

    dias.filter(function(){return parseFloat($(this).text()) < parseFloat(laboral)}).parent().children('td#laboral').css({'background-image':'url(/images/no-icon.png)','background-repeat':'no-repeat','background-position':'center' });
    dias.filter(function(){return parseFloat($(this).text()) >= parseFloat(laboral)}).parent().children('td#laboral').css({'background-image':'url(/images/check-icon.png)','background-repeat':'no-repeat','background-position':'center' });
    
    dias.filter(function(){return parseFloat($(this).text()) < parseFloat(fin)}).parent().children('td#fin').css({'background-image':'url(/images/no-icon.png)','background-repeat':'no-repeat','background-position':'center' });
    dias.filter(function(){return parseFloat($(this).text()) >= parseFloat(fin)}).parent().children('td#fin').css({'background-image':'url(/images/check-icon.png)','background-repeat':'no-repeat','background-position':'center' });

}
//metodo que cambia el icono de aprobado o no aprobado
totalPronostico.prototype.totalesPronostico=function()
{
    var mismo=this;
    var acum=0;
    $('#pronosticos').children('table.items').children('tbody').children().children('td#propuesta').children('input').filter(function(){return $(this).val() != "" }).each(function()
    {
        acum=acum+parseFloat($(this).val());
    });
    $('td#totalMontoRecargas').html(acum);
    var recargas=$('td#totalMontoRecargas').text();
    var disponible=$('td#disponible').text();
    if(parseFloat(recargas)<=parseFloat(disponible))
    {

        $('td#aprobacion').css({'background-image':'url(/images/check-icon.png)','background-repeat':'no-repeat','background-position':'center' });
    }
    else
    {
        $('td#aprobacion').css({'background-image':'url(/images/no-icon.png)','background-repeat':'no-repeat','background-position':'center' });

    }
}
totalPronostico.prototype.nuevoSaldo=function(objeto)
{
    var mismo=this;
    var suma=0, dias=0;
    var saldo=$(objeto).parent().parent().children().filter(function(){return $(this).attr('id') == "saldo"}).text();
    if(saldo==null || saldo=="" || saldo=='&nbsp;')
    {
        saldo=0;
    }
    console.log("saldo: "+saldo);
    var propuesta=$(objeto).val();
    if(propuesta==null || propuesta=="" || propuesta=='&nbsp;')
    {
        propuesta=0;
    }
    var ventas=$(objeto).parent().parent().children().filter(function(){return $(this).attr('id') == "ventaMaxima"}).text();
    if(ventas<=0)
    {
        dias=parseFloat(propuesta)+parseFloat(saldo);
    }
    else
    {
        dias=(parseFloat(propuesta)+parseFloat(saldo))/parseFloat(ventas);
    }
    suma=parseFloat(propuesta)+parseFloat(saldo);
    console.log("propuesta: "+propuesta+" + saldo: "+saldo+" / ventas:"+ventas+" = "+dias);
    $(objeto).parent().parent().children().filter(function(){return $(this).attr('id') == "dias"}).text(mismo.totales.redondeo(dias));
    $(objeto).parent().parent().children().filter(function(){return $(this).attr('id') == "nuevoSaldo"}).text(mismo.totales.redondeo(suma));
}



var totales=new totalGridView();
var imprime=new imprimir();
var pronostico=new totalPronostico('.grid-view');
var datepicker=new selectfecha();

$(document).ready(function()
{
    datepicker.escoge("input#dateMonth");
    datepicker.escoge("input#FechaMes");
    totales.run();

    //imprime.run();

    pronostico.run();

    /*

    
    //Generando archivos excel
    var archivo=new excel();
    archivo.detalle("img.botonExcelDetail","div#detail","#datos_a_enviar","#FormularioExportacion");*/

    followMeTable();
    validarNum();
    getHref();
    getHref2();

    //gen_excel();
//    send_mail();
//    send_mail_detail();
//    send_mail_panel();

    takeOff();
    switchCabina();
    $(this).ajaxComplete(function()
    {
        totales.run();

        //imprime.run();





    followMeTable();
    validarNum();
    getHref();
    getHref2();

    //gen_excel();
    //send_mail();

    switchCabina();
    });
});


function redondeo(numero)
{
    var original=parseFloat(numero);
    var resultado=Math.round(original * 100) / 100;
    if(resultado==null || resultado == undefined)
    {
        resultado='0.00';
    }
    return resultado;
}




/*********************************************************************
* Clase encargada de hacer el cambio de gridviews                    *
*********************************************************************/
/*var switchCabina=function()
{
    var self=this;
    this.boton=$('#cambio');
    this.oculta=$('div[name="oculta"]');
    this.vista=$('div[name="vista"]');
    this.ventas=$('a[rel="fancybox1"]');
    this.bancarios=$('a[rel="fancybox2"]');
    this.brightstar=$('a[rel="fancybox3"]');
    this.captura=$('a[rel="fancybox4"]');
    this.boton.on('click',function(e)
    {
        self.cambio();
        totaliza();
    });
};
//ejecuta el cambio
switchCabina.prototype.cambio=function()
{
    if(this.boton.text() == 'Activas')
    {
        this.boton.text('Inactivas');
        this.oculta.addClass('oculta');
        this.vista.removeClass('oculta');
        this.ventas.attr('href','/balance/pop/1');
        this.bancarios.attr('href','/balance/pop/2');
        this.brightstar.attr('href','/balance/pop/3');
        this.captura.attr('href','/balance/pop/4');
    }
    else if(this.boton.text() == 'Inactivas')
    {
        this.boton.text('Activas');
        this.oculta.removeClass('oculta');;
        this.vista.addClass('oculta');
        this.ventas.attr('href','/balance/pop/5');
        this.bancarios.attr('href','/balance/pop/6');
        this.brightstar.attr('href','/balance/pop/7');
        this.captura.attr('href','/balance/pop/8');
    }
};*/

function switchCabina()
{       
     $('#cambio').on('click',function()      
     {       
         if($(this).text() == 'Activas')     
         {       
             $(this).text('Inactivas');      
             $('div[name="oculta"]').css('display','none');      
             $('div[name="vista"]').css('display','block');      
             $('a[rel="fancybox1"]').attr('href','/balance/pop/1');      
             $('a[rel="fancybox2"]').attr('href','/balance/pop/2');      
             $('a[rel="fancybox3"]').attr('href','/balance/pop/3');      
             $('a[rel="fancybox4"]').attr('href','/balance/pop/4');   
             
             $('#formCabina').prop('disabled', false);
             $('#dateMonth').prop('disabled', false);
         }       
         else        
         {       
             $(this).text('Activas');
             $('div[name="oculta"]').css('display','block');     
             $('div[name="vista"]').css('display','none');       
             $('a[rel="fancybox1"]').attr('href','/balance/pop/5');      
             $('a[rel="fancybox2"]').attr('href','/balance/pop/6');      
             $('a[rel="fancybox3"]').attr('href','/balance/pop/7');      
             $('a[rel="fancybox4"]').attr('href','/balance/pop/8'); 
             
             $('#formCabina').prop('disabled', true);
             $('#dateMonth').prop('disabled', true);
         }       
        totales();      
     });  

}

/*****************************
* Funciones de segundo plano *
*****************************/
//de un numero con mas de dos decimales, retorna el redondeo a dos decimales
function retornar(variable, booleano)
{
    if(variable==false && booleano == true)
    {
        return variable = false;

    }
    else
    {
        return variable = booleano;
    }
}
//Funcion que se encarga de pasar una url de un link a otro
function remUrl(desde, hasta)
{
    //Almaceno la url en una variable
    var ref = $(desde).attr("href");
    //cuento donde tiene el simbolo de ? y lo guardo en una variable
    var num = ref.indexOf('?');
    //traigo la url a partir del simbolo
    if(num >= 0)
    {
        var extrac = ref.substr(num,300);
        //al selector le reemplazo la url
        $(hasta).each(function()
        {
            //traigo la url
            var link = $(this).attr("href");
            //veo donde tiene el simbolo
            var num2 = link.indexOf('?');
            //si no tiene simbolo le agrego el resto de la url
            if(num2 == -1)
            {
                $(this).attr("href",link+extrac);
            }
            else
            {
                //si lo tiene traigo todo lo que esta antes
                var nueva=link.substr(0,num2);
                $(this).attr("href",nueva+extrac);
            }
        });
    }
}

//Se encarga de colocar un fondo especifico a los id ya especificados
function fondo(id)
{
    if(id.substr(0,1)!='#')
    {
        var ide='#'+id;
    }
    else
    {
         var ide=id;
    }
    var fondos={
        'log-grid':'rgba(64,152,8,1)',
        'list-user-grid':'rgba(64,152,8,1)',
        'user-grid':'rgba(64,152,8,1)',
        'novedad-grid':'rgba(64,152,8,1)',
        'balance-grid':'rgba(64,152,8,1)',
        'estadogasto-grid':'rgba(255,153,51,1)',
        'balance-grid-oculta':'rgba(64,152,8,1)',
        'balanceLibroVentas':'rgba(255,187,0,1)',
        'balanceLibroVentasOculta':'rgba(255,187,0,1)',
        'balanceReporteDepositos':'rgba(51,153,153,1)',
        'balanceReporteDepositosOculta':'rgba(51,153,153,1)',
        'balanceReporteBrighstar':'rgba(255,153,51,1)',
        'balanceReporteBrighstarOculta':'rgba(255,153,51,1)',
        'balanceReporteCaptura':'rgba(204,153,204,1)',
        'balanceReporteCapturaOculta':'rgba(204,153,204,1)',
        }
    $(ide).children('table').children('thead').children('tr').children().css({'background':fondos[id], 'color':'white'});
}
//quita los links en gridview del id pasado como parametro
function noLink(id)
{
    if(id.substr(0,1)!='#'){
        var ide='#'+id;
    }
    else
    {
        var ide=id;
    }
    $(ide).children('table').children('thead').children().children().each(function()
        {
            temp=$(this).children('a.sort-link').text();
            if(temp)
            {
                $(this).children('a.sort-link').remove();
                $(this).html(temp);
            }
        });
}
//fondos de cada fila de resultados
function fila(id)
{
    if(id.substr(0,1)!='#'){
        var ide='#'+id;
    }
    else
    {
        var ide=id;
    }
    $(ide).children('table').children('tbody').children().each(function(){
        var clase = $(this).attr('class').toString();
            if( clase.search("odd") != -1){
                $(this).css('background','rgba(234,248,225,1)');
                $(this).css('text-align','center');
            }
            else
            {
                $(this).css('background','rgba(248,248,248,1)');
                $(this).css('text-align','center');
            }
        });
}
//actualiza un gridview
function update(id,cabina,fecha)
{
    $.fn.yiiGridView.update(id,{
            data:'Balance%5BCABINA_Id%5D='+cabina+"&Balance%5BFecha%5D="+fecha,
        });
}
/*Estas funciones estan para el gridview creado en la tabla de pronosticos*********************************************/
function consigue(objeto,id)
{
    var valor=$(objeto).children('td').filter(function(){return $(this).attr('id') == id}).text();
    if(valor==null || valor=='')
    {
        return valor="0";
    }
    else
    {
        return valor;
    }
    
}
function consigueInput(objeto,id)
{
    var valor=$(objeto).children('td').filter(function(){return $(this).attr('id') == id}).children('input').val();
    if(valor!=null)
    {
        return valor;
    }
    else
    {
        return valor="0";
    }
    
}
/**********************************************************************************************************************/
//remueve todo lo indicado en los id
function takeOff()
{
    // quita los links de ordenamiento
    $('th[id^="balanceLibroVentas1_c"] a').each(function()
    {
        $(this).replaceWith(function()
        {
            return $(this).html();
        });
    });
    $('th[id^="balanceReporteDepositos1_c"] a').each(function()
    {
        $(this).replaceWith(function()
        {
            return $(this).html();
        });
    });
    $('th[id^="balanceReporteBrighstar1_c"] a').each(function()
    {
        $(this).replaceWith(function()
        {
            return $(this).html();
        });
    });
    $('th[id^="balanceReporteCaptura1_c"] a').each(function()
    {
        $(this).replaceWith(function()
        {
            return $(this).html();
        });
    });
}
//Funcion que se encarga de que el gridview completo realize la misma accion que gridview resumido
function followMeTable()
{
    $('#balanceCicloIngresosResumido  a').on('click',function()
    {
        var uno=$(this).text();
        $('#balanceCicloIngresosCompletoActivas a').filter(function(){return $(this).text() == uno}).trigger('click');
    });
    $('#balanceCicloIngresosResumido').on('change','select, input.hasDatepicker',function()
    {
        var cabina=$('#balanceCicloIngresosResumido').children().children('thead').children('tr.filters').children().children('select').val();
        var fecha=$('#balanceCicloIngresosResumido').children().children('thead').children('tr.filters').children().children('input.hasDatepicker').val();
        update('balanceCicloIngresosCompletoActivas',cabina,fecha);
    });
    $('#balanceCicloIngresosResumidoOculta  a').on('click',function()
    {
        var uno=$(this).text();
        $('#balanceCicloIngresosCompletoInactivas a').filter(function(){return $(this).text() == uno}).trigger('click');
    });
    $('#balanceCicloIngresosResumidoOculta').on('change','select, input.hasDatepicker',function()
    {
        var cabina=$('#balanceCicloIngresosResumidoOculta').children().children('thead').children('tr.filters').children().children('select').val();
        var fecha=$('#balanceCicloIngresosResumidoOculta').children().children('thead').children('tr.filters').children().children('input.hasDatepicker').val();
        update('balanceCicloIngresosCompletoInactivas',cabina,fecha);
    });
}

function getHref()
{
    $('div#balanceCicloIngresosResumido a.sort-link, div#balanceCicloIngresosResumido a').on("click",function()
    {
        remUrl(this,'a[rel^="fancybox"]');
    });
    $('div#balanceCicloIngresosResumido input').change(function()
    {
        var val=$(this).val();
        $('a[rel^="fancybox"]').each(function()
        {
            var url=$(this).attr("href");
            var completa="Balance%5BFecha%5D="+val;
            var numP=url.indexOf('Balance_sort=');
            if(numP>0)
            {
                var fecha=url.substr(numP,15);
                completa=completa+"&"+fecha;
            }
            var numC=url.indexOf('Balance%5BCABINA_Id%5D=');
            if(numC>0)
            {
                var cabina=url.substr(numC,25);
                completa=completa+"&"+cabina;
            }
            var exits=url.indexOf('?');
            if(exits>0)
            {
                completa=url.substr(0,exits+1)+completa;
            }
            else
            {
                completa=url+'?'+completa;
            }
            $(this).attr("href",completa);
        });
    });
    $('div#balanceCicloIngresosResumido select').change(function()
    {
        var val=$(this).val();
        $('a[rel^="fancybox"]').each(function()
        {
            var url=$(this).attr("href");
            var completa="Balance%5BCABINA_Id%5D="+val;
            var numO=url.indexOf('Balance_sort=');
            if(numO>0)
            {
                var ordenF=url.substr(numO,19);
                completa=completa+"&"+ordenF;
            }
            var numF=url.indexOf('Balance%5BFecha%5D=');
            if(numF>0)
            {
                var fecha=url.substr(numF,29);
                completa=completa+"&"+fecha;
            }
            var exits=url.indexOf('?');
            if(exits>0)
            {
                completa=url.substr(0,exits+1)+completa;
            }
            else
            {
                completa=url+'?'+completa;
            }
            $(this).attr("href",completa);
        });
    });
}

function getHref2()
{
    $('div#balanceCicloIngresosResumidoOculta a.sort-link, div#balanceCicloIngresosResumidoOculta a').on("click",function()
    {
        remUrl(this,'a[rel^="fancybox"]');
    });
    $('div#balanceCicloIngresosResumidoOculta input').change(function()
    {
        var val=$(this).val();
        $('a[rel^="fancybox"]').each(function()
        {
            var url=$(this).attr("href");
            var completa="Balance%5BFecha%5D="+val;
            var numP=url.indexOf('Balance_sort=');
            if(numP>0)
            {
                var fecha=url.substr(numP,15);
                completa=completa+"&"+fecha;
            }
            var numC=url.indexOf('Balance%5BCABINA_Id%5D=');
            if(numC>0)
            {
                var cabina=url.substr(numC,25);
                completa=completa+"&"+cabina;
            }
            var exits=url.indexOf('?');
            if(exits>0)
            {
                completa=url.substr(0,exits+1)+completa;
            }
            else
            {
                completa=url+'?'+completa;
            }
            $(this).attr("href",completa);
        });
    });
    $('div#balanceCicloIngresosResumidoOculta select').change(function()
    {
        var val=$(this).val();
        $('a[rel^="fancybox"]').each(function()
        {
            var url=$(this).attr("href");
            var completa="Balance%5BCABINA_Id%5D="+val;
            var numO=url.indexOf('Balance_sort=');
            if(numO>0)
            {
                var ordenF=url.substr(numO,19);
                completa=completa+"&"+ordenF;
            }
            var numF=url.indexOf('Balance%5BFecha%5D=');
            if(numF>0)
            {
                var fecha=url.substr(numF,29);
                completa=completa+"&"+fecha;
            }
            var exits=url.indexOf('?');
            if(exits>0)
            {
                completa=url.substr(0,exits+1)+completa;
            }
            else
            {
                completa=url+'?'+completa;
            }
            $(this).attr("href",completa);
        });
    });
}

function validarNum()
{
    $("input[id^='MontoBanco']").on('keypress',function()
    {
        if(!$.isNumeric($(this).val()))
        {
            $(this).css({'background':'#DE5C5C',"border-color":"#CC0000"});
        }
        else
        {
            $(this).css({'background':'#E6EFC2',"border-color":"#C6D880"});
        }
    });
    $("input[id^='MontoBanco']").blur(function()
    {
        if(!$(this).val())
        {
            $(this).css({'background':'#FFFFFF',"border-color":"#EEEAEA"});
        }
    });
    $("input[value='Actualizar']").on('click',function(){
        
    });
    $("form#banco").submit(function()
    {
        if(validar()){
            return validar();
        }
        else{
            alert("Hay campos escritos con letras");
            return validar();
        }
        
    }); 
}
function validar()
{
    var valor = true;
    $("input[id^='MontoBanco']").each(function()
        {
            if($(this).val() == "")
            {
                valor = retornar(valor,true);
            }
            else
            {
                if(!$.isNumeric($(this).val()))
                {
                    valor = retornar(valor,false);
                }
                else
                {
                    valor =  retornar(valor,true);
                }
            }
        });
    return valor;

}

/*se encarga de realizar el cambio de cabinas activas a inactivas*/
function resetValues()
{
    $('#reset').on('click',function()
    {
        $('#FechaMes').val("");
        $('#formCabina').val("");
        $('#FechaMes').val("");
    });
}




/*
* Clase encargada de generar los excel
*/
var excel=function()
{
    this.boton=null;
}
//metodo para generar excel de detalle
excel.prototype.detalle=function(boton, objeto, input, form)
{
    this.boton=$(boton);
    var objeto=$(objeto);
    var campo=$(input);
    var formulario=$(form);
    this.boton.on('click',function()
    {
        objeto.children('table').children('tbody').children().each(function()
        {
            if($(this).attr('class') == 'odd')
            {
                $(this).css('background','rgba(229,241,244,1)');
            }
            else
            {
                $(this).css('background','rgba(248,248,248,1)');
            }
        });
        campo.val($('<div>').append('<h1>'+$('.enviar').html()+'</h1>'+'<br>'+objeto.html()).html());
        formulario.submit();
    });
    
}

/*
* Clase encargada de enviar mail
*/
var mail=function()
{
    this.boton=null;
    this.objeto=null;
}
mail.prototype.panel=function(id)
{

}
//Metodo encargado de enviar mail en todas las vistas de reportes
mail.prototype.mail=function(boton, capa)
{
    this.boton=$(boton);
    this.objeto=$(capa);
    this.boton.on('click',function()
    {
        this.objeto.filter(function(){return $(this).css('display') == 'block'}).attr('id')
    });
}
function send_mail()
{
    $(".botonCorreo").click(function(event)
    {
        //Obtengo el id del gridview que va para el ecel
        var id=$('div[rel="total"]').filter(function(){return $(this).css('display') == "block" }).attr('id');
        if($('div[rel="total"]').filter(function(){return $(this).css('display') == "none" }).length)
        var id2=$('div[rel="total"]').filter(function(){return $(this).css('display') == "none" }).attr('id');
        if($("div#totales" ).length)
            var id3=$('div#totales').filter(function(){return $(this).css('display') == "block" }).attr('id');
        //le quito los links al thead
        noLink(id);
        //cambio el color del fondo
        fondo(id);
        if($("div#totales" ).length)
            fondo(id3);
        //le coloco los fondos a los resultados
        fila(id);
        if($("div#totales" ).length)
            fila(id3);
        $(".filters").remove();
        $(".button-column").remove();
        $("table.items input" ).attr('disabled','disabled');
        if($("div#totales" ).length)
            var html = "<h1>" + $(".enviar").clone().html() + "</h1>" + "<br/>"  + $("table.items" ).clone().html() + "<br/>" +$("div#totales" ).children().clone().html();
        else
            html = "<h1>" + $(".enviar").clone().html() + "</h1>" + "<br/>"  + $("table.items" ).clone().html();
        $("#html").val(html);
        $("#FormularioCorreo").submit();
        $.fn.yiiGridView.update(id);
        $.fn.yiiGridView.update(id2);
        alert('Correo Enviado');
    });
    $("img#enviar").click(function(event)
    {
        var html = $("div.enviar").clone().html();
        $("#html").val(html);
        $("#FormularioCorreo").submit();
        alert('Correo Enviado');
    });
}
function send_mail_panel()
{
    $(".botonCorreoPanel").click(function(event)
    {
        $("h1").children().remove();
        $(".filters").remove();
        var h1=$("h1").clone().html();
        var html = $("div#enviar").clone().html();
        var reglas = $("div#reglasCorreo").clone().html();
        var completo= "<h1>"+h1+"</h1>"+"<br/>"+html+"<br/>"+"<div>"+reglas+"</div>";
        $("#html").val(completo);
        $("#FormularioCorreo").submit();
        alert('Correo Enviado');
    });
}
function send_mail_detail()
{
    $(".botonCorreoDetail").click(function(event)
    {
        var id="detail";
        fila(id);
        var html = "<h1>"+ $(".enviar").clone().html() + "</h1>" + "<br/>" +$(".enviarTabla").clone().html();
        $("#html").val(html);
        $("#FormularioCorreo").submit();
        alert('Correo Enviado');
    });
}
