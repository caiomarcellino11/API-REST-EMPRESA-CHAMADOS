<?php

header("Content-type: application/json");

require "conexao.php";

$metodo = $_SERVER["REQUEST_METHOD"];


if ($metodo == "POST") {
    $json = file_get_contents("php://input");

    $dados = json_decode($json, true);

    $prioridade = $dados["prioridade"];
    $status = $dados["status"];

    if ($prioridade != "baixa" && $prioridade != "media" && $prioridade != "alta") {
        echo json_encode(["Mensagem" => "prioridade inválida - coloque estritamente prioridade: baixa ou media ou alta"]);
        exit;
    }

      if ($status != "aberto" && $status != "em andamento" && $status != "concluido") {
        echo json_encode(["Mensagem" => "Status inválido - coloque estritamente status: aberto ou em andamento ou concluido "]);
        exit;
    }


    $sql = "INSERT INTO chamados (equipamento,setor,descricao,prioridade,status) VALUES (?,?,?,?,?)";
    

    $comando = $pdo ->prepare($sql);

    $comando -> execute([
        $dados["equipamento"],
        $dados["setor"],
        $dados["descricao"],
        $prioridade,
        $status
    ]);

    echo json_encode(["Mensagem" => "Chamado cadastrado com sucesso!"]);
};

if ($metodo == "GET") {
    $sql = "SELECT * FROM chamados ORDER BY id";

    $comando = $pdo -> prepare($sql);

    $chamado = $comando -> fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($chamado);
};

if ($metodo == "PUT") {
    $json = file_get_contents("php://input");

    $dados = json_decode($json, true);

    $prioridade = $dados["prioridade"];
    $status = $dados["status"];

    if ($prioridade != "baixa" && $prioridade != "media" && $prioridade != "alta") {
        echo json_encode(["Mensagem" => "prioridade inválida"]);
        exit;
    }

      if ($status != "aberto" && $status != "em andamento" && $status != "concluido") {
        echo json_encode(["Mensagem" => "Status inválido"]);
        exit;
    }

    $sql = "UPDATE chamados SET equipamento=?,setor=?,descricao=?,prioridade=?,status=? WHERE id=?";

    $comando = $pdo -> prepare($sql);

    $comando -> execute([
        $dados["equipamento"],
        $dados["setor"],
        $dados["descricao"],
        $prioridade,
        $status,
        $dados["id"]
    ]);

    echo json_encode(["Mensagem"=> "Chamado atualizado com sucesso!!"]);
};

if ($metodo == "DELETE") {
    $json = file_get_contents("php://input");

    $dados = json_decode($json, true);

    $sql = "DELETE FROM chamados WHERE id=?";

    $comando = $pdo -> prepare($sql);

    $comando -> execute([
        $dados["id"],
    ]);

    echo json_encode(["Mensagem"=> "Chamado deletado com sucesso"]);
}
