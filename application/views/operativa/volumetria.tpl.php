<div class="list-group-item">
    <label for="descripcion_encuestas">Año:</label>
    <?php echo $this->form_complete->create_element(array('id' => 'anio', 'type' => 'dropdown', 'options' => null, 'value' => '', 'first' => array('' => 'Seleccione opción'), 'attributes' => array('name' => 'anio', 'class' => 'form-control', 'placeholder' => 'Año', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Año'))); ?>
    <span class="text-danger"> <?php echo form_error('eva_tipo', '', ''); ?> </span>
    <p class="help-block"></p>
</div>


<a href="<?php echo site_url('operaciones/cargar_implementaciones'); ?>" class="btn btn-primary pull-right"> Descargar CSV de volumetría</a>

<div class="clearfix"></div>

<?php
$this->config->load('general');
$tipo_msg = $this->config->item('alert_msg');
?>
