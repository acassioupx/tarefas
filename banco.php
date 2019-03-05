<?php
  $bdServidor='127.0.0.1';
  $bdUsuario='sistematarefas';
  $bdSenha='sistema';
  $bdBanco='tarefas';

  /*
    A função "mysqli_connect()" com os paramentros conforme sintaxe,
    promove a conexao ao banco.
  */

  $conexao=mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);

  //Verifica erros de conexao e retornar caso seu valor seja true.
  if(mysqli_connect_errno($conexao)){
    echo "Problemas para conectar no banco. Erro ";
    echo mysqli_connect_error();
    die();
  }

  function buscar_tarefas($conexao){
    //Armazena o comando SQL
    $sqlBusca='SELECT * FROM tarefas';

    /*
    A função "mysqli_query()" utiliza a variavel $conexao e a variavel
    com o comando SQL $sqlBusca para ir ao banco executar o comando e trazer o
    resultado. Este resultado fica armazenado na variavel $resultado, esta
    variavel é uma array e por isto devemos usar o foreach as para ler toda
    array.
    */
    $resultado=mysqli_query($conexao,$sqlBusca);

    //Criação da array vazia para receber os resultados no while abaixo.
    $tarefas=[];

    /*
    A função mysqli_fetch_assoc() passar por todas a linhas do resultado. Deste
    modo o while será executado até mysqli_fetch_assoc() tenha passado por cada
    linha do resultado. A cada volta no while o resultado em armazenado no array
    $tarefas[];
    */
    while($tarefa=mysqli_fetch_assoc($resultado)){
      $tarefas[]=$tarefa;
    }
    /*
    Finalmente o return devolve a variavel array $tarefas com todos resultados
    obtidos para quem solicitou o procedimento.
    */
    return $tarefas;
  }

  //Função para gravar no banco.
  function gravar_tarefa($conexao,$tarefa){
    /*
    A variavel $sqlGravar escreve no banco com a linguame SQL o comando
    INSERT INTO com a sintaxe do SQL. Para gravar valores strings de um variavel
    PHP deve-se coloca-las dentro de {} colchetes.
    */
    $sqlGravar="
      INSERT INTO tarefas
      (nome, descricao, prioridade, prazo, concluida)
      VALUES
      (
        '{$tarefa['nome']}',
        '{$tarefa['descricao']}',
        '{$tarefa['prioridade']}',
        '{$tarefa['prazo']}',
        '{$tarefa['concluida']}'
      )
    ";
    /*
    Utilizando mais uma vez a função mysqli_query() que serve para executar o
    codigo SQL conforme foi informado na variavel $sqlGravar. A função recebe
    dois parametros, $conexao - que está criado no topo deste documento e a
    variavel $sqlGravar que está recebendo como parametro a variavel
    $tarefa que são os dados conforme nosso formulário.
    */
    mysqli_query($conexao,$sqlGravar);

  }

  function buscar_tarefa($conexao, $id)
  {
    $sqlBusca = 'SELECT * FROM tarefas  WHERE id = ' . $id;
    $resultado = mysqli_query($conexao,$sqlBusca);
    return mysqli_fetch_assoc($resultado);
  }

  function editar_tarefa($conexao,$tarefa)
  {
      $sqlEditar = "
        UPDATE tarefas SET
          nome = '{$tarefa['nome']}',
          descricao = '{$tarefa['descricao']}',
          prioridade = {$tarefa['prioridade']},
          prazo = '{$tarefa['prazo']}',
          concluida = {$tarefa['concluida']}
        WHERE id = {$tarefa['id']}
      ";

      mysqli_query($conexao, $sqlEditar);
  }

  function remover_tarefa($conexao, $id)
  {
    $sqlRemover = "DELETE FROM tarefas WHERE id = {$id}";
    mysqli_query($conexao,$sqlRemover);
  }


  //funcao para gravar anexo no banco.
  function gravar_anexo($conexao, $anexo)
  {
    $sqlGravar ="
      INSERT INTO anexos
      (tarefa_id, nome, arquivo)
      VALUES
        (
          {$anexo['tarefa_id']},
          '{$anexo['nome']}',
          '{$anexo['arquivo']}'
        )
        ";

    mysqli_query($conexao, $sqlGravar);

  }

  function buscar_anexos($conexao, $tarefa_id)
  {
    $sql = "
      SELECT * FROM anexos
      WHERE tarefa_id = {$tarefa_id}";
      $resultado = mysqli_query($conexao, $sql);

    $anexos = [];

    while ($anexo = mysqli_fetch_assoc($resultado)){
      $anexos[] = $anexo;
    }

    return $anexos;
  }

  function buscar_anexo($conexao, $id)
  {
    $sqlBusca =   'SELECT * FROM anexos WHERE id = '. $id;
    $resultado = mysqli_query($conexao, $sqlBusca);

    return mysqli_fetch_assoc($resultado);
  }

  function remover_anexo($conexao, $id)
  {
    $sqlRemover = "DELETE FROM anexos WHERE id = {$id}";

    mysqli_query($conexao, $sqlRemover);
  }

?>
