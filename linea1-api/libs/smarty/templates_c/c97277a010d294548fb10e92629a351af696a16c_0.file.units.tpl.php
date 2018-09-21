<?php
/* Smarty version 3.1.31, created on 2018-05-10 07:08:30
  from "/Users/Alvaro/Work/Web/Wabir-PMS/views/units.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5af4363e405548_29626528',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c97277a010d294548fb10e92629a351af696a16c' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Wabir-PMS/views/units.tpl',
      1 => 1525954109,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5af4363e405548_29626528 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layouts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="portlet light medi">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-dark bold uppercase"><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</span>
        </div>
        <div class="actions">
            <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                <a class="btn btn-primary" onclick="MUnit.add();">
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
                    <th width="1%"><div class="tooltips" title="Código">Cod.</div></th>
                    <th> Nombre</th>
                    <th> <span class="tooltips" title="Unidad base">U. base</span></th>
                    <th width="1%"> <span class="tooltips" title="Operador">Op.</span></th>
                    <th width="1%"> <span class="tooltips" title="Valor de operación">Val.</span></th>
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
                            <td><?php echo sprintf('%03d',$_smarty_tpl->tpl_vars['m']->value->id);?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['m']->value->code;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['m']->value->name;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['m']->value->un2_name;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['m']->value->operator;?>
</td>
                            <td align="right"><?php echo $_smarty_tpl->tpl_vars['m']->value->value;?>
</td>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                                    <span class="btn dark btn-sm mrg-0" onclick="MUnit.edit(items[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
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

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array('assets/js/m_unit.js')), 0, false);
}
}
