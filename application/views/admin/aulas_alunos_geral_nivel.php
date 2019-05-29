<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/header.php'); ?>
<div class="content">
    <div class="row">
        <div class="panel-heading">
            <h2>Meus Agendamentos</h2>
        </div>
       

        <div class="panel-body">

            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped small">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Turma</th>
                                    <th>Nivel</th>
                                    <th>Módulo</th>
                                    <th>Aula</th>
                                    <th>Professor</th>
                                    <th>Sala</th>
                                    <th></th>                            
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(count($itens)>0):
                                   
                                    foreach ($itens as $row): ?>
                                        <tr>
                                            <td><?= $row->status ?></td>
                                            <td><?= $row->turma ?></td>
                                            <td><?= $row->curso ?></td>
                                            <td><?= strip_tags($row->modulo) ?></td>
                                            <td><?php 
                                                if($row->tipo=='revisao'){ echo "Revisão";}elseif($row->tipo=='normal'){echo "Normal";}elseif($row->tipo=="reposicao"){echo "Reposição";}?>

                                                </td>
                                            <?php 
                                            /*
                                            if($row->data!='0000-00-00'){
                                                if(!is_null($row->data)){
                                                     echo formata_data($row->data);
                                                     echo "<br >";
                                                }
                                               
                                            }

                                            if($row->data_segunda!='0000-00-00'){
                                                if(!is_null($row->data_segunda)){
                                                     echo formata_data($row->data_segunda);
                                                     echo "<br >";
                                                }
                                               
                                            }

                                           
                                            

                                            if($row->data_terceira!='0000-00-00'){
                                                if(!is_null($row->data_terceira)){
                                                     echo formata_data($row->data_terceira);
                                                     echo "<br >";
                                                }
                                               
                                            }
                                            ?>
                                            </td>
                                            
                                            <td><?php 

                                            $dias = unserialize($row->dias_semana);
                                                $i = 0;
                                                 if(!is_null($row->dias_semana)){
                                                    foreach ($dias as $key => $value) {
                                                        $atributo_data_dias = explode(' ',$value);
                                                        if(count($atributo_data_dias)>0){
                                                            $attr = $atributo_data_dias[0];
                                                        }else{
                                                            $attr=$value;
                                                        }

                                                        echo $value;
                                                        echo "<br />";
                                                       
                                                        $i++;
                                                        
                                                    }
                                                } */
                                            ?>
                                            <td><?=$row->professor?></td>
                                            <td><?= $row->sala_id ?></td>

                                             <td> <a class="btn btn-xs btn-info btn btn-info" href="<?php echo site_url(); ?>/admin/agendamento/ver_minha_agenda_geral/<?php echo $row->curso_id ?>/<?php echo $row->turma ?>" title="Visulizar este registro"  class="btn btn-mini btn-primary"><i class="fa fa-eye"></i>Ver Módulos</a></td>
                                        </tr>
                                    <?php endforeach;?>
                                    <?php endif;?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            

        </div><!--/panel-body-->
    </div><!--/row-->
</div>
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>  
