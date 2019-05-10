<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/header.php'); ?>
	<div class="panel-heading">
        <h2>Alunos</h2>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
	        <table class="table table-striped small">
	            <thead>
	                <tr>
	                    <th>Nome</th>
	                    <th>Curso</th>
	                    <th>Módulo</th>
	                    <th>Tipo Aula</th>
	                    <th>Maca Sala 1</th>
	                    <th>Maca Sala 2</th>
	                    <th>Presente</th>
	                    <th>&nbsp;</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                
	                foreach ($itens as $row): ?>
	                    <tr>
	                        <td><?= $row->nome ?></td>
	                        <td><?= $row->curso ?></td>
	                        <td><?= $row->modulo ?></td>
	                        <td><?= $row->tipo ?></td>
	                        <td><?= $row->mesa ?></td>
	                        <td><?= $row->mesa2 ?></td>
	                        <td><?php if($row->presenca !='confirmado'){
	                        	echo $row->presenca;
	                        }?></td>
	                        <?php if($row->presenca =='sim'){?>
	                        <td class="acoes_alunos">
								<a data-presenca="1" class="add_presenca btn btn-xs btn-info btn btn-info" data-toggle="modal" data-target="#myModalAgendamento"><i class="fa fa-eye"></i>Marcar Revisão</a>
                            </td>
                            <?php }elseif($row->presenca =='nao'){?>
								
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

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sistema IDOT</h4>
      </div>
      <div class="modal-body">
        <p>Insira uma Observação</p>
        <form id="form_observacao" method="" action="<?php echo site_url(); ?>/admin/agendamento/add_obs">
			<div class="form-group">
			  <textarea class="form-control" name="observacao" rows="5" id="observacao"></textarea>
			  <input type="hidden" id="presenca_id" name="presenca_id" value="" />
			</div>
			<button id="send_obs" type="button" class="btn btn-primary btn-block">Enviar</button>
        </form>
      </div>
     
    </div>

  </div>
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