<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/header.php'); ?>
	<div class="panel-heading">
        <h2>Níveis</h2>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
	        <table class="table table-striped small">
	            <thead>
	                <tr>
	                    <th>TURMA</th>
	                    <th>NÍVEL</th>
	                    <th>PROFESSOR</th>
	                    <th>&nbsp;</th>
	                   
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                foreach ($itens as $row): ?>
	                    <tr>
	                        <td><?= $row->turma ?></td>
	                        <td><?= $row->curso ?></td>
	                        <td><?= $row->professor ?></td>
	                          <td class="acoes_alunos">
                            	<a class="btn btn-xs btn-info btn btn-warning" href="/index.php/admin/calendario/modulos/<?= $row->turma ?>/<?= $row->curso_id ?>" title="Adicionar Data"><i class="fa fa-pencil"></i> Ver Módulos</a>
                            </td>
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
 <?php include_once(dirname(__FILE__) . '/footer.php'); ?>  