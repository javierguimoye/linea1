<?php
/* Smarty version 3.1.31, created on 2018-05-06 01:44:20
  from "/Users/Alvaro/Work/Web/Wabir-PMS/views/logs.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5aeea4441ded14_04517940',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd4773e28768a62bb34417b634fe960abae0253e6' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Wabir-PMS/views/logs.tpl',
      1 => 1525589059,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5aeea4441ded14_04517940 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layouts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('css'=>array('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')), 0, false);
?>


<div class="portlet light">

    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-dark bold uppercase"><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</span>
        </div>
        <div class="actions"></div>
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
                <label>Usuario</label>
                <div class="input-icon">
                    <i class="la la-user"></i>
                    <input class="form-control" name="word" value="" placeholder="Buscar...">
                </div>
            </div>
            <div class="form-group">
                <label>Tipo de log</label>
                <select class="form-control" name="type" style="min-width:100px">
                    <option value="">Todos</option>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['types']->value, 'o', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['o']->value) {
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['fils']->value->type == $_smarty_tpl->tpl_vars['i']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['o']->value;?>
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
                    <th></th>
                    <th data-column="date_created" width="1%">Fecha</th>
                    <th width="1%"> Ref.</th>
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

    

    function $Ready() {

        var types = {
            1: {title: 'inició sesión', clazz: 'bg-blue'},
            2: {title: 'cerró sesión', clazz: 'bg-yellow-mint'},
            3: {title: 'agregó', clazz: 'bg-green-seagreen'},
            4: {title: 'modificó', clazz: 'bg-yellow-gold'},
            5: {title: 'eliminó', clazz: 'bg-red-mint'}
        };

        Fils.init(stg.module, data, function (item, i) {

            var type = types[item.type];

            var html = '';
            html += '<tr>';
            html += ' <td>' + item.id + '</td>';
            html += ' <td>';
            html += '  ' + item.us_name + ' ' + item.us_surname;
            html += '  <span class="badge ' + type.clazz + '" style="height:14px;padding:1px 4px">' + type.title + '</span> ';
            html += '  ' + item.target;
            html += ' </td>';
            html += ' <td class="nowrap">' + item.date_created.dateFormat() + '</td>';
            html += ' <td class="nowrap">' + item.id_ref + '</td>';
            html += '</tr>';

            return html;
        });
        Fils.setupDaterange();
    }

    
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js','assets/js/fils.js')), 0, false);
}
}
