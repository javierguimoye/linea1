<?php
/* Smarty version 3.1.31, created on 2018-08-09 16:36:12
  from "/Users/Alvaro/work/web/Wabir-PMS/views/layouts/footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5b6cb3ccbad039_97609363',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d5171a2936a2334624bcddc4c43e12fce4df408' => 
    array (
      0 => '/Users/Alvaro/work/web/Wabir-PMS/views/layouts/footer.tpl',
      1 => 1524598257,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b6cb3ccbad039_97609363 (Smarty_Internal_Template $_smarty_tpl) {
?>

            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->

    <!-- BEGIN FOOTER -->
    
    <!-- END FOOTER -->

    <?php echo '<script'; ?>
 src="assets/global/plugins/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/global/plugins/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/global/plugins/moment.min.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 src="assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 src="assets/global/scripts/app.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="assets/layouts/layout/scripts/layout.min.js"><?php echo '</script'; ?>
>

    <?php echo '<script'; ?>
 src="assets/js/core.js?v=<?php echo $_smarty_tpl->tpl_vars['stg']->value->version;?>
"><?php echo '</script'; ?>
>

    <?php if (isset($_smarty_tpl->tpl_vars['js']->value)) {?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['js']->value, 's');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['s']->value) {
?>
            <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['s']->value;
if (strpos($_smarty_tpl->tpl_vars['s']->value,"http") === false) {?>?v=<?php echo $_smarty_tpl->tpl_vars['stg']->value->version;
}?>"><?php echo '</script'; ?>
>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

    <?php }?>

</body>
</html><?php }
}
