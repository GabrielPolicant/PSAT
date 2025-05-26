<?php

if (isset($_GET['mensagem'])) {
    $msg = $_GET['mensagem'];
    if ($_GET['status'] == 'erro') {
        ?> <script>alert("ERRO !! Informação não foi enviada.") 
        console.log("<?php echo $msg ?>") </script> <?php    
    } else {
        ?> <script>alert("<?php echo $msg ?>");</script> <?php
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/menu.css">
  <link rel="icon" type="image/png" href="source/img/favicon.ico">
  <title>AME Assis - Avaliação</title>
</head>
<body>
  <div class="content-wrapper">
    <header>
      <div class="header-content">
        <img src="./source/img/Logo.png" alt="Logo do AME">
        <p>Escolha o motivo da sua visita</p>
      </div>
    </header>
    <main>
      <section class="menu-container">
        <div class="menu-options">
          <a href="consulta.php" class="menu-card">
            <div class="icon">🩺</div>
            <h2>Consulta</h2>
          </a>
          <a href="exame.php" class="menu-card">
            <div class="icon">🧪</div>
            <h2>Exame</h2>
          </a>
          <a href="cirurgia.php" class="menu-card">
            <div class="icon">🏥</div>
            <h2>Cirurgia</h2>
          </a>
        </div>
      </section>
    </main>
  </div>
  <footer>
    <p>&copy; 2024 AME Assis. Todos os direitos reservados.</p>
  </footer>

</body>
</html>
