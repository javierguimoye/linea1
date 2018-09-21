<?php
/* Smarty version 3.1.31, created on 2018-05-04 19:35:32
  from "/Users/Alvaro/Work/Web/Wabir-PMS/views/printers.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5aecfc54248b83_93323993',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4a1e06a2597f2cee22ef99a8eadd2f89c24f07d5' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Wabir-PMS/views/printers.tpl',
      1 => 1524968459,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5aecfc54248b83_93323993 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/Users/Alvaro/Work/Web/wabir-pms/vendor/smarty/smarty/libs/plugins/modifier.date_format.php';
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
                <a class="btn btn-primary" onclick="MPrinter.add();">
                    <i class="fa fa-plus"></i> Nuevo
                </a>
            <?php }?>
        </div>
    </div>

    <div class="portlet-body fils">

        <div class="table-responsive">
            <table class="table table-bordered table-striped mdl-td fils_table">
                <thead>
                <tr>
                    <th width="1%">#</th>
                    <th> Nombre</th>
                    <th> IP</th>
                    <th> Nº Serie</th>
                    <th> Nº Autorización</th>
                    <th> Letras</th>
                    <th width="1%" class="nowrap">Fecha de creación</th>
                    <th width="1%"></th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($_smarty_tpl->tpl_vars['items']->value)) {?>
                    <tr>
                        <td colspan="100%">
                            <div class="alert alert-warning mrg-5">No hay datos disponibles para mostrar.</div>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['items']->value, 'm', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['m']->value) {
?>
                        <tr>
                            <td width="1%"><?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['m']->value->name;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['m']->value->ip;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['m']->value->serial;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['m']->value->authorization;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['m']->value->num_letters;?>
</td>
                            <td class="nowrap"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['m']->value->date_created,"%d/%m/%Y %I:%M %p");?>
</td>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                                    <span class="btn dark btn-sm mrg-0" onclick="MPrinter.edit(items[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
]);">
                                        <i class="fa fa-pencil"></i>
                                    </span>
                                <?php }?>
                            </td>
                        </tr>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                <?php }?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array('assets/js/m_printer.js')), 0, false);
}
}
