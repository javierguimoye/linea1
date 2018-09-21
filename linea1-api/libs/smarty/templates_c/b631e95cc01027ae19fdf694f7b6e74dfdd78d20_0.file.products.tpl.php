<?php
/* Smarty version 3.1.31, created on 2018-05-12 19:40:19
  from "/Users/Alvaro/Work/Web/Wabir-PMS/views/products.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5af7897325c177_22777297',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b631e95cc01027ae19fdf694f7b6e74dfdd78d20' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Wabir-PMS/views/products.tpl',
      1 => 1526172018,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5af7897325c177_22777297 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layouts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="portlet light">

    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-dark bold uppercase"><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</span>
        </div>
        <div class="actions">
            <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                <a class="btn btn-primary" href="<?php echo $_smarty_tpl->tpl_vars['stg']->value->module;?>
/form">
                    <i class="fa fa-plus"></i> Nuevo
                </a>
            <?php }?>
        </div>
    </div>

    <div class="portlet-body clearfix fils">
        <form class="form-inline fils_form">

            <input type="hidden" name="page" value="<?php echo $_smarty_tpl->tpl_vars['fils']->value->page;?>
">
            <input type="hidden" name="sort" value="<?php echo $_smarty_tpl->tpl_vars['fils']->value->sort;?>
">
            <input type="hidden" name="sort_by" value="<?php echo $_smarty_tpl->tpl_vars['fils']->value->sort_by;?>
">

            <div class="form-group">
                <label>Filtro</label>
                <div class="input-icon">
                    <i class="la la-search"></i>
                    <input class="form-control" name="word" value="<?php echo $_smarty_tpl->tpl_vars['fils']->value->word;?>
" placeholder="Buscar...">
                </div>
            </div>
            <div class="form-group">
                <label>Resultados</label>
                <select class="form-control" name="max" style="min-width:75px">
                    <?php $_smarty_tpl->_assignInScope('maxs', array(5,10,20,50,100,200,500,1000));
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['maxs']->value, 'val', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['fils']->value->max == $_smarty_tpl->tpl_vars['val']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                </select>
            </div>
            <div class="form-group">
                <label>&nbsp;</label>
                <button class="btn btn-default reset" type="button">Reiniciar</button>
                <button class="btn btn-primary">Aplicar</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-striped mdl-td nowrap-th fils_table">
                <thead>
                <tr class="columns noselect">
                    <th data-column="id" width="1%"> #</th>
                    <th data-column="code" width="1%"> Código</th>
                    <th data-column="name"> Nombre</th>
                    <th data-column="id_category"> Categoría</th>
                    <th data-column="cost" width="1%"> Costo</th>
                    <th data-column="price" width="1%"> Precio</th>
                    <th data-column="unit_name" width="1%"> Unidad</th>
                    <th width="1%"> Stock</th>
                    <th width="1%"></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="fils_pager"></div>

    </div>

</div>

<?php echo '<script'; ?>
>
    var data = <?php echo json_encode($_smarty_tpl->tpl_vars['fils']->value);?>
;

    

    function clickRemove() {
        Fils.go(false);
    }

    function $Ready() {

        Fils.init(stg.module, data, function (item, i) {

            var html = '';
            html += '<tr>';
            html += '<td>' + item.id + '</td>';
            html += '<td>' + item.code + '</td>';
            html += '<td>' + item.name + '</td>';
            html += '<td>' + item.category_name + '</td>';
            html += '<td class="nowrap">' + stg.coin + num(item.cost, 2) + '</td>';
            html += '<td class="nowrap">' + stg.coin + num(item.price, 2) + '</td>';
            html += '<td class="nowrap">' + item.unit_name + '</td>';
            html += '<td class="nowrap">' + item.stock + '</td>';
            html += '<td>';
            if (stg.can_edit) {
                html += '<a href="' + stg.module + '/' + item.id + '/form" class="btn btn-round dark btn-sm mrg-0">';
                html += '  <i class="fa fa-pencil"></i>';
                html += '</span>';
            }
            html += '</td>';
            html += '</tr>';

            return html;
        });
    }
    
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array('assets/js/fils.js')), 0, false);
}
}
