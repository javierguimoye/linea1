<?php
/* Smarty version 3.1.31, created on 2018-04-28 21:15:09
  from "/Users/Alvaro/Work/Web/Dev/views/branches.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ae52aada10989_34036206',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b6e590711303a94a7dfc86f16a59d426b61b580d' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Dev/views/branches.tpl',
      1 => 1524968109,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5ae52aada10989_34036206 (Smarty_Internal_Template $_smarty_tpl) {
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
                <span class="btn btn-primary" onclick="clickAdd()">
                    <i class="fa fa-plus"></i> Nuevo
                </span>
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
                <select class="form-control" name="max" style="min-width:100px">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, array(5,10,20,50,100,200,500,1000), 'val', false, 'key');
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
                    <th data-column="name"> Nombre / Razón social</th>
                    <th data-column="address"> Dirección</th>
                    <th data-column="phone" width="1%"> Teléfono</th>
                    <th data-column="date_created" width="1%" class="nowrap"> Fecha de creación</th>
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

    

    function clickAdd() {
        MBranch.add(function () {
            Fils.goSortIDNocache();
        });
    }

    function clickEdit(index) {
        MBranch.edit(Fils.data.items[index], function () {
            Fils.go(false);
        });
    }

    function $Ready() {

        MBranch.onRemove = function () {
            Fils.go(false);
        };

        Fils.init('branches', data, function (item, i) {

            var html = '';
            html += '<tr>';
            html += '<td>' + item.id + '</td>';
            html += '<td>' + item.name + '</td>';
            html += '<td>' + item.address + '</td>';
            html += '<td class="nowrap">' + item.phone + '</td>';
            html += '<td class="nowrap">' + item.date_created.dateFormat() + '</td>';
            html += '<td>';
            if (stg.can_edit) {
                html += '<span onclick="clickEdit(' + i + ');" class="btn btn-round dark btn-sm mrg-0">';
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

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array('assets/js/fils.js','assets/js/m_branch.js')), 0, false);
}
}
