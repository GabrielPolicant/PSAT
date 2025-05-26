<?php

$status = '';
$mensagem = '';

try {
    include_once './conexao.php';
    
    $data = $_POST['data'];
    $servico = $_POST['servico'];
    

    unset($_POST['data'],
          $_POST['servico']);
    
    $sql_participante = "SELECT MAX(id_participante) as participante FROM respostas";
    $resultParticipante = $conexao->prepare($sql_participante);
    $resultParticipante->execute();
    $listarParticipante = $resultParticipante->fetch();
    $id_participante = $listarParticipante['participante'] + 1;

    foreach ($_POST as $key => $value) { 
        $questao = $key;
        $respostas = $value;
        // echo $questao. ' - '. $respostas.'</br>';
        $insert = "INSERT INTO respostas (ID_PARTICIPANTE,PERGUNTA, RESPOSTA, DATA_CADASTRO, SERVICO) VALUES (?,?,?,?,?)";
        $stmt   = $conexao->prepare($insert);
        $stmt->execute([$id_participante,$questao, $respostas, $data, $servico]);
        // var_dump($stmt);
    }
        $mensagem = 'Informações enviadas com sucesso!';
        $status = 'sucesso';
    // echo json_encode(array("retorno" => "QuestionÃ¡rio finalizado com sucesso."));

} catch (PDOException $msg) {
    $mensagem = $msg->getMessage();
    $status = 'erro';
}

header("Location:index.php?mensagem=$mensagem&status=$status");

/*if ($servico == 'EXAME'){
    header("Location:exame.php?mensagem=$mensagem");
} elseif ($servico == 'CONSULTA'){
    header("Location:consulta.php?mensagem=$mensagem");
} elseif ($servico == 'CIRURGIA') {
    header("Location:cirurgia.php?mensagem=$mensagem");
}*/

?>
