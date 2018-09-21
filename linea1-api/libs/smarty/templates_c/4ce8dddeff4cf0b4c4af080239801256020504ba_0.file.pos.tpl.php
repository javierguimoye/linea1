<?php
/* Smarty version 3.1.31, created on 2018-04-28 22:02:19
  from "/Users/Alvaro/Work/Web/Dev/views/pos.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ae535bb42bcc4_85864419',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4ce8dddeff4cf0b4c4af080239801256020504ba' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Dev/views/pos.tpl',
      1 => 1524970938,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5ae535bb42bcc4_85864419 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layouts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="row">

    <div class="col-md-7">

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase"><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</span>
                </div>
            </div>

            <div class="portlet-body">


            </div>
        </div>

    </div>

    <div class="col-md-5">

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase"><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</span>
                </div>
            </div>

            <div class="portlet-body">


            </div>
        </div>

    </div>

</div>

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array('assets/js/m_turn.js')), 0, false);
}
}
