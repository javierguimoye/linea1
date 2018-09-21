<?php
/* Smarty version 3.1.31, created on 2018-05-04 20:48:47
  from "/Users/Alvaro/Work/Web/Wabir-PMS/views/settings.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5aed0d7f0d48e0_47377237',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b385614a9a498ba3d45ed340136daeaae0dad2a6' => 
    array (
      0 => '/Users/Alvaro/Work/Web/Wabir-PMS/views/settings.tpl',
      1 => 1525217037,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5aed0d7f0d48e0_47377237 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layouts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('css'=>array('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css','assets/global/plugins/select2/css/select2.min.css','assets/global/plugins/select2/css/select2-bootstrap.min.css')), 0, false);
?>



    <style>
        .bootstrap-touchspin .bootstrap-touchspin-prefix {
            border-right: none
        }

        .bootstrap-touchspin .bootstrap-touchspin-postfix {
            border-left: none
        }

        .bootstrap-touchspin .btn.bootstrap-touchspin-down {
            border-right: none
        }
    </style>


<div class="row">

    <div class="col-sm-6">

        <form class="portlet light form_general">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">
                        <i class="fa fa-gear"></i>
                        <?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>

                    </span>
                </div>
                <div class="actions">
                    <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                        <button class="btn btn-primary">
                            <i class="fa fa-check"></i> Guardar
                        </button>
                    <?php }?>
                </div>
            </div>

            <div class="portlet-body form-horizontal">

                <fieldset <?php if (!$_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>disabled<?php }?>>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Marca</label>
                        <div class="col-md-7">
                            <input class="form-control" name="brand" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->brand;?>
">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Menu lateral</label>
                        <div class="col-md-7">
                            <select class="form-control" name="menu_lateral">
                                
                                <option value="1" <?php if ($_smarty_tpl->tpl_vars['stg']->value->menu_lateral == 1) {?>selected<?php }?>>Mantener expandido</option>
                                <option value="2" <?php if ($_smarty_tpl->tpl_vars['stg']->value->menu_lateral == 2) {?>selected<?php }?>>Mantener colapsado</option>
                                <option value="3" <?php if ($_smarty_tpl->tpl_vars['stg']->value->menu_lateral == 3) {?>selected<?php }?>>Mantener oculto</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Key Firebase</label>
                        <div class="col-md-7">
                            <input class="form-control" name="key_firebase" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->key_firebase;?>
">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Key Google Maps</label>
                        <div class="col-md-7">
                            <input class="form-control" name="key_maps" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->key_maps;?>
">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Moneda</label>
                        <div class="col-md-2 tooltips" title="Símbolo">
                            <input class="form-control" name="coin" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->coin;?>
">
                        </div>
                        <label class="col-md-4 control-label hidden-md hidden-lg">Abreviación</label>
                        <div class="col-md-2 tooltips" title="Abreviación">
                            <input class="form-control" name="coin_short" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->coin_short;?>
">
                        </div>
                        <label class="col-md-4 control-label hidden-md hidden-lg">Nombre</label>
                        <div class="col-md-3 tooltips" title="Nombre moneda">
                            <input class="form-control" name="coin_name" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->coin_name;?>
">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Segunda Moneda</label>
                        <div class="col-md-2 tooltips" title="Símbolo">
                            <input class="form-control" name="coin2" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->coin2;?>
">
                        </div>
                        <label class="col-md-4 control-label hidden-md hidden-lg">Abreviación</label>
                        <div class="col-md-2 tooltips" title="Abreviación">
                            <input class="form-control" name="coin2_short" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->coin2_short;?>
">
                        </div>
                        <label class="col-md-4 control-label hidden-md hidden-lg">Nombre</label>
                        <div class="col-md-3 tooltips" title="Nombre moneda">
                            <input class="form-control" name="coin2_name" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->coin2_name;?>
">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">IGV</label>
                        <div class="col-md-7" style="max-width:200px">
                            <input class="form-control ctr touchspin" name="igv" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->igv;?>
"
                                   data-decimals="2" data-postfix="%">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Tipo de cambio</label>
                        <div class="col-md-7" style="max-width:200px">
                            <input class="form-control ctr touchspin" name="tc" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->tc;?>
"
                                   data-decimals="3" data-step="0.010" data-prefix="<?php echo $_smarty_tpl->tpl_vars['stg']->value->coin;?>
">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Intervalo de tiempo</label>
                        <div class="col-md-7" style="max-width:200px">
                            <input class="form-control ctr touchspin" name="interval" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->interval;?>
"
                                   data-min="1" data-max="999" data-postfix="seg">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Versión</label>
                        <div class="col-md-7" style="max-width:100px">
                            <input class="form-control" name="version" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->version;?>
">
                        </div>
                    </div>

                </fieldset>

            </div>
        </form>

        <form class="portlet light form_mail">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase"><i class="fa fa-envelope"></i> Correo</span>
                </div>
                <div class="actions">
                    <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                        <button class="btn btn-primary">
                            <i class="fa fa-check"></i> Guardar
                        </button>
                    <?php }?>
                </div>
            </div>

            <div class="portlet-body form-horizontal">

                <fieldset <?php if (!$_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>disabled<?php }?>>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Remitente</label>
                        <div class="col-md-7">
                            <input class="form-control" name="mail_sender" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->mail_sender;?>
">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">
                            Copia oculta
                            <i class="fa fa-question-circle-o font-grey-salsa tooltips"
                               title="Si ingresa un correo electrónico, se agrega como una copia oculta para todos los correos electrónicos enviados por el sistema."></i>
                        </label>
                        <div class="col-md-7">
                            <input class="form-control" name="mail_bcc" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->mail_bcc;?>
"
                                   placeholder="Sin copia oculta">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label"></label>
                        <div class="col-md-7">
                            <label class="mrg-0">
                                <input type="checkbox" name="mail_auth" value="1" <?php if ($_smarty_tpl->tpl_vars['stg']->value->mail_auth == 1) {?>checked<?php }?>>
                                Autenticación SMTP
                            </label>
                        </div>
                    </div>

                    <div class="mail_auth_items" <?php if ($_smarty_tpl->tpl_vars['stg']->value->mail_auth == 0) {?>style="display:none"<?php }?>>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Host</label>
                            <div class="col-md-7">
                                <input class="form-control" name="mail_host" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->mail_host;?>
">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Usuario</label>
                            <div class="col-md-7">
                                <input class="form-control" name="mail_username" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->mail_username;?>
">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Contraseña</label>
                            <div class="col-md-7">
                                <input class="form-control" name="mail_password" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->mail_password;?>
">
                            </div>
                        </div>

                    </div>

                </fieldset>

            </div>
        </form>

    </div>

    <div class="col-sm-6">

        <form class="portlet light form_company">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject font-dark bold uppercase">
                        <i class="fa fa-university"></i>
                        Empresa
                    </span>
                </div>
                <div class="actions">
                    <?php if ($_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>
                        <button class="btn btn-primary">
                            <i class="fa fa-check"></i> Guardar
                        </button>
                    <?php }?>
                </div>
            </div>

            <div class="portlet-body form-horizontal">

                <fieldset <?php if (!$_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>disabled<?php }?>>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Razón social</label>
                        <div class="col-md-7">
                            <input class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->name;?>
">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">RUC</label>
                        <div class="col-md-7">
                            <input class="form-control" name="ruc" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->ruc;?>
">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">País</label>
                        <div class="col-md-7">
                            <select class="form-control select2" name="id_country" <?php if (!$_smarty_tpl->tpl_vars['stg']->value->can_edit) {?>disabled<?php }?>>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['countries']->value, 'o');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['o']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['o']->value->id;?>
"
                                            <?php if ($_smarty_tpl->tpl_vars['o']->value->id == $_smarty_tpl->tpl_vars['stg']->value->id_country) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['o']->value->name;?>
</option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Dirección</label>
                        <div class="col-md-7">
                            <input class="form-control" name="address" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->address;?>
">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Correo electrónico</label>
                        <div class="col-md-7">
                            <input class="form-control" name="email" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->email;?>
">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Teléfono</label>
                        <div class="col-md-7">
                            <input class="form-control" name="phone" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->phone;?>
">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Fax</label>
                        <div class="col-md-7">
                            <input class="form-control" name="fax" value="<?php echo $_smarty_tpl->tpl_vars['stg']->value->fax;?>
">
                        </div>
                    </div>

                </fieldset>

            </div>
        </form>

    </div>

</div>

<?php echo '<script'; ?>
>

    
    function $Ready() {

        $('.form_general').submit(function (e) {
            e.preventDefault();
            save($(this), 'settings/saveGeneral');
        });

        var $form_mail = $('.form_mail');
        $form_mail.mail_auth_items = $form_mail.find('.mail_auth_items');
        $form_mail.submit(function (e) {
            e.preventDefault();
            save($(this), 'settings/saveMail');
        });
        $form_mail.find('input[name=mail_auth]').change(function () {
            if (this.checked) {
                $form_mail.mail_auth_items.slideDown();
            } else {
                $form_mail.mail_auth_items.slideUp();
            }
        });

        $('.form_company').submit(function (e) {
            e.preventDefault();
            save($(this), 'settings/saveCompany');
        });

        $(".select2").select2({
            placeholder: 'Elegir...'
        });

        $(".touchspin").TouchSpin();

    }

    function save($form, endpoint) {
        var data = $form.serializeObject();

        api(endpoint, data, function (rsp) {

            if (rsp.ok) {

                toastr.success('Guardado correctamente');

                setTimeout(function () {
                    location.reload();
                }, 600);

            } else {
                bootbox.alert(rsp.msg);
            }

        });
    }

    

<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js','assets/global/plugins/select2/js/select2.full.min.js')), 0, false);
}
}
