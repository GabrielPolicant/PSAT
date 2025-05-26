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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exame</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <a href="index.php"><img src="source\img\Logo.png" alt="Logo AME Assis" class="responsive-img"></a>

    <form id="formulario" action="processamento.php" method="post">
        <!-- Header -->
        <header class="form-header">
            <div class="title-header">
                <h1>I) Avaliação Geral</h1>
            </div>

            <div class="info-header">
                <h2>I) Nome do Entrevistador: Daiana dos Santos</h2>
                <hr>

                <h2>II) Nome da Unidade: AME Assis</h2>
                <hr>

                <div class="date-header">
                    <label for="data"><h2>III) Data/Horário:</h2></label>
                    <input type="datetime-local" id="data" name="data" >
                </div>
                <hr>

                <h2>IV) Tipo de Unidade: Ambulatório</h2>
                <hr>



            </div>
        </header>

        <!-- Main -->
        <main>


        <?php
            require 'conexao.php';

            // 1. Obter perguntas do tipo GERAL
            $sqlGeral = "SELECT * FROM perguntas WHERE SERVICO = ? ORDER BY SEQUENCIA";
            $resultGeral = $conexao->prepare($sqlGeral);
            $resultGeral->execute(['GERAL']);
            $listarGeral = $resultGeral->fetchAll();

            foreach ($listarGeral as $pergunta) { ?>
                <div class="questao1">
                    <?php 
                    // Renderizar perguntas do tipo 'CHECK'
                    if ($pergunta['TIPO'] == 'CHECK') { ?>
                        <h3><?php echo $pergunta['CODIGO']; ?>) <?php echo $pergunta['NOME']; ?></h3>
                        <?php 
                        // Buscar itens relacionados à pergunta
                        $sqlItens = "SELECT * FROM perguntas_itens WHERE ID_PERGUNTA = ?";
                        $resultItens = $conexao->prepare($sqlItens);
                        $resultItens->execute([$pergunta['ID']]);
                        $listarItens = $resultItens->fetchAll();

                        foreach ($listarItens as $opcao) { ?>
                            <label class="label-main">
                                <input type="radio" name="<?php echo $pergunta['ID']; ?>" value="<?php echo $opcao['DESCRICAO']; ?>" >
                                <?php echo $opcao['DESCRICAO']; ?>
                            </label>
                        <?php }
                    } elseif ($pergunta['TIPO'] == 'TEXT') { ?>
                        <h3><?php echo $pergunta['CODIGO']; ?>) <?php echo $pergunta['NOME']; ?></h3>
                        <label class="label-main-coment">
                            <textarea id="coment" name="<?php echo $pergunta['ID']; ?>" rows="2" maxlength="100" placeholder="Digite seus comentários aqui..."></textarea>
                        </label>
                    <?php 
                    } elseif ($pergunta['TIPO'] == 'SELECT') { ?>
                        <h3 class="label-main-coment-title"><?php echo $pergunta['NOME']; ?></h3>
                        <?php 
                        $sqlItens = "SELECT * FROM perguntas_itens WHERE ID_PERGUNTA = ?";
                        $resultItens = $conexao->prepare($sqlItens);
                        $resultItens->execute([$pergunta['ID']]);
                        $listarItens = $resultItens->fetchAll();

                        foreach ($listarItens as $opcao) { ?>
                            <label class="label-main-insta">
                                <input type="radio" name="<?php echo $pergunta['ID']; ?>" value="<?php echo $opcao['DESCRICAO']; ?>"  >
                                <?php echo $opcao['DESCRICAO']; ?>
                            </label>
                        <?php }
                    } ?>
                </div>
            <?php }
            ?>

            <section class="form-header">
                <div class="title-header">
                    <h1>II) Ambulatório - Exame</h1>
                </div>
            </section>
            
            <?php

            // 2. Obter perguntas do tipo CONSULTA

            $sqlConsulta = "SELECT * FROM perguntas WHERE SERVICO = ? ORDER BY SEQUENCIA";
            $resultConsulta = $conexao->prepare($sqlConsulta);
            $resultConsulta->execute(['EXAME']);
            $listarConsulta = $resultConsulta->fetchAll();

            foreach ($listarConsulta as $perguntaConsulta) { ?>
                <div class="questao1">
                    <input type="hidden" name="servico" value="EXAME">
                    <?php 
                    if ($perguntaConsulta['TIPO'] == 'CHECK') { ?>
                        <h3><?php echo $perguntaConsulta['CODIGO']; ?>) <?php echo $perguntaConsulta['NOME']; ?></h3>
                        <?php 
                        $sqlItensConsulta = "SELECT * FROM perguntas_itens WHERE ID_PERGUNTA = ?";
                        $resultItensConsulta = $conexao->prepare($sqlItensConsulta);
                        $resultItensConsulta->execute([$perguntaConsulta['ID']]);
                        $listarItensConsulta = $resultItensConsulta->fetchAll();

                        foreach ($listarItensConsulta as $opcao) { ?>
                            <label class="label-main">
                                <input type="radio" name="<?php echo $perguntaConsulta['ID']; ?>" value="<?php echo $opcao['DESCRICAO']; ?>" >
                                <?php echo $opcao['DESCRICAO']; ?>
                            </label>
                        <?php }
                    } elseif ($perguntaConsulta['TIPO'] == 'TEXT') { ?>
                        <h3><?php echo $perguntaConsulta['CODIGO']; ?>) <?php echo $perguntaConsulta['NOME']; ?></h3>
                        <label class="label-main-coment">
                            <textarea id="coment" name="<?php echo $perguntaConsulta['ID']; ?>" rows="2" maxlength="100" placeholder="Digite seus comentários aqui..." ></textarea>
                        </label>
                    <?php } elseif ($perguntaConsulta['TIPO'] == 'SELECT') { ?>
                        <h3 class="label-main-coment-title"><?php echo $perguntaConsulta['NOME']; ?></h3>
                        <?php 
                        $sqlItensConsulta = "SELECT * FROM perguntas_itens WHERE ID_PERGUNTA = ?";
                        $resultItensConsulta = $conexao->prepare($sqlItensConsulta);
                        $resultItensConsulta->execute([$perguntaConsulta['ID']]);
                        $listarItensConsulta = $resultItensConsulta->fetchAll();

                        foreach ($listarItensConsulta as $opcao) { ?>
                            <label class="label-main-insta">
                                <input type="radio" name="<?php echo $perguntaConsulta['ID']; ?>" value="<?php echo $opcao['DESCRICAO']; ?>"  >
                                <?php echo $opcao['DESCRICAO']; ?>
                            </label>
                        <?php }
                    } ?>
                </div>
            <?php } ?>

            <section class="form-header">
                <div class="title-header">
                    <h1>III) Avaliação Final</h1>
                </div>

                <div class="form-avaliacao">
                    <div class="form-avaliacao-1">
                        <h3>Informações do(a) usuário(a) (Obrigátorio)</h3>
                        <p>Continuar na seção (1)</p>
                    </div>
                    <div class="form-avaliacao-2">
                        <h3>Informações do(a) acompanhante</h3>
                        <p>Continuar na seção (2)</p>
                    </div>
                </div>
            </section>
            
            <?php

            // 3. Obter perguntas do tipo FINAL

            $sqlFinal = "SELECT * FROM perguntas WHERE SERVICO = ? ORDER BY SEQUENCIA";
            $resultFinal = $conexao->prepare($sqlFinal);
            $resultFinal->execute(['FINAL']);
            $listarFinal = $resultFinal->fetchAll();

            foreach ($listarFinal as $perguntaFinal) { ?>
                <div class="questao1">
                    <?php 
                    if ($perguntaFinal['TIPO'] == 'CHECK') { ?>
                        <h3><?php echo $perguntaFinal['CODIGO']; ?>) <?php echo $perguntaFinal['NOME']; ?></h3>
                        <?php 
                        $sqlItens = "SELECT * FROM perguntas_itens WHERE ID_PERGUNTA = ?";
                        $resultItens = $conexao->prepare($sqlItens);
                        $resultItens->execute([$perguntaFinal['ID']]);
                        $listarItens = $resultItens->fetchAll();

                        foreach ($listarItens as $opcao) { ?>
                            <label class="label-main">
                                <input type="radio" name="<?php echo $perguntaFinal['ID']; ?>" value="<?php echo $opcao['DESCRICAO']; ?>" >
                                <?php echo $opcao['DESCRICAO']; ?>
                            </label>
                        <?php }
                    } elseif ($perguntaFinal['TIPO'] == 'TEXT') { ?>
                        <h3><?php echo $perguntaFinal['CODIGO']; ?>) <?php echo $perguntaFinal['NOME']; ?></h3>
                        <label class="label-main-coment">
                            <textarea id="coment" name="<?php echo $perguntaFinal['ID']; ?>" rows="2" maxlength="100" placeholder="Digite seus comentários aqui..." ></textarea>
                        </label>
                    <?php }

                    elseif ($perguntaFinal['TIPO'] == 'SELECT') { ?>
                        <h3 class="label-main-coment-title"><?php echo $perguntaFinal['NOME']; ?></h3>
                        <?php 
                        $sqlItens = "SELECT * FROM perguntas_itens WHERE ID_PERGUNTA = ?";
                        $resultItens = $conexao->prepare($sqlItens);
                        $resultItens->execute([$perguntaFinal['ID']]);
                        $listarItens = $resultItens->fetchAll();

                        foreach ($listarItens as $opcao) { ?>
                            <label class="label-main-insta">
                                <input type="radio" name="<?php echo $perguntaFinal['ID']; ?>" value="<?php echo $opcao['DESCRICAO']; ?>"  >
                                <?php echo $opcao['DESCRICAO']; ?>
                            </label>
                        <?php }
                    } ?>

                </div>
            <?php } 
        ?>


</main>

        <!-- Footer -->
        <footer>
            <!-- Botão de envio -->
            <button class="submit" type="submit">Enviar</button>
        </footer>
    </form>

    <!-- <script src="script.js"></script> -->

</body>
</html>
          