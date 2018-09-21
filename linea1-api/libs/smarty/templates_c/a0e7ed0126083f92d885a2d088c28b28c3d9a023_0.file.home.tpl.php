<?php
/* Smarty version 3.1.31, created on 2018-04-27 14:35:46
  from "/Users/Alvaro/Work/Web/Dev/views/home.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ae37b92ef57c1_47358861',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a0e7ed0126083f92d885a2d088c28b28c3d9a023' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Dev/views/home.tpl',
      1 => 1524857746,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5ae37b92ef57c1_47358861 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layouts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="portlet light">

    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-dark bold uppercase"><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</span>
        </div>
    </div>

    <div class="portlet-body">
        Home
    </div>

</div>

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
