<?php 
    include_once 'conexao.php';
    include_once 'funcoes.php';

    
    if (isset($_GET['acao']) && $_GET['acao'] == 'editar') {
        //if ternario 
        $id = $_GET['id'];
        //vamos abrira conexao com o banco de dados 
        $conexaoComBanco = abrirBanco();

        $sql = "select* FROM pessoas where id = ?";
        //preparar o sql para consultar o id no banco de dados 
        $pegarDados = $conexaoComBanco->prepare($sql);
        //substituir ??????
        $pegarDados->bind_param("i", $id);
        // executar o sql que preparamos 
$pegarDados->execute();
$result = $pegarDados->get_result();

if ($result->num_rows == 1 ){


    $registro = $result->fetch_assoc();

}
else {
    echo"nemhum registro encontrado";
    exit;
}

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $nascimento = $_POST['nascimento'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];

    $sql = "UPDATE pessoas set nome =  ?, sobrenome = ?, nascimento = ?, endereco = ?, telefone = ?
        where id = ?";
    $pegarDados = $conexaoComBanco->prepare($sql);
    $pegarDados->bind_param("sssssi", $nome, $sobrenome, $nascimento, $endereco, $telefone, $id);
    $pegarDados->execute();
    $pegarDados->close();

}

}

?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
</head>
<body>
    <header>
        <h1>Agenda de Contatos</h1>
    
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="cadastrar.php">Cadastrar</a></li>
    </nav>
    </header>

    <secton>
        <h2>Cadastrar Contato</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="nome">Nome</label>
            <input type="text" id="Nome" name="nome" required value="<?= $registro['nome']?>">

            <label for="sobrenome">Sobrenome</label>
            <input type="text" id="sobrenome" name="sobrenome" required value="<?= $registro['sobrenome']?>">

            <label for="nome">Nascimento</label>
            <input type="date" id="nascimento" name="nascimento" required value="<?= $registro['nascimento']?>">

            <label for="nome">Endereco</label>
            <input type="text" id="endereco" name="endereco" required value="<?= $registro['endereco']?>">

            <label for="nome">Telefone</label>
            <input type="text" id="telefone" name="telefone" required value="<?= $registro['telefone']?>">

            <button type="submit">Atualizar</button>
        </form>
    </secton>
</body>
</html>