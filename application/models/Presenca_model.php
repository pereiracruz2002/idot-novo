<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Presenca_model extends My_Model
{
	var $id_col = 'presenca_id';

	public function enviaEmail($email, $msg) 
    {
    	$this->load->library('email');
        $this->email->set_mailtype("html");

        $data['msg'] = $msg;

        $this->email->from(EMAIL_FROM, 'Aviso de Agendamento');
        $this->email->to((ENVIRONMENT == 'development' ? EMAIL_DEV : $email));
        $this->email->subject('Aviso de Agendamento');
        //$this->email->message($msg);
        if ($this->email->message($this->load->view("emails/aviso_agendamento", $data, TRUE))) {
        	return 'ok';
		}
    }
}
