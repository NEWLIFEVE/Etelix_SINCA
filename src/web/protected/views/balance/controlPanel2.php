
<?php
/* BUSCO EN BD EL REGISTRO QUE COINCIDA CON LA DATA PARA VALIDAR QUE NO EXISTA */
$sql = "SELECT id,Nombre FROM cabina";
$connection0 = Yii::app()->db;
$command0 = $connection0->createCommand($sql);
$cabinas = $command0->query(); // execute a query SQL
$fechaActual = date("Y-m-d", time());
/* * ********************************************* */
// $post=$model->findByPk(114); $id->readColumn(0)
?>
<h1>Tablero de Control</h1>
<?php if ($model !== null) { ?>
    <!-- COMIENZO DE LA TABLA-->
    <table border="1"  style="background-color:#F2F4F2;"  >
        <tr>
            <!--AQUI SE FORMAN LAS COLUMNAS CON LAS CABINAS EN LA DB-->
            <td  align="center" style='background: url("<?php echo Yii::app()->theme->baseUrl; ?>/img/footer_bg.gif") repeat scroll 0 0 #2D2D2D;'><img style="padding-left: 16px;" src="<?php echo Yii::app()->request->baseUrl; ?>/images/Activity Monitor.png"></td>
            <?php for ($i = 1; $i <= $cabinas->count(); $i++) { ?>
                <td style='font-size:10px; font-weight:bold;  color:#FFFFFF; background: url("<?php echo Yii::app()->theme->baseUrl; ?>/img/footer_bg.gif") repeat scroll 0 0 #2D2D2D;' ><div align="center" style="width:50px;"><?php echo $cabinas->readColumn(1); ?></div></td>
            <?php } ?>
        </tr>

        <tr <?php echo ($x++) % 2 == 0 ? "style='background-color:#CCC'" : ""; ?>>
            <td><h3 style="font-size:14px;">Inicio Jornada</h3></td>

            <?php
            for ($i = 1; $i <= $cabinas->count(); $i++) {
                 $sql="select DISTINCT(l.Hora) from log l, users u 
where l.ACCIONLOG_Id = 9 and l.Fecha = :fecha and l.USERS_Id = u.Id and u.CABINA_Id = :cabina";
                        $connection=Yii::app()->db; 
                        $command=$connection->createCommand($sql);
                        $command->bindValue(":cabina", $i); // bind de parametro cabina del user
                        $command->bindValue(":fecha", $fechaActual , PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
                        $id=$command->query(); // execute a query SQL
                if ($id->count()) {
                    ?>
                      <td style="color:#36C; font-family:'Comic Sans MS', cursive; font-size:12px;"><?php echo $id->readColumn(0) ?></td>
                      <!--<td style="color:#36C; font-family:'Comic Sans MS', cursive; font-size:12px;">08:00:00</td>-->
                <?php } else { ?>
                    <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-icon.png"></td>
                     <!--<td style="color:#36C; font-family:'Comic Sans MS', cursive; font-size:12px;">08:00:00</td>-->
                    <?php
                }
            }
            ?>       

        </tr>
        <tr <?php echo ($x++) % 2 == 0 ? "style='background-color:#CCC'" : ""; ?>>
            <td><h3 style="font-size:14px;  background: url(../img/line_hor.gif) repeat-x 0 100%;">Saldo Apertura</h3></td>

            <?php
            for ($i = 1; $i <= $cabinas->count(); $i++) {
                $post = $model->find('CABINA_Id = :id and Fecha = :fecha', array(':id' => $i, ':fecha' => $fechaActual));
                if ($post->SaldoApMov !== null) {
                    ?>
                      <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/check-icon.png"></td>
                <?php } else { 
                    if (date('H',  time())<9){?>
                    <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/wtf-icon.png"></td>
                    <?php }else{
                            if (date('H',  time())>16){?>
                    <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-icon.png"></td>
                    <?php }else{?>
                    <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/danger-icon.png"></td>          
                    <?php
                    }
                    }
                }
            }
            ?> 

        </tr>
        <tr <?php echo ($x++) % 2 == 0 ? "style='background-color:#CCC'" : ""; ?>>
            <td><h3 style="font-size:14px;">Ventas Llamadas</h3></td>

            <?php
            for ($i = 1; $i <= $cabinas->count(); $i++) {
                $post = $model->find('CABINA_Id = :id and Fecha = :fecha', array(':id' => $i, ':fecha' => $fechaActual));
                if ($post->FechaIngresoLlamadas !== null) {
                    ?>
                       <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/check-icon.png"></td>
                <?php } else { ?>
                          <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-icon.png"></td>
                    <?php
                }
            }
            ?> 
        </tr>
        <tr <?php echo ($x++) % 2 == 0 ? "style='background-color:#CCC'" : ""; ?>>
            <td><h3 style="font-size:14px; background: url(../img/line_hor.gif) repeat-x 0 100%;">Depositos</h3></td>
            <?php
            for ($i = 1; $i <= $cabinas->count(); $i++) {
                $post = $model->find('CABINA_Id = :id and Fecha = :fecha', array(':id' => $i, ':fecha' => $fechaActual));
                if ($post->FechaIngresoDeposito !== null) {
                    ?>
                         <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/check-icon.png"></td>
                <?php } else { ?>
                     <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-icon.png"></td>
                    <?php
                }
            }
            ?> 
        </tr>
        <tr <?php echo ($x++) % 2 == 0 ? "style='background-color:#CCC'" : ""; ?>>
            <td><h3 style="font-size:14px;">Saldo Cierre</h3></td>

            <?php
            for ($i = 1; $i <= $cabinas->count(); $i++) {
                $post = $model->find('CABINA_Id = :id and Fecha = :fecha', array(':id' => $i, ':fecha' => $fechaActual));
                if ($post->SaldoCierreMov !== null) {
                    ?>
                         <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/check-icon.png"></td>
                <?php } else { ?>
           <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-icon.png"></td>
                    <?php
                }
            }
            ?> 
        </tr>
        <tr <?php echo ($x++) % 2 == 0 ? "style='background-color:#CCC'" : ""; ?>>
            <td><h3 style="font-size:14px; background: url(../img/line_hor.gif) repeat-x 0 100%;">Fin Jornada</h3></td>

            <?php
            for ($i = 1; $i <= $cabinas->count(); $i++) {
                 $sql="select DISTINCT(l.Hora) from log l, users u 
where l.ACCIONLOG_Id = 10 and l.Fecha = :fecha and l.USERS_Id = u.Id and u.CABINA_Id = :cabina";
                        $connection2=Yii::app()->db; 
                        $command2=$connection2->createCommand($sql);
                        $command2->bindValue(":cabina", $i); // bind de parametro cabina del user
                        $command2->bindValue(":fecha", $fechaActual , PDO::PARAM_STR); //bind del parametro fecha dada por el usuario          
                        $id2=$command2->query(); // execute a query SQL
                if ($id2->count()) {
                    ?>
                      <!--<td style="color:#36C; font-family:'Comic Sans MS', cursive; font-size:12px;">21:00:00</td>-->
                      <td style="color:#36C; font-family:'Comic Sans MS', cursive; font-size:12px;"><?php echo $id2->readColumn(0) ?></td>
                <?php } else { ?>
                    <td><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/no-icon.png"></td>
                      <!--<td style="color:#36C; font-family:'Comic Sans MS', cursive; font-size:12px;">21:00:00</td>-->
                    <?php
                }
            }
            ?> 
        </tr>

    </table>
<?php } ?>
