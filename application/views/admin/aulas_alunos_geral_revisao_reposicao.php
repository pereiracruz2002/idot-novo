<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/header.php'); ?>
    <div class="panel-heading">
        <h2>Alunos</h2>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped small">
                <thead>
                    <tr>

                        <th>Curso</th>
                        <th>Módulo</th>
                        <th>Dia Presença</th>
                        <th>Presente</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 

                    
                    if(isset($itens)):
                      $i = 0;
                      foreach ($itens as $row): ?>
                           <?php if($row->tipo=='revisao'):?>
                          <tr style="background-color:#d9534f"; class="danger">
                          <?php elseif($row->tipo=='reposicao'):?>
                            <tr style="background-color:#5cb85c"; class="success">
                          <?php else:?>
                          <tr style="background-color:#CEECF5"; class="primary">
                          <?php endif;?>

                              <td><?= $row->curso ?></td>
                              <td><?= abreviaString(strip_tags($row->modulo),100) ?></td>
                              <td><?php 
                                if($row->presenca == 'sim' ){
                                  echo formata_data($row->data_dia);}

                              ?>

                              <td><?php if($row->presenca !='confirmado'){

                                  if($row->presenca == 'sim' ){
                                    echo "Sim";
                                  }elseif($row->presenca == 'nao'){
                                    echo "Não";
                                  }
                                  //echo $row->presenca;
                              }?></td>
                                <?php if(array_key_exists($i,$agendamentos_extra )){?>
                                    <td class="acoes_alunos">Já existe um agendamento para a <?php echo $agendamentos_extra[$i];?></td>
                                    
                                  <?php }else{?>
                                      <?php if($row->presenca =='sim'){?>
                                        <td class="acoes_alunos">
                                            <a data-id="<?php echo $row->linha;?>" data-presenca="1" class="add_presenca btn btn-xs btn-info btn btn-warning" data-toggle="modal" data-target="#myModalAgendamento2"><i class="fa fa-eye"></i>Marcar Revisão</a>
                                        </td>
                                      <?php }elseif($row->presenca =='nao'){?>
                                         <td class="acoes_alunos">  
                                            <a data-id="<?php echo $row->linha;?>" data-presenca="2" class="add_presenca btn btn-xs btn-info btn btn-warning" data-toggle="modal" data-target="#myModalAgendamento2"><i class="fa fa-eye"></i>Marcar Reposição</a>
                                        </td>
                                    <?php }else{?>
                                        <td class="acoes_alunos"></td>
                                    <?php } ?>
                                <?php } ?>
                          </tr>
                          <?php $i++;?>
                      <?php endforeach; ?>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
     </div><!--/panel-body-->
    </div><!--/row-->
</div>


<!-- Modal Revisao ou reposicao -->
<div id="myModalAgendamento" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sistema IDOT</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger text-center" role="alert">
            Para fazer uma aula de reposição entrar em contato com o idot (11) 99784-0978<br />
            Sera cobrado uma taxa de R$ 50,00 pago no dia da reposição.<br />
            Obrigado.<br/>
            A Gerência.
        </div>
        
      </div>
     
    </div>

  </div>
</div>


<!-- Modal Revisao ou reposicao -->
<div id="myModalAgendamento2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sistema IDOT</h4>
      </div>
      <div class="modal-body">

         <p>Escolha uma turma</p>
        <form id="send_agendamento" method="post" action="<?php echo site_url(); ?>/admin/agendamento/add_novaAula">
            <div class="form-group">
              
          
            <?php 

            if(isset($agendamentos)):
              //if(count($agendamentos)> 0):
                $dias = formata_data($agendamentos->data);
                if(!empty($agendamentos->data_segunda)){
                  if($agendamentos->data_segunda != '0000-00-00'){
                    $dias.= ", ".formata_data($agendamentos->data_segunda);
                  }
                }
                 if(!empty($agendamentos->data_terceira)){
                    if($agendamentos->data_terceira != '0000-00-00'){
                      $dias.= ", ".formata_data($agendamentos->data_terceira);
                    }
                  
                }


                if(!$prosegue){?>

               <div class="alert alert-danger text-center" role="alert">

                  No momento a sala para o curso <?php echo $agendamentos->curso;?> -<?php echo $agendamentos->modulo;?> está completa. Se desejar ficar aguardando a desistência de alguém clique no fila de espera.<br />
                  Caso haja alguma desistênica você será avisado por email.
              </div>
              <?php }

                /*
                ?>
                <select class="form-control" id="turma" name="turma">
                <?php foreach($agendamentos as $agendamento):
                  $consulta = '';
                  $array_data[0] = $agendamento->data;
                  $array_data[1] = $agendamento->data_segunda;
                  $array_data[2] = $agendamento->data_terceira; 
                
                //var_dump($agendamentos);
                
                $consulta = unserialize($agendamento->dias_semana);



                ?>
                    <?php foreach($consulta as $k => $c):?>
                    <?php 
                    if($c == "sexta manhã" || $c == "sexta tarde" || $c=="sexta noite"){
                      $indice = 0;
                    }

                    if($c == "sábado manhã" || $c == "sábado tarde"){
                      $indice = 1;
                    }

                     if($c == "domingo manhã" || $c == "domingo tarde"){
                      $indice = 2;
                    }

                    ?>
                      <option data-periodo="dia_<?php echo $indice;?>" value="<?php echo $c?>"><?php echo "Turma ". $agendamento->turma. " - " .$agendamento->curso." - ". $agendamento->modulo. " - ".ucfirst($c). " - ".formata_data($array_data[$indice]);?></option>
                     <?php endforeach;?>
                <?php endforeach;?>
                </select>
                <?php */ ?>
              <?php if($prosegue){?>
              <div class="alert alert-success" role="alert">
                  Há um agendamento disponível do curso <?php echo $agendamentos->curso;?> - <?php echo $agendamentos->modulo;?>.<br />
                  Deseja realmente marcar esse agendamento?
              </div>
            <?php } ?>
              <input type="hidden" id="turma" name="turma" value="<?php echo $row->turma;?>" />
              <input type="hidden" id="aluno" name="aluno_id" value="<?php echo $row->aluno_id;?>" />
              <input type="hidden" id="agenda_id" name="agenda_id" value="<?php echo $agendamentos->agenda_id;?>" />
              <input type="hidden" id="curso_id" name="curso_id" value="<?php echo $agendamentos->curso_id;?>" />
              <input type="hidden" id="modulo_id" name="modulo_id" value="<?php echo $agendamentos->modulo_id;?>" />
              <input type="hidden" id="tipo_aula" name="tipo_aula" value="" />
              <input type="hidden" id="linha" name="linha" value="" />
                <?php if(!$prosegue):?>
                  <input type="hidden" id="espera" name="espera" value="espera" />
                <?php endif;?>
               <?php else:?>
                <div class="alert alert-danger text-center" role="alert">
                  Não há nenhum agendamento disponível neste momento!<br />
              </div>
               <?php endif; ?>
            </div>
             <?php if(isset($prosegue) and $prosegue==FALSE):?>
              <button id="send_agendamento" type="submit" class="btn btn-primary btn-block">Fila de Espera</button>
            <?php elseif(isset($prosegue) and $prosegue==TRUE):?>
              <button id="send_agendamento" type="submit" class="btn btn-primary btn-block">Agendar</button>
            <?php endif;?>
        </form>
      </div>
     
    </div>

  </div>
</div>


 <?php include_once(dirname(__FILE__) . '/footer.php'); ?>  