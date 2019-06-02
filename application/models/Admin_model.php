<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends My_Model
{
    var $id_col = 'admin_id';
    var $fields = array(   
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
            'extra' => array('required'=>'required')
        ),

    );

    

    public function __construct() 
    {
        parent::__construct();
    }

    public function login($login, $senha) 
    {
        $where['login'] = $login;
        $cadastro = $this->get_where($where)->row();
        if($cadastro){
            $this->load->library('encrypt');

            if ($cadastro->senha == md5($senha)) {
            //if(password_verify($senha,$cadastro->senha)){
                unset($cadastro->senha);
                $cadastro->tipo = 'admin';
                $this->session->set_userdata('admin', $cadastro);
                $this->session->unset_userdata('cliente');
                $this->update(array('last_login' => date('Y-m-d H:i:s')), $cadastro->admin_id);
                return true;
            }
        }
        return false;
    }

    public function forgotPassword()
    {
        $output = array();
        $this->load->helper(array('form', 'url'));
        $validation = array(
                array('field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email',
                'errors' => array(
                    'required' => "O campo %s é obrigatório",
                    'valid_email' => "Email inválido"
                )
            )
        );
        
        $this->form_validation->set_rules($validation);
        if (!$this->form_validation->run()) {
            if (validation_errors()) {
                $error = str_replace("<p>", "* ", validation_errors());
                $error = str_replace("<p/>", "<br/>", $error);
                $this->data['error_forgot'] = $error;
            }
            $this->index();
            return;
        }
        
        $this->load->model('admin_model', 'user');
        $email = $this->input->post('email');
        $return = $this->user->checkEmail(array("email" => $email));
        
        if ($return == NULL) {
            $this->data['error_forgot'] = "Email não encontrado";
            $this->index();
            return;
        }
        
        $date_limit = date("Y-m-d", strtotime("+1 day"));
        $return->hash = $this->encryption->encrypt($date_limit);
        $return->code = $this->encryption->encrypt($return->IDUser);
        $return->user_type = "franqueador";
        
        $this->load->library('email');
        $this->email->from(EMAIL_FROM, 'Solicitação de recuperação de senha');
        $this->email->to((ENVIRONMENT == 'development' ? EMAIL_DEV : $return->email));
        $this->email->subject('Solicitação de recuperação de senha');
        $this->email->message($this->load->view("emails/forgotpassword", $return, TRUE));
        if ($this->email->send()) {
            if ($return->login == "userteste") {
                $this->data['success_forgot'] = "Email enviado com sucesso";
                $this->index();
                return;
            }
            $this->user->update(array("updatePass" => $date_limit), array("IDUser" => $return->IDUser));
            $this->data['success_forgot'] = "Email enviado com sucesso";
            $this->index();
            return;
        } else {
            $this->data['error_forgot'] = "Erro ao enviar o email: {$this->email->print_debugger()}";
            $this->index();
            return;
        }
    }
    
    public function recuperarSenha($code = NULL, $validate = NULL)
    {
        $output = array();

        if ($code == NULL && $validate == NULL) {
            $output = array("error" => "Código para validação não inserido");
        } else {
            $userteste = 5243;
            $this->load->model('user_model', 'user');
            $user_id = $this->encryption->decrypt(base64_decode($code));
            $date_limit = $this->encryption->decrypt(base64_decode($validate));
            
            if ($user_id == $userteste)
                $result = $this->user->checkEmail(array("IDUser" => $user_id, "updatePass" => $date_limit, "nivel" => 3));
            else
                $result = $this->user->checkEmail(array("IDUser" => $user_id, "updatePass" => $date_limit, "updatePass <=" => strtotime(date("Y-m-d H:i:s")), "nivel" => 3));



            if (count($result) > 0) {
                $result->code = base64_decode($code);
                $output['data'] = $result;
            } else {
                $output = array("error" => "Código para validação expirado");
            }
            
            if ($this->input->posts()) {
                $this->load->helper(array('form', 'url'));
                $validation = array(
                    array('field' => 'password',
                        'label' => 'Senha',
                        'rules' => 'trim|required|min_length[6]',
                        'errors' => array(
                            'required' => "O campo %s é obrigatório"
                        )
                    ), 
                    array('field' => 'password_again',
                        'label' => 'Confirme a nova senha',
                        'rules' => 'trim|required|min_length[6]|matches[password]',
                        'errors' => array(
                            'required' => "O campo %s é obrigatório"
                        )
                    )
                );
                $this->form_validation->set_rules($validation);
                if ($this->form_validation->run() == FALSE) {
                    if (validation_errors()) {
                        $error = str_replace("<p>", "* ", validation_errors());
                        $error = str_replace("<p/>", "<br/>", $error);
                        $output['error'] = $error;
                    }
                } else {
                    if ($user_id == $userteste) {
                        $update = array("senha" => md5($this->input->post('password')));
                    } else {
                        $update = array(
                            "senha" => md5($this->input->post('password')),
                            "updatePass" => date("Y-m-d H:i:s")
                        );
                    }
                        
                    $where_pass = array("IDUser" => $user_id);
                    if ($this->user->update($update, $where_pass)) {
                        $output['success'] = "Senha alterada com sucesso.";
                        unset($output['data']);
                    } else {
                        $output['error'] = "Erro ao alterar a sua senha.";
                    }
                }
            }
        }
        $this->load->view("/admin/recuperar_senha", $output);
    }

}
