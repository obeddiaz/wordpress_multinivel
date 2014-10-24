<?php
/*
  Template Name: Login Template
 */
?>
<?php
wp_head();
?>  
<form action="" method="post">       
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 0px;">
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <input name="log" type="text" class="form-control input-lg" placeholder="Nombre de usuario"/>             
                </div>
                <div class="form-group">
                    <input name="pwd" type="password" placeholder="Introduce tu password" class="form-control input-lg"/>       
                </div>
                <div class="form-group">
                    <input type="submit" value="Iniciar sesión" title="Iniciar sesión" class="btn btn-primary btn-lg btn-block"/>
                    <input type="hidden" name="action" value="my_login_action" />
<!--                    <span class="pull-right"><a href="/index.php/inscripcion"><div>Inscripcion</div></a></span>-->
                </div>

            </div>
            <div class="modal-footer" style="border-top: 0px;">
            </div>
        </div>
    </div></form>