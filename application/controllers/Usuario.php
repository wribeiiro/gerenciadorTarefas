<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Usuario_model');
    }

    /*chama a página de cadastro*/
    public function index()
    {
        $this->load->view('usuario/cadastro');
    }

    /*Adiciona um novo usuário ao banco de dados*/
    public function adicionar()
    {
        /*pega os valores preenchidos no formulário e atribui as variáveis*/
        $nome = $this->input->post('nome');
        $email = $this->input->post('email');
        $senha = md5($this->input->post('senha'));

        /*Array dos dados que serão adicionados na tabela*/
        $dados = array(
            'nome' => $nome,
            'email' => $email,
            'senha' => $senha
        );

        /*tabela do banco*/
        $tabela = "usuarios";

        /*verifica se o usuário foi adicionado*/
        if ($this->Usuario_model->adicionar($tabela, $dados))
        {
            $this->session->set_flashdata('success', 'Cadastro realizado com sucesso!');
            redirect('login');
        } else
        {
            $this->session->set_flashdata('error', 'Não foi possível realizar o cadastro.');
            redirect('login');  
        }
    }


    public function perfil()
    {
        $usuario_id = $this->session->userdata('usuario_id');
        $tabela = "usuarios";

        $dados['usuario'] = $this->Usuario_model->getById($usuario_id, $tabela);

        $dados['titulo'] = "Perfil";
		$dados['conteudo'] = "usuario/perfil";

		$this->load->view('includes/html_header');
		$this->load->view('includes/menu');
		$this->load->view('base', $dados);
		$this->load->view('includes/html_footer');
    }

}