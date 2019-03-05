<?php

session_start();

require "banco.php";
require "ajudantes.php";

/*
Esta variavel recebe o valor de false e ao ler o if no template
é definido que a listagem de tarefas não seja exibida.
*/
$exibir_tabela = true;

$tem_erros = false;
$erros_validacao=[];

if(tem_post()){
  $tarefa=[];

  if(array_key_exists('nome', $_POST)
   && strlen($_POST['nome']) > 0){
    $tarefa['nome'] = $_POST['nome'];
  }else{
    $tem_erros = true;
    $erros_validacao['nome'] = 'O nome da tarefa é obrigatório!';
  }


  if(array_key_exists('descricao',$_POST)){
    $tarefa['descricao']=$_POST['descricao'];
  }else{
    $tarefa['descricao']='';
  }

  if(array_key_exists('prazo',$_POST)
    && strlen($_POST['prazo']) > 0){
      if(validar_data($_POST['prazo'])){
        $tarefa['prazo']=
        traduz_data_para_banco($_POST['prazo']);
      }else{
        $tem_erros = true;
        $erros_validacao['prazo'] =
        'O prazo não é uma data válida!';
      }
  }else {
    $tarefa['prazo']='';
  }

  $tarefa['prioridade']=$_POST['prioridade'];

  if(array_key_exists('concluida',$_POST)){
    $tarefa['concluida']=1;
  }else{
    $tarefa['concluida']=0;
  }

  if(! $tem_erros){
    gravar_tarefa($conexao,$tarefa);
    header('Location: tarefas.php');
    die();
  }
}

$lista_tarefas=[];

$lista_tarefas=buscar_tarefas($conexao);

$tarefa=[
  'id'          => 0,
  'nome'        => (array_key_exists('nome',$_POST))
                   ? $_POST['nome']
                   :  '',
  'descricao'   => (array_key_exists('descricao',$_POST))
                   ? $_POST['descricao']
                   : '',
  'prazo'       => (array_key_exists('prazo',$_POST))
                   ? traduz_data_para_banco($_POST['prazo'])
                   : '',
  'prioridade'  => (array_key_exists('prioridade',$_POST))
                   ? $_POST['prioridade']
                   : 1,
  'concluida'   => (array_key_exists('concluida',$_POST))
                   ? $_POST['concluida']
                   : ''
];

require "template.php";


?>
