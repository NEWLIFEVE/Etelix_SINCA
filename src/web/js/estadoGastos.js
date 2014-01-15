$(document).ready(function() {
   

$("input[class='Pagada']:checked").each(function() {
        $(this).parents("tr:first").find("input[id^='NumeroTransferencia_']").removeAttr("disabled");
        $(this).parents("tr:first").find("select[id^='Cuenta_']").removeAttr("disabled");
        $(this).parents("tr:first").find("input[id^='FechaTransferencia_']").removeAttr("disabled");
        $(this).parents("tr:first").find("input[id^='FechaTransferencia_']").attr('readonly', 'readonly');
    });
    $("input[id^='status_'].OrdenDePago").click(function() {
        $(this).parents("tr:first").find("input[id^='NumeroTransferencia_']").attr('disabled', 'disabled');
        $(this).parents("tr:first").find("select[id^='Cuenta_']").attr('disabled', 'disabled');
        $(this).parents("tr:first").find("input[id^='FechaTransferencia_']").attr('disabled', 'disabled');
    });
    $("input[id^='status_'].Aprobada").click(function() {
        $(this).parents("tr:first").find("input[id^='NumeroTransferencia_']").attr('disabled', 'disabled');
        $(this).parents("tr:first").find("select[id^='Cuenta_']").attr('disabled', 'disabled');
        $(this).parents("tr:first").find("input[id^='FechaTransferencia_']").attr('disabled', 'disabled');
    });
    $("input[id^='status_'].Pagada").click(function() {
        $(this).parents("tr:first").find("input[id^='NumeroTransferencia_']").removeAttr("disabled");
        $(this).parents("tr:first").find("select[id^='Cuenta_']").removeAttr("disabled");
        $(this).parents("tr:first").find("input[id^='FechaTransferencia_']").removeAttr("disabled");
        $(this).parents("tr:first").find("input[id^='FechaTransferencia_']").attr('readonly', 'readonly');
    });
    $("input[id^='FechaTransferencia_']").each(function() {
        if ($(this).val().length) {
            if ($(this).click()) {
                $(this).datepicker({
                    dateFormat: 'dd/mm/yy'
                });
            }
        }
        else {
            $(this).datepicker();
            $(this).datepicker("option", "dateFormat", "dd/mm/yy");
        }
    });
    $("input[id='habilitarStatus']").click(function() {
        if ($("input[id='habilitarStatus']").prop("checked")) {
            $("input[id^='rbtnStatus_']").removeAttr("disabled");
        }
        else {
            $("input[id^='rbtnStatus_']").prop("checked", false);
            $("input[id^='rbtnStatus_']").attr('disabled', 'disabled');
        }
    });
    
    
    $("#convertir").click(function() {

        $("input[id^='status_']").each(function() {
            if ($(this).prop("checked")) {
                var clase = $(this).attr('class');
                if (clase == "OrdenDePago") {
                    var padre = $(this).parents("tr:first");
                    padre.find("input[id^='status_'].OrdenDePago").replaceWith('<strong>Completado</strong>');
                    padre.find("input[id^='status_'].Aprobada").replaceWith('<span style="color:red;">En espera<span>');
                    padre.find("input[id^='status_'].Pagada").replaceWith('<span style="color:red;">En espera<span>');
                }
                else if (clase == "Aprobada") {
                    var padre = $(this).parents("tr:first");
                    padre.find("input[id^='status_'].OrdenDePago").replaceWith('<strong>Completado</strong>');
                    padre.find("input[id^='status_'].Aprobada").replaceWith('<strong>Completado</strong>');
                    padre.find("input[id^='status_'].Pagada").replaceWith('<span style="color:red;">En espera<span>');
                }
                else if (clase == "Pagada") {
                    var padre = $(this).parents("tr:first");
                    padre.find("input[id^='status_'].OrdenDePago").replaceWith('<strong>Completado</strong>');
                    padre.find("input[id^='status_'].Aprobada").replaceWith('<strong>Completado</strong>');
                    padre.find("input[id^='status_'].Pagada").replaceWith('<strong>Completado</strong>');
                }
            }
        });
        $("input[id^='NumeroTransferencia_']").each(function() {
            var contenido = $(this).val();
            if (contenido == "" || contenido == NULL) {
                var padre = $(this).parents("tr:first");
                padre.find("td").attr('style', 'text-align: center;');
                padre.find("input[id^='NumeroTransferencia_']").replaceWith('<strong>No definido</strong>');
            }
            else {
                var padre = $(this).parents("tr:first");
                padre.find("td").attr('style', 'text-align: center;');
                padre.find("input[id^='NumeroTransferencia_']").replaceWith(contenido);
            }
        });
        $("input[id^='FechaTransferencia_']").each(function() {
            var contenido = $(this).val();
            if (contenido == "" || contenido == NULL) {
                var padre = $(this).parents("tr:first");
                padre.find("td").attr('style', 'text-align: center;');
                padre.find("input[id^='FechaTransferencia_']").replaceWith('<strong>No definido</strong>');
            }
            else {
                var padre = $(this).parents("tr:first");
                padre.find("td").attr('style', 'text-align: center;');
                padre.find("input[id^='FechaTransferencia_']").replaceWith(contenido);
            }
        });
        $("select[id^='Cuenta_']").each(function() {
            var contenido = $(this).val();
            if (contenido == "" || contenido == NULL) {
                var padre = $(this).parents("tr:first");
                padre.find("td").attr('style', 'text-align: center;');
                padre.find("select[id^='Cuenta_']").replaceWith('<strong>No definido</strong>');
            }
            else {
                var padre = $(this).parents("tr:first");
                padre.find("td").attr('style', 'text-align: center;');
                padre.find("select[id^='Cuenta_']").replaceWith(contenido);
            }
        });

    });

});

$(document).ajaxStop(function() {
    $("input[class='Pagada']:checked").each(function() {
        $(this).parents("tr:first").find("input[id^='NumeroTransferencia_']").removeAttr("disabled");
        $(this).parents("tr:first").find("select[id^='Cuenta_']").removeAttr("disabled");
        $(this).parents("tr:first").find("input[id^='FechaTransferencia_']").removeAttr("disabled");
        $(this).parents("tr:first").find("input[id^='FechaTransferencia_']").attr('readonly', 'readonly');
    });
    $("input[id^='status_'].OrdenDePago").click(function() {
        $(this).parents("tr:first").find("input[id^='NumeroTransferencia_']").attr('disabled', 'disabled');
        $(this).parents("tr:first").find("select[id^='Cuenta_']").attr('disabled', 'disabled');
        $(this).parents("tr:first").find("input[id^='FechaTransferencia_']").attr('disabled', 'disabled');
    });
    $("input[id^='status_'].Aprobada").click(function() {
        $(this).parents("tr:first").find("input[id^='NumeroTransferencia_']").attr('disabled', 'disabled');
        $(this).parents("tr:first").find("select[id^='Cuenta_']").attr('disabled', 'disabled');
        $(this).parents("tr:first").find("input[id^='FechaTransferencia_']").attr('disabled', 'disabled');
    });
    $("input[id^='status_'].Pagada").click(function() {
        $(this).parents("tr:first").find("input[id^='NumeroTransferencia_']").removeAttr("disabled");
        $(this).parents("tr:first").find("select[id^='Cuenta_']").removeAttr("disabled");
        $(this).parents("tr:first").find("input[id^='FechaTransferencia_']").removeAttr("disabled");
        $(this).parents("tr:first").find("input[id^='FechaTransferencia_']").attr('readonly', 'readonly');
    });
    $("input[id^='FechaTransferencia_']").each(function() {
        if ($(this).val().length) {
            if ($(this).click()) {
                $(this).datepicker({
                    dateFormat: 'dd/mm/yy'
                });
            }
        }
        else {
            $(this).datepicker();
            $(this).datepicker("option", "dateFormat", "dd/mm/yy");
        }
    });
    $("input[id='habilitarStatus']").click(function() {
        if ($("input[id='habilitarStatus']").prop("checked")) {
            $("input[id^='rbtnStatus_']").removeAttr("disabled");
        }
        else {
            $("input[id^='rbtnStatus_']").prop("checked", false);
            $("input[id^='rbtnStatus_']").attr('disabled', 'disabled');
        }
    });
    
    
    $("#convertir").click(function() {

        $("input[id^='status_']").each(function() {
            if ($(this).prop("checked")) {
                var clase = $(this).attr('class');
                if (clase == "OrdenDePago") {
                    var padre = $(this).parents("tr:first");
                    padre.find("input[id^='status_'].OrdenDePago").replaceWith('<strong>Completado</strong>');
                    padre.find("input[id^='status_'].Aprobada").replaceWith('<span style="color:red;">En espera<span>');
                    padre.find("input[id^='status_'].Pagada").replaceWith('<span style="color:red;">En espera<span>');
                }
                else if (clase == "Aprobada") {
                    var padre = $(this).parents("tr:first");
                    padre.find("input[id^='status_'].OrdenDePago").replaceWith('<strong>Completado</strong>');
                    padre.find("input[id^='status_'].Aprobada").replaceWith('<strong>Completado</strong>');
                    padre.find("input[id^='status_'].Pagada").replaceWith('<span style="color:red;">En espera<span>');
                }
                else if (clase == "Pagada") {
                    var padre = $(this).parents("tr:first");
                    padre.find("input[id^='status_'].OrdenDePago").replaceWith('<strong>Completado</strong>');
                    padre.find("input[id^='status_'].Aprobada").replaceWith('<strong>Completado</strong>');
                    padre.find("input[id^='status_'].Pagada").replaceWith('<strong>Completado</strong>');
                }
            }
        });
        $("input[id^='NumeroTransferencia_']").each(function() {
            var contenido = $(this).val();
            if (contenido == "" || contenido == NULL) {
                var padre = $(this).parents("tr:first");
                padre.find("td").attr('style', 'text-align: center;');
                padre.find("input[id^='NumeroTransferencia_']").replaceWith('<strong>No definido</strong>');
            }
            else {
                var padre = $(this).parents("tr:first");
                padre.find("td").attr('style', 'text-align: center;');
                padre.find("input[id^='NumeroTransferencia_']").replaceWith(contenido);
            }
        });
        $("input[id^='FechaTransferencia_']").each(function() {
            var contenido = $(this).val();
            if (contenido == "" || contenido == NULL) {
                var padre = $(this).parents("tr:first");
                padre.find("td").attr('style', 'text-align: center;');
                padre.find("input[id^='FechaTransferencia_']").replaceWith('<strong>No definido</strong>');
            }
            else {
                var padre = $(this).parents("tr:first");
                padre.find("td").attr('style', 'text-align: center;');
                padre.find("input[id^='FechaTransferencia_']").replaceWith(contenido);
            }
        });
        $("select[id^='Cuenta_']").each(function() {
            var contenido = $(this).val();
            if (contenido == "" || contenido == NULL) {
                var padre = $(this).parents("tr:first");
                padre.find("td").attr('style', 'text-align: center;');
                padre.find("select[id^='Cuenta_']").replaceWith('<strong>No definido</strong>');
            }
            else {
                var padre = $(this).parents("tr:first");
                padre.find("td").attr('style', 'text-align: center;');
                padre.find("select[id^='Cuenta_']").replaceWith(contenido);
            }
        });
    });
});


// ***************** Establacer idioma DatePicker - INICIO *********************//

/*
$(function($) {
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi�rcoles', 'Jueves', 'Viernes', 'S�bado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mi�', 'Juv', 'Vie', 'S�b'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S�'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
});*/

// ***************** Establacer idioma DatePicker - FIN ************************//