<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/header.php'); ?>
	<div class="panel-heading">
        <h2>Meus Agendamentos</h2>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
	        <table class="table table-striped small">
	            <thead>
	                <tr>
	                    <th>Nome</th>
	                    <th>Curso</th>
                      <th>Módulo</th>
	                    <th>&nbsp;</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                foreach ($itens as $row):?>
	                    <tr>
	                        <td><?= $row->nome ?></td>
	                        <td><?= $row->curso ?></td>
                          <td><?= $row->modulo?></td>
	                        <td><a href="<?php base_url();?>/admin/agendamento/ver_inscritos/<?php echo $row->agenda_id;?>/<?php echo $row->aluno_id;?>" class="btn btn-xs btn btn-xs btn-info btn btn-warning">Ver</td>
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
			<?php $i = 0;?>
			<?php foreach($array_obs as $obs): ?>
			  <textarea  data-id="<?php echo $i;?>" class="form-control observacao_linha" name="observacao" rows="5" id="observacao"><?php echo trim($obs);?></textarea>
			  <?php endforeach;?>	
			  <input type="hidden" id="presenca_id" name="presenca_id" value="" />
			</div>
			<button id="send_obs" type="button" class="btn btn-primary btn-block">Enviar</button>
        </form>
      </div>
     
    </div>

  </div>
</div>

<!-- Modal -->
<div id="myModalNota" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Sistema IDOT</h4>
      </div>
      <div class="modal-body">
        <p>Insira uma Nota</p>
        <form id="form_nota" method="" action="<?php echo site_url(); ?>/admin/agendamento/add_nota">
			<div class="form-group">
			  <input type="text"  required="required" class="form-control" id='nota' name="nota">
			  <input type="hidden" id="presenca_id" name="presenca_id" value="" />
			</div>
			<button id="send_nota" type="submit" class="btn btn-primary btn-block">Enviar</button>
        </form>
      </div>
     
    </div>

  </div>
</div>



 <?php include_once(dirname(__FILE__) . '/footer.php'); ?>  