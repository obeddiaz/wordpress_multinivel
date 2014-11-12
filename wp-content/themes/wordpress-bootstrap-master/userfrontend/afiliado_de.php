
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!--<link href="<?= get_bloginfo('template_url') ?>/css/bootstrap.min.css" rel="stylesheet">-->
<!-- MetisMenu CSS -->
<link href="<?= get_bloginfo('template_url') ?>/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
<!-- Timeline CSS -->
<link href="<?= get_bloginfo('template_url') ?>/css/plugins/timeline.css" rel="stylesheet">
<!-- Custom CSS -->
<!--<link href="<?= get_bloginfo('template_url') ?>/css/sb-admin-2.css" rel="stylesheet">-->
<!-- Morris Charts CSS -->
<link href="<?= get_bloginfo('template_url') ?>/css/plugins/morris.css" rel="stylesheet">
<!-- Custom Fonts -->
<link href="<?= get_bloginfo('template_url') ?>/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link href="<?= get_bloginfo('template_url') ?>/css/style.css" rel="stylesheet">
<?php
$afiliado = get_user_meta($_GET['user_id'], 'afiliado_de');
//var_dump($afiliado);
?>
<script type="text/javascript">
    $(function () {
        $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
        $('.tree li.parent_li > span').on('click', function (e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');
            if (children.is(":visible")) {
                children.hide('fast');
                $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
            } else {
                children.show('fast');
                $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
            }
            e.stopPropagation();
        });
    });
</script>
<div class="wrap">
    <h1>Mi Red</h1>
    <h2>Patrocinadores</h2>
    <table class="wp-list-table widefat fixed users">
        <thead>
            <tr>
                <th scope="col" class="manage-column" style="">
                    Nivel
                </th>
                <th scope="col" class="manage-column" style="">
                    Nombre
                </th>
                <th scope="col" class="manage-column" style="">
                    Telefono
                </th>
                <th scope="col" class="manage-column" style="">
                    celular
                </th>
                <th scope="col" class="manage-column" style="">
                    e-mail
                </th>	
                <th scope="col" class="manage-column" style="">
                    Cuenta Bancaria
                </th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th scope="col" class="manage-column" style="">
                    Nivel
                </th>
                <th scope="col" class="manage-column" style="">
                    Nombre
                </th>
                <th scope="col" class="manage-column" style="">
                    Telefono
                </th>
                <th scope="col" class="manage-column" style="">
                    celular
                </th>
                <th scope="col" class="manage-column" style="">
                    e-mail
                </th>	
                <th scope="col" class="manage-column" style="">
                    Cuenta Bancaria
                </th>	
            </tr>
        </tfoot>

        <tbody id="the-list" data-wp-lists="list:user">

            <?php
            for ($a = 1; $a <= 2; $a++) {
                $patrocinador = get_user_by('id', $afiliado[0]);
                $datos_patrocinador = get_user_meta($patrocinador->ID, 'ml_misdatos');
                $afiliado = get_user_meta($patrocinador->ID, 'afiliado_de');
                if ($patrocinador) {
                    ?>
                    <tr id="user-1" class="alternate">
                        <td class="user_id column-user_id">
                            <?= $a ?>
                        </td>
                        <td class="cant_inv column-cant_inv">
                            <?= $patrocinador->display_name ?>
                        </td>
                        <td class="afiliado_de column-afiliado_de">
                            <?php if (isset($datos_patrocinador[0]['telefono'])) { ?>
                                <?= $datos_patrocinador[0]['telefono'] ?>
                            <?php } ?>
                        </td>
                        <td class="afiliado_de column-afiliado_de">
                            <?php if (isset($datos_patrocinador[0]['celular'])) { ?>
                                <?= $datos_patrocinador[0]['celular'] ?>
                            <?php } ?>
                        </td>
                        <td class="cant_afi column-cant_afi">
                            <?= $patrocinador->user_email ?>
                        </td>
                        <td class="afiliado_de column-afiliado_de">
                            <?php if (isset($datos_patrocinador[0]['cuenta_bancaria'])) { ?>
                                <?= $datos_patrocinador[0]['cuenta_bancaria'] ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
    </table>
    <?php
    $afiliados = get_users(array(
        'meta_key' => 'afiliado_de',
        'meta_value' => $_GET['user_id']
    ));
    //var_dump($afiliados);
    $users_count = 0;
    ?>
    <h2>Mi Arbol de afiliados</h2>
    <div class="row">
        <div class="col-lg-12">
            <div class="row-fluid">
                <div class="tree well">
                    <ul>
                        <?php
                        foreach ($afiliados as $afi) {
                            $users_count++;
                            ?>
                            <li class="parent_li">
                                <span class="badge alert-info" title="Collapse this branch"><i class="icon-folder-open icon-minus-sign"></i> <?= $afi->display_name ?></span> 
                                <?php
                                $red = red_completa_boton($afi->ID, 1);
                                if ($red) {
                                    echo $red;
                                } else {
                                    echo 'El pago de este Usuario ya a sido confirmado';
                                }
                                ?>
                                <ul>
                                    <?php
                                    $afiliados2 = get_users(array(
                                        'meta_key' => 'afiliado_de',
                                        'meta_value' => $afi->ID
                                    ));
                                    //var_dump($afiliados2);
                                    foreach ($afiliados2 as $afi2) {
                                        $users_count++;
                                        ?>
                                        <li class="parent_li">
                                            <span class="badge alert-info" title="Collapse this branch"><i class="icon-folder-open icon-minus-sign"></i> <?= $afi2->display_name ?></span> 
                                            <?php
                                            if (!$red) {
                                                $red_afi2 = red_completa_boton($afi2->ID, 2);
                                                if ($red_afi2) {
                                                    echo $red_afi2;
                                                } else {
                                                    echo 'El pago de este Usuario ya a sido confirmado';
                                                }
                                            }
                                            ?>
                                            <!--                                            <ul>
                                            <?php
                                            $afiliados3 = get_users(array(
                                                'meta_key' => 'afiliado_de',
                                                'meta_value' => $afi2->ID
                                            ));
                                            foreach ($afiliados3 as $afi3) {
                                                //$users_count++;
                                                ?>
                                                                                                                                                            <li>
                                                                                                                                                                <span class="badge alert-warning"><i class="icon-folder-open"></i> <?= $afi3->display_name ?></span>
                                                                                                                                                            </li>
                                                <?php
                                            }
                                            ?>
                                                                                        </ul>-->
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div> 
    </div>
</div>