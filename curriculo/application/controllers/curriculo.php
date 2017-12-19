<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Curriculo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cidades_model', 'cidades');
        $this->load->model('Formacao_model', 'formacao');
        $this->load->model('Usuario_model', 'usuario');
        $this->load->model('Formacao_model', 'formacao');
        $this->load->model('Habilidades_model', 'habilidades');
        $this->load->model('Historicos_model', 'historicos');
        $this->load->model('Curriculo_model', 'curriculo');
        $this->load->model('Categorias_model', 'categorias');
        $this->load->helper('file');
        //$this->output->enable_profiler(TRUE);
    }

    public function index() {
        
    }

    public function show($usu_codigo, $mensagem = null) {
        if (!$usu_codigo) {
            $mensagem['sucesso'] = '<strong><span class="special">Ocorreu um problema, faça seu login e tente novamente.</strong></span>';
            $this->load->view('view_sucesso', $mensagem);
        } else {
            if (!$this->curriculo->verifica_curriculo($usu_codigo)) {
                $dados['mensagem'] = $mensagem;
                $dados['usuario'] = $usu_codigo;
                $dados['estados'] = $this->cidades->getEstados();
                $dados['areas'] = $this->formacao->getArea();
                $dados['escolaridades'] = $this->formacao->getEscolaridade();
                $dados['categorias'] = $this->categorias->getCategorias();
                $dados_header = array(
                    'titulo' => 'Monte seu Currículo',
                    'descricao' => 'Tenha um currículo personalizado e profissional em suas mãos.',
                    'palavras_chave' => 'empregue-me, curriculo, empregos es'
                );
                //nome, arquivo, dados
                $this->layout->region('html_header', 'view_html_header', $dados_header);
                $this->layout->region('corpo', 'view_conteudo', $dados);
                $this->layout->region('html_footer', 'view_html_footer');
                //chama o layout que irá exibir as views parciais..
                $this->layout->show('layout');
            } else {
                //echo "<script type='text/javascript'>window.location.href = 'http://www.empreguemeagora.com.br/devempregueme/rede/novo/main.php?session_curriculo=ok&show_message=Currículo cadastrado com sucesso!';</script>";
                $mensagem['sucesso'] = '<strong><span class="special">Currículo cadastrado com sucesso!!</strong></span>';
                $this->load->view('view_sucesso', $mensagem);
            }
        }
    }

    public function getCidades($estados_cod_estados) {
        $cidades = $this->cidades->getCidades($estados_cod_estados);
        if (empty($cidades)) {
            return "Nenhuma cidade encontrada";
        } else {
            echo json_encode($cidades);
            return;
        }
    }

    public function setAdd() {
        $usu_codigo = $this->input->post('user');
        $this->form_validation->set_rules('usu_nome', 'Nome', 'required');
        $this->form_validation->set_rules('usu_sexo', 'Sexo', 'required');
        $this->form_validation->set_rules('usu_idade', 'Idade', 'required');
        $this->form_validation->set_rules('cidade', 'Cidade', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('usu_bairro', 'Bairro', 'required');
        $this->form_validation->set_rules('usu_telefone1', 'Telefone de Contato', 'required');
        $this->form_validation->set_rules('objetivo', 'Objetivo', 'required');
        $this->form_validation->set_rules('fk_area_formacao', 'Área profissional', 'required');
        $this->form_validation->set_rules('fk_categoria_codigo', 'Categoria', 'required');
        $this->form_validation->set_rules('fk_escolaridade_formacao', 'Escolaridade', 'required');
        $this->form_validation->set_rules('ingles', 'Sabe falar Inglês?', 'required');
        $this->form_validation->set_rules('informatica', 'Conhecimento do Pacote Office', 'required');
        $this->form_validation->set_rules('horario_disp', 'Disponibilidade de Horário', 'required');
        $this->form_validation->set_rules('pretensao_salarial', 'Pretensão Salarial', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->show($usu_codigo);
        } else {

            /*
             * 1 ATUALIZA DADOS DO USUÁRIO
             * 2 INSERE FORMAÇÃO
             * 3 INSERE HABILIDADES
             * 4 INSERE CURRICULO
             * 5 INSERE HISTÓRICO PROFISSIONAL
             */
            $usu_codigo = $this->usuario($usu_codigo);
            if ($usu_codigo) {
                $fk_formacao_id = $this->formacao($usu_codigo);
                $fk_habilidades_id = $this->habilidades($usu_codigo);
                $objetivo = $this->input->post('objetivo');
                $fk_categoria_codigo = $this->input->post('fk_categoria_codigo');
                $outras_informacoes = $this->input->post('outras_informacoes');
                $curriculo_codigo = $this->curriculo->insert($usu_codigo, $fk_habilidades_id, $fk_formacao_id, $fk_categoria_codigo, $objetivo, $outras_informacoes);
                if ($curriculo_codigo) {
                    $this->historico($curriculo_codigo);
                    //curriculo cadastrado com sucesso
                    $mensagem['sucesso'] = '<strong><span class="special">Currículo cadastrado com sucesso!!</strong></span>';
                    $this->load->view('view_sucesso', $mensagem);
                } else {
                    //problema ao cadastrar curriculo
                    $this->show($usu_codigo, 'Ocorreu um problema. ERRO CURR');
                }
            } else {
                //problema ao editar usuário
                $this->show($usu_codigo, 'Ocorreu um problema. ERRO USER');
            }
        }
    }

    public function usuario($usu_codigo) {
        /* DADOS USUARIO */
        //traz os dados do usuário cadastrado no banco        
        /* dados do usuario vindo do BD ----inicio */
        $dados_user['user'] = $this->usuario->getById($usu_codigo);
        $usu_id = $dados_user['user']->usu_id;
        $usu_dt_cad = $dados_user['user']->usu_dt_cad;
        $usu_login = $dados_user['user']->usu_login;
        $usu_senha = $dados_user['user']->usu_senha;
        $usu_tags = $dados_user['user']->usu_tags;
        $usu_permissao = $dados_user['user']->usu_permissao;
        /* dados do usuario vindo do BD ----fim */
        $usu_nome = $this->input->post('usu_nome');
        $usu_sexo = $this->input->post('usu_sexo');
        $usu_idade = $this->input->post('usu_idade');
        $usu_local = $this->input->post('cidade');
        $usu_email = $this->input->post('email');
        $usu_bairro = $this->input->post('usu_bairro');
        $usu_telefone1 = $this->input->post('usu_telefone1');
        $usu_telefone2 = $this->input->post('usu_telefone2');
        $usu_link_facebook = $this->input->post('usu_link_facebook');
        if ($_FILES['userfile']['error'] == 0) {
            $usu_file = $this->uploadImage($usu_codigo);
            $usu_file = $this->ImageResize($usu_file, 100, 100);
        } else {
            $usu_file = NULL;
        }
        $query = $this->usuario->update($usu_codigo, $usu_id, $usu_nome, $usu_local, $usu_dt_cad, $usu_email, $usu_login, $usu_senha, $usu_tags, $usu_permissao, $usu_sexo, $usu_idade, $usu_bairro, $usu_telefone1, $usu_telefone2, $usu_link_facebook, $usu_file);
        if ($query) {
            return $usu_codigo;
        } else {
            return 0;
        }
    }

    public function formacao($usu_codigo = null) {
        /* FORMACAO ------INICIO */
        $fk_area_formacao = $this->input->post('fk_area_formacao');
        $fk_escolaridade_formacao = $this->input->post('fk_escolaridade_formacao');
        $fk_formacao = $this->formacao->insertFormacao($fk_area_formacao, $fk_escolaridade_formacao);
        if ($fk_formacao) {
            /* CURSO 1 */
            $curso1 = $this->input->post('curso1');
            if ($curso1 != "") {
                $curso1_inicio = $this->input->post('curso1_inicio');
                $curso1_termino = $this->input->post('curso1_termino');
                $curso1_instituicao = $this->input->post('curso1_instituicao');
                $this->formacao->insertCursos($fk_formacao, $curso1, $curso1_inicio, $curso1_termino, $curso1_instituicao);
            }
            /* CURSO 2 */
            $curso2 = $this->input->post('curso2');
            if ($curso2 != "") {
                $curso2_inicio = $this->input->post('curso2_inicio');
                $curso2_termino = $this->input->post('curso2_termino');
                $curso2_instituicao = $this->input->post('curso2_instituicao');
                $this->formacao->insertCursos($fk_formacao, $curso2, $curso2_inicio, $curso2_termino, $curso2_instituicao);
            }
            /* FORMACAO ------FIM */
            return $fk_formacao;
        } else {
            redirect(base_url('show/' . $usu_codigo));
        }
    }

    public function habilidades($usu_codigo = null) {
        /* HABILIDADES ------INICIO */
        $cnh_form = $this->input->post('cnh');
        $cnh = "";
        if ($cnh_form != "") {
            foreach ($cnh_form as $dados_cnh) {
                $cnh .= $dados_cnh;
            }
        }
        $disponivel_viagem = $this->input->post('disponivel_viagem');
        $horario_disp_form = $this->input->post('horario_disp');
        $horario_disp = "";
        foreach ($horario_disp_form as $dados_horario_disp) {
            $horario_disp .= $dados_horario_disp . "/";
        }
        $pretensao_salarial = $this->input->post('pretensao_salarial');
        $ingles = $this->input->post('ingles');
        $ingles_nivel = $this->input->post('ingles_nivel');
        $office = $this->input->post('informatica');
        $office_nivel = $this->input->post('informatica_nivel');
        $fk_habilidades = $this->habilidades->insertHabilidades($cnh, $disponivel_viagem, $horario_disp, $pretensao_salarial, $ingles, $ingles_nivel, $office, $office_nivel);
        if ($fk_habilidades) {
            /* HABILIDADE 1 */
            $habilidade1 = $this->input->post('habilidade1');
            if ($habilidade1 != "") {
                $habilidade1_inicio = $this->input->post('habilidade1_inicio');
                $habilidade1_termino = $this->input->post('habilidade1_termino');
                $habilidade1_instituicao = $this->input->post('habilidade1_instituicao');
                $this->habilidades->insertOutras($fk_habilidades, $habilidade1, $habilidade1_inicio, $habilidade1_termino, $habilidade1_instituicao);
            }
            /* HABILIDADE 2 */
            $habilidade2 = $this->input->post('habilidade2');
            if ($habilidade2 != "") {
                $habilidade2_inicio = $this->input->post('habilidade2_inicio');
                $habilidade2_termino = $this->input->post('habilidade2_termino');
                $habilidade2_instituicao = $this->input->post('habilidade2_instituicao');
                $this->habilidades->insertOutras($fk_habilidades, $habilidade2, $habilidade2_inicio, $habilidade2_termino, $habilidade2_instituicao);
            }
            /* HABILIDADES ------FIM */
            return $fk_habilidades;
        } else {
            redirect(base_url('show/' . $usu_codigo));
        }
    }

    public function historico($fk_curriculos_id) {
        /* HISTORICO PROFISSIONAL ------INICIO */

        /* EMPRESA 1 */
        $empresa1_nome = $this->input->post('empresa1_nome');
        if ($empresa1_nome != "") {
            $empresa1_ano = $this->input->post('empresa1_ano');
            $empresa1_periodo_valor = $this->input->post('empresa1_periodo_valor');
            $empresa1_periodo_tempo = $this->input->post('empresa1_periodo_tempo');
            $empresa1_cargo = $this->input->post('empresa1_cargo');
            $empresa1_responsabilidades = $this->input->post('empresa1_responsabilidades');
            $this->historicos->insert($fk_curriculos_id, $empresa1_nome, $empresa1_ano, $empresa1_periodo_valor, $empresa1_periodo_tempo, $empresa1_cargo, $empresa1_responsabilidades);
        }
        /* EMPRESA 2 */
        $empresa2_nome = $this->input->post('empresa2_nome');
        if ($empresa2_nome != "") {
            $empresa2_ano = $this->input->post('empresa2_ano');
            $empresa2_periodo_valor = $this->input->post('empresa2_periodo_valor');
            $empresa2_periodo_tempo = $this->input->post('empresa2_periodo_tempo');
            $empresa2_cargo = $this->input->post('empresa2_cargo');
            $empresa2_responsabilidades = $this->input->post('empresa2_responsabilidades');
            $this->historicos->insert($fk_curriculos_id, $empresa2_nome, $empresa2_ano, $empresa2_periodo_valor, $empresa2_periodo_tempo, $empresa2_cargo, $empresa2_responsabilidades);
        }
        /* HISTORICO PROFISSIONAL ------FIM */
    }

    public function uploadImage($usu_codigo) {
        $config['upload_path'] = 'assets/images/usuarios/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 1024 * 1024 * 2;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['file_name'] = "curr_usu_" . $usu_codigo;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
            exit();
        } else {
            $data = array('upload_data' => $this->upload->data());
            return $data['upload_data']['file_name'];
        }
    }

    public function ImageResize($foto, $widht, $height, $miniatura = FALSE) {
        $this->load->library('image_lib');
        $this->image_lib->clear();
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'assets/images/usuarios/' . $foto;
        $config['create_thumb'] = $miniatura;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $widht;
        $config['height'] = $height;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        return $foto;
    }

}
