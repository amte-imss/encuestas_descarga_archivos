
<?php
echo form_open($form_url, array('id' => 'form_custom_modulo'));
?>
<div class="row">
    <div class="form-group">
        <div class="col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon">Nombre:</span>
                <?php
                echo $this->form_complete->create_element(
                        array('id' => 'modulo',
                            'type' => 'text',
                            'attributes' => array('name' => 'modulo',
                                'class' => 'form-control  form-control input-sm',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'title' => 'Nombre')
                        )
                );
                ?>
            </div>
            <?php echo form_error_format('nombre'); ?>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm">
                <span class="input-group-addon">URL:</span>
                <?php
                echo $this->form_complete->create_element(
                        array('id' => 'url',
                            'type' => 'text',
                            'attributes' => array('name' => 'url',
                                'class' => 'form-control  form-control input-sm',
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'top',
                                'title' => 'url')
                        )
                );
                ?>
            </div>
            <?php echo form_error_format('url'); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="input-group input-group-sm">
            <span class="input-group-addon">Tipo:</span>
            <?php
            echo $this->form_complete->create_element(
                    array('id' => 'tipo',
                        'type' => 'dropdown',
                        'first' => array('' => 'Seleccione...'),
                        'options' => $configuradores,
                        'attributes' => array('name' => 'tipo',
                            'class' => 'form-control  form-control input-sm',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'tipo')
                    )
            );
            ?>
        </div>
        <?php echo form_error_format('tipo'); ?>
    </div>
    <div class="col-md-6">
        <div class="input-group input-group-sm">
            <span class="input-group-addon">Modulo padre:</span>
            <?php
            echo $this->form_complete->create_element(
                    array('id' => 'padre',
                        'type' => 'dropdown',
                        'first' => array('' => 'Seleccione...'),
                        'options' => $modulos_dropdown,
                        'attributes' => array('name' => 'padre',
                            'class' => 'form-control  form-control input-sm',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'padre')
                    )
            );
            ?>
        </div>
        <?php echo form_error_format('padre'); ?>
    </div>
</div>
<br>

<div class="row">

    <div class="row">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </div>
</div>



<?php echo form_close(); ?>
