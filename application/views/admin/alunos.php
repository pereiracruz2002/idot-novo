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
								<a data-presenca="2" class="add_obs btn btn-xs btn-info btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i>Marcar Revisão</a>
                            </td>
                            <?php }elseif($row->presenca =='nao'){?>
								
								<a data-presenca="2" class="add_obs btn btn-xs btn-info btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i>Marcar Reposição</a>

                            </td>
                        <?php }else{?>
							<td class="acoes_alunos"></td>
                        <?php } ?>
	                        <td class="acoes_alunos">
                            	<a class="btn btn-xs btn-info btn btn-warning" href="/index.php/admin/alunos/editar/<?= $row->aluno_id ?>" title="Editar este registro"><i class="fa fa-pencil"></i> Editar</a>
                    			<a class="btn btn-xs btn btn-danger delete" href="#" data-remove="/index.php/admin/alunos/deletar/<?= $row->aluno_id ?>" title="Deletar este registro"><i class="fa fa-times-circle"></i> Deletar</a>
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