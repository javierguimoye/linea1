<?php
/* Smarty version 3.1.31, created on 2018-05-10 08:07:54
  from "/Users/Alvaro/Work/Web/Wabir-PMS/views/products_add.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5af4442a495541_78587892',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '58302083bbc6a7cd8bbe72be831c2e8bce676d42' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Wabir-PMS/views/products_add.tpl',
      1 => 1525957673,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5af4442a495541_78587892 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layouts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<form class="portlet light">

    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-dark bold uppercase"><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</span>
        </div>
        <div class="actions">
            <a class="btn btn-default uppercase" href="<?php echo $_smarty_tpl->tpl_vars['stg']->value->module;?>
">
                Cancelar
            </a>
            <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                <a class="btn btn-primary bold uppercase" onclick="save()">
                    <i class="fa fa-check"></i> Guardar
                </a>
            <?php }?>
        </div>
    </div>

    <div class="portlet-body">

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">
                    <label class="bold">Nombre <span class="font-red-mint">*</span></label>
                    <input name="name" class="form-control">
                </div>

                <div class="form-group">
                    <label class="bold">Descripción</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label class="bold">Código de barras <span class="font-red-mint">*</span></label>
                    <div class="input-group">
                        <input class="form-control" name="barcode">
                        <span class="input-group-addon btn btn-default tooltips" title="Generar código aleatorio">
                            <i class="fa fa-random font-dark"></i></span>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bold">Costo <span class="font-red-mint">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['stg']->value->coin;?>
</span>
                                <input name="cost" class="form-control" placeholder="0">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bold">Precio <span class="font-red-mint">*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['stg']->value->coin;?>
</span>
                                <input name="price" class="form-control" placeholder="0">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label class="bold">Categoría <span class="font-red-mint">*</span></label>
                    <select name="id_category" class="form-control">
                        <option value="">Elegir...</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="bold">Marca</label>
                    <select name="id_brand" class="form-control">
                        <option value="">Elegir...</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="bold">Unidad <span class="font-red-mint">*</span></label>
                    <select name="id_unit" class="form-control">
                        <option value="">Elegir...</option>
                    </select>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bold">Unidad de compra</label>
                            <select name="id_unit" class="form-control">
                                <option value="">Elegir...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bold">Unidad de venta</label>
                            <select name="id_unit" class="form-control">
                                <option value="">Elegir...</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label class="bold">
                        <input type="checkbox"> Es un combo
                    </label>
                </div>


            </div>

            <div class="col-md-6">
                RR
            </div>

        </div>

    </div>

</form>

<?php echo '<script'; ?>
>
    var item = <?php echo json_encode($_smarty_tpl->tpl_vars['item']->value);?>
;

    

    function save() {

    }

    function $Ready() {

    }
    
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array()), 0, false);
}
}
