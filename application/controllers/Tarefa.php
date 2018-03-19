<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarefa extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Tarefa_model');
		$this->load->helper('data');
	}

    public function index()
    {
    	$usuario_id = $this->session->userdata('usuario_id');
    	$tabela = "tarefas";
    	/*registros do banco de dados*/
 		$dados['tarefas'] = $this->Tarefa_model->getAll($usuario_id, $tabela);

        $dados['titulo'] = "Minhas tarefas";
		$dados['conteudo'] = "tarefa/lista";

		$this->load->view('includes/html_header');
		$this->load->view('includes/menu');
		$this->load->view('base', $dados);
		$this->load->view('includes/html_footer');
	}
	
	
	/*Formulário cadastro de tarefas*/
	public function cadastro()
	{
		$dados['titulo'] = "Adicionar tarefa";
		$dados['conteudo'] = "tarefa/cadastro";

		$this->load->view('includes/html_header');
		$this->load->view('includes/menu');
		$this->load->view('base', $dados);
		$this->load->view('includes/html_footer');
	}


	/*Adicionar tabela no banco de dados*/
	public function adicionar()
	{
		$titulo = $this->input->post('titulo');
		$descricao = $this->input->post('descricao');
		$prioridade = $this->input->post('prioridade');
		$status = 0;
		$data_criacao = date('Y-m-d');
		$usuario_id = $this->session->userdata('usuario_id');

		$dados = array(
			'titulo' => $titulo,
			'descricao' => $descricao,
			'prioridade' => $prioridade,
			'status' => $status,
			'data_criacao' => $data_criacao,
			'usuario_id' => $usuario_id
		);

		$tabela = "tarefas";

		if ($this->Tarefa_model->adicionar($tabela, $dados))
		{
			$this->session->set_flashdata('success', 'Tarefa adicionada com sucesso!');
			redirect('tarefa');
		} else
		{
			$this->session->set_flashdata('error', 'Não foi possível adicionar a tarefa.');
			redirect('tarefa');
		}
	}


	/*Excluir tarefa do banco de dados*/
	public function excluir()
	{
		$id = $this->uri->segment(3);

		$tabela = "tarefas";

		if ($this->Tarefa_model->excluir($id, $tabela))
		{
			$this->session->set_flashdata('success', 'Tarefa excluída com sucesso!');
			redirect('tarefa');
		} else
		{
			$this->session->set_flashdata('error', 'Não foi possível excluir a tarefa.');
			redirect('tarefa');
		}
	}


	/*Concluir tarefa*/
	public function concluir()
	{
		$id = $this->uri->segment(3);

		$tabela = "tarefas";

		$dados = array(
			'status' => 1,
			'data_termino' => date('Y-m-d')
		);

		if ($this->Tarefa_model->atualizar($id, $tabela, $dados))
		{
			$this->session->set_flashdata('success', 'Parabéns! Sua tarefa foi concluída com sucesso!');
			redirect('tarefa');
		} else
		{
			$this->session->set_flashdata('error', 'Não foi possível concluir a tarefa.');
			redirect('tarefa');
		}
	}


	/*Atualizar tarefa*/
	public function atualizar()
	{
		/*Preenche os campos do formulário*/
		$id = $this->uri->segment(3);

		$tabela = "tarefas";

		$dados['tarefa'] = $this->Tarefa_model->getById($id, $tabela);


		/*Carrega a página*/
		$dados['titulo'] = "Atualizar tarefa";
		$dados['conteudo'] = "tarefa/atualizar";

		$this->load->view('includes/html_header');
		$this->load->view('includes/menu');
		$this->load->view('base', $dados);
		$this->load->view('includes/html_footer');

		/*Atualiza os dados da tarefa*/
		if ($_POST)
		{
			$id = $this->input->post('id');
			$titulo = $this->input->post('titulo');
			$descricao = $this->input->post('descricao');
			$prioridade = $this->input->post('prioridade');

			$dados = array(
				'titulo' => $titulo,
				'descricao' => $descricao,
				'prioridade'=> $prioridade
			);

			$tabela = "tarefas";

			if ($this->Tarefa_model->atualizar($id, $tabela, $dados))
			{
				$this->session->set_flashdata('success', 'Tarefa atualizada com sucesso!');
				redirect('tarefa');	
			} else
			{
				$this->session->set_flashdata('error', 'Não foi possível atualizar a tarefa');
				redirect('tarefa');
			}
		}
	}
}