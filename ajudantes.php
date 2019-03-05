<?php

/*
Função para converter o valor da prioridade cadastrado no formulario
pois o banco de dados recebe numeros 1, 2 ou 3 e é exibido no
formulário uma string com seu significado.
*/
function traduz_prioridade($codigo){
  $prioridade='';
  switch($codigo){
    case 1:
      $prioridade='Baixa';
      break;
    case 2:
      $prioridade='Média';
      break;
    case 3:
      $prioridade='Alta';
      break;
  }
  return $prioridade;
}

/*
Função para exibir a data no formato americano AAAA/MM/DD pois é desta
forma que o banco de dados MySQL interpreta.
*/
function traduz_data_para_banco($data){
  if($data == ""){
    return "";
  }

  $partes = explode("/",$data);

  if(count($partes) != 3){
    return $data;
  }

  $objeto_data = DateTime::createFromFormat('d/m/Y',$data);

  return $objeto_data->format('Y-m-d');

# $dados=explode("/",$data);
# $data_banco="{$dados[2]}-{$dados[1]}-{$dados[0]}";

#  return $data_banco;
}

/*
Função para configurar o formato da data no modelo brasileiro
DD/MM/AAAA, este será exibido no formulário.
*/
function traduz_data_para_exibir($data){
  if($data=="" OR $data == "0000-00-00"){
    return "";
  }

  $partes = explode("-",$data);

  if(count($partes) != 3){
    return $data;
  }
/*
Esta é uma maneira de traduzir o formato da data utilizando
um objeto e uma classe.
*/
  $objeto_data=DateTime::createFromFormat('Y-m-d',$data);

  return $objeto_data->format('d/m/Y');

//Está é uma maneira de fazer a tradução (convencional/antiquada)
# $dados=explode("-",$data);
# $data_exibir="{$dados[2]}/{$dados[1]}/{$dados[0]}";

#  return $data_exibir;
}

/*
Função para apresentar a prioridade em forma de string pois
para melhor utilização no banco de dados, é enviado apenas o
numero 1 - para conlcuida e o numero 0 para não concluida ou
quando o checkbox fica desmarcado.
*/
function traduz_concluida($concluida){
  if($concluida==1){
    return 'Sim';
  }

  return 'Não';
}

/*
Função para verificar se uma variavel possui indice e se possui dados no
indice.
*/
function tem_post(){
  if(count($_POST) > 0){
    return true;
  }
  return false;
}

function validar_data($data){
  $padrao = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/';
  $resultado = preg_match($padrao,$data);

  if ($resultado == 0 ){
    return false;
  }

  $dados = explode('/',$data);

  $dia = $dados[0];
  $mes = $dados[1];
  $ano = $dados[2];

  $resultado = checkdate($mes,$dia,$ano);

  return $resultado;
}

function tratar_anexo($anexo)
{
  $padrao = '/^.+(\.pdf|\.zip)$/';
  $resultado = preg_match($padrao, $anexo['name']);

  if($resultado == 0){
    return false;
  }

  move_uploaded_file(
    $anexo['tmp_name'],
    "anexos/{$anexo['name']}"
  );

  return true;
}

?>
