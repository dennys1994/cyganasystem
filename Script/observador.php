<?php
require '../vendor/autoload.php';

// Carregar o arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable('..');
$dotenv->load();

// Conectar ao banco de dados MySQL usando PDO
$dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'] . ';port=' . $_ENV['DB_PORT'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

try {
    $db = new PDO($dsn, $username, $password);
    // Configurar o modo de erro
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
    exit;
}

// Obter o token de autorização da tabela dados_milvus
$query = $db->query("SELECT auth_milvus FROM relatorio_users LIMIT 1");
$token = $query->fetch(PDO::FETCH_ASSOC)['auth_milvus'];

// Obter o token da tabela dados_digisac
$query = $db->query("SELECT token FROM dados_digisac LIMIT 1");
$token_digisac = $query->fetch(PDO::FETCH_ASSOC)['token'];

// API Milvus URL
$apiUrl = "https://apiintegracao.milvus.com.br/api/chamado/listagem";

// Função para somar horas
function somarHoras($tickets) {
    $totalHoras = 0;
    foreach ($tickets as $ticket) {
        // Verificar se o ticket está finalizado e se tem o campo 'total_horas'
        if (isset($ticket['status']) && $ticket['status'] == 'Finalizado' && isset($ticket['total_horas']) && $ticket['total_horas']) {
            $hora = explode(":", $ticket['total_horas']);
            $totalHoras += $hora[0] * 60 + $hora[1];
            echo $ticket['codigo'] . '- Somado' . "\n";
        }
        else
            echo $ticket['codigo'] . ' - nao Somado' . $ticket['status'] . "\n";
    }
    // Convertendo minutos para horas
    $horas = floor($totalHoras / 60);
    $minutos = $totalHoras % 60;
    return sprintf("%02d:%02d", $horas, $minutos);
}


// Função para obter os tickets da API
function obterTickets($token, $cliente_id) {
    global $apiUrl;

    // Calcular a data inicial do mês e a data de hoje
    $dataInicial = date("Y-m-01"); // Primeiro dia do mês atual
    $dataFinal = date("Y-m-24"); // Data de hoje

    // Construir o corpo da requisição
    $body = [
        "filtro_body" => [
            "cliente_id" => $cliente_id,
            "data_hora_criacao_inicial" => $dataInicial,
            "data_hora_criacao_final" => $dataFinal
        ]
    ];

    // Converter o corpo para JSON
    $jsonBody = json_encode($body);

    $token = trim($token);
    // Configurar os cabeçalhos
    $headers = [
        "Authorization: $token",
        "Content-Type: application/json"
    ];

    // Iniciar cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1); // Definir como POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody); // Incluir o corpo da requisição

    // Executar cURL e capturar a resposta
    $response = curl_exec($ch);
    curl_close($ch);
    // Retornar a resposta decodificada
    return json_decode($response, true);
}

// Função para enviar a mensagem via API Digisac
function enviarMensagemDigisacTotalhoras($totalHoras, $idDigisac, $token) {
    // Preparar o corpo da requisição
    $body = [
        "text" => "Prezado(a) Cliente,\n Informamos que o consumo de horas de chamados atingiu 50% do limite no seu plano. Estamos à disposição para fornecer detalhes sobre as atividades realizadas até o momento ou esclarecer quaisquer dúvidas.\n Conte conosco para o que precisar! - Pixel Bot",
        "type" => "chat",
        "contactId" => $idDigisac,
        "origin" => "bot"
    ];

    // Inicializar cURL
    $ch = curl_init();

    // Definir a URL da API
    curl_setopt($ch, CURLOPT_URL, "https://lotussquad.digisac.me/api/v1/messages");

    // Definir o método POST
    curl_setopt($ch, CURLOPT_POST, 1);

    // Definir os dados da requisição
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

    // Definir os cabeçalhos da requisição
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ]);

    // Retornar a resposta da API
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Executar a requisição
    $response = curl_exec($ch);

    // Fechar cURL
    curl_close($ch);

    // Verificar se a requisição foi bem-sucedida
    if ($response === false) {
        echo "Erro ao enviar mensagem para Digisac.\n";
    } else {
        echo "Mensagem enviada com sucesso para Digisac.\n";
    }
}


// Função para enviar a mensagem via API Digisac
function enviarMensagemDigisacResp($totalHoras, $idDigisac, $token, $tickets) {
    // Preparar o corpo da requisição
    
   
    $body = [
        "text" => "Prezado(a) Cliente,\n Informamos que o consumo de horas de chamados atingiu o limite de $totalHoras horas no seu plano. A partir deste ponto, todos os novos tickets serão notificados previamente e somente serão executados mediante sua aprovação.
Estamos à disposição para fornecer detalhes sobre as atividades realizadas até o momento ou esclarecer quaisquer dúvidas.\n Conte conosco para o que precisar!. - Pixel Bot\n\nSegue Abaixo lista de tickets que não foram finalizados:\n",
        "type" => "chat",
        "contactId" => $idDigisac,
        "origin" => "bot"
    ];

    // Inicializar cURL
    $ch = curl_init();

    // Definir a URL da API
    curl_setopt($ch, CURLOPT_URL, "https://lotussquad.digisac.me/api/v1/messages");

    // Definir o método POST
    curl_setopt($ch, CURLOPT_POST, 1);

    // Definir os dados da requisição
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

    // Definir os cabeçalhos da requisição
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ]);

    // Retornar a resposta da API
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Executar a requisição
    $response = curl_exec($ch);

    // Fechar cURL
    curl_close($ch);

    // Verificar se a requisição foi bem-sucedida
    if ($response === false) {
        echo "Erro ao enviar mensagem para Digisac.\n";
    } else {
        echo "Mensagem enviada com sucesso para Digisac.\n";
    }
}

// Função para enviar a mensagem via API Digisac
function enviarMensagemDigisacNovoTicket($idDigisac, $token, $UltimoTicket) {
    // Preparar o corpo da requisição
    $body = [
        "text" => "Foi aberto um novo Ticket\n\n Descrição: ".$UltimoTicket["descricao"] ."\nPrecisamos da sua autorização para iniciar o atendimento - Pixel Bot",
        "type" => "chat",
        "contactId" => $idDigisac,
        "origin" => "bot"
    ];

    // Inicializar cURL
    $ch = curl_init();

    // Definir a URL da API
    curl_setopt($ch, CURLOPT_URL, "https://lotussquad.digisac.me/api/v1/messages");

    // Definir o método POST
    curl_setopt($ch, CURLOPT_POST, 1);

    // Definir os dados da requisição
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

    // Definir os cabeçalhos da requisição
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ]);

    // Retornar a resposta da API
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Executar a requisição
    $response = curl_exec($ch);

    // Fechar cURL
    curl_close($ch);

    // Verificar se a requisição foi bem-sucedida
    if ($response === false) {
        echo "Erro ao enviar mensagem para Digisac.\n";
    } else {
        echo "Mensagem enviada com sucesso para Digisac.\n";
    }
}

function enviarMensagemDigisacTicketsAbertos($idDigisac, $token, $Ticket) {
    // Preparar o corpo da requisição
    $body = [
        "text" => "Ticket Aberto " . $Ticket["codigo"] . "\n Descrição: ". $Ticket["descricao"] ."\n\n - Pixel Bot",
        "type" => "chat",
        "contactId" => $idDigisac,
        "origin" => "bot"
    ];

    // Inicializar cURL
    $ch = curl_init();

    // Definir a URL da API
    curl_setopt($ch, CURLOPT_URL, "https://lotussquad.digisac.me/api/v1/messages");

    // Definir o método POST
    curl_setopt($ch, CURLOPT_POST, 1);

    // Definir os dados da requisição
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

    // Definir os cabeçalhos da requisição
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ]);

    // Retornar a resposta da API
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Executar a requisição
    $response = curl_exec($ch);

    // Fechar cURL
    curl_close($ch);

    // Verificar se a requisição foi bem-sucedida
    if ($response === false) {
        echo "Erro ao enviar mensagem para Digisac.\n";
    } else {
        echo "Mensagem enviada com sucesso para Digisac.\n";
    }
}



function converterParaMinutos($horas) {
    list($h, $m) = explode(':', $horas);
    return ($h * 60) + $m;
}

// Iterar sobre as empresas
$query = "SELECT id, id_milvus, num_max_horas, id_digisac, cod_aviso, id_responsavel_digisac FROM empresa";
$empresas = $db->query($query);

while ($empresa = $empresas->fetch(PDO::FETCH_ASSOC)) {
    echo "Empresa: " . $empresa['id'] . "\n";
    echo "id milvus: ". $empresa['id_milvus'] . "\n";

    // Verificar se o campo id_milvus existe
    if (isset($empresa['id_milvus'])) {
        // Obter tickets
        $tickets = obterTickets($token, $empresa['id_milvus']);        
        // Somar horas dos tickets finalizados
        $totalHoras = somarHoras($tickets['lista']);
        
        echo "Total de Horas: " . $totalHoras . "\n";
        echo "num_max_horas: " . $empresa['num_max_horas']  . "\n";
        echo "Cod aviso: " . $empresa['cod_aviso']  . "\n";

        // Converter totalHoras para minutos
        $totalMinutos = converterParaMinutos($totalHoras);
                
        // Converter num_max_horas para minutos
        $numMaxHorasMinutos = $empresa['num_max_horas'] * 60;

        usort($tickets['lista'], function ($a, $b) {
            return (int) $b['codigo'] - (int) $a['codigo'];
        });
        
        $ultimoTicket = null;
        
        foreach ($tickets['lista'] as $ticket) {       
                $ultimoTicket = $ticket;
                break; // Após ordenar, o primeiro ticket será o com maior código            
        }

        $ultimoTicketCodigo = $ultimoTicket['codigo'];
        echo "Ultimo ticket Cod: " . $ultimoTicketCodigo . "\n";

        // Verificar a condição para enviar mensagem
        if ($totalMinutos >= ($numMaxHorasMinutos / 2) && ($empresa['cod_aviso'] == 0 || $empresa['cod_aviso'] == null)) {
            // Chamar a função para enviar a mensagem
            enviarMensagemDigisacTotalhoras($totalHoras, $empresa['id_digisac'], $token_digisac);   

            // Atualizar o valor de cod_aviso para 1 no banco de dados
            $updateQuery = "UPDATE empresa SET cod_aviso = 1 WHERE id = :id";
            $stmt = $db->prepare($updateQuery);
            $stmt->bindValue(':id', $empresa['id'], PDO::PARAM_INT);
            $stmt->execute();     
        }
        else if ($totalMinutos >= $numMaxHorasMinutos/2 && ($empresa['cod_aviso'] == 1)) {
            // Chamar a função para enviar a mensagem
            enviarMensagemDigisacTotalhoras($totalHoras, $empresa['id_digisac'], $token_digisac);  
            enviarMensagemDigisacResp($totalHoras, $empresa['id_responsavel_digisac'], $token_digisac, $tickets['lista'] );   

            foreach ($tickets['lista'] as $ticket) {
                if (!($ticket['status'] === 'Finalizado')) {
                    enviarMensagemDigisacTicketsAbertos($empresa['id_responsavel_digisac'], $token_digisac, $ticket);
                }         
            }

            foreach ($tickets['lista'] as $ticket) {            
                $ultimoTicket = $ticket;   
                break;                       
            }
        
            // Se encontrado um ticket finalizado, atualiza o cod_aviso
            if ($ultimoTicket) {
                $ultimoTicketCodigo = $ultimoTicket['codigo'];
        
                // Atualizar o valor de cod_aviso para o código do último ticket
                $updateQuery = "UPDATE empresa SET cod_aviso = :cod_aviso WHERE id = :id"; 
                $stmt = $db->prepare($updateQuery);
                $stmt->bindValue(':cod_aviso', $ultimoTicketCodigo, PDO::PARAM_INT);
                $stmt->bindValue(':id', $empresa['id'], PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        else if (($ultimoTicketCodigo != $empresa['cod_aviso']) && $empresa['cod_aviso']!= 0 && $empresa['cod_aviso'] != 1)  {
            // Chamar a função para enviar a mensagem
            foreach ($tickets['lista'] as $ticket) {
                // Como o primeiro ticket na lista é o mais recente
                $ultimoTicket = $ticket;
                break;
            }

            enviarMensagemDigisacNovoTicket($empresa['id_responsavel_digisac'], $token_digisac, $ultimoTicket);
        
            // Se encontrado um ticket finalizado, atualiza o cod_aviso
            if ($ultimoTicket) {
                $ultimoTicketCodigo = $ultimoTicket['codigo'];
        
                // Atualizar o valor de cod_aviso para o código do último ticket
                $updateQuery = "UPDATE empresa SET cod_aviso = :cod_aviso WHERE id = :id"; 
                $stmt = $db->prepare($updateQuery);
                $stmt->bindValue(':cod_aviso', $ultimoTicketCodigo, PDO::PARAM_INT);
                $stmt->bindValue(':id', $empresa['id'], PDO::PARAM_INT);
                $stmt->execute();
            }
        }
    } else {
        echo "id_milvus não encontrado para esta empresa.\n";
    }
}


?>
