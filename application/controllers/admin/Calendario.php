<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('BaseCrud.php');
class Calendario extends BaseCrud
{
    var $modelname = 'agendamento';
    var $base_url = 'admin/calendario';
    var $actions = 'R';
    var $titulo = 'Calendario';
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
    //var $acoes_extras = array(array('url'=>'admin/calendario/ver_alunos','title'=>'Ver Alunos','class'=>'btn btn-xs btn-info btn btn-warning'),array('url'=>'admin/calendario/novo','title'=>'Adicionar data','class'=>'btn btn-xs btn-info btn btn-warning'));
    // var $acoes_extras = array(array('url'=>'admin/calendario/ver_alunos','title'=>'Ver Alunos','class'=>'btn btn-xs btn-info btn btn-warning'),
    //     array('url'=>'admin/calendario/modulos','title'=>'Ver Modulos','class'=>'btn btn-xs btn-info btn btn-warning')
    //     );

    var $acoes_extras = array(
        array('url'=>'admin/calendario/cursos','title'=>'Ver NÍveis','class'=>'btn btn-xs btn-info btn btn-warning')
        );

   

    public function __construct() 
    {

        parent::__construct();
        $this->data['menu_active'] = 'turmas';
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



    public function novo($agenda_id =null){
       	$this->load->model('agendamento_model','agendamento');
        $this->load->model('modulos_model','modulos');
        $this->load->model('salas_model','salas');
        $this->load->model('cursos_model','cursos');

        $this->data['titulo'] = "Cadastrar Calendario";
        $this->data['action'] = $this->base_url."/save_calendario";

        $this->db->select('modulo_id, curso_id');
        $where_agendamento = array('agenda_id'=>$agenda_id);
        $modulo = $this->agendamento->get_where($where_agendamento)->row();


        
        $where = array('status'=>'ativo');
        $salas = $this->salas->get_where($where)->result();
        foreach ($salas as $key => $value) {
            $this->agendamento->fields['sala_id']['values'][$value->salas_id] = $value->titulo;
        }

        if(!is_null($agenda_id)){
            $this->data['agenda_id'] = $agenda_id;
        }

        $where_modulos = array('modulos_id'=>$modulo->modulo_id);
        $modulos = $this->modulos->get_where($where_modulos)->result();
        
        foreach ($modulos as $key => $value) {
            $this->agendamento->fields['modulo_id']['values'][$value->modulos_id] = $value->titulo;
        }

        $where_cursos = array('cursos_id'=>$modulo->curso_id);
        $cursos = $this->cursos->get_where($where_cursos)->result();
        
        foreach ($cursos as $key => $value) {
            $this->agendamento->fields['curso_id']['values'][$value->cursos_id] = $value->titulo;
        }

        $this->data['form0'] = $this->agendamento->form('curso_id','modulo_id');
      
        $this->data['form1'] = $this->agendamento->form('data','data_segunda','data_terceira','sala_id');

        

        $this->data['form2'] = $this->agendamento->form('dias_semana');
        

        $this->load->view('admin/calendario', $this->data);
    }

    public function save_calendario(){



        $this->load->model('agendamento_model','agendamento');
        $this->load->model('presenca_model','presenca');
        $this->load->model('avisos_model','avisos');
       
        $post = $this->input->posts();

        $where['agendamento.agenda_id'] = $post['agenda_id'];

        $this->db->select('agendamento.*, cursos.titulo as curso, modulos.titulo as modulos')
                 ->join('modulos','modulos.modulos_id=agendamento.modulo_id')
                 ->join('cursos','cursos.cursos_id=agendamento.curso_id');
        $resultados = $this->agendamento->get_where($where)->row();


        if(isset($post['agenda_id'])){
             $data['agenda_id'] = $post['agenda_id'];
        }else{
          $data['agenda_id'] = $resultados->agenda_id;  
        }

        
        $data['data'] = $post['data'];
        $data['data_segunda'] = $post['data_segunda'];
        $data['data_terceira'] = $post['data_terceira'];




        $data['sala_id'] = $post['sala_id'];
       
        $data['dias_semana'] = serialize($post['dias_semana']);
        $this->agendamento->save($data);


        for ($i = 0; $i <3; $i++) {
            $this->db->where('presenca.agenda_id', $post['agenda_id']);
            if($i == 0){
                $this->db->set('data_dia', $data['data'] );
                $this->db->where('presenca.linha', 0);
            }elseif($i == 1){
                $this->db->set('data_dia', $data['data_segunda'] );
                 $this->db->where('presenca.linha', 1);
            }else{
                $this->db->set('data_dia', $data['data_terceira'] );
                 $this->db->where('presenca.linha', 2);
            }
            $this->db->update('presenca');


        }

        $where_aluno['alunos.status'] ='ativo';
        $where_aluno['alunos.situacao'] = 'adimplente';
        $where_aluno['agendamento.curso_id'] = $resultados->curso_id;
        $where_aluno['agendamento.modulo_id'] = $resultados->modulo_id;
        //$where_aluno['presenca.tipo !='] ='normal';

        $this->db->select('alunos.*')
                 ->join('alunos','alunos.alunos_id=presenca.aluno_id')
                 ->join('agendamento','agendamento.agenda_id=presenca.agenda_id');
        $this->db->group_by('alunos.alunos_id');
        $all_alunos = $this->presenca->get_where($where_aluno)->result();

        if(count($all_alunos) > 0){
            $msg_painel = 'Há uma nova turma para o curso' . $resultados->curso. " - " . $resultados->modulos;

            foreach($all_alunos as $aluno){


                $this->avisos->save_aviso($aluno->alunos_id,'aluno',$msg_painel,"Aviso de Nova Turma aberta");

                $this->load->library('email');
                $this->email->set_mailtype("html");     

                $this->email->from(EMAIL_FROM, 'Aviso de Nova Turma aberta');
                $this->email->to((ENVIRONMENT == 'development' ? EMAIL_DEV : $aluno->email));
                $this->email->subject('Aviso de Nova Turma aberta');

                $data = array('aluno'=> $aluno->nome, 'msg'=>$msg_painel);
                       
                $this->email->message($this->load->view("emails/aviso_nova_turma", $data, true));
                $this->email->send();
                // if ($this->email->send()) {
                //     echo 'email enviado com sucesso!';
                //      var_dump($this->email->print_debugger());
                // }else{
                //     var_dump($this->email->print_debugger());
                // }
            }
        }


        redirect('admin/calendario/modulos/'.$resultados->turma.'/'.$post['curso_id']);

    }

    public function _filter_pre_listar(&$where, &$where_ativo){

        //$where['agendamento.data!='] = '0000-00-00';
        $where['agendamento.status=!'] = 'fechado';


        $this->model->fields['status'] = array(
          'label' => 'Status da Aula',
          'type' => 'text',
          'class' => '',
        );

        $this->model->fields['curso'] = array(
          'label' => 'Nível',
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
        $this->model->fields['alunos'] = array(
          'label' => 'Nome',
          'type' => 'text',
          'class' => '',
        );
    }

    public function _filter_pos_save($data, $id) 
    {
        $this->load->model('avisos_model','avisos');
        $this->load->model('aluno_cursos_model','alunos_cursos');

        $checa_turma = $this->alunos_cursos->get_where(array('curso_id'=>$data['curso_id'],'modulos_id'=>$data['modulos_id'],'turma'=>$data['turma']))->result();

        if(count($checa_turma) > 0){
            $msg = "Há uma nova aula agendada para você no dia ".formata_data($data['data']);
            $this->avisos->save_aviso($checa_turma->alunos_id,'aluno',$msg,'Novo aviso de aula');
        }
       

        redirect('admin/calendario');
    }

    public function ver_alunos($agenda_id){
        $this->load->model('agendamento_model','agendamento');
        $this->db->select('agendamento.agenda_id,agendamento.data,alunos.mesa, alunos.mesa2,cursos.titulo as curso,modulos.titulo as modulo,alunos.nome,alunos.alunos_id as aluno_id,presenca.presente as presenca, presenca.tipo as tipo, presenca.presenca_id')
        ->join('presenca','presenca.agenda_id=agendamento.agenda_id')
        ->join('alunos','alunos.alunos_id=presenca.aluno_id')
        ->join('cursos','cursos.cursos_id=agendamento.curso_id')
        ->join('modulos','modulos.modulos_id=agendamento.modulo_id')
        ->join('professor','professor.id_professor=agendamento.professor_id');
        $where['agendamento.agenda_id'] = $agenda_id;
        $this->data['itens'] = $this->agendamento->get_where($where)->result();
        $this->load->view('admin/aulas_alunos_admin', $this->data);
    }

    public function modulos($turma,$curso_id){
        $this->load->model('agendamento_model','agendamento');

        // $this->db->select('agendamento.turma');
        // $curso = $this->agendamento->get_where(array('agendamento.agenda_id'=>$agenda_id))->row();



        $this->db->select('agendamento.*,cursos.titulo as curso,professor.nome as professor, CONCAT(modulos.titulo," - ",modulos.descricao) as modulo')
        ->join('cursos','cursos.cursos_id=agendamento.curso_id')
        ->join('modulos','modulos.modulos_id=agendamento.modulo_id')
        ->join('professor','professor.id_professor=agendamento.professor_id');
        $where['agendamento.curso_id'] = $curso_id;
        $where['agendamento.turma'] = $turma;
        $this->data['itens'] = $this->agendamento->get_where($where)->result();
       
        $this->load->view('admin/agendamento_modulos', $this->data);
    }

    public function cursos($agenda_id){
        $this->load->model('agendamento_model','agendamento');

       $this->db->select('agendamento.turma');
       $curso = $this->agendamento->get_where(array('agendamento.agenda_id'=>$agenda_id))->row();



        $this->db->select('agendamento.*,cursos.titulo as curso,professor.nome as professor')
        ->join('cursos','cursos.cursos_id=agendamento.curso_id')
        ->join('professor','professor.id_professor=agendamento.professor_id');
        $where['agendamento.turma'] = $curso->turma;
        $this->db->group_by("agendamento.curso_id");
        $this->data['itens'] = $this->agendamento->get_where($where)->result();

       
        $this->load->view('admin/agendamento_cursos', $this->data);
    }




}
