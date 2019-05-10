<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alunos_model extends My_Model{
	var $id_col="alunos_id";
	var $fields= array(
            'turmas_id' => array(
                'type' => 'select',
                'label' => 'Turma',
                'class' => '',
                'rules' => 'required',
                'label_class' => 'col-md-2',
                'prepend' => '<div class="col-md-6">',
                'append' => '</div>',
                // 'values' => array(""=>'Selecione',"1"=>1,"2"=>2,"3"=>3,"4"=>4,"5"=>5,"6"=>6,"7"=>7,"8"=>8,"9"=>9,"10"=>10,
                //     "11"=>11,"12"=>12,"13"=>13,"14"=>14,"15"=>15,"16"=>16,"17"=>17,"18"=>18,"19"=>19,"20"=>20,
                //     "21"=>21,"22"=>22,"23"=>23,"24"=>24,"25"=>25,"26"=>26,"27"=>27,"28"=>28,"29"=>29,"30"=>30,
                //     "31"=>31,"32"=>32,"33"=>33,"34"=>34,"35"=>35,"36"=>36,"37"=>37,"38"=>38,"39"=>39,"40"=>40,
                //     "41"=>41,"42"=>42,"43"=>43,"44"=>44,"45"=>45,"46"=>46,"47"=>47,"48"=>48,"49"=>49,"50"=>50
                // ),
                'extra' => array('required'=>'required')
            ),
		   "nome" => array("type" => "text",
				"label" => "Nome do Aluno",
				"class"=> "vObrigatorio",
				"rules" => "required|min_length[3]|max_length[45]",
				'label_class' => 'col-md-2',
				'prepend' => '<div class="col-md-3">',
				'append' => '</div>',
                'extra' => array('required'=>'required')
			),

		   "email" => array("type" => "text",
				"label" => "Email",
				"class" => "",
				"rules" => "required",
				'label_class' => 'col-md-2',
		        'prepend' => '<div class="col-md-3">',
		        'append' => '</div>',
                'extra' => array('required'=>'required')
			),
		   'matricula' => array(
	            'type' => 'text',
	            'label' => 'Matrícula <br />(dd/mm/aaaa-0000)',
	            'class' => '',
	            'rules' => '',
	            'label_class' => 'col-md-2',
	            'prepend' => '<div class="col-md-3">',
	            'append' => '</div>',
                'extra'=> array('class'=>'matricula')
        	),

		   'login' => array(
            'type' => 'text',
            'label' => 'Login',
            'class' => '',
            'rules' => 'required|callback_uniqlogin',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
            'extra' => array('required'=>'required')
        ),
        'senha' => array(
            'type' => 'password',
            'label' => 'Senha',
            'class' => '',
            'rules' => 'required',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
            'value'=>'',
            'extra' => array('required'=>'required')
        ),

        // 'data_cadastro' => array(
        //     'type' => 'date',
        //     'label' => 'Data de Cadastro',
        //     'class' => '',
        //     'rules' => '',
        //     'label_class' => 'col-md-2',
        //     'prepend' => '<div class="col-md-3">',
        //     'append' => '</div>',
        // ),
        'endereco' => array(
            'type' => 'text',
            'label' => 'Endereço',
            'class' => '',
            'rules' => '',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
        ),
        'cep' => array(
            'type' => 'text',
            'label' => 'CEP',
            'class' => '',
            'rules' => '',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
            'extra'=> array('class'=>'cep')
        ),
        'bairro' => array(
            'type' => 'text',
            'label' => 'Bairro',
            'class' => '',
            'rules' => '',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
        ),
        'complemento' => array(
            'type' => 'text',
            'label' => 'Complemento',
            'class' => '',
            'rules' => '',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
        ),
        'telefone' => array(
            'type' => 'text',
            'label' => 'Telefone',
            'class' => '',
            'rules' => '',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
            'extra'=> array('class'=>'telefone')
        ),
        'celular' => array(
            'type' => 'text',
            'label' => 'Celular',
            'class' => 'celular',
            'rules' => '',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
            'extra'=> array('class'=>'celular')
        ),
        'situacao' => array(
            'type' => 'select',
            'label' => 'Situação',
            'class' => '',
            'rules' => 'required',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
            'values' => array('adimplente' => 'Adimplente','inadimplente' => 'Inadimplente'),
            'extra' => array('required'=>'required')
        ),
        'reposicao' => array(
            'type' => 'select',
            'label' => 'Reposição',
            'class' => '',
            'rules' => 'required',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
            'values' => array('nao' => 'Não','sim' => 'Sim'),
            'extra' => array('required'=>'required')
        ),
        
        'status' => array(
            'type' => 'select',
            'label' => 'Status',
            'class' => '',
            'rules' => 'required',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
            'values' => array('ativo' => 'Ativo', 'inativo' => 'Inativo'),
            'extra' => array('required'=>'required')
        ),
        

        
        

	);

    public function login($login, $senha) 
    {
        $where['login'] = $login;
        $cadastro = $this->get_where($where)->row();

        if($cadastro){
            $this->load->library('encrypt');

            if ($cadastro->senha == md5($senha)) {
            //if(password_verify($senha,$cadastro->senha)){
                unset($cadastro->senha);
                $cadastro->tipo = 'aluno';
                $this->session->set_userdata('admin', $cadastro);
                $this->session->unset_userdata('cliente');
                $this->update(array('last_login' => date('Y-m-d H:i:s')), $cadastro->alunos_id);
                return true;
            }
        }
        return false;
    }
}

?>
