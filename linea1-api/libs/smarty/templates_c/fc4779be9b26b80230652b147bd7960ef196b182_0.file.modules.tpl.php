<?php
/* Smarty version 3.1.31, created on 2018-04-27 14:42:54
  from "/Users/Alvaro/Work/Web/Dev/views/modules.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ae37d3ec0e522_75419777',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fc4779be9b26b80230652b147bd7960ef196b182' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Dev/views/modules.tpl',
      1 => 1524858174,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5ae37d3ec0e522_75419777 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->_tplFunction->registerTplFunctions($_smarty_tpl, array (
  'mkMenu2' => 
  array (
    'compiled_filepath' => '/Users/Alvaro/Work/Web/Dev/libs/smarty/templates_c/fc4779be9b26b80230652b147bd7960ef196b182_0.file.modules.tpl.php',
    'uid' => 'fc4779be9b26b80230652b147bd7960ef196b182',
    'call_name' => 'smarty_template_function_mkMenu2_19372230815ae37d3eba77c9_04851745',
  ),
));
$_smarty_tpl->_subTemplateRender('file:layouts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('css'=>array('assets/global/plugins/jquery-nestable/jquery.nestable.css')), 0, false);
?>


<div class="portlet light mini">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-dark bold uppercase"><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</span>
        </div>
        <div class="actions">
            <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                <span class="btn dark" id="load" style="display:none">
                            <i class="fa fa-spinner fa-pulse fa-1x fa-f"></i>
                        </span>
                <a class="btn btn-primary" onclick="MModule.add();">
                    <i class="fa fa-plus"></i> Agregar
                </a>
            <?php }?>
        </div>
    </div>

    <div class="portlet-body">

        <div class="dd" id="list">

            
            <?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'mkMenu2', array('data'=>$_smarty_tpl->tpl_vars['menu_all']->value), true);?>


        </div>

    </div>
</div>


<form class="modal fade" id="modal_add_module" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">---</h4>
            </div>
            <div class="modal-body form-horizontal">
                <input type="hidden" name="id" value="">
                <div class="form-group">
                    <label class="col-md-3 control-label">Nombre</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" placeholder="Escribir...">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Url</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="url" placeholder="Escribir...">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Icono</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="icon" placeholder="Escribir...">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn red remove pull-left">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary save"> <i class="fa fa-check"></i> Guardar</button>
            </div>
        </div>
    </div>
</form>

<?php echo '<script'; ?>
>

    function $Ready(){

        MModule.init();

    }

<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array('assets/global/plugins/jquery-nestable/jquery.nestable.js','assets/js/m_module.js')), 0, false);
}
/* smarty_template_function_mkMenu2_19372230815ae37d3eba77c9_04851745 */
if (!function_exists('smarty_template_function_mkMenu2_19372230815ae37d3eba77c9_04851745')) {
function smarty_template_function_mkMenu2_19372230815ae37d3eba77c9_04851745($_smarty_tpl,$params) {
$params = array_merge(array('level'=>0), $params);
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}?>
                <ol class="dd-list">
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'm');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['m']->value) {
?>
                        <li class="dd-item dd3-item" data-id="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
">
                            <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                                <div class="dd-handle dd3-handle"></div>
                            <?php }?>
                            <div class="dd3-content">
                                <i class="<?php echo $_smarty_tpl->tpl_vars['m']->value->icon;?>
"></i> <?php echo $_smarty_tpl->tpl_vars['m']->value->name;?>

                                <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                                    <a class="btn dark btn-xs pull-right" onclick="MModule.edit(items[<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
]);">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                <?php }?>
                            </div>
                            <?php if (!empty($_smarty_tpl->tpl_vars['m']->value->sub)) {?>
                                <?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'mkMenu2', array('data'=>$_smarty_tpl->tpl_vars['m']->value->sub,'level'=>$_smarty_tpl->tpl_vars['level']->value+1), true);?>

                            <?php }?>
                        </li>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                </ol>
            <?php
}}
/*/ smarty_template_function_mkMenu2_19372230815ae37d3eba77c9_04851745 */
}
