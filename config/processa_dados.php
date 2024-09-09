<?php

session_start();
// print_r($_SESSION);
if(!isset($_SESSION) OR $_SESSION['logado'] != true){
    header("location: ../config/sair.php");	
    exit();	
}

//incluir conexao
include 'config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

try {

    


    
    if( !empty($_POST['nome']) && 
        !empty($_POST['genero']) && 
        !empty($_POST['telefone']) && 
        !empty($_POST['email']) && 
        !empty($_POST['datadenascimento']) && 
        !empty($_POST['senha']) && 
        // !empty($_POST['cpf']) && 
        !empty($_POST['confirmarsenha']) && 
        $_POST['senha'] === $_POST['confirmarsenha']) {
        
        $nome = htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8');
        $genero = intval($_POST['genero']);
        $telefone = htmlspecialchars($_POST['telefone'], ENT_QUOTES, 'UTF-8');
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $data_nasc = $_POST['datadenascimento'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        //$cpf = htmlspecialchars($_POST['cpf'], ENT_QUOTES, 'UTF-8'); 
        //$rg = htmlspecialchars($_POST['rg'], ENT_QUOTES, 'UTF-8');  
        
        // var_dump($nome, $genero, $telefone, $email, $data_nasc, $senha, $cpf_cnpj);

        $sql_pessoas = "INSERT INTO pessoas(nome_pessoa, fk_id_genero, numero_telefone, endereco_email, data_nasc, senha)
        VALUES (:nome_pessoa, :genero, :telefone, :email, :data_nasc, :senha)";

        //preparar a instruçao SQL
        $stmt = $pdo->prepare($sql_pessoas);

        //associar valores a placeholders
        $stmt->bindParam(':nome_pessoa', $nome);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':data_nasc', $data_nasc);
        $stmt->bindParam(':senha', $senha);
        

        $stmt->execute();
        

        $id_pessoa = $pdo->lastInsertId();


        if (isset($_POST['tipo_pessoa'])) {

        $tipo_pessoa = $_POST['tipo_pessoa'];

            if($tipo_pessoa === 'fisica') {

                echo "tipo pessoa fisica";
                
                // //inserir dados na tabela pessoa fisica
                // $sql = "INSERT INTO pessoas_fisicas (cpf, rg, fk_id_pessoa)
                //         VALUES (:cpf, :rg, :fk_id_pessoa)";
        
                // //prepara o codigo sql
                // $stmt = $pdo->prepare($sql_pessoas);
        
                // //bind dos parametros
                // $stmt->bindParam(':cpf', $cpf);
                // $stmt->bindParam(':rg', $rg);
                // $stmt->bindParam(':fk_id+pessoa', $id_pessoa);
        
                // }
            } elseif ($tipo_pessoa === 'juridica') {
                echo "tipo pessoa juridica";
            }
        }

        //executar consulta
        if ($stmt->execute()) {
            echo "Dados salvos com sucesso.";
        } else { 
            echo "Erro ao salvar os dados.";
        }
    } else {
        echo "Por favor, preencha corretamente todos os dados, e verifique se as senhas coincidem";
    }


}
catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
} else {
    header("Location: ../pages/cadastras-cliente.php");
    exit();
}



?>