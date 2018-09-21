<?php
/* Smarty version 3.1.31, created on 2018-05-05 22:51:06
  from "/Users/Alvaro/Work/Web/Wabir-PMS/views/login.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5aee7baa6c4025_31266370',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ff04b77f5eaae6835a5a6790caac9b14df6ae98' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Wabir-PMS/views/login.tpl',
      1 => 1524850275,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5aee7baa6c4025_31266370 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Iniciar sesión | <?php echo $_smarty_tpl->tpl_vars['stg']->value->brand;?>
</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <base href="<?php echo $_smarty_tpl->tpl_vars['stg']->value->url_base;?>
">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"/>
    <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="assets/global/css/components-rounded.min.css" rel="stylesheet"/>

    <link href="assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>

    <link href="assets/plugins/animate/animate.css" rel="stylesheet"/>

    <link href="assets/pages/css/login.min.css" rel="stylesheet"/>
    <link href="assets/css/core.css?v=<?php echo $_smarty_tpl->tpl_vars['stg']->value->version;?>
" rel="stylesheet"/>

    <link rel="shortcut icon" href="favicon.ico"/>
</head>

<body class=" login"
      >

<!-- BEGIN LOGO -->
<div class="logo">
    <a href="<?php echo $_smarty_tpl->tpl_vars['stg']->value->url_base;?>
"><?php echo $_smarty_tpl->tpl_vars['stg']->value->brand;?>
</a>
</div>
<!-- END LOGO -->

<!-- BEGIN LOGIN -->
<div class="content" style="box-shadow:5px 5px 50px rgba(0,0,0,.3)">

    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" id="form-login">

        <h3 class="form-title font-dark">Iniciar sesión</h3>

        <div class="alert alert-danger" id="error-alert" style="display:none"></div>

        <div class="form-group">
            <input class="form-control" autocomplete="off" placeholder="Usuario" name="username" autofocus/>
        </div>

        <div class="form-group">
            <input class="form-control" autocomplete="off" placeholder="Contraseña" name="password" type="password"/>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary uppercase" id="enter">Ingresar</button>
            <label class="rememberme check">
                <input type="checkbox" name="remember" value="1" checked> No cerrar sesión
                <i class="fa fa-question-circle-o tooltips"
                   title="Si no marcas esta casilla, la sesión caducará cuando cierres el navegador o cuando estés inactivo durante un tiempo considerable."></i>
            </label>
        </div>

    </form>
    <!-- END LOGIN FORM -->

</div>

<div class="copyright"> <?php echo date('Y');?>
 © <?php echo $_smarty_tpl->tpl_vars['stg']->value->brand;?>
 - v<?php echo $_smarty_tpl->tpl_vars['stg']->value->version;?>
 </div>


    <?php echo '<script'; ?>
>
        function $Ready() {

            $form = $('#form-login');
            $form._alert = $('#error-alert', $form);
            $form._enter = $('#enter', $form);
            $form.username = $('input[name=username]', $form);
            $form.password = $('input[name=password]', $form);
            $form.submit(function (e) {
                e.preventDefault();

                $form._alert.slideUp();
                $form._enter.showButtonLoading();
                api('login/login', $form.serializeObject(), function (rsp) {
                    $form._enter.hideButtonLoading();
                    if (rsp.ok) {
                        toastr.success('Iniciado correctamente');
                        location.href = '';

                    } else {
                        $form._alert.html(rsp.msg);
                        $form._alert.slideDown();

                        if (rsp.field == 'username') {
                            $form.username.focus();
                        } else if (rsp.field == 'password') {
                            $form.password.focus();
                        }

                    }

                }, false);

            });

            /*$(window).resize(function (e) {
                var $this = $(this);

                $body.css({
                    width: $this.width(),
                    height: $this.height()
                });

            }).trigger('resize');*/

        }
    <?php echo '</script'; ?>
>


<?php echo '<script'; ?>
 src="assets/global/plugins/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="assets/global/plugins/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js"><?php echo '</script'; ?>
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
<!--<?php echo '<script'; ?>
 src="assets/pages/scripts/login.min.js"><?php echo '</script'; ?>
>-->

<?php echo '<script'; ?>
 src="assets/js/core.js?v=<?php echo $_smarty_tpl->tpl_vars['stg']->value->version;?>
"><?php echo '</script'; ?>
>

</body>
</html><?php }
}
