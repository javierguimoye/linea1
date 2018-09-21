<?php
/* Smarty version 3.1.31, created on 2018-05-01 19:50:21
  from "/Users/Alvaro/Work/Web/Dev/views/layouts/header.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5ae90b4d654878_34389140',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c5317286ddee1f1ddaeac25185882d9f6c37dfeb' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Dev/views/layouts/header.tpl',
      1 => 1525222145,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5ae90b4d654878_34389140 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->_tplFunction->registerTplFunctions($_smarty_tpl, array (
  'mkMenu' => 
  array (
    'compiled_filepath' => '/Users/Alvaro/Work/Web/Dev/libs/smarty/templates_c/c5317286ddee1f1ddaeac25185882d9f6c37dfeb_0.file.header.tpl.php',
    'uid' => 'c5317286ddee1f1ddaeac25185882d9f6c37dfeb',
    'call_name' => 'smarty_template_function_mkMenu_4596697995ae90b4d597710_45246086',
  ),
));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['stg']->value->brand;?>
</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <base href="<?php echo $_smarty_tpl->tpl_vars['stg']->value->url_base;?>
">

    <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"/>-->
    <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="assets/global/plugins/line-awesome/css/line-awesome.min.css" rel="stylesheet"/>
    <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet"/>
    <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

    <link href="assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>

    <link href="assets/plugins/animate/animate.css" rel="stylesheet"/>

    <link href="assets/layouts/layout/css/layout.min.css" rel="stylesheet"/>
    <link href="assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet"/>

    <?php if (isset($_smarty_tpl->tpl_vars['css']->value)) {?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['css']->value, 's');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['s']->value) {
?>
            <link href="<?php echo $_smarty_tpl->tpl_vars['s']->value;?>
?v=<?php echo $_smarty_tpl->tpl_vars['stg']->value->version;?>
" rel="stylesheet"/>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

    <?php }?>

    <link href="assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components"/>
    <link href="assets/global/css/plugins.min.css" rel="stylesheet"/>

    <link href="assets/css/core.css?v=<?php echo $_smarty_tpl->tpl_vars['stg']->value->version;?>
" rel="stylesheet" type="text/css"/>

    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico"/>

    <?php echo '<script'; ?>
>
        var stg = <?php echo json_encode($_smarty_tpl->tpl_vars['stg']->value);?>
;
        <?php if (isset($_smarty_tpl->tpl_vars['items']->value) && is_array($_smarty_tpl->tpl_vars['items']->value)) {?>
        var items = <?php echo json_encode($_smarty_tpl->tpl_vars['items']->value);?>
;
        <?php }?>
    <?php echo '</script'; ?>
>
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid
<?php if ($_smarty_tpl->tpl_vars['stg']->value->menu_lateral == 2) {?>page-sidebar-closed<?php } elseif ($_smarty_tpl->tpl_vars['stg']->value->menu_lateral == 3) {?>menu_lateral_hide page-sidebar-closed<?php }?>">

<!-- HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- HEADER INNER -->
    <div class="page-header-inner ">

        <!-- LOGO -->
        <div class="page-logo hidden-xs hidden-sm">
            <a href="<?php echo $_smarty_tpl->tpl_vars['stg']->value->url_home;?>
"><?php echo $_smarty_tpl->tpl_vars['stg']->value->brand;?>
</a>
            <div class="menu-toggler sidebar-toggler"></div>
        </div>
        <!-- END LOGO -->

        <!-- RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->

        <!-- PAGE TOP -->
        <div class="page-top">

            <!-- SHORTCUTS -->
            <div class="top-menu pull-left">
                <ul class="nav navbar-nav menu-shortcuts">

                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['shortcuts']->value, 'm');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['m']->value) {
?>
                        <li class="dropdown dropdown-user <?php if ($_smarty_tpl->tpl_vars['m']->value->active) {?>active<?php }?>">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['m']->value->url;?>
">
                                <?php if (empty($_smarty_tpl->tpl_vars['m']->value->icon)) {?>
                                    <i class="la la-star"></i>
                                <?php } else { ?>
                                    <i class="<?php echo $_smarty_tpl->tpl_vars['m']->value->icon;?>
"></i>
                                <?php }?>
                                <span class="hidden-xs hidden-sm"><?php echo $_smarty_tpl->tpl_vars['m']->value->name;?>
</span>
                            </a>
                        </li>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


                </ul>
            </div>
            <!-- END SHORTCUTS -->

            <!-- TOP NAVIGATION MENU -->
            <div class="top-menu pull-right">

                <ul class="nav navbar-nav pull-right mrg-r-10">

                    <!-- USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle" src="assets/img/avatar.png">

                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default pdg-10">
                            <div class="pdg-10">
                                <h5 class="mrg-0"><?php echo $_smarty_tpl->tpl_vars['stg']->value->user->name;?>
 <?php echo $_smarty_tpl->tpl_vars['stg']->value->user->surname;?>
</h5>
                                <h5 class="mrg-0 mrg-t-5" style="color:#999">@<?php echo $_smarty_tpl->tpl_vars['stg']->value->user->username;?>
</h5>
                            </div>
                            <!--<li> <a href="#"> Option 1 </a> </li>
                            <li> <a href="#"> Option 2 </a> </li>
                            <li class="divider"></li>-->
                            <li class="divider"></li>
                            <li>
                                <a onclick="Acs.changeBranch()" class="tooltips pdg-r-5"
                                   title="Sucursal en la que estás trabajando">
                                    <i class="icon-home"></i>
                                    <?php echo $_smarty_tpl->tpl_vars['stg']->value->user->branch;?>

                                    <i class="fa fa-angle-right pull-right mrg-0"></i>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="#"> <i class="icon-user"></i> Mi cuenta </a></li>
                            <li><a href="#"> <i class="icon-support"></i> Soporte </a></li>
                            <li class="divider"></li>
                            <li><a href="login/logout"> <i class="icon-logout"></i> Cerrar sesión </a></li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->

                    <!-- FULL -->
                    <li class="dropdown dropdown-user hide">
                        <a id="head_fullscreen" class="dropdown-toggle" onclick="toggleFullScreen();">
                            <i class="fa fa-arrows-alt"></i>
                        </a>
                    </li>
                    <!-- END FULL -->

                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->

    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->

<div class="clearfix"></div>

<!-- CONTAINER -->
<div class="page-container">

    <!-- SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <!-- SIDEBAR -->
        <div class="page-sidebar navbar-collapse collapse">

            <!-- SIDEBAR MENU -->
            <ul class="page-sidebar-menu  page-header-fixed <?php if ($_smarty_tpl->tpl_vars['stg']->value->menu_lateral == 2) {?>page-sidebar-menu-closed<?php }?>"
                data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top:10px">
                <li class="sidebar-toggler-wrapper hide">
                    <!-- SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler"></div>
                    <!-- END SIDEBAR TOGGLER BUTTON -->
                </li>

                
                <?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'mkMenu', array('data'=>$_smarty_tpl->tpl_vars['menu']->value), true);?>



            </ul>
            <!-- END SIDEBAR MENU -->

        </div>
        <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->

    <!-- CONTENT -->
    <div class="page-content-wrapper">
        <!-- CONTENT BODY -->
        <div class="page-content"><?php }
/* smarty_template_function_mkMenu_4596697995ae90b4d597710_45246086 */
if (!function_exists('smarty_template_function_mkMenu_4596697995ae90b4d597710_45246086')) {
function smarty_template_function_mkMenu_4596697995ae90b4d597710_45246086($_smarty_tpl,$params) {
$params = array_merge(array('level'=>0), $params);
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['data']->value, 'm');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['m']->value) {
?>
                        <li class="nav-item start <?php if ($_smarty_tpl->tpl_vars['m']->value->active) {?>active<?php }?>">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['m']->value->url;?>
" class="nav-link nav-toggle">
                                <?php if ($_smarty_tpl->tpl_vars['level']->value == 0) {?>
                                    <i class="<?php echo $_smarty_tpl->tpl_vars['m']->value->icon;?>
"></i>
                                <?php } else { ?>
                                    <i class="fa fa-circle-o nav-bull"></i>
                                <?php }?>
                                <span class="title"><?php echo $_smarty_tpl->tpl_vars['m']->value->name;?>
</span>
                                <?php if (!empty($_smarty_tpl->tpl_vars['m']->value->sub)) {?><span class="arrow"></span><?php }?>
                            </a>
                            <?php if (!empty($_smarty_tpl->tpl_vars['m']->value->sub)) {?>
                                <ul class="sub-menu">
                                    <?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'mkMenu', array('data'=>$_smarty_tpl->tpl_vars['m']->value->sub,'level'=>$_smarty_tpl->tpl_vars['level']->value+1), true);?>

                                </ul>
                            <?php }?>
                        </li>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                <?php
}}
/*/ smarty_template_function_mkMenu_4596697995ae90b4d597710_45246086 */
}
