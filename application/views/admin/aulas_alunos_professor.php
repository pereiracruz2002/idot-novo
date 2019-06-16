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
	                	
	                    <th>Nome</th>
	                    <th>Curso</th>
	                    <th>Módulo</th>
	                    <th>Data</th>
	                    <th >Período</th>
	                    <th>Tipo Aula</th>
	                    <!-- <th>Nota</th> -->
	                    <th>Observação</th>
	                    <!-- <th>&nbsp;</th> -->
	                </tr>
	            </thead>
	            <tbody>
	                <?php 
	                $array_obs = array();
	                $i = 1;
	                $array_periodos = array();
	                 $diasemana = array('domingo', 'segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado');
	                foreach ($itens as $row):

	                $array_dias =unserialize($row->dias_semana);
	            	$aulas_assistidas = explode(',', $row->semana);
	            	$notas_aulas = explode(',',$row->nota);
	            	//var_dump($notas_aulas);

	            	$aulas_assistidas_formatada = array();
	            	$notas_formatada = array();
	            	$dia_marcado = array();
	            	$nota_dia_marcado = array();
	            	$qtd_assistidas = 0;
	            	foreach($aulas_assistidas as $assistidas){
	            		if(!empty($assistidas)){
	            			$aulas_assistidas_formatada[] = substr($assistidas, 0, -2);
	            			$dia_marcado[substr($assistidas, 0, -2)] = substr($assistidas,-1,1);
	            			$qtd_assistidas++;
	            		}
	            	}

	            	foreach($notas_aulas as $notas_dadas){
	            		//echo $notas_dadas;
	            		if(!empty($notas_dadas)){

	            			$nota_dia_marcado[] = substr($notas_dadas, 0, -2);
	            			$notas_formatada[substr($notas_dadas, 0, -2)] = substr($notas_dadas,-2);
	            		}
	            	}

	          

	            	

	            	// echo $qtd_assistidas;
	            	// echo "<br />";
	            	// exit();
	            	$dias_semana = '';
	            	foreach($array_dias as $i => $dias){

	            		
		                $indice_semana = explode(' ', $dias);
		                $array_periodos[$indice_semana[0]][$i] = $dias;


	            		//$dias_semana.= "<p style='width:110px;font-size:12px;'>".$dias." <input type='radio' class='dias_semana' name='dia_semana' value='".$dias."' /></p>";
	            	}
	            	$diasemana_numero = date('w', strtotime($row->data));

	            		foreach($array_periodos as $chave => $periodos){
		                    if($chave == $diasemana[$diasemana_numero]){
		                    	$total = 0;
		                    	$tipo_marcacao = '';
		                        foreach($periodos as $periodo){
		                        	$total++;
		                        	if(!in_array($periodo,$aulas_assistidas_formatada)){
		                        		$dias_semana.= '<p style="font-size:12px;">'. $periodo.' <a  class="btn btn-xs btn-info  btn-info confirmar_chamada" href="'. $row->presenca_id.'" title="Visulizar este registro" data-confirm="'.site_url().'/admin/agendamento/chamada/'.$row->aluno_id.'/'.$row->presenca_id.'/1/'.$periodo.'" class="btn btn-mini btn-primary confirmar_presenca">Presença</a>
										<a  class="btn btn-xs btn-info  btn-info confirmar_chamada" href="'. $row->presenca_id.'" title="Visulizar este registro" data-confirm="'.site_url().'/admin/agendamento/chamada/'.$row->aluno_id.'/'.$row->presenca_id.'/2/'.$periodo.'" class="btn btn-mini btn-primary confirmar_presenca">Ausência</a>
										
		                        		</p>';
		                        	}else{
		                        		if($dia_marcado[$periodo] == 1){
		                        			$tipo_marcacao = 'Presença';
		                        		}else{
		                        			$tipo_marcacao = 'Ausência';
		                        		}
		                        		$dias_semana.= '<p style="font-size:12px;">'. $periodo.' - '.$tipo_marcacao.'</p>';
		                        	}


		                        	if(!array_key_exists($periodo, $notas_formatada)){
		                        		$dias_semana.= '<p><a href="#" data-nota="'.$periodo.'"  data-presenca="'.$row->presenca_id.'"  class="add_nota_aluno btn btn-xs btn-info btn btn-warning btn-block" data-toggle="modal" data-target="#myModalNota">Adicionar Nota</a>';
		                        	}else{
		                        		$dias_semana.= "<p class='badge badge-success' style='display:block; background-color:orange;'>Nota".str_replace("-",": ",$notas_formatada[$periodo])."</p>";
		                        	}
		                        	

		                        }
		                       
		                    }
		                    
		                }
		              

	            	//var_dump($array_periodos);



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
	                		
	                        <td><?= $row->nome ?></td>
	                        <td><?= $row->curso ?></td>
	                        <td><?= $row->modulo ?></td>
	                        <td><?= formata_data($row->data) ?></td>
	                        <td><?php //if($row->presenca=='sim' || $row->presenca=='nao'){
	                        	if($qtd_assistidas == $total){
	                        	//echo $dias_semana;
	                        		echo $dias_semana;
	                        	}else{
	                        			echo $dias_semana;
	                        		} ?></td>
	                        <td><?php if($row->tipo=="revisao"){echo "Revisão";}elseif($row->tipo=="reposicao"){echo "Reposição";}elseif($row->tipo=="normal"){echo "Normal";}elseif($row->tipo=="espera"){echo "Aguardando vagas";} ?></td>
	                        <!-- <td> -->
	                        	<?php 
	                        	/*
		                        if(is_null($row->nota) || empty($row->nota)){
		                        	
		                        	
		                        	?>

		                             <a   data-presenca="<?php echo $row->presenca_id ?>"  class="add_nota_aluno btn btn-xs btn-info btn btn-info" data-toggle="modal" data-target="#myModalNota"><i class="fa fa-eye"></i>Adicionar Nota</a>
		                        <?php }else{
		                           echo $row->nota;
		                          } */?>
	                        <!-- </td> -->
	                        <td><a data-linha="<?php echo $row->linha;?>"  data-presenca="<?php echo $row->presenca_id ?>"  class="add_obs btn btn-xs btn-info btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i>Observação</a></td>
	                        <!-- <td class="acoes"> -->
	                            <?php 
	                            	/*
		                        if($row->presenca=='confirmado' || is_null($row->presenca)){?>
		                            <a  class="btn btn-xs btn-info btn btn-info confirmar_chamada" href="<?php echo $row->presenca_id ?>" title="Visulizar este registro" data-confirm="<?php echo site_url(); ?>/admin/agendamento/chamada/<?php echo $row->aluno_id ?>/<?php echo $row->presenca_id ?>/1" class="btn btn-mini btn-primary confirmar_presenca"><i class="fa fa-eye"></i>Confirmar Presença</a>
		                            <a  class="btn btn-xs btn-info btn btn-info confirmar_chamada" href="<?php echo $row->presenca_id ?>" title="Visulizar este registro" data-confirm="<?php echo site_url(); ?>/admin/agendamento/chamada/<?php echo $row->aluno_id ?>/<?php echo $row->presenca_id ?>/2" class="btn btn-mini btn-primary confirmar_presenca"><i class="fa fa-eye"></i>Confirmar Ausência</a>
		                             <!--<a  class="btn btn-xs btn-info btn btn-info" href="<?php echo site_url(); ?>/admin/agendamento/add_obs/<?php echo $row->aluno_id ?>/<?php echo $row->agenda_id ?>" title="Visulizar este registro" data-confirm="" class="btn btn-mini btn-primary confirmar_presenca"><i class="fa fa-eye"></i>Observação</a>-->
		                             
		                        <?php }else{?>
		                            <?php if($row->presenca=='sim'):?>
		                               <p>Presente</p>
		                            <?php elseif($row->presenca=='nao'):?>
		                               <p>Ausente</p>
		                            <?php else:?>
		                                 <p><i>Não confirmou</i></p>
		                            <?php endif;?>
		                         <?php } */?>
		                         
	                        <!-- </td> -->

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
			 <input type="hidden" id="periodo" name="periodo" value="" />
			</div>
			<button id="send_nota" type="submit" class="btn btn-primary btn-block">Enviar</button>
        </form>
      </div>
     
    </div>

  </div>
</div>



 <?php include_once(dirname(__FILE__) . '/footer.php'); ?>  