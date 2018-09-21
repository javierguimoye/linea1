<?php
/* Smarty version 3.1.31, created on 2018-08-09 16:38:07
  from "/Users/Alvaro/work/web/Wabir-PMS/views/reception.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5b6cb43f6cb820_52865580',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '040bb4f3409bf8c18661edd019af65458cb0cfc1' => 
    array (
      0 => '/Users/Alvaro/work/web/Wabir-PMS/views/reception.tpl',
      1 => 1525530647,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layouts/header.tpl' => 1,
    'file:layouts/footer.tpl' => 1,
  ),
),false)) {
function content_5b6cb43f6cb820_52865580 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender('file:layouts/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('css'=>array('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css')), 0, false);
?>



    <style>
        .page-content {
            position: relative
        }


    </style>


<div class="reception">

    <div class="portlet light">
        <div class="portlet-title tabbable-line">
            <div class="caption">
                <span class="caption-subject font-dark bold uppercase"><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</span>
            </div>
            <ul class="nav nav-tabs">
                <li class="active">
                    <a style="padding-left:20px;padding-right:20px" href="#tab_rooms" data-toggle="tab">
                        <i class="fa fa-th font-lg"></i>
                    </a>
                </li>
                <li class="hide">
                    <a style="padding-left:20px;padding-right:20px" href="#tab_2" data-toggle="tab">
                        <i class="fa fa-calendar-o font-lg"></i>
                    </a>
                </li>
                <li class="">
                    <a style="padding-left:20px;padding-right:20px" href="#tab_list" data-toggle="tab">
                        <i class="fa fa-bars font-lg"></i>
                    </a>
                </li>
            </ul>
        </div>

        <div class="portlet-body pdg-0">
            <div class="tab-content">
                <div class="tab-pane room_types clearfix noselect active" id="tab_rooms">

                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['room_types']->value, 'rt');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['rt']->value) {
?>
                        <?php if (!empty($_smarty_tpl->tpl_vars['rt']->value->rooms)) {?>
                            <div class="room_type clearfix">
                                <div class="head" style="text-align:right">

                                    <h4><?php echo $_smarty_tpl->tpl_vars['rt']->value->name;?>
</h4>
                                    <h4 class="price"><?php echo $_smarty_tpl->tpl_vars['stg']->value->coin;
echo sprintf('%.2f',$_smarty_tpl->tpl_vars['rt']->value->price);?>
</h4>

                                </div>
                                <div class="rooms clearfix">
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rt']->value->rooms, 'ro');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ro']->value) {
?>
                                        <div class="room" data-id="<?php echo $_smarty_tpl->tpl_vars['ro']->value->id;?>
">
                                            <span class="name"> <?php echo $_smarty_tpl->tpl_vars['ro']->value->name;?>
 </span>
                                        </div>
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                                </div>
                            </div>
                        <?php }?>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>


                </div>
                <div class="tab-pane pdg-10" id="tab_2">
                    coming soon
                </div>
                <div class="tab-pane" id="tab_list">
                    <table class="table table-bordered table-striped mdl-td fils_table">
                        <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th width="1%">
                                <span class="tooltips" title="Habitación" data-placement="right">Hab.</span>
                            </th>
                            <th>Cliente</th>
                            <th width="1%">Precio</th>
                            <th width="1%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>00001</td>
                            <td>204</td>
                            <td>Mateo Chachapoyas</td>
                            <td class="nowrap"><?php echo $_smarty_tpl->tpl_vars['stg']->value->coin;?>
10.50</td>
                            <td class="nowrap">
                                <a class="btn btn-sm dark mrg-0">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>00001</td>
                            <td>204</td>
                            <td>Mateo Chachapoyas</td>
                            <td class="nowrap"><?php echo $_smarty_tpl->tpl_vars['stg']->value->coin;?>
10.50</td>
                            <td class="nowrap">
                                <a class="btn btn-sm dark mrg-0">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <form class="portlet light rcp_back" id="reserve" style="display:none">
        <div class="portlet-title">
            <button class="btn font-dark back" type="button">
                <i class="fa fa-chevron-left"></i>
            </button>
            <div class="caption">
                <span class="caption-subject font-dark bold uppercase">
                    Habitación 202
                </span>
            </div>
            <div class="actions">
                <button class="btn btn-default uppercase" type="button">
                    Cancelar
                </button>
                <button class="btn btn-primary bold uppercase">
                    <i class="fa fa-check"></i> Completar pago
                </button>
            </div>
        </div>

        <div class="portlet-body">

            <div class="row">

                <div class="col-sm-5">

                    <div class="form-group tooltips" title="Fecha de ingreso" data-placement="bottom">
                        <div class="input-group">
                            <span class="input-group-addon" style="min-width:100px;text-align:left">
                                <i class="fa fa-calendar"></i> Ingreso
                            </span>
                            <input type="date" class="form-control" name="date_from">
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-xs-9">
                            <div class="form-group tooltips" title="Fecha de salida">
                                <div class="input-group">
                                    <span class="input-group-addon" style="min-width:100px;text-align:left">
                                        <i class="fa fa-calendar"></i> Salida
                                    </span>
                                    <input type="date" class="form-control" name="date_to">
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-3">

                            <div class="form-group tooltips" title="Número de noches">
                                <input class="form-control ctr touchspin" name="stay" placeholder="Noches" value="1"
                                       data-verticalbuttons="true"
                                       style="border-radius:4px 0 0 4px; padding-left:0;padding-right:0">
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon" style="min-width:100px;text-align:left">
                                <i class="fa fa-user"></i> Huésped
                            </span>
                            <input class="form-control" name="id_client" placeholder="Buscar...">
                            <span class="input-group-addon btn btn-default">
                                <i class="fa fa-plus font-dark"></i>
                            </span>
                        </div>
                    </div>

                    <div class="form-group tooltips" title="Acompañantes">
                        <div class="input-group">
                            <span class="input-group-addon" style="min-width:100px;text-align:left">
                                <i class="fa fa-users"></i> Acomp.
                            </span>
                            <input class="form-control companions" placeholder="Buscar...">
                            <span class="input-group-addon btn btn-default">
                                <i class="fa fa-plus font-dark"></i>
                            </span>
                        </div>
                        <div style="margin-left:100px;margin-top:2px">
                            <table class="table table-bordered mdl-td mrg-0">
                                <tbody>
                                <tr>
                                    <td class="pdg-t-0 pdg-b-0">
                                        <i class="fa fa-angle-right"></i>
                                        Luz Jorge Osorio
                                    </td>
                                    <td width="1%" class="pdg-5">
                                        <a class="btn dark btn-xs mrg-0 tooltips" title="Eliminar">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pdg-t-0 pdg-b-0">
                                        <i class="fa fa-angle-right"></i>
                                        Mateo Chachapoyas Jorge
                                    </td>
                                    <td width="1%" class="pdg-5">
                                        <a class="btn dark btn-xs mrg-0 tooltips" title="Eliminar">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-group tooltips" title="Comprobante de pago">
                        <div class="input-group">
                            <span class="input-group-addon" style="min-width:100px;text-align:left">
                                <i class="fa fa-list-alt"></i> Comp.
                            </span>
                            <div class="input-icon right">
                                <i class="fa fa-angle-down"></i>
                                <select class="form-control" name="id_type_proof"
                                        style="border-radius:0 4px 4px 0;-webkit-appearance:none">
                                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['proofs']->value, 'o');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['o']->value) {
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['o']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['o']->value->name;?>
</option>
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-xs-8">

                            <div class="form-group tooltips" title="Propina">

                                <div class="input-group bootstrap-touchspin">
                                    <span class="input-group-addon" style="min-width:100px;text-align:left">
                                        <i class="fa fa-graduation-cap"></i> Propina
                                    </span>

                                    <input class="form-control ctr" name="tip" placeholder="0.00">

                                    <span class="input-group-btn-vertical">
                                        <a class="btn btn-default bootstrap-touchspin-up">
                                            <i class="glyphicon glyphicon-chevron-up"></i>
                                        </a>
                                        <a class="btn btn-default bootstrap-touchspin-down">
                                            <i class="glyphicon glyphicon-chevron-down"></i>
                                        </a>
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="col-xs-4">

                            <div class="form-group">

                                <a class="btn btn-block dark tooltips add_payment" title="Agregar forma de pago" data-placement="bottom">
                                    <i class="fa fa-plus"></i> Pago
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="payments">
                        <div class="item_payment" style="border-bottom:1px solid #eee; padding-bottom:10px; margin-bottom:10px">
                            <div class="form-group mrg-b-5">

                                <div class="row">
                                    <div class="col-xs-5">
                                        <select class="form-control" name="coin">
                                            <option value="1">(<?php echo $_smarty_tpl->tpl_vars['stg']->value->coin_short;?>
) <?php echo $_smarty_tpl->tpl_vars['stg']->value->coin_name;?>
</option>
                                            <option value="2">(<?php echo $_smarty_tpl->tpl_vars['stg']->value->coin2_short;?>
) <?php echo $_smarty_tpl->tpl_vars['stg']->value->coin2_name;?>
</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-5">

                                        <div class="input-group bootstrap-touchspin">
                                            <span class="input-group-addon btn btn-default tooltips"
                                                  title="Todo lo restante">
                                                <i class="fa fa-chevron-right font-dark"></i>
                                            </span>

                                            <input class="form-control ctr" name="amount"
                                                   placeholder="0.00">

                                            <span class="input-group-btn-vertical">
                                                <a class="btn btn-default bootstrap-touchspin-up">
                                                    <i class="glyphicon glyphicon-chevron-up"></i>
                                                </a>
                                                <a class="btn btn-default bootstrap-touchspin-down">
                                                    <i class="glyphicon glyphicon-chevron-down"></i>
                                                </a>
                                            </span>
                                        </div>

                                    </div>
                                    <div class="col-xs-2">
                                        <span class="btn btn-default btn-block remove">
                                            <i class="fa fa-times"></i>
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group mrg-b-0">

                                <div class="row">
                                    <div class="col-xs-5">
                                        <select class="form-control" name="id_type_method">
                                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['methods']->value, 'o');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['o']->value) {
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['o']->value->id;?>
"><?php echo $_smarty_tpl->tpl_vars['o']->value->name;?>
</option>
                                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                                        </select>
                                    </div>
                                    <div class="col-xs-7">
                                        <input class="form-control" name="reference" placeholder="Referencia">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"
                                  style="min-width:100px;text-align:left;vertical-align:top;padding-top:10px">
                                <i class="fa fa-sticky-note"></i> Notas
                            </span>
                            <textarea class="form-control" name="notes" placeholder="Escribir..."></textarea>
                        </div>
                    </div>

                </div>

                <div class="col-sm-7">

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-cubes"></i>
                                Productos
                            </span>
                            <input class="form-control aa_products" placeholder="Buscar...">
                            <span class="input-group-addon btn btn-default show_categories tooltips" title="Todas las categorías"
                                  data-placement="bottom" style="border-left:none">
                                <i class="fa fa-th-large font-dark"></i>
                            </span>
                            <span class="input-group-addon btn btn-default show_categories_favorites tooltips" title="Categorías favoritas"
                                  data-placement="bottom" style="border-left:none">
                                <i class="fa fa-star font-dark"></i>
                            </span>
                            <span class="input-group-addon btn btn-default show_rooms tooltips hide" title="Habitaciones"
                                  data-placement="bottom" style="border-left:none">
                                <i class="fa fa-bed font-dark"></i>
                            </span>
                            <span class="input-group-addon btn btn-default add_another_charge tooltips" title="Agregar otro cargo"
                                  data-placement="bottom" style="border-left:none">
                                <i class="fa fa-asterisk font-dark"></i>
                            </span>
                        </div>
                    </div>


                    <!--categorias-->
                    <div class="panel-group accordion prodcats" id="categories" style="display:none">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, array('Bebidas calientes','Ropa','Preservativos','Frutas y verduras'), 'name', false, 'i');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['name']->value) {
?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <a class="accordion-toggle  <?php if ($_smarty_tpl->tpl_vars['i']->value > 0) {?>collapsed<?php }?> clearfix" data-toggle="collapse"
                                       data-parent="#categories" href="#collapse_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
">
                                        <span class="color" style="background:red"></span>
                                        <span class="name">
                                            <?php echo $_smarty_tpl->tpl_vars['name']->value;?>

                                        </span>
                                        <span class="action">
                                            <i class="fa fa-chevron-right"></i>
                                            <i class="fa fa-chevron-up"></i>
                                        </span>
                                        <span class="count">
                                            <?php echo $_smarty_tpl->tpl_vars['i']->value;?>
 productos
                                        </span>
                                    </a>
                                </div>
                                <div id="collapse_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="panel-collapse <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>in<?php } else { ?>collapse<?php }?>">
                                    <div class="panel-body products">
                                        <a class="btn btn-lg grey-gallery">Aceite verde</a>
                                        <a class="btn btn-lg grey-gallery">Pepsi</a>
                                        <a class="btn btn-lg grey-gallery">Coca-Cola</a>
                                        <div class="btn-group">
                                            <button class="btn grey-gallery btn-lg dropdown-toggle" type="button"
                                                    data-toggle="dropdown" aria-expanded="false"> Large button
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pdg-t-10 pdg-b-10" role="menu">
                                                <li>
                                                    <a class="bold pdg-15">
                                                        <i class="fa fa-angle-right"></i> Personal
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="bold pdg-15">
                                                        <i class="fa fa-angle-right"></i> Familiar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                    </div>

                    <!--cuenta-->
                    <div class="account_summary">
                        <table class="table table-bordered mdl-td">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th width="80px">Cant.</th>
                                <th width="1%">Total</th>
                                <th width="1%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr style="background:#f9f9f9">
                                <td>

                                    Habitación: Suite - 202

                                    

                                </td>
                                <td class="pdg-5">
                                    <input class="form-control ctr pdg-l-0 pdg-r-0" value="1" disabled>
                                </td>
                                <td class="nowrap pdg-l-10" align="right">S/ 150.00</td>
                                <td class="pdg-5">

                                    <div class="btn-group">
                                        <button class="btn dark btn-sm mrg-0 dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-bars"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right pdg-t-10 pdg-b-10" role="menu">
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-sticky-note"></i> Agregar notas
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-pencil"></i> Editar descuentos
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td>Jabon Dobe - Antibacterial</td>
                                <td class="pdg-5">
                                    <input class="form-control ctr touchspin pdg-l-0 pdg-r-0" placeholder="0"
                                           data-verticalbuttons="true" data-max="9999"
                                           style="border-radius:4px 0 0 4px">
                                </td>
                                <td class="nowrap pdg-l-10" align="right">
                                    S/ 8.30
                                    <div class="font-xs">- S/ 2.50 (10%)</div>
                                </td>
                                <td class="pdg-5">

                                    <div class="btn-group">
                                        <button class="btn dark btn-sm mrg-0 dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-bars"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right pdg-t-10 pdg-b-10" role="menu">
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-sticky-note"></i> Agregar notas
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-pencil"></i> Editar descuentos
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr class="font-green">
                                <th colspan="2" style="text-align:right">Descuento total</th>
                                <th class="nowrap pdg-l-10 pdg-r-10" style="text-align:right">- S/ 2.50</th>
                                <th class="nowrap pdg-5">
                                    <a class="btn btn-sm green mrg-0">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2" style="text-align:right">Sub Total</th>
                                <th class="nowrap pdg-l-10 pdg-r-10" style="text-align:right">S/ 25.30</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th colspan="2" style="text-align:right">IGV <em class="font-xs">(<?php echo $_smarty_tpl->tpl_vars['stg']->value->igv;?>
%)</em></th>
                                <th class="nowrap pdg-l-10 pdg-r-10" style="text-align:right">S/ 25.30</th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>

            </div>

        </div>
    </form>

</div>

<?php echo '<script'; ?>
>
    function $Ready() {
        Reception.init();
        Reserve.byRoom(1);
    }
<?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender('file:layouts/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('js'=>array('assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js','assets/js/reception.js')), 0, false);
}
}
