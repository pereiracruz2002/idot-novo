<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    var $data = array();
    public function index() 
    {
        
        $this->load->model('admin_model','admin');
        $this->load->model('professor_model','professor');
        $this->load->model('alunos_model','alunos');

        if($this->input->posts()){

            //$senha = password_hash('senha', PASSWORD_DEFAULT); 
            if($this->admin->login($this->input->post('login'), $this->input->post('senha'))) {
                redirect('painel');
            } else {

                if($this->professor->login($this->input->post('login'), $this->input->post('senha'))) {
                    redirect('painel');
                }else{
                    $verifica_login  = $this->alunos->login($this->input->post('login'), $this->input->post('senha'));
                    if($verifica_login=='ok') {
                        redirect('painel');
                    }else{
                        $this->data['msg'] = $verifica_login;
                    }

                }
                
            }
        }
        $this->load->view('admin/login', $this->data);
    }

    public function sair() 
    {
        $this->session->sess_destroy();
        redirect('login');
    }


    public function forgotPassword()
    {

        $this->load->model('alunos_model','user');

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
                $msg = $error;
            }
            $output = array( 'msg' => $msg);
            $this->output->set_content_type('application/json')
                     ->set_output(json_encode($output));
        }
        
        $this->load->model('user_model', 'user');
        $email = $this->input->post('email');


        $where['email'] = $email;
        $return = $this->user->get_where($where)->row();
        
        if ($return == NULL) {
            $this->data['error_forgot'] = "Email não encontrado";
            $msg = $this->data['error_forgot'];
            $output = array( 'msg' => $msg);
            $this->output->set_content_type('application/json')
                     ->set_output(json_encode($output));
        }

        $gerar = $this->user->geraSenha(10);
        $nova_senha = md5($gerar);


        
        $this->load->library('email');
        $this->email->set_mailtype("html");

        // $config = Array(
        //     'protocol' => 'smtp',
        //     'smtp_host' => 'ssl://smtp.googlemail.com',
        //     'smtp_port' => 465,
        //     'smtp_user' => 'pereiracruz2002@gmail.com',
        //     'smtp_pass' => '817924fl',
        //     'mailtype'  => 'html', 
        //     'charset'   => 'iso-8859-1'
        // );
        // $this->load->library('email', $config);

        $this->email->from(EMAIL_FROM, 'Solicitação de recuperação de senha');
        $this->email->to((ENVIRONMENT == 'development' ? EMAIL_DEV : $return->email));
        $this->email->subject('Solicitação de recuperação de senha');

        $data = array('aluno'=> $return->nome,'nova_senha'=>$gerar);
                 

        $this->email->message($this->load->view("emails/forgotpassword", $data, TRUE));
        if ($this->email->send()) {
            
            $this->user->update(array("senha" => $nova_senha), array("alunos_id" => $return->alunos_id));
            $msg = "Email enviado com sucesso";

        } else {
            $msg = "Erro ao enviar o email: {$this->email->print_debugger()}";

        }
         $output = array( 'msg' => $msg);
            $this->output->set_content_type('application/json')
                     ->set_output(json_encode($output));
    }


}

/*
class Login extends CI_Controller
{
    var $data = array();
    
    public function index()
    {
        // if ($this->session->userdata('franqueador')) {
        //     redirect("franqueador/painel");
        // }
        
        $login = $this->input->post('login');
        $senha = trim(md5($this->input->post('password')));
        if ($this->input->posts() && $this->input->post('login')) {
            
            //$this->session->set_userdata('nome_usuario', $usuario_comum->nome);

            $this->load->model('user_model', 'user');
            //$this->load->model('mural_model','mural');

            $where = array('login' => $this->input->post('login'));

            $user = $this->user->get_where($where)->row();


            if ($user) {
                if ($user->status == 1) {
                    if ($user->senha == md5($this->input->post('password'))) {
                        //$this->load->model('usuario_franqueador_model', 'usuario_franqueador');
                        unset($user->senha);

                        //$user->mural = $this->mural->getMessages($user->IDFranquia);
                        $this->session->set_userdata('franqueador', $user);
                        redirect("admin/painel");
                    } else {
                        $this->data['msg'] = 'Senha inválida';
                    }
                } else {
                    $this->data['msg'] = 'Usuário desabilitado';
                }
            } else {
                $this->data['msg'] = 'Usuário não encontrado.';
            }
        }
        $this->load->view("/admin/login", $this->data);
    }
    
    public function logout()
    {
        $this->session->unset_userdata('franqueador');
        $this->session->unset_userdata('user_access');
        $this->session->unset_userdata('nome_usuario');
        redirect('/franqueador/login');
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
        
        $this->load->model('user_model', 'user');
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
        $this->load->view("/franqueador/recuperar_senha", $output);
    }


}
*/