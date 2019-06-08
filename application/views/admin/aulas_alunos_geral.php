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
                                    <th>Sala</th>
                                    <th></th>
                                    <th></th>                             
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(count($itens)>0):
                                    $hoje = strtotime(date('Y-m-d'));
                                    $data_atual = strtotime("+7 day",$hoje);
                                    $data_uma_semana = date('Y-m-d',$data_atual);
                                   
                                    //echo date('Y-m-d', $data_atual);
                                    foreach ($itens as $row):
                                         
                                        $data_final = '';
                                        if($row->data !='0000-00-00'){
                                            $data_final = $row->data;
                                        }
                                        if($row->data_segunda !='0000-00-00'){
                                            $data_final =$row->data_segunda;
                                        }
                                        if($row->data_terceira !='0000-00-00'){
                                            $data_final =$row->data_terceira;
                                        }


                                        ?>
                                        <tr>
                                            <td><?= $row->status ?></td>
                                            <td><?= $row->turma ?></td>
                                            <td><?= $row->curso ?></td>
                                            <td><?= abreviaString(strip_tags($row->modulo),100) ?></td>
                                          
                                            
                                            <td><?= $row->sala_id ?></td>
                                             <td> <a class="btn btn-xs btn-info btn btn-info" href="<?php echo site_url(); ?>/admin/agendamento/ver_minha_agenda/<?php echo $row->agenda_id ?>" title="Visulizar este registro"  class="btn btn-mini btn-primary"><i class="fa fa-eye"></i>Ver Detalhes</a></td>
                                             <?php 
                                                if($data_uma_semana <= $data_final){
                                                    if($row->tipo=='reposicao' || $row->tipo=='revisao' ){
                                                        if($row->presenca=='confirmado'){?>
                                                            <td><a class="cancelar_presenca btn btn-xs btn-info btn btn-info" data-confirm="<?php echo site_url(); ?>/admin/agendamento/cancelar_minha_agenda" href="<?php echo $row->agenda_id ?>" title="Cancelar este registro"  class="btn btn-mini btn-primary"><i class="fa fa-eye"></i>Cancelar</a></td>
                                                        <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                             
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
