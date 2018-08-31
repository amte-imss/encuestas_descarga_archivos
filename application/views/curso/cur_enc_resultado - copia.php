<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid-theme.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.js"></script>

<?php
$mostrar_registros = [5, 10, 15, 20, 100];
$postutorizado = strpos($datos_curso[0]['nombre_curso'], 'utorizado');
$text_tutorizado = ($datos_curso[0]['tutorizado'] == '0') ? ' - No tutorizado' : ' - Tutorizado';
$nombre_curso = (is_numeric($postutorizado)) ? $datos_curso[0]['nombre_curso'] : $datos_curso[0]['nombre_curso'] . $text_tutorizado;
echo js("js_export/canvas-datagrid.js");
echo js("js_export/Blob.js");
echo js("js_export/FileSaver.js");
echo js("js_export/xlsx.full.min.js");
echo js("curso/reporte_encuestas.js");
?>

<?php echo $this->form_complete->create_element(array('id' => 'curso', 'type' => 'hidden', 'value' => $datos_curso[0]['cur_id'])); ?>
<div class="panel-heading clearfix breadcrumbs6">
    <h1><?php echo $datos_curso[0]['clave_curso'] . '-' . $nombre_curso; ?>
    </h1><br>
    <a href="<?php echo site_url('curso/info_curso/' . $datos_curso[0]['cur_id']); ?>" class="btn btn-info pull-right"> <span class="glyphicon glyphicon-level-up"></span> Regresar a detalle curso</a>
    <input class="btn btn-info pull-right" type="submit" value="Exportar reporte" id="xport" data-clavecurso ="<?php echo $datos_curso[0]['clave_curso']; ?>" onclick="export_xlsx_grid(this);">
</div>


<div class="col-sm-12">
    <div id="jsReporteEncuestas"></div>
</div>


