<?php
/* Smarty version 3.1.31, created on 2018-04-28 21:16:20
  from "/Users/Alvaro/Work/Web/Dev/views/clients.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ae52af4429b17_76707190',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '75991db85bfbdaa6ce169c3816742cadb5837a34' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Dev/views/clients.tpl',
      1 => 1524968179,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5ae52af4429b17_76707190 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layouts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('css'=>array('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')), 0, false);
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

            <div class="form-group daterange">
                <label>Periodo de fechas</label>
                <input type="hidden" name="date_from" value="<?php echo $_smarty_tpl->tpl_vars['fils']->value->date_from;?>
">
                <input type="hidden" name="date_to" value="<?php echo $_smarty_tpl->tpl_vars['fils']->value->date_to;?>
">
                <div class="btn btn-default">
                    <i class="fa fa-calendar"></i> &nbsp;
                    <span> </span>
                    <b class="fa fa-angle-down"></b>
                </div>
            </div>

            <div class="form-group">
                <label>Filtro</label>
                <div class="input-icon">
                    <i class="la la-search"></i>
                    <input class="form-control" name="word" value="<?php echo $_smarty_tpl->tpl_vars['fils']->value->word;?>
" placeholder="Buscar...">
                </div>
            </div>
            <div class="form-group">
                <label>Tipo de cliente</label>
                <select class="form-control" name="id_type_client" style="min-width:100px">
                    <option value="">Todos</option>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['type_clients']->value, 'o', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['o']->value) {
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['o']->value->id;?>
" <?php if ($_smarty_tpl->tpl_vars['fils']->value->id_type_client == $_smarty_tpl->tpl_vars['o']->value->id) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['o']->value->name;?>
</option>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                </select>
            </div>
            <div class="form-group">
                <label>Resultados</label>
                <select class="form-control" name="max" style="min-width:100px">
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
                    <th data-column="name"> Nombre / Razón social</th>
                    <th data-column="email" width="1%"> Email</th>
                    <th data-column="phone" width="1%"> Teléfono</th>
                    <th data-column="date_created" width="1%"> Fecha de creación</th>
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
        MClient.add(function () {
            Fils.goSortIDNocache();
        });
    }

    function clickEdit(index) {
        MClient.edit(Fils.data.items[index], function () {
            Fils.go(false);
        });
    }

    function $Ready() {

        MClient.onRemove = function () {
            Fils.go(false);
        };

        Fils.init('clients', data, function (item, i) {


            var html = '';
            html += '<tr>';
            html += '<td>' + item.id + '</td>';
            html += '<td>' + item.name + '</td>';
            html += '<td>' + item.email + '</td>';
            html += '<td>' + item.phone + '</td>';
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
        Fils.setupDaterange();
    }

    
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js','assets/js/fils.js','assets/js/m_client.js')), 0, false);
}
}
