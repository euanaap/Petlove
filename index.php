<?php include 'config/config.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Veterinária PetLove</title>
    <link rel="stylesheet" href="View/css/style.css">
</head>
<body> 
    <header>
        <nav class="container">
            <div class="logo">
                <h1>🐾 PetLove</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Início</a></li>
                <li><a href="Controller/servicos.php">Serviços</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="Model/agendamento.php">Agendar</a></li>
                    <li><a href="Model/meus_agendamentos.php">Meus Agendamentos</a></li>
                    <?php if (isVeterinario()): ?>
                        <li><a href="Controller/area_veterinario.php">Área Veterinário</a></li>
                    <?php endif; ?>
                    <li><a href="Controller/logout.php">Sair</a></li>
                <?php else: ?>
                    <li><a href="Controller/login.php">Login</a></li>
                    <li><a href="Model/cadastro.php">Cadastro</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="container">
            <h2>Cuidando do seu pet com amor e dedicação</h2>
            <p>A melhor clínica veterinária da região, com profissionais qualificados e equipamentos modernos</p>
            <?php if (!isLoggedIn()): ?>
                <a href="Model/cadastro.php" class="btn">Cadastre-se Agora</a>
            <?php else: ?>
                <a href="Model/agendamento.php" class="btn">Agendar Consulta</a>
            <?php endif; ?>
        </div>
    </section>

    <section class="services-preview">
        <div class="container">
            <h2 class="section-title">Nossos Serviços</h2>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon"></div>
                    <h3>Consultas</h3>
                    <p>Consultas veterinárias completas para manter a saúde do seu pet em dia</p>
                </div>
                <div class="service-card">
                    <div class="service-icon"></div>
                    <h3>Vacinação</h3>
                    <p>Vacinação completa seguindo o calendário vacinal recomendado</p>
                </div>
                <div class="service-card">
                    <div class="service-icon"></div>
                    <h3>Exames</h3>
                    <p>Exames laboratoriais e diagnósticos com equipamentos modernos</p>
                </div>
                <div class="service-card">
                    <div class="service-icon"></div>
                    <h3>Cirurgias</h3>
                    <p>Procedimentos cirúrgicos com toda segurança e cuidado</p>
                </div>
                <div class="service-card">
                    <div class="service-icon"></div>
                    <h3>Emergências</h3>
                    <p>Atendimento de emergência disponível 24 horas</p>
                </div>
            </div>
        </div>
    </section>

    <section class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h3>Sobre a PetLove</h3>
                    <p>Há mais de 10 anos cuidando da saúde e bem-estar dos animais de estimação. Nossa equipe é formada por veterinários experientes e apaixonados pelo que fazem.</p>
                    <p>Oferecemos um atendimento humanizado, equipamentos modernos e um ambiente acolhedor para você e seu pet se sentirem em casa.</p>
                    <a href="Controller/servicos.php" class="btn">Ver Todos os Serviços</a>
                </div>
            
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2025 Clínica Veterinária PetLove Todos os direitos reservados.</p>
            <p>(11) 1234-5678 | contato@petlove.com.br</p>
        </div>
    </footer>
</body>
</html>
