<?php

require("conexao.php");

$NomeUsuario = $_POST['NomeUsuario'];
$LocalAlagamento = $_POST['LocalAlagamento'];
$IntensiadeAlagamento = $_POST['Intensidade'];
$ClassificacaoAlagamento = $_POST['Classificacao'];

// este Id será usado com um tipo de chave Unique nas tabelas do BD, para quando houver consulta em ambas
// as tabelas, os valores sejam rertornados sem erro.
$IdConsulta = rand(5, 10000);;


$sql = "INSERT INTO ocorrencia (NomeUsuario, LocalAlagamento, IntensidadeAlagamento, classificacaoAlagamento, IdConsulta) 
VALUES ( '$NomeUsuario', '$LocalAlagamento', '$IntensiadeAlagamento', '$ClassificacaoAlagamento', '$IdConsulta')";
mysqli_query($mysqli, $sql) or die("Não foi possivel inserir os dados");


if(isset($_FILES['imagem'])){
  $imagem = $_FILES['imagem'];

  $pasta = "arquivos/";
  
  // redefinição do nome da imagem para não haver conflitos
  $NomeDaImagem = $imagem['name'];
  // adicionando um numero único ao arquivo
  $NovoNomeImagem = uniqid();
  // removendo a extensão do arquivo
  // strtolower - põe todas a letras em minusculo
  $extensao = strtolower(pathinfo($NomeDaImagem, PATHINFO_EXTENSION));

  $path = $pasta . $NovoNomeImagem . "." . $extensao;

  // move_upload_file irá mover o arquivo selecionado para upload para outro local
  $SucessoUpload = move_uploaded_file($imagem["tmp_name"], $path);

  if($SucessoUpload){
  $sql = "insert into imagemOcorrencia (Nome, Path, IdConsulta) values ('$NomeDaImagem','$path', '$IdConsulta')";
    mysqli_query($mysqli, $sql)or die($mysqli->error);

  }
  else{
    echo "falha ao enviar arquivo";
  }
}

// comando para consultar os arquivos do Banco de dados
$SqlConsulta = "select OC.NomeUsuario, OC.LocalAlagamento, OC.IntensidadeAlagamento,
OC.ClassificacaoAlagamento, OC.Data_Ocorrencia, Img.Path
from ocorrencia OC inner Join imagemOcorrencia Img
on OC.IdConsulta = Img.IdConsulta";
mysqli_query($mysqli, $SqlConsulta)or die($mysqli->error);

$hoje = date('d/m/Y');



?>



<!DOCTYPE html>
<html lang="pt-br">

  <head>
      <title>Entre em Contato</title>
      <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../thm/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../thm/css/estilo.css">
  </head>

  <body class="container p-5">
      <div class="alert alert-secondary" role="alert">
      <h4 class="col-12 p-8 p-md-5  d-flex justify-content-center">Cadastro concluído com sucesso. clique em voltar para retornar ao formulário.
      </h4>

      <a class="btn btn-secondary col-3" href="../thm/index.html" role="button">Voltar</a>
      </div>



      <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Nome Usuario</th>
      <th scope="col">Local</th>
      <th scope="col">Classificaçâo</th>
      <th scope="col">Intensidade</th>
      <th scope="col">Data</th>
      <th scope="col">imagem</th>
    </tr>
  </thead>
  <tbody>


            <tr>
              <td><?php echo $NomeUsuario; ?></td>
              <td><?php echo $LocalAlagamento; ?></td>
              <td><?php echo $ClassificacaoAlagamento; ?></td>
              <td><?php echo $IntensiadeAlagamento; ?></td>
              <td><?php echo $hoje; ?></td>
              <td><a href="<?php echo $path; ?>">Imagem</a></td>


  </tbody>
</table> 
  <body>



</html>



<!-- Não consegui fazer a parte de upload de 2 ou mais imagens e nem a parte
de exibição dos dados já cadastrados por falta de tempo para a execução e para pesquisar sobre. -->


