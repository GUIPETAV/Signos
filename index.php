<?php include('layouts/header.php'); ?>

<div class="card p-4">
    <h2 class="text-center mb-4">Descubra seu signo:</h2>
    
    <form id="signo-form" method="POST" action="show_zodiac_sign.php">
        <div class="mb-3">
            <label for="data_nascimento" class="form-label">Data de nascimento</label>
            <input type="text" class="form-control" id="data_nascimento" name="data_nascimento" 
                   placeholder="Ex.: 21/05/1992" required pattern="\d{2}/\d{2}/\d{4}"
                   title="Digite a data no formato DD/MM/AAAA">
            <div class="form-text">Formato: DD/MM/AAAA</div>
        </div>
        
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Descobrir</button>
        </div>
    </form>
</div>

<div class="card mt-4 p-3">
    <h3>Sobre os Signos Zodiacais</h3>
    <p>Os signos do zodíaco são baseados na posição do Sol em relação às constelações durante o ano, com cada signo correspondendo a um período específico. Descubra qual signo zodiacal você pertence com base na sua data de nascimento.</p>
</div>

<?php include('layouts/footer.php'); ?>
