<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/header.php'); ?>
	<div class="panel-heading">
        <h2>Meus Agendamentos</h2>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
        	<!-- <table>
				<tr>
					<td>
						<button style="background-color:#d9534f; color:#fff" class="btn btn-danger" type="button">Reposição</button>
					</td>
					<td>
						<button style="background-color:#f0ad4e; color:#fff" class="btn btn-warning" type="button">Revisão</button>
					</td>
					<td></td>
				</tr>
        	</table> -->
	        <table class="table table-striped small">
	            <thead>
	                <tr>
	                	<th>#</th>
	                    <th>Nome</th>
	                    <th>Curso</th>
	                    <th>Módulo</th>
	                    <th>Data</th>
	                    <th>Tipo Aula</th>
	                    <th>Nota</th>
	                    <th>Observação</th>
	                    <th>&nbsp;</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                $array_obs = array();
	                $i = 1;
	                foreach ($itens as $row):
	                	$array_obs[] = $row->obs;
	         			if($row->data !='0000-00-00'):
	                 ?>
	                 <?php if($row->tipo=='revisao'):?>
	                    <tr style="background-color:#f2dede";>
	                <?php elseif($row->tipo=='reposicao'):?>
	                	<tr style="background-color:#F0E68C";>
	                <?php else:?>
						<tr style="background-color:#CEECF5";>
	                <?php endif;?>
	                		<td><?= $i; ?></td>
	                        <td><?= $row->nome ?></td>
	                        <td><?= $row->curso ?></td>
	                        <td><?= $row->modulo ?></td>
	                        <td><?= formata_data($row->data) ?></td>
	                        <td><?php if($row->tipo=="revisao"){echo "Revisão";}elseif($row->tipo=="reposicao"){echo "Reposição";}elseif($row->tipo=="normal"){echo "Normal";}elseif($row->tipo=="espera"){echo "Aguardando vagas";} ?></td>
	                        <td><?php 

		                        if(is_null($row->nota) || empty($row->nota)){?>
		                             <a  data-presenca="<?php echo $row->presenca_id ?>"  class="add_nota_aluno btn btn-xs btn-info btn btn-info" data-toggle="modal" data-target="#myModalNota"><i class="fa fa-eye"></i>Adicionar Nota</a>
		                        <?php }else{
		                           echo $row->nota;
		                          } ?>
	                        </td>
	                        <td><a data-linha="<?php echo $row->linha;?>"  data-presenca="<?php echo $row->presenca_id ?>"  class="add_obs btn btn-xs btn-info btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i>Observação</a></td>
	                        <td class="acoes">
	                            <?php 

		                        if($row->presenca=='confirmado' || is_null($row->presenca)){?>
		                            <a class="btn btn-xs btn-info btn btn-info confirmar_chamada" href="<?php echo $row->presenca_id ?>" title="Visulizar este registro" data-confirm="<?php echo site_url(); ?>/admin/agendamento/chamada/<?php echo $row->aluno_id ?>/<?php echo $row->presenca_id ?>/1" class="btn btn-mini btn-primary confirmar_presenca"><i class="fa fa-eye"></i>Confirmar Presença</a>
		                            <a class="btn btn-xs btn-info btn btn-info confirmar_chamada" href="<?php echo $row->presenca_id ?>" title="Visulizar este registro" data-confirm="<?php echo site_url(); ?>/admin/agendamento/chamada/<?php echo $row->aluno_id ?>/<?php echo $row->presenca_id ?>/2" class="btn btn-mini btn-primary confirmar_presenca"><i class="fa fa-eye"></i>Confirmar Ausência</a>
		                             <!--<a  class="btn btn-xs btn-info btn btn-info" href="<?php echo site_url(); ?>/admin/agendamento/add_obs/<?php echo $row->aluno_id ?>/<?php echo $row->agenda_id ?>" title="Visulizar este registro" data-confirm="" class="btn btn-mini btn-primary confirmar_presenca"><i class="fa fa-eye"></i>Observação</a>-->
		                             
		                        <?php }else{?>
		                            <?php if($row->presenca=='sim'):?>
		                               <p><i class="pe-7s-check">Presente</i></p>
		                            <?php elseif($row->presenca=='nao'):?>
		                               <p><i class="pe-7s-check">Ausente</i></p>
		                            <?php else:?>
		                                 <p><i>Não confirmou</i></p>
		                            <?php endif;?>
		                         <?php } ?>
		                         
	                        </td>

	                    </tr>
	                	<?php endif; ?>
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
			<?php $i = 0;?>
			<?php foreach($array_obs as $obs): ?>
			  <textarea  data-id="<?php echo $i;?>" class="form-control observacao_linha" name="observacao" rows="5" id="observacao"><?php echo trim($obs);?></textarea>
			  <?php endforeach;?>	
			  <input type="hidden" id="presenca_id" name="presenca_id" value="" />
			   <input type="hidden" id="linha" name="linha" value="" />
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