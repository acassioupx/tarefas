<!DOCTYPE html>

<html>
<head>
  <meta charset="UTF-8"/>
  <link rel="stylesheet" href="../_css/estilo2.css" type="text/css"/>
  <title>Gerenciador de Tarefas</title>
</head>
<body>
  <div>

    <h1>Gerenciador de Tarefas</h1>

    <?php require 'formulario.php'; ?>

    <?php if($exibir_tabela) : ?>
      <?php require 'tabela.php'; ?>
    <?php endif; ?>
  </div>
</body>
</html>
