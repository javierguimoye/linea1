<?php
/* Smarty version 3.1.31, created on 2018-08-09 16:37:32
  from "/Users/Alvaro/work/web/Wabir-PMS/views/types.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5b6cb41c673ea3_54506359',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1b29efe7df118b4eefc9f76b605af1ae1b2c0e67' => 
    array (
      0 => '/Users/Alvaro/work/web/Wabir-PMS/views/types.tpl',
      1 => 1525555334,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5b6cb41c673ea3_54506359 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->_tplFunction->registerTplFunctions($_smarty_tpl, array (
  'mkMenu2' => 
  array (
    'compiled_filepath' => '/Users/Alvaro/work/web/Wabir-PMS/libs/smarty/templates_c/1b29efe7df118b4eefc9f76b605af1ae1b2c0e67_0.file.types.tpl.php',
    'uid' => '1b29efe7df118b4eefc9f76b605af1ae1b2c0e67',
    'call_name' => 'smarty_template_function_mkMenu2_12567030965b6cb41c5cc483_08628846',
  ),
));
if (!is_callable('smarty_modifier_date_format')) require_once '/Users/Alvaro/work/web/wabir-pms/vendor/smarty/smarty/libs/plugins/modifier.date_format.php';
$_smarty_tpl->_subTemplateRender('file:layouts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('css'=>array('assets/global/plugins/jquery-nestable/jquery.nestable.css','assets/global/plugins/jquery-minicolors/jquery.minicolors.css')), 0, false);
?>


<div class="row">

    <div class="col-md-8">

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase"><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</span>
                </div>
                <div class="actions">
                    <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                        <a class="btn btn-primary" onclick="MType.add();">
                            <i class="fa fa-plus"></i> Agregar
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
                            <?php if (isset($_smarty_tpl->tpl_vars['opts']->value['title_color'])) {?>
                                <th width="1%"> <?php echo $_smarty_tpl->tpl_vars['opts']->value['title_color'];?>
</th>
                            <?php }?>
                            <th> Nombre</th>
                            <?php if (isset($_smarty_tpl->tpl_vars['opts']->value['title_code'])) {?>
                                <th> <?php echo $_smarty_tpl->tpl_vars['opts']->value['title_code'];?>
</th>
                            <?php }?>
                            <?php if (isset($_smarty_tpl->tpl_vars['opts']->value['title_favorite'])) {?>
                                <th width="1%">
                                    <div class="tooltips" title="<?php echo $_smarty_tpl->tpl_vars['opts']->value['title_favorite'];?>
">
                                        <i class="fa fa-info-circle"></i>
                                    </div>
                                </th>
                            <?php }?>
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
                                    <td width="1%"><?php echo sprintf('%03d',$_smarty_tpl->tpl_vars['m']->value->id);?>
</td>
                                    <?php if (isset($_smarty_tpl->tpl_vars['opts']->value['title_color'])) {?>
                                        <td>
                                            <?php if ($_smarty_tpl->tpl_vars['m']->value->id_parent == 0) {?>
                                                <div class="tooltips" title="<?php echo $_smarty_tpl->tpl_vars['m']->value->color;?>
"
                                                     style="width:40px;height:20px;background:<?php echo $_smarty_tpl->tpl_vars['m']->value->color;?>
;border-radius:4px"></div>
                                            <?php }?>
                                        </td>
                                    <?php }?>
                                    <td><?php echo str_repeat('—',$_smarty_tpl->tpl_vars['m']->value->level);?>
 <?php echo $_smarty_tpl->tpl_vars['m']->value->name;?>
</td>
                                    <?php if (isset($_smarty_tpl->tpl_vars['opts']->value['title_code'])) {?>
                                        <td><?php echo $_smarty_tpl->tpl_vars['m']->value->code;?>
</td>
                                    <?php }?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['opts']->value['title_favorite'])) {?>
                                        <td>
                                            <?php if ($_smarty_tpl->tpl_vars['m']->value->favorite == 1) {?>
                                                <i class="fa fa-star font-yellow-crusta"></i>
                                            <?php } else { ?>
                                                <i class="fa fa-star font-grey"></i>
                                            <?php }?>
                                        </td>
                                    <?php }?>
                                    <td class="nowrap"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['m']->value->date_created,"%d/%m/%Y %I:%M %p");?>
</td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                                            <span class="btn dark btn-sm mrg-0" onclick="MType.edit(items[<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
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

    </div>
    <div class="col-md-4">

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">Ordenar</span>
                </div>
                <div class="actions">
                    <span class="btn dark" id="load" style="display:none">
                        <i class="fa fa-spinner fa-pulse fa-1x fa-f"></i>
                    </span>
                </div>
            </div>

            <div class="portlet-body">


                <?php if (empty($_smarty_tpl->tpl_vars['items']->value)) {?>
                    <div class="alert alert-warning mrg-0">No hay datos disponibles para mostrar.</div>
                <?php } else { ?>
                    <div class="dd" id="list">

                        
                        <?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'mkMenu2', array('data'=>$_smarty_tpl->tpl_vars['items_order']->value), true);?>


                    </div>
                <?php }?>

            </div>
        </div>

    </div>

</div>

<?php echo '<script'; ?>
>

    function $Ready() {

        MType.setup(<?php echo json_encode($_smarty_tpl->tpl_vars['opts']->value);?>
);

    }

<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array('assets/global/plugins/jquery-nestable/jquery.nestable.js','assets/global/plugins/jquery-minicolors/jquery.minicolors.min.js','assets/js/m_type.js')), 0, false);
}
/* smarty_template_function_mkMenu2_12567030965b6cb41c5cc483_08628846 */
if (!function_exists('smarty_template_function_mkMenu2_12567030965b6cb41c5cc483_08628846')) {
function smarty_template_function_mkMenu2_12567030965b6cb41c5cc483_08628846($_smarty_tpl,$params) {
$params = array_merge(array('level'=>0), $params);
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}?>
                            <ol class="dd-list">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'm', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['m']->value) {
?>
                                    <li class="dd-item dd3-item" data-id="<?php echo $_smarty_tpl->tpl_vars['m']->value->id;?>
">
                                        <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                                            <div class="dd-handle dd3-handle"></div>
                                        <?php }?>
                                        <div class="dd3-content">
                                            <?php echo $_smarty_tpl->tpl_vars['m']->value->name;?>

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
/*/ smarty_template_function_mkMenu2_12567030965b6cb41c5cc483_08628846 */
}
