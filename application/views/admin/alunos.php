<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/header.php'); ?>
	<div class="panel-heading">
        <h2>Alunos</h2>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
	        <table class="table table-striped small">
	            <thead>
	                <tr>
	                	<th>#</th>
	                    <th>Nome</th>
	                    <th>Curso</th>
	                    <th>Módulo</th>
	                    <th>Tipo Aula</th>
	                    <th>Assento Sala 1</th>
	                    <th>Assento Sala 2</th>
	                    <th>&nbsp;</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                $i = 1;
	                foreach ($itens as $row): ?>
	                	<?php if($row->tipo=='revisao'):?>
                          <tr style="background-color:#d9534f"; class="danger">
                          <?php elseif($row->tipo=='reposicao'):?>
                            <tr style="background-color:#5cb85c"; class="success">
                          <?php else:?>
                          <tr style="background-color:#CEECF5"; class="primary">
                          <?php endif;?>
							<td><?= $i;?></td>
	                        <td><?= $row->nome ?></td>
	                        <td><?= $row->curso ?></td>
	                        <td><?= $row->modulo ?></td>
	                        <td><?php if($row->tipo=="revisao"){echo "Revisão";}elseif($row->tipo=="reposicao"){echo "Reposição";}elseif($row->tipo=="normal"){echo "Normal";}elseif($row->tipo=="espera"){echo "Aguardando vagas";} ?></td>
	                        <td><?= $row->mesa ?></td>
	                        <td><?= $row->mesa2 ?></td>
							<td class="acoes_alunos">
                            	<a class="btn btn-xs btn-info btn btn-warning" href="/index.php/admin/alunos/editar/<?= $row->aluno_id ?>" title="Editar este registro"><i class="fa fa-pencil"></i> Editar</a>
                    			<a class="btn btn-xs btn btn-danger delete" href="#" data-remove="/index.php/admin/alunos/deletar/<?= $row->aluno_id ?>" title="Deletar este registro"><i class="fa fa-times-circle"></i> Deletar</a>
                            </td>
	                    </tr>
	                    <?php $i++;?>
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