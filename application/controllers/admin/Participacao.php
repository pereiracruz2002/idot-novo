<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('BaseCrud.php');
class Participacao extends BaseCrud {


    var $modelname = 'agendamento';
    var $base_url = 'admin/participacao';
    var $actions = 'R';
    var $titulo = 'Participação dos Alunos';
     var $tabela = 'turma,curso,professor';
    var $campos_busca = 'turma';
    var $order = array('agenda_id'=>"DESC");
    var $joins = array(
         'cursos' => 'cursos.cursos_id=agendamento.curso_id',
         'modulos'=> 'modulos.modulos_id=agendamento.modulo_id',
         'professor'=>'professor.id_professor=agendamento.professor_id'
    );
    var $selects = 'agendamento.*,cursos.titulo as curso,professor.nome as professor, CONCAT(modulos.titulo," - ",modulos.descricao) as modulo';
    var $group = array('agendamento.turma');
    var $acoes_extras = array(array('url'=>'admin/alunos_participacao/ver_alunos','title'=>'Ver Alunos','class'=>'btn btn-xs btn-info btn btn-default'));

    var $turmas_id;
    var $mesa;
    var $minha_mesa;
    var $sala;

  public function __construct() 
    {

        parent::__construct();
        //verify_permiss_redirect('departamentos');
        $this->data['menu_active'] = 'alunos';
    }

    public function _complemento_form(){



         if($this->uri->segment(3) == 'editar'){
            if($this->sala=='2'){

                 $html = '<div   id="sala2">
                    <div class="col-md-2" style="text-align:right;">
                        <b>Vagas Sala 2</b></div>
                    <div class="col-md-10" style="margin-bottom:10px;" id="form1" runat="server">
                           <div id="holder"> 
                                <ul  id="place">
                                </ul>    
                            </div>
                            <div style="width:600px;text-align:center;overflow:auto"> 

                            </div>
                    </div></div>';

               
              
                     $html.= '<div style="display:none;" id="sala1"><div class="col-md-2" style="text-align:right;"><b>Vagas Sala 1</b></div><div class="col-md-10" style="margin-bottom:10px;" id="form1" runat="server">
                           <div id="holder2"> 
                                <ul  id="place2">
                                </ul>    
                            </div>
                            <div style="width:600px;text-align:center;overflow:auto"> 

                            </div></div>';
            }else{
                $html = '<div style="display:none;" id="sala2">
                    <div class="col-md-2" style="text-align:right;">
                        <b>Vagas Sala 2</b></div>
                    <div class="col-md-10" style="margin-bottom:10px;" id="form1" runat="server">
                           <div id="holder"> 
                                <ul  id="place">
                                </ul>    
                            </div>
                            <div style="width:600px;text-align:center;overflow:auto"> 

                            </div>
                    </div></div>';

               
              
                     $html.= '<div id="sala1"><div class="col-md-2" style="text-align:right;"><b>Vagas Sala 1</b></div><div class="col-md-10" style="margin-bottom:10px;" id="form1" runat="server">
                           <div id="holder2"> 
                                <ul  id="place2">
                                </ul>    
                            </div>
                            <div style="width:600px;text-align:center;overflow:auto"> 

                            </div></div>';
            }

        }else{

            $html = '<div style="display:none;" id="sala2">
            <div class="col-md-2" style="text-align:right;">
                <b>Vagas Sala 2</b></div>
            <div class="col-md-10" style="margin-bottom:10px;" id="form1" runat="server">
                   <div id="holder"> 
                        <ul  id="place">
                        </ul>    
                    </div>
                    <div style="width:600px;text-align:center;overflow:auto"> 

                    </div>
            </div></div>';

       
      
             $html.= '<div id="sala1"><div class="col-md-2" style="text-align:right;"><b>Vagas Sala 1</b></div><div class="col-md-10" style="margin-bottom:10px;" id="form1" runat="server">
                   <div id="holder2"> 
                        <ul  id="place2">
                        </ul>    
                    </div>
                    <div style="width:600px;text-align:center;overflow:auto"> 

                    </div></div>';
        }
         
                   
           
            $html.='<input type="hidden" id="mesa" name="mesa" value="'.$this->minha_mesa.'"/>
                </div>';
        

        echo $html;
    }


     public function _filter_pre_read(&$data) 
    {



        foreach ($data as $val => $key) {
            foreach ($key as $chave => $valor) {
                if($chave == "modulo"){
                    $key->modulo = strip_tags($key->modulo);
                }

                 if($chave=="data"){
                   
                    if($key->data !='0000-00-00'){
                        $key->data = formata_data($key->data);

                        if($key->data_segunda !=='0000-00-00'){
                            $key->data.= '<br /> '.formata_data($key->data_segunda);
                        }

                        if($key->data_terceira !=='0000-00-00'){
                            $key->data.= '<br />'.formata_data($key->data_terceira);
                        }
                    }else{
                        $key->data = "Sem data definida";
                    }   

                    //$key->data.=$days_of_week;
                    
                }

                if($chave == "curso"){
                    $key->curso = ucfirst($key->curso);
                }

                if($chave=="dias_semana"){
                    if(!is_null($key->dias_semana)){
                        $days_of_week = ' <b>';
                        foreach(unserialize($data[$val]->dias_semana) as $days){
                            $days_of_week.=$days."<br/>";
                        }
                        $days_of_week = trim($days_of_week,",");
                        $days_of_week.="</b>";
                        $key->dias_semana=$days_of_week;
                    }
                    
                }

                if($chave=="modulo"){
                    $key->modulo = abreviaString($key->modulo,50);
                }
            }
        }
    }


    public function _pre_form(&$model, &$data) 
    {

        $this->load->model('presenca_model','presenca');
        $this->load->model('agendamento_model','agendamento');
        $model->fields['turmas_id']['values'][0] = "--Selecione--";

        
       
        // for ($i=1; $i <=50; $i++) {
        //     $model->fields['turmas_id']['values'][$i] = $i;
        // }
       
       

        $mesas_ocupadas = array();
        
        $this->db->select('agendamento.*,presenca.*')
                ->join('agendamento','agendamento.agenda_id =presenca.agenda_id');

        
        if($this->uri->segment(3) == 'editar'){


             $my_agendamento = $this->presenca->get_where(array('presenca.aluno_id'=>$data[0]['values']['alunos_id']))->row();
        }
       

        if(isset($my_agendamento)){

            if(count($my_agendamento) > 0){

                $this->minha_mesa =  $my_agendamento->mesa;
      

                $this->db->select('presenca.mesa');

              
                $mesas_ocupadas[$my_agendamento->agenda_id] = $this->presenca->get_where(array('agenda_id'=>$my_agendamento->agenda_id))->result();
                if(isset($data[0]['values']['alunos_id'])){
                    $minha_mesa = $this->presenca->get_where(array('agenda_id'=>$my_agendamento->agenda_id,'aluno_id' => $data[0]['values']['alunos_id']))->row();
                    $minha_turma = $this->agendamento->get_where(array('agenda_id'=>$my_agendamento->agenda_id))->row();

                    

                    $this->sala = $minha_turma->sala_id;
                }


                if(count($mesas_ocupadas >0)){
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
                }else{
                    echo "<script type='text/javascript'>";
                    echo "var bookedSeats =[];\n";
                    echo "</script>";
                }
            }else{
                echo "<script type='text/javascript'>";
                echo "var bookedSeats =[];\n";
                echo "</script>";
            }
        }else{
            echo "<script type='text/javascript'>";
            echo "var bookedSeats =[];\n";
            echo "</script>";
        }



    }

    

     public function _filter_pre_save(&$data) 
    {


      $this->turmas_id = $data['turmas_id'];
      $this->mesa = $this->input->post('mesa');
      $data['turmas_id'];


        if($this->uri->segment(3) == 'editar'){
            unset($data['senha']);
        }else{
            if($data['senha']){
             $data['senha'] = md5($data['senha']);
            //$data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
            } else {
                unset($data['senha']);
            }
        }


        
    }

    public function _filter_pre_listar(&$where, &$where_ativo)
    {

     

      if(isset($where_ativo['alunos.turma'])){
        
        $where_ativo['agendamento.turma'] = $where_ativo['alunos.turma'];
        unset($where_ativo['alunos.turma']);
      }

      $this->model->fields['curso'] = array(
          'label' => 'Curso',
          'type' => 'text',
          'class' => '',
        );

       $this->model->fields['mesa'] = array(
          'label' => 'Mesa',
          'type' => 'text',
          'class' => '',
        );

        $this->model->fields['modulo'] = array(
          'label' => 'Módulo',
          'type' => 'text',
          'class' => '',
        );

        

        $this->model->fields['professor'] = array(
          'label' => 'Professor',
          'type' => 'text',
          'class' => '',
        );

        $this->model->fields['data'] = array(
          'label' => 'Data',
          'type' => 'text',
          'class' => '',
        );
        $this->model->fields['dias_semana'] = array(
          'label' => 'Data do Curso',
          'type' => 'text',
          'class' => '',
        );
       
    }





  function upload_foto(){
    $config['upload_path'] = FCPATH.'imagens/professor/';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = '10000';
    $config['max_width'] = '1024';
    $config['max_height'] = '768';
    $this->load->library('upload', $config);
    if($_FILES['foto']['name']){
      if(!$this->upload->do_upload('foto')){
        $this->form_validation->set_message('upload_foto', $this->upload->display_errors());
        return false;
      }else{
        $data = $this->upload->data();
        $this->upload_foto = $data['file_name'];
        return true;
      }
    }
  }

 
  public function uniqlogin($login) 
  {
        $where['login'] = $login;
        if($this->uri->segment(3) == 'editar'){
            $where['alunos_id !='] = $this->uri->segment(4);
        }
        $cadastro = $this->model->get_where($where)->row();
        if($cadastro){
            $this->form_validation->set_message('uniqlogin', 'Esse login já está em uso');
            return false;
        } else {
            return true;
        }
  }

  public function _filter_pos_save($data, $id) 
  {
     
       

        $this->load->model('turmas_model','turmas');
        $this->load->model('agendamento_model','agenda');
        $this->load->model('modulos_model','modulos');
        $this->load->model('presenca_model','presenca');
        $this->load->model('aluno_cursos_model','alunos_cursos');
        $this->load->model('avisos_model','avisos');

        if($this->uri->segment(3) != 'editar'){

            $where['agendamento.turma'] = $this->turmas_id;

            $resultados = $this->agenda->get_where($where)->row();

            $resultados_modulos = $this->modulos->get_where(array('curso_id'=>$resultados->curso_id))->result();



            foreach($resultados_modulos as $resultado){
                $save_cursos[] = array('aluno_id' => $id, 'turma' => $this->turmas_id,'curso_id'=> $resultado->curso_id,'modulo_id'=>$resultado->modulos_id);
            }

            $this->db->insert_batch('aluno_cursos', $save_cursos);


            $resultados_agendamento = $this->agenda->get_where($where)->result();

            foreach($resultados_agendamento as $agendamento){
                $dados['aluno_id'] = $id;
                $dados['agenda_id'] = $agendamento->agenda_id;
                $dados['mesa'] = $this->mesa;
                $this->db->insert('presenca',$dados);
            }
            $msg = "Há uma nova aula agendada para você no dia ".formata_data($resultados_agendamento[0]->data);
            $this->avisos->save_aviso($id,'aluno',$msg,'Novo aviso de aula');

        }else{


            $this->db->select('turma');
            $checa_turma = $this->alunos_cursos->get_where(array('aluno_id'=>$id))->row();
            if($checa_turma->turma != $data['turmas_id'] ){
                $this->db->delete('aluno_cursos', array('aluno_id' => $id));
                $this->db->delete('presenca', array('aluno_id' => $id));
                 $where['agendamento.turma'] = $this->turmas_id;

                    $resultados = $this->agenda->get_where($where)->row();

                    $resultados_modulos = $this->modulos->get_where(array('curso_id'=>$resultados->curso_id))->result();



                    foreach($resultados_modulos as $resultado){
                        $save_cursos[] = array('aluno_id' => $id, 'turma' => $this->turmas_id,'curso_id'=> $resultado->curso_id,'modulo_id'=>$resultado->modulos_id);
                    }

                    $this->db->insert_batch('aluno_cursos', $save_cursos);


                    $resultados_agendamento = $this->agenda->get_where($where)->result();

                    foreach($resultados_agendamento as $agendamento){
                        $dados['aluno_id'] = $id;
                        $dados['agenda_id'] = $agendamento->agenda_id;
                        $dados['mesa'] = $this->mesa;
                        $this->db->insert('presenca',$dados);
                    }
            }else{
                $this->db->where('aluno_id', $id);
                $this->db->set('mesa', $this->mesa);
                $this->db->update('presenca');
            }
           
       

           
        }

       

        redirect('admin/alunos');

  }


  public function associar_cursos($aluno_id, $ok=false){
        $this->load->model('cursos_model','cursos');
        $this->load->model('aluno_cursos_model','aluno_cursos');

        $where['aluno_id'] = $aluno_id;

        $this->data['permissoes'] = array();
        $this->db->select('cursos.*');
        $this->db->join('cursos','cursos.cursos_id=aluno_cursos.curso_id');
        $permissoes = $this->aluno_cursos->get_where($where)->result();
        foreach ($permissoes as $item) {
            $this->data['permissoes'][] = $item->cursos_id;
        }
   
        $this->data['aluno_id'] = $aluno_id;
        unset($where['aluno_id']);
        $this->data['cursos'] = $this->cursos->get_where($where)->result();

        $this->load->view('admin/associar_alunos_cursos',$this->data);
    }



    public function add_cursos(){
        $this->load->model('aluno_cursos_model','aluno_cursos');

        if($this->input->posts()){
            $nivel_permissoes = $save_depto = array();
            $aluno_id = $this->input->post('aluno_id');
            $this->db->delete('aluno_cursos', array('aluno_id' => $aluno_id));
           
            if($this->input->post('cursos') and !empty($this->input->post('cursos'))){
                foreach ($this->input->post('cursos') as $curso) {
                    $save_cursos[] = array('curso_id' => $curso, 'aluno_id' => $aluno_id);
                }
            }
            
            if($save_cursos){
                $this->db->insert_batch('aluno_cursos', $save_cursos);
            }
        }
        redirect('admin/alunos');
    }

    public function ver_alunos($agenda_id){
        $this->load->model('agendamento_model','agendamento');
        $this->db->select('agendamento.agenda_id,agendamento.data,presenca.mesa,cursos.titulo as curso,modulos.titulo as modulo,alunos.nome,alunos.alunos_id as aluno_id,presenca.presente as presenca, presenca.tipo as tipo, presenca.presenca_id')
        ->join('presenca','presenca.agenda_id=agendamento.agenda_id')
        ->join('alunos','alunos.alunos_id=presenca.aluno_id')
        ->join('cursos','cursos.cursos_id=agendamento.curso_id')
        ->join('modulos','modulos.modulos_id=agendamento.modulo_id')
        ->join('professor','professor.id_professor=agendamento.professor_id');
        $where['agendamento.agenda_id'] = $agenda_id;
        $this->data['itens'] = $this->agendamento->get_where($where)->result();
        $this->load->view('admin/alunos', $this->data);
    }

}
