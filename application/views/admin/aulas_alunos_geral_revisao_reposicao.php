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
                        <th>Presente</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                    foreach ($itens as $row): ?>
                        <tr>

                            <td><?= $row->curso ?></td>
                            <td><?= abreviaString(strip_tags($row->modulo),100) ?></td>


                            <td><?php if($row->presenca !='confirmado'){
                                echo $row->presenca;
                            }?></td>
                            <?php if($row->presenca =='sim'){?>
                            <td class="acoes_alunos">
                                <a data-presenca="1" class="add_presenca btn btn-xs btn-info btn btn-info" data-toggle="modal" data-target="#myModalAgendamento2"><i class="fa fa-eye"></i>Marcar Revisão</a>
                            </td>
                            <?php }elseif($row->presenca =='nao'){?>
                             <td class="acoes_alunos">  
                                <a data-presenca="2" class="add_presenca btn btn-xs btn-info btn btn-info" data-toggle="modal" data-target="#myModalAgendamento"><i class="fa fa-eye"></i>Marcar Reposição</a>

                            </td>
                        <?php }else{?>
                            <td class="acoes_alunos"></td>
                        <?php } ?>
                        </tr>
                    <?php endforeach; ?>
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
        <div class="alert alert-danger" role="alert">
            Para fazer uma aula de reposição você deve entrar em contato com o Idot (11) 99784-0978
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
        <form id="send_agendamento" method="" action="<?php echo site_url(); ?>/admin/agendamento/add_novaAula">
            <div class="form-group">
              <?php 

              if(count($agendamentos)> 0):?>
                <select class="form-control" name="turma">
                <?php foreach($agendamentos as $agendamento):?>
                    <option value="<?php echo $agendamento->turma?>"><?php echo "Turma ". $agendamento->turma. " - " .$agendamento->curso." - ". $agendamento->modulo;?></option>
                <?php endforeach;?>
                </select>
               
              <input type="hidden" id="aluno" name="aluno_id" value="<?php echo $row->aluno_id;?>" />
              <input type="hidden" id="agenda_id" name="agenda_id" value="<?php echo $agendamento->agenda_id;?>" />
              <input type="hidden" id="curso_id" name="curso_id" value="<?php echo $agendamento->curso_id;?>" />
              <input type="hidden" id="modulo_id" name="modulo_id" value="<?php echo $agendamento->modulo_id;?>" />
              <input type="hidden" id="tipo_aula" name="tipo_aula" value="" />
               <?php endif; ?>
            </div>
            <button id="send_agendamento" type="submit" class="btn btn-primary btn-block">Enviar</button>
        </form>
      </div>
     
    </div>

  </div>
</div>


 <?php include_once(dirname(__FILE__) . '/footer.php'); ?>  