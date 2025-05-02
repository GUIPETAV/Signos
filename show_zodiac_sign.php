<?php
include('layouts/header.php');

// Receber a data de nascimento
$data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : '';

// Validar o formato da data
if (empty($data_nascimento) || !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $data_nascimento)) {
    echo '<div class="alert alert-danger" role="alert">
            Data de nascimento inválida! Por favor, digite no formato DD/MM/AAAA.
          </div>';
    echo '<div class="text-center"><a href="index.php" class="btn btn-primary">Voltar</a></div>';
    include('layouts/footer.php');
    exit;
}

// Carregar o arquivo XML
$signos = simplexml_load_file("signos.xml");

if (!$signos) {
    echo '<div class="alert alert-danger" role="alert">
            Erro ao carregar informações dos signos. Por favor, tente novamente mais tarde.
          </div>';
    echo '<div class="text-center"><a href="index.php" class="btn btn-primary">Voltar</a></div>';
    include('layouts/footer.php');
    exit;
}

// Extrair dia e mês da data de nascimento
list($dia, $mes, $ano) = explode('/', $data_nascimento);
$dia = (int)$dia;
$mes = (int)$mes;

// Função para comparar datas sem considerar o ano
function compararDatas($data_ref, $data_inicio, $data_fim) {
    // Converter as datas para o formato dia/mês
    list($dia_ref, $mes_ref) = explode('/', $data_ref);
    list($dia_inicio, $mes_inicio) = explode('/', $data_inicio);
    list($dia_fim, $mes_fim) = explode('/', $data_fim);
    
    // Converter para inteiros
    $dia_ref = (int)$dia_ref;
    $mes_ref = (int)$mes_ref;
    $dia_inicio = (int)$dia_inicio;
    $mes_inicio = (int)$mes_inicio;
    $dia_fim = (int)$dia_fim;
    $mes_fim = (int)$mes_fim;
    
    // Caso especial para Capricórnio (entre dezembro e janeiro)
    if ($mes_inicio > $mes_fim) {
        // Se o mês de referência for dezembro
        if ($mes_ref == 12) {
            return ($dia_ref >= $dia_inicio);
        }
        // Se o mês de referência for janeiro
        else if ($mes_ref == 1) {
            return ($dia_ref <= $dia_fim);
        }
        return false;
    }
    
    // Verificar se a data está no intervalo
    if ($mes_ref > $mes_inicio && $mes_ref < $mes_fim) {
        return true;
    } else if ($mes_ref == $mes_inicio && $dia_ref >= $dia_inicio) {
        return true;
    } else if ($mes_ref == $mes_fim && $dia_ref <= $dia_fim) {
        return true;
    }
    
    return false;
}

// Formatação da data para comparação (apenas dia/mês)
$data_ref = sprintf("%02d/%02d", $dia, $mes);

// Variáveis para armazenar o signo encontrado
$signo_nome = '';
$signo_descricao = '';
$data_inicio = '';
$data_fim = '';

// Percorrer todos os signos para encontrar o correspondente à data
foreach ($signos->signo as $signo) {
    $data_inicio = (string)$signo->dataInicio;
    $data_fim = (string)$signo->dataFim;
    
    // Verificar caso especial (Capricórnio)
    if ($data_inicio === '22/12' && $data_fim === '20/01') {
        if (($mes == 12 && $dia >= 22) || ($mes == 1 && $dia <= 20)) {
            $signo_nome = (string)$signo->signoNome;
            $signo_descricao = (string)$signo->descricao;
            break;
        }
    }
    // Para outros signos, usar a função de comparação
    else if (compararDatas($data_ref, $data_inicio, $data_fim)) {
        $signo_nome = (string)$signo->signoNome;
        $signo_descricao = (string)$signo->descricao;
        break;
    }
}

// Exibir o resultado
if (!empty($signo_nome)) {
    echo '<div class="signo-card">
            <div class="signo-icon">✨</div>
            <h2>' . $signo_nome . '</h2>
            <p class="signo-periodo">Período: ' . $data_inicio . ' a ' . $data_fim . '</p>
            <p>' . $signo_descricao . '</p>
          </div>';
    
    echo '<div class="card p-3 mt-4">
            <h4>Sua data de nascimento: ' . $data_nascimento . '</h4>
            <p>De acordo com a astrologia ocidental, pessoas nascidas neste período pertencem ao signo de <strong>' . $signo_nome . '</strong>.</p>
          </div>';
} else {
    echo '<div class="alert alert-warning" role="alert">
            Não foi possível determinar o signo para a data informada.
          </div>';
}

echo '<div class="text-center mt-4">
        <a href="index.php" class="btn btn-primary">Voltar para a consulta</a>
      </div>';

include('layouts/footer.php');
?>