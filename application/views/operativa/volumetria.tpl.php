<?php
echo js("js_export/canvas-datagrid.js");
echo js("js_export/Blob.js");
echo js("js_export/FileSaver.js");
echo js("js_export/xlsx.full.min.js");
?>
<div class="header">
    Módulo de descarga de la volumetría de los cursos e implementaciónes en la DIE
</div><br>

<div class="list-group-item">
    <label for="descripcion_encuestas">Año:</label>
    <?php echo $this->form_complete->create_element(array('id' => 'anio', 'type' => 'dropdown', 'options' => dropdown_options($data_elements['years_course'], 'year_course', 'year_course'), 'value' => '', 'first' => array('' => 'Seleccione opción'), 'attributes' => array('name' => 'anio', 'class' => 'form-control', 'placeholder' => 'Año', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Año'))); ?>
    <span class="text-danger"> <?php echo form_error('anio', '', ''); ?> </span>
    <p class="help-block"></p>
    <div class="col-md-3 text-right">
        <input class="btn btn-moodle" type="submit" value="Exportar XLS" id="xport" data-tiporeport="<?php echo $config['reporte_volumetria_anio']; ?> " data-namegrid="jsReporteEncuestas" onclick="export_xlsx_volumetria(this);">
    </div>
</div>

<div class="clearfix"></div>
<?php
echo js("Descarga_operativa/control_descarga_operativa.js");
?>

