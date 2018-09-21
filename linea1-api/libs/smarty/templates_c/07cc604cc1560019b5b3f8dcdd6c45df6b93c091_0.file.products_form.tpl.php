<?php
/* Smarty version 3.1.31, created on 2018-05-12 19:25:03
  from "/Users/Alvaro/Work/Web/Wabir-PMS/views/products_form.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5af785df69bbe8_57443268',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '07cc604cc1560019b5b3f8dcdd6c45df6b93c091' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Wabir-PMS/views/products_form.tpl',
      1 => 1526171085,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5af785df69bbe8_57443268 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layouts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('css'=>array('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css','assets/global/plugins/bootstrap-summernote/summernote.css','assets/global/plugins/select2/css/select2.min.css','assets/global/plugins/select2/css/select2-bootstrap.min.css')), 0, false);
?>


<form class="portlet light" id="form">
    <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['item']->value->id;?>
">

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
                <button class="btn btn-primary bold uppercase">
                    <i class="fa fa-check"></i> Guardar
                </button>
            <?php }?>
        </div>
    </div>

    <div class="portlet-body">

        <div class="row">

            <div class="col-sm-6">

                <div class="row">

                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="bold">Tipo de producto <span class="font-red-mint">*</span></label>
                            <select name="type" class="form-control">
                                <option value="1">Estandar</option>
                                <option value="2">Combo</option>
                                <option value="3">Con presentaciones</option>
                                <option value="3">Con insumos</option>
                                <option value="3">Insumo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="bold">Código <span class="font-red-mint">*</span></label>
                            <div class="input-group">
                                <input class="form-control" name="code" value="<?php echo $_smarty_tpl->tpl_vars['item']->value->code;?>
">
                                <a class="input-group-addon btn btn-default tooltips" title="Generar código aleatorio"
                                   data-placement="left"><i class="fa fa-random font-dark"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="bold">Nombre <span class="font-red-mint">*</span></label>
                    <input name="name" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['item']->value->name;?>
">
                </div>

                <div class="row">

                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="bold">Categoría <span class="font-red-mint">*</span></label>
                            <select name="id_category" class="form-control select2">
                                <option value="">Elegir...</option>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'o');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['o']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['o']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['item']->value->id_category == $_smarty_tpl->tpl_vars['o']->value->id) {?>selected<?php }?>>
                                        <?php echo str_repeat('—',$_smarty_tpl->tpl_vars['o']->value->level);?>
 <?php echo $_smarty_tpl->tpl_vars['o']->value->name;?>

                                    </option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="bold">Marca</label>
                            <select name="id_brand" class="form-control select2">
                                <option value="">Elegir...</option>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['brands']->value, 'o');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['o']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['o']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['item']->value->id_brand == $_smarty_tpl->tpl_vars['o']->value->id) {?>selected<?php }?>>
                                        <?php echo $_smarty_tpl->tpl_vars['o']->value->name;?>

                                    </option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                            </select>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="bold">Unidad <span class="font-red-mint">*</span></label>
                            <select name="id_unit" class="form-control">
                                <option value="">Elegir...</option>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['units']->value, 'o');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['o']->value) {
?>
                                    <?php if ($_smarty_tpl->tpl_vars['o']->value->id_unit == 0) {?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['o']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['o']->value->id == $_smarty_tpl->tpl_vars['item']->value->id_unit) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['o']->value->name;?>

                                            (<?php echo $_smarty_tpl->tpl_vars['o']->value->code;?>
)
                                        </option>
                                    <?php }?>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="bold">Stock mínimo</label>
                            <input class="form-control touchspin" name="min_stock" value="<?php echo $_smarty_tpl->tpl_vars['item']->value->min_stock;?>
" placeholder="0"
                                   data-verticalbuttons="true" data-max="999999" style="border-radius:4px 0 0 4px">
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bold">Unidad de compra</label>
                            <select name="id_unit_buy" class="form-control"></select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bold">Unidad de venta</label>
                            <select name="id_unit_sell" class="form-control"></select>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bold">Costo <span class="font-red-mint">*</span></label>
                            <input class="form-control touchspin" name="cost" value="<?php echo $_smarty_tpl->tpl_vars['item']->value->cost;?>
" placeholder="0.00"
                                   data-verticalbuttons="true" data-prefix="<?php echo $_smarty_tpl->tpl_vars['stg']->value->coin;?>
" data-max="999999"
                                   data-decimals="2" data-step="0.50">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="bold">Precio <span class="font-red-mint">*</span></label>
                            <input class="form-control touchspin" name="price" value="<?php echo $_smarty_tpl->tpl_vars['item']->value->price;?>
" placeholder="0.00"
                                   data-verticalbuttons="true" data-prefix="<?php echo $_smarty_tpl->tpl_vars['stg']->value->coin;?>
" data-max="999999"
                                   data-decimals="2" data-step="0.50">
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label class="bold">Proveedor</label>
                    <select name="id_provider" class="form-control select2-ajax">
                        <?php if (!empty($_smarty_tpl->tpl_vars['item']->value->provider_name)) {?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value->id_provider;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value->provider_name;?>
</option>
                        <?php }?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="bold">Detalles del producto</label>
                    <textarea name="details" class="form-control summernote"><?php echo $_smarty_tpl->tpl_vars['item']->value->details;?>
</textarea>
                </div>

                <div class="form-group">
                    <div>
                        <label class="bold">
                            <input type="checkbox" name="featured" value="1" <?php if ($_smarty_tpl->tpl_vars['item']->value->featured == 1) {?>checked<?php }?>>
                            Producto estacado
                            <i class="fa fa-question-circle-o font-grey-salsa tooltips"
                               title="Se agrega en la pantalla principal del POS"></i>
                        </label>
                    </div>
                </div>

            </div>

            <div class="col-sm-6">
                RR
            </div>

        </div>

    </div>

</form>

<?php echo '<script'; ?>
>
    var item = <?php echo json_encode($_smarty_tpl->tpl_vars['item']->value);?>
;
    var units = <?php echo json_encode($_smarty_tpl->tpl_vars['units']->value);?>
;

    function $Ready() {

        MProduct.init();

    }
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js','assets/global/plugins/bootstrap-summernote/summernote.min.js','assets/global/plugins/select2/js/select2.full.min.js','assets/js/m_product.js')), 0, false);
}
}
