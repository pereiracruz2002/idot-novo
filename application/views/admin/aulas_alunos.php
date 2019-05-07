<?php if (!$this->input->is_ajax_request()) include_once(dirname(__FILE__) . '/header.php'); ?>
<div class="content">
    <div class="row">
        <div class="panel-heading">
            <h2>Meus Agendamentos</h2>
        </div>
       

        <div class="panel-body">

            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped small">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Turma</th>
                                    <th>Nivel</th>
                                    <th>Módulo</th>
                                    <!-- <th>Professor</th> -->
                                    <th>Data curso - período</th>
                                   
                                    <th>Sala</th>
                                    <th>Maca</th>                              
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $linhas = 0;

                               
                                if($row):
  
                                        $agenda_id = $row->agenda_id;
                                        $aluno_id = $row->aluno_id;

                                        
                                        $mesas = '';
                                        foreach ($mesas_ocupadas as $key => $value) {
                                            foreach ($value as $chave => $valor) {
                                                if(!is_null($value[$chave]->mesa)){
                                                    $mesas.= $value[$chave]->mesa.",";
                                                }
                                            }
                                            
                                        }


                                        echo "<script type='text/javascript'>";

                                        echo "var bookedSeats =[". substr($mesas, 0, -1). "];\n";
                                        echo "</script>";
                                        ?>
                                        <tr>
                                            <td><?= $row->status ?></td>
                                            <td><?= $row->turma ?></td>
                                            <td><?= $row->curso ?></td>
                                            <td><?= strip_tags($row->modulo) ?></td>
                                            <!-- <td><?= $row->professor ?></td> -->
                                            <td><?php 
                                            $array_dias = array();
                                            if(isset($row->data)){
                                                if($row->data != '0000-00-00'){
                                                     echo $row->data;
                                                echo "<br />";
                                                }
                                               
                                            }
                                            if(isset($row->data_segunda)){
                                                if($row->data_segunda != '0000-00-00'){
                                                    echo $row->data_segunda;
                                                    echo "<br />";
                                                }
                                                
                                            }
                                            if(isset($row->data_terceira)){
                                                if($row->data_terceira != '0000-00-00'){
                                                        echo $row->data_terceira;
                                                        echo "<br />";
                                                }
                                            }

                                           

                                           
                                            // $dias = unserialize($row->dias_semana);
                                            // $i = 0;
                                           
                                            // if($dias){   
                                            //     foreach ($dias as $key => $value) {

                                            //         if(isset($array_dias[$key])){
                                            //             $array_dias[$key].=$value;
                                                        
                                            //             echo $array_dias[$key];
                                            //             echo "<br />";
                                            //         }
                                                   
                                                   
                                            //         $i++;
                                                    
                                            //     }
                                            // }else{
                                            //     echo "Sem Data Definida";
                                            // }


                                           


                                            ?>
                                            </td>
                                            
                                            
                                            <td><?= $row->sala_id ?></td>
                                             <td><?= $row->mesa ?></td>
                                        </tr>
                                    <?php endif;?>
                            </tbody>
                        </table>
                        <?php if($row):?>
                            <div class="col-sm-12">
                                <div style="color:red; font-weight:bold;" class="row">
                                    <div class="col-sm-6 col-offset-sm-6">
                                        <h5 style="font-weight:bold;">Caso queira escolher outra maca:</h5>
                                        <ul>
                                            <li>Selecione a maca desejada;</li>
                                            <li>Clicar em alterar maca no botão abaixo.</li>
                                        </ul>
                                    </div>
                                </div>
                                <form id="form1" runat="server">
                                    <h2 style="font-size:1.2em;"> Selecione a maca:</h2>
                                    <?php 
                                    
                                    if($row->sala_id ==1):?>
                                    <div id="holder2"> 
                                        <ul  id="place2">
                                        </ul>    
                                    </div>
                                    <div style="width:600px;text-align:center;overflow:auto"> 
          
                                    </div>

                                    <?php else:?>

                                    <div id="holder"> 
                                        <ul  id="place">
                                        </ul>    
                                    </div>
                                    <div style="width:600px;text-align:center;overflow:auto"> 
          
                                    </div>

                                    <?php endif;?>
                                   

                                    <?php if(isset($meu_agendamento->mesa)):?>
                                     <input type="hidden" id="mesa" name="mesa" value="<?php echo $meu_agendamento->mesa;?>" />
                                    <?php else:?>
                                     <input type="hidden" id="mesa" name="mesa" value="" />
                                    <?php endif;?>
                                   
                                    <input type="hidden" id="aluno_id" name="aluno_id" value="<?php echo $aluno_id ?>"/>
                                    <input type="hidden" id="minha_agenda_id" name="agenda_id" value="<?php echo $agenda_id ?>"/>
                                </form>
                            </div>
                            <?php if($this->session->userdata('admin')->tipo=="aluno"){?>
                                <div style="margin-top:10px;" class="col-sm-12">
                                     <p> <a  class="btn btn-xs btn-info btn btn-info confirmar_presenca" href="1" title="Alterar Maca" data-confirm="<?php echo site_url(); ?>/admin/agendamento/checar_presenca" class="btn btn-mini btn-warning confirmar_presenca"><i class="fa fa-eye"></i>Alterar maca</a></p>
                                    <?php 
                                    if(empty($row->presenca)){?>
                                        <!-- <a class="btn btn-xs btn-info btn btn-info confirmar_presenca" href="1" title="Visulizar este registro" data-confirm="<?php echo site_url(); ?>/admin/agendamento/checar_presenca" class="btn btn-mini btn-warning confirmar_presenca"><i class="fa fa-eye"></i>Confirmar Presença</a>
                                        <a class="btn btn-xs btn-info btn btn-info confirmar_presenca" href="2" title="Visulizar este registro" data-confirm="<?php echo site_url(); ?>/admin/agendamento/checar_presenca" class="btn btn-mini btn-warning confirmar_presenca"><i class="fa fa-eye"></i>Confirmar Ausencia</a> -->
                                       
                                    <?php }else{?>
                                        <?php /*if($row->presenca=='confirmado'):?>
                                            <p><i class="pe-7s-check">Confirmado</i></p>
                                            <p> <a  class="btn btn-xs btn-info btn btn-info confirmar_presenca" href="1" title="Editar Presença" data-confirm="<?php echo site_url(); ?>/admin/agendamento/checar_presenca" class="btn btn-mini btn-warning confirmar_presenca"><i class="fa fa-eye"></i>Editar Presença</a></p>
                                        <?php elseif($row->presenca=='nao'):?>
                                             <p><i class="pe-7s-close-circle">Ausente</i></p>
                                        <?php else:?>
                                            <p><i class="pe-7s-close-circle">Presente</i></p>
                                        <?php endif;*/?>
                                    <?php } ?>
                                </div>
                            <?php }?>
                        <?php endif;?>
                    </div>
                </div>
            </div>

            

        </div><!--/panel-body-->
    </div><!--/row-->
</div>
<?php include_once(dirname(__FILE__) . '/footer.php'); ?>  
