$(document).ready(function () {

});

function export_xlsx_volumetria(element) {
    var tipo = $(element).data("tiporeport");
    console.log(tipo);
    $.ajax({
        type: "POST",
        url: site_url + "/operaciones/get_opciones_descarga/" + tipo,
        data: {anio: $("#anio").val()},
        dataType: "json"
    })
            .done(function (result) {
                console.log(result);
                var name_file = 'Volumetria_' + $("#anio").val() + ".xls";
                export_xlsx(result.data, result.head, name_file, 'volumetri');
            });
}

var XLSX;
function export_xlsx(data, cabeceras, nombre_file, nombre_libro_excel) {
    var auxdata = prep_objetc(data, cabeceras);
//    console.log(auxdata);
    var new_ws = XLSX.utils.aoa_to_sheet(auxdata);

    /* build workbook */
    var new_wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(new_wb, new_ws, nombre_libro_excel);

    /* write file and trigger a download */
    var wbout = XLSX.write(new_wb, {bookType: 'xlsx', bookSST: true, type: 'binary'});
    var fname = nombre_file;
    try {
        saveAs(new Blob([s2ab(wbout)], {type: "application/octet-stream"}), fname);
    } catch (e) {
        if (typeof console != 'undefined')
            console.log(e, wbout);
    }
}

function prep_objetc(arr) {
    var out = [];
    var init = 0;

    var valor;
    var cabeceras = null;
    if (arguments.length === 2) {//Prepara los datos extra que se enviarán por post
        cabeceras = arguments[1];
        var aux_cabeceras = [];
        Object.keys(cabeceras).forEach(function (c, index) {
            aux_cabeceras[index] = cabeceras[c];
        });
        out[init] = aux_cabeceras;
        init++;
    }
//    console.log(arr[6]);
    for (var i = 0; i < arr.length; ++i) {
        if (!arr[i])
            continue;
        valor = arr[i];
        if (typeof valor === 'object') {
            var auxarr = [];
            Object.keys(cabeceras).forEach(function (c, index) {
                auxarr[index] = valor[c];
            });
//            console.log(auxarr);
            out[(i + init)] = auxarr;
//            console.log(auxarr);
            continue;
        }
    }
//    console.log(out);
    return out;

}

function prep(arr) {
    var out = [];
    var valor;
    var cabeceras = null;
    if (arguments.length === 2) {//Prepara los datos extra que se enviarán por post
        cabeceras = arguments[1];
    }
//    console.log(arr[6]);
    for (var i = 0; i < arr.length; ++i) {
        if (!arr[i])
            continue;
//        if (Array.isArray(arr[i])) {
        valor = arr[i];
        if (Array.isArray(valor)) {
//            console.log(arr[i]);
            out[i] = valor;
            continue;
        }

        var o = new Array();
        Object.keys(arr[i]).forEach(function (k) {
            o[+k] = arr[i][k]
        });
        out[i] = o;
    }
//    console.log(out);

    return out;
}

function s2ab(s) {
    var b = new ArrayBuffer(s.length), v = new Uint8Array(b);
    for (var i = 0; i != s.length; ++i)
        v[i] = s.charCodeAt(i) & 0xFF;
    return b;
}