document.addEventListener('DOMContentLoaded', function() {
    // Obter o formulário
    const form = document.getElementById('signo-form');
    
    if (form) {
        form.addEventListener('submit', function(event) {
            // Obter o valor do campo data_nascimento
            const dataNascimento = document.getElementById('data_nascimento').value;
            
            // Expressão regular para validar o formato da data (DD/MM/AAAA)
            const regexData = /^\d{2}\/\d{2}\/\d{4}$/;
            
            if (!regexData.test(dataNascimento)) {
                event.preventDefault(); // Impedir o envio do formulário
                alert('Por favor, insira a data no formato DD/MM/AAAA');
                return false;
            }
            
            // Validar se a data é válida
            const partes = dataNascimento.split('/');
            const dia = parseInt(partes[0], 10);
            const mes = parseInt(partes[1], 10);
            const ano = parseInt(partes[2], 10);
            
            // Verificar se o mês está no intervalo válido
            if (mes < 1 || mes > 12) {
                event.preventDefault();
                alert('Mês inválido. Por favor, insira um mês entre 01 e 12.');
                return false;
            }
            
            // Verificar se o dia está no intervalo válido para o mês
            const diasPorMes = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            
            // Verificar se é ano bissexto
            if (ano % 400 === 0 || (ano % 100 !== 0 && ano % 4 === 0)) {
                diasPorMes[1] = 29; // Fevereiro tem 29 dias em anos bissextos
            }
            
            if (dia < 1 || dia > diasPorMes[mes - 1]) {
                event.preventDefault();
                alert('Dia inválido para o mês selecionado.');
                return false;
            }
            
            return true;
        });
    }
});