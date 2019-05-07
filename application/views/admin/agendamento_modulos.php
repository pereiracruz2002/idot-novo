<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/header.php'); ?>
	<div class="panel-heading">
        <h2>Meus Agendamentos</h2>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
	        <table class="table table-striped small">
	            <thead>
	                <tr>
	                    <th>TURMA</th>
	                    <th>NÍVEL</th>
	                    <th>MÓDULO</th>
	                    <th>PROFESSOR</th>
	                    <th>DATA DO CURSO</th>
	                    <th>&nbsp;</th>
	                   
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                foreach ($itens as $row):
			$array_periodos = array();
 ?>
	                    <tr>
	                        <td><?= $row->turma ?></td>
	                        <td><?= $row->curso ?></td>
	                        <td><?= abreviaString(strip_tags($row->modulo),50) ?></td>
	                        <td><?= $row->professor ?></td>
	                        <td><?php
	                        $diasemana = array('domingo', 'segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado');

					        if($row->dias_semana){
					            $consulta = unserialize($row->dias_semana);
							

					            foreach($consulta as $i => $c){
					                $indice_semana = explode(' ', $c);
					                $array_periodos[$indice_semana[0]][$i] = $c;
					            }
					        }

					        if($row->data !='0000-00-00'){
					            if(!is_null($row->data)){

					                $diasemana_numero = date('w', strtotime($row->data));
					                $row->data = formata_data($row->data);
							$array_checa_data = array();
					                foreach($array_periodos as $chave => $periodos){
					                    if($chave == $diasemana[$diasemana_numero]){
					                        foreach($periodos as $periodo){
								    if(!array_key_exists($periodo,$array_checa_data)){
					                            	$row->data.="<br />".$periodo;
								    }
								    $array_checa_data[$periodo] = $periodo;
					                        }
								
					                       
					                    }
					                    
					                }
					            echo $row->data;
	                        	echo "<br />";

					            }
           
        					}

        					if($row->data_segunda !='0000-00-00'){
					            if(!is_null($row->data_segunda)){

					                $diasemana_numero = date('w', strtotime($row->data_segunda));
					                $row->data_segunda = formata_data($row->data_segunda);
							$array_checa_data = array();
					                foreach($array_periodos as $chave => $periodos){
					                    if($chave == $diasemana[$diasemana_numero]){
					                        foreach($periodos as $periodo){
								    if(!array_key_exists($periodo,$array_checa_data)){
					                            	$row->data_segunda.="<br />".$periodo;
								    }
								    $array_checa_data[$periodo] = $periodo;
					                        }
								
					                       
					                    }
							
					                    
					                }
					            echo $row->data_segunda;
	                        	echo "<br />";

					            }
           
        					}
        					if($row->data_terceira !='0000-00-00'){
					            if(!is_null($row->data_terceira)){

					                $diasemana_numero = date('w', strtotime($row->data_terceira));
					                $row->data_terceira = formata_data($row->data_terceira);
							$array_checa_data = array();
					                foreach($array_periodos as $chave => $periodos){
					                    if($chave == $diasemana[$diasemana_numero]){
					                        foreach($periodos as $periodo){
								    if(!array_key_exists($periodo,$array_checa_data)){
					                            	$row->data_terceira.="<br />".$periodo;
								    }
								    $array_checa_data[$periodo] = $periodo;
					                        }
								
								
					                       
					                    }
					                    
					                }

					            }

					             echo $row->data_terceira;
        					}
	                       
	                       
	                       
	                         ?></td>
	                          <td class="acoes_alunos">
                            	<a class="btn btn-xs btn-info btn btn-warning" href="/index.php/admin/calendario/novo/<?= $row->agenda_id ?>" title="Adicionar Data"><i class="fa fa-pencil"></i> Adicionar Data</a>
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