<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura dos dados do formulário
    $nome = isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; 
    $idade  = isset($_POST['idade']) ? htmlspecialchars($_POST['idade']) :[];
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $telefone = isset($_POST['telefone']) ? htmlspecialchars($_POST['telefone']) : '';
    $endereco = isset($_POST['endereco']) ? htmlspecialchars($_POST['endereco']) : '';
    $formacao = isset($_POST['formacao']) ? $_POST['formacao'] : [];
    $experiencia = isset($_POST['experiencia']) ? $_POST['experiencia'] : [];
    $sobre = isset($_POST['sobre']) ? htmlspecialchars($_POST['sobre']) : '';

    // Verificação e movimento do arquivo de imagem (se necessário)
    $imagem_destino = '';
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Cria o diretório se não existir
        }
        $imagem_destino = $uploadDir . $_FILES['imagem']['name'];
        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem_destino)) {
            die('Erro ao mover o arquivo para o diretório de uploads.');
        }
    }

    // Gerando o currículo em HTML
    $html = '
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Currículo</title>
            <style>
                body { font-family: Arial, sans-serif; }
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    padding: 20px;
                    border: 1px solid #ccc;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Adicionando sombra */
                }
                img { max-width: 100px; max-height: 100px; }
                h1 { text-align: center; }
                .section { margin-bottom: 20px; }
                .section h2 { border-bottom: 1px solid #ccc; padding-bottom: 5px; }
                .section p { margin: 10px 0; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="section">
                    <p><strong>Nome:</strong> ' . $nome . '</p>
                    <p><strong>Email:</strong> ' . $email . '</p>
                    <p><strong>Telefone:</strong> ' . $telefone . '</p>
                    <p><strong>Endereço:</strong> ' . $endereco . '</p>';
                    
    // Incluir a imagem apenas se ela foi carregada com sucesso
    if (!empty($imagem_destino) && file_exists($imagem_destino)) {
        $html .= '<p><strong>Imagem:</strong> <img src="' . htmlspecialchars($imagem_destino) . '" alt="Foto de Perfil"></p>';
    }

    $html .= '
                </div>
                <div class="section">
                    <h2>Formação</h2>';
    foreach ($formacao as $f) {
        $html .= '<p>' . nl2br(htmlspecialchars($f)) . '</p>';
    }

    $html .= '
                </div>
                <div class="section">
                    <h2>Experiência</h2>';
    foreach ($experiencia as $e) {
        $html .= '<p>' . nl2br(htmlspecialchars($e)) . '</p>';
    }

    $html .= '
                </div>
                <div class="section">
                    <h2>Sobre Mim</h2>
                    <p>' . nl2br($sobre) . '</p>
                </div>
            </div>
            <button type="button" id="printCV" class="btn btn-secondary mt-3">Imprimir Currículo</button>
        </body>
        </html>
    ';

    // Exibindo o currículo gerado
    echo $html;
}
?>
