<?php
/* Smarty version 3.1.31, created on 2018-05-04 16:42:49
  from "/Users/Alvaro/Work/Web/Wabir-PMS/views/roles.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5aecd3d9d43498_41586565',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fa52ec376161bf47500930b6a4406d7154a50c02' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Wabir-PMS/views/roles.tpl',
      1 => 1524968428,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5aecd3d9d43498_41586565 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->_tplFunction->registerTplFunctions($_smarty_tpl, array (
  'mkMenu3' => 
  array (
    'compiled_filepath' => '/Users/Alvaro/Work/Web/Wabir-PMS/libs/smarty/templates_c/fa52ec376161bf47500930b6a4406d7154a50c02_0.file.roles.tpl.php',
    'uid' => 'fa52ec376161bf47500930b6a4406d7154a50c02',
    'call_name' => 'smarty_template_function_mkMenu3_19287661645aecd3d9ca83c9_61586596',
  ),
));
if (!is_callable('smarty_modifier_date_format')) require_once '/Users/Alvaro/Work/Web/wabir-pms/vendor/smarty/smarty/libs/plugins/modifier.date_format.php';
$_smarty_tpl->_subTemplateRender('file:layouts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="portlet light mini">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-dark bold uppercase"><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</span>
        </div>
        <div class="actions">
            <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                <a class="btn btn-primary" onclick="MRole.add();">
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
                    <th width="1%">Fecha de creación</th>
                    <th width="1%"></th>
                </tr>
                </thead>
                <tbody>
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
                        <td class="nowrap"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['m']->value->date_created,"%d/%m/%Y %I:%M %p");?>
</td>
                        <td>
                            <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                                <span class="btn dark btn-sm mrg-0" onclick="MRole.edit(items[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
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

                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modal_add_level" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">---</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal">
                    <input type="hidden" name="action" value="add_level">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nombre</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" placeholder="Escribir...">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Permisos</label>
                        <div class="col-md-10">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="vertical-align:middle">Modulo</th>
                                    <th width="1%"> Leer</th>
                                    <th width="1%"> Editar</th>
                                    <th rowspan="2" class="ctr" style="vertical-align:middle"><i class="fa fa-home"></i>
                                    </th>
                                    <th rowspan="2" class="ctr" style="vertical-align:middle"><i
                                                class="fa fa-hand-o-up"></i></th>
                                </tr>
                                <tr>
                                    <th class="ctr"><input type="checkbox" class="tooltips see"
                                                           title="Marcar&nbsp;/&nbsp;desmarcar&nbsp;todo"></th>
                                    <th class="ctr"><input type="checkbox" class="tooltips edit"
                                                           title="Marcar&nbsp;/&nbsp;desmarcar&nbsp;todo"></th>
                                </tr>
                                </thead>
                                <tbody class="levels">


                                
                                <?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'mkMenu3', array('data'=>$_smarty_tpl->tpl_vars['menu_all']->value), true);?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left remove">Eliminar</button>
                <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary save"><i class="fa fa-check"></i> Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- MODAL -->

<?php echo '<script'; ?>
>

    function $Ready() {

        MRole.init();
        //MRole.edit(levels[1]);

    }

<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array('assets/js/m_role.js')), 0, false);
}
/* smarty_template_function_mkMenu3_19287661645aecd3d9ca83c9_61586596 */
if (!function_exists('smarty_template_function_mkMenu3_19287661645aecd3d9ca83c9_61586596')) {
function smarty_template_function_mkMenu3_19287661645aecd3d9ca83c9_61586596($_smarty_tpl,$params) {
$params = array_merge(array('level'=>0), $params);
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}?>
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'm');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['m']->value) {
?>
                                        <tr class="menu <?php if (!empty($_smarty_tpl->tpl_vars['m']->value->sub)) {?>active<?php }?> id_<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
 id_parent_<?php echo $_smarty_tpl->tpl_vars['m']->value->id_parent;?>
"
                                            data-id="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
" data-id_parent="<?php echo $_smarty_tpl->tpl_vars['m']->value->id_parent;?>
">
                                            <td>
                                                <?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$_smarty_tpl->tpl_vars['level']->value);?>

                                                <i class="<?php echo $_smarty_tpl->tpl_vars['m']->value->icon;?>
"></i> <?php echo $_smarty_tpl->tpl_vars['m']->value->name;?>

                                            </td>
                                            <td class="ctr"><input type="checkbox" name="see[]" value="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
"
                                                                   class="see"></td>
                                            <td class="ctr"><input type="checkbox" name="edit[]" value="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
"
                                                                   class="edit"></td>
                                            <td class="ctr">
                                                <?php if (empty($_smarty_tpl->tpl_vars['m']->value->sub)) {?>
                                                    <input type="radio" name="id_module" value="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
"
                                                           class="home id_<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
">
                                                <?php }?>
                                            </td>
                                            <td class="ctr">
                                                <?php if (empty($_smarty_tpl->tpl_vars['m']->value->sub)) {?>
                                                    <input type="checkbox" name="shortcut[]" value="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
"
                                                           class="shortcut id_<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
">
                                                <?php }?>
                                            </td>
                                        </tr>
                                        <?php if (!empty($_smarty_tpl->tpl_vars['m']->value->sub)) {?>
                                            <?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'mkMenu3', array('data'=>$_smarty_tpl->tpl_vars['m']->value->sub,'level'=>$_smarty_tpl->tpl_vars['level']->value+1), true);?>

                                        <?php }?>
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                                <?php
}}
/*/ smarty_template_function_mkMenu3_19287661645aecd3d9ca83c9_61586596 */
}
