<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('BaseCrud.php');
class Turmas extends BaseCrud
{
    var $modelname = 'agendamento';
    var $base_url = 'admin/turmas';
    var $actions = 'CRUD';
    var $titulo = 'Turmas';
    var $tabela = 'turma,curso,professor';
    var $campos_busca = 'busca_turma';
    var $acoes_extras = array();
    var $joins = array(
         'cursos' => 'cursos.cursos_id=agendamento.curso_id',
         'modulos'=> 'modulos.modulos_id=agendamento.modulo_id',
         'professor'=>'professor.id_professor=agendamento.professor_id'
    );
    var $selects = 'agendamento.*,cursos.titulo as curso,professor.nome as professor, CONCAT(modulos.titulo," - ",modulos.descricao) as modulo';
    var $group = array('agendamento.turma');
   

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
                    if($key->data == '0000-00-00'){
                        $key->data = "Sem data definida";  
                    }else{
                        $key->data = formata_data($key->data);
                    }  
                }

                if($chave == "curso"){
                    $key->curso = ucfirst($key->curso);
                }
            }
        }
    }

    public function _pre_form(&$model, &$data) 
    {
        
       
        unset($model->fields['sala_id'], $model->fields['modulo_id'], $model->fields['data'], $model->fields['data_segunda'],$model->fields['data_terceira'],$model->fields['encontro_id'],$model->fields['descricao'],$model->fields['dias_semana']);
       

        $this->load->model('cursos_model','cursos');
        $where = array('status'=>'ativo');
        $cursos = $this->cursos->get_where($where)->result();
        $model->fields['curso_id']['values'][''] = '--Selecione um Curso--';

        // for ($i=1; $i <=50; $i++) {
        //     $model->fields['turma']['values'][$i] = $i;
        // }

        $this->load->model('professor_model','professores');
        $where = array('status'=>'ativo');
        $professores = $this->professores->get_where($where)->result();
        foreach ($professores as $key => $value) {
            $model->fields['professor_id']['values'][$value->id_professor] = $value->nome;
        }


        foreach ($cursos as $key => $value) {
            $model->fields['curso_id']['values'][$value->cursos_id] = ucwords($value->titulo);
        }
    }

    public function _filter_pre_save(&$data) 
    {



        $this->load->model('cursos_model','cursos');
        $this->load->model('agendamento_model','agendamento');

        $this->db->select('*')
                 ->join('modulos','modulos.curso_id = cursos.cursos_id');
        $where['cursos.cursos_id ='] = $data['curso_id'];

        $resultados = $this->cursos->get_where($where)->result();



        foreach($resultados as $resultado){
            $save_agendamento[] = array('turma' => $data['turma'],'professor_id'=>$data['professor_id'],'curso_id'=> $resultado->curso_id,'modulo_id'=>$resultado->modulos_id);
        }

        $this->db->insert_batch('agendamento', $save_agendamento);

    
    }

    public function calendario(){
        $this->load->model('agendamento_model','agendamento');
        $this->data['titulo'] = "Cadastrar Calendario";
        $this->data['action'] = $this->base_url."/save_calendario";

        $this->load->model('salas_model','salas');
        $where = array('status'=>'ativo');
        $salas = $this->salas->get_where($where)->result();
        foreach ($salas as $key => $value) {
            $this->agendamento->fields['sala_id']['values'][$value->salas_id] = $value->titulo;
        }


        $this->data['form1'] = $this->agendamento->form('data','data_segunda','data_terceira','sala_id');
        $this->data['form2'] = $this->agendamento->form('dias_semana');
        

        $this->load->view('admin/calendario', $this->data);
    }

    public function save_calendario(){

        $this->load->model('agendamento_model','agendamento');
       
        $resultados = $this->agendamento->get_where($where)->row();

        $post = $this->input->posts();

        $data['agenda_id'] = $resultados->agenda_id;
        $data['data'] = $post['data'];
        $data['data_segunda'] = $post['data_segunda'];
        $data['data_terceira'] = $post['data_terceira'];
        $data['sala_id'] = $post['sala_id'];
        $data['dias_semana'] = serialize($post['dias_semana']);
        $this->agendamento->save($data);
        redirect('admin/turmas');

    }

    public function _filter_pre_listar(&$where, &$where_ativo){

        

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

        $this->model->fields['busca_turma'] = array(
          'label' => 'Turma',
          'type' => 'text',
          'class' => '',
        );



        if(isset($where_ativo['agendamento.busca_turma'])){
            $where_ativo['agendamento.turma'] = $where_ativo['agendamento.busca_turma'];
            unset($where_ativo['agendamento.busca_turma']);

           
        }
    }

    public function _filter_pos_save($data, $id) 
    {
        redirect('admin/turmas');
    }




}
