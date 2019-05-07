<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Agendamento_model extends My_Model
{
	var $id_col = 'agenda_id';
    var $fields = array(   

        'turma' => array(
                'type' => 'select',
                'label' => 'Turma',
                'class' => '',
                'rules' => 'required',
                'label_class' => 'col-md-2',
                'prepend' => '<div class="col-md-3">',
                'append' => '</div>',
                'values' => array(),
                'values' => array(""=>'Selecione',"1"=>1,"2"=>2,"3"=>3,"4"=>4,"5"=>5,"6"=>6,"7"=>7,"8"=>8,"9"=>9,"10"=>10,
                    "11"=>11,"12"=>12,"13"=>13,"14"=>14,"15"=>15,"16"=>16,"17"=>17,"18"=>18,"19"=>19,"20"=>20,
                    "21"=>21,"22"=>22,"23"=>23,"24"=>24,"25"=>25,"26"=>26,"27"=>27,"28"=>28,"29"=>29,"30"=>30,
                    "31"=>31,"32"=>32,"33"=>33,"34"=>34,"35"=>35,"36"=>36,"37"=>37,"38"=>38,"39"=>39,"40"=>40,
                    "41"=>41,"42"=>42,"43"=>43,"44"=>44,"45"=>45,"46"=>46,"47"=>47,"48"=>48,"49"=>49,"50"=>50),
                'extra' => array('required'=>'required')
        ),

        'curso_id' => array(
            'type' => 'select',
            'label' => 'Nível',
            'class' => '',
            'rules' => 'required',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
            'empty' => '--Selecine um status--',
            'values' => array(),
        ),

        'modulo_id' => array(
            'type' => 'select',
            'label' => 'Módulos',
            'class' => '',
            'rules' => 'required',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-8">',
            'append' => '</div>',
            'values' => array(),
        ),

        'sala_id' => array(
            'type' => 'select',
            'label' => 'Salas',
            'class' => '',
            'rules' => 'required',
            'label_class' => 'col-md-4',
            'prepend' => '<div class="col-md-4">',
            'append' => '</div>',
            'values' => array(),
        ),

        // 'nivel_id' => array(
        //     'type' => 'select',
        //     'label' => 'Nível',
        //     'class' => '',
        //     'rules' => 'required',
        //     'label_class' => 'col-md-4',
        //     'prepend' => '<div class="col-md-4">',
        //     'append' => '</div>',
        //     'values' => array(),
        // ),


        'data' => array(
            'type' => 'date',
            'label' => 'Data do Curso',
            'class' => '',
            'rules' => '',
            'label_class' => 'col-md-4',
            'prepend' => '<div class="col-md-8">',
            'append' => '</div>',
        ),

        'data_segunda' => array(
            'type' => 'date',
            'label' => '',
            'class' => '',
            'rules' => '',
            'label_class' => 'col-md-4',
            'prepend' => '<div class="col-md-8">',
            'append' => '</div>',
        ),

        'data_terceira' => array(
            'type' => 'date',
            'label' => '',
            'class' => '',
            'rules' => '',
            'label_class' => 'col-md-4',
            'prepend' => '<div class="col-md-8">',
            'append' => '</div>',
        ),


        'dias_semana' => array(
            'type' => 'check',
            'label' => '',
            'class' => '',
            'rules' => '',
            'label_class' => 'col-md-4',
            'prepend' => '<div class="col-md-12">',
            'append' => '</div>',
            'extra' => array('class'=>'dias_semana'),
            'values' => array('sexta manhã'=>'Sexta Manhã','sexta tarde'=>'Sexta Tarde', 'sexta noite'=>'Sexta Noite','sábado manhã'=>'Sábado Manhã','sábado tarde'=>'Sábado Tarde','sábado noite'=>'','domingo manhã'=>'Domingo Manhã','domingo tarde'=>'Domingo Tarde'),

        ),




        // 'vagas' => array(
        //     'type' => 'text',
        //     'label' => 'Vagas',
        //     'class' => '',
        //     'rules' => 'required',
        //     'label_class' => 'col-md-2',
        //     'prepend' => '<div class="col-md-3">',
        //     'append' => '</div>',
        // ),

        'professor_id' => array(
            'type' => 'select',
            'label' => 'Professor',
            'class' => '',
            'rules' => 'required',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
            'values' => array(),
        ),
        

        'encontro_id' => array(
            'type' => 'select',
            'label' => 'Submodulo',
            'class' => '',
            'rules' => 'required',
            'label_class' => 'col-md-2 hide',
            'prepend' => '<div class="col-md-3 hide">',
            'append' => '</div>',
            'values' => array(),
            
        ),

        
	 'descricao' => array(
                'type' => 'textarea',
                'label' => 'Descrição',
                'class' => '',
                'extra' => array('class'=>'mytextarea'),
                'rules' => 'required',
                'label_class' => 'col-md-2',
                'prepend' => '<div class="col-md-6">',
                'append' => '</div>',
            ),

     'status' => array(
            'type' => 'select',
            'label' => 'Status',
            'class' => '',
            'rules' => 'required',
            'label_class' => 'col-md-2',
            'prepend' => '<div class="col-md-3">',
            'append' => '</div>',
            'values' => array('aberto' => 'Aberto', 'finalizado' => 'Finalizado'),
            'extra' => array('required'=>'required')
        ),
        
    );
}
