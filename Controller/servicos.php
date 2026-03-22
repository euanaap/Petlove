<?php 
    include dirname(__DIR__) . '/config/config.php';
    
    // Buscar serviços do banco de dados
    $stmt = $pdo->query("SELECT * FROM servicos ORDER BY id");
    $servicos = $stmt->fetchAll();
    ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços - Clínica Veterinária PetLove</title>
    <link rel="stylesheet" href="../View/css/style.css">
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">
                <h1>🐾 PetLove</h1>
            </div>
            <ul class="nav-links">
    <li><a href="../index.php">Início</a></li>
    <li><a href="servicos.php">Serviços</a></li>
    <?php if (isLoggedIn()): ?>
        <li><a href="../Model/agendamento.php">Agendar</a></li>
        <li><a href="../Model/meus_agendamentos.php">Meus Agendamentos</a></li>
        <?php if (isVeterinario()): ?>
            <li><a href="../Controller/area_veterinario.php">Área Veterinário</a></li>
        <?php endif; ?>
        <li><a href="logout.php">Sair</a></li>
    <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="../Model/cadastro.php">Cadastro</a></li>
    <?php endif; ?>
</ul>
        </nav>
    </header>

    <section class="page-header">
        <div class="container">
            <h1>Nossos Serviços</h1>
            <p>Cuidado completo para a saúde e bem-estar do seu pet</p>
        </div>
    </section>

    <section class="services-section">
        <div class="container">
            <div class="services-grid detailed">
                <?php foreach ($servicos as $servico): ?>
                <div class="service-card detailed">
                    <div class="service-header">
                        <div class="service-title"><?= htmlspecialchars($servico['nome']) ?></div>
                    </div>
                    
                    <div class="service-description">
                        <?= htmlspecialchars($servico['descricao']) ?>
                    </div>
                    
                    <?php if ($servico['nome'] == 'Consulta Geral'): ?>
                    <ul class="service-features">
                        <li>Exame físico completo</li>
                        <li>Avaliação do histórico médico</li>
                        <li>Orientações sobre cuidados</li>
                        <li>Prescrição de medicamentos</li>
                    </ul>
                    <?php elseif ($servico['nome'] == 'Vacinação'): ?>
                    <ul class="service-features">
                        <li>Vacinas nacionais e importadas</li>
                        <li>Carteirinha de vacinação</li>
                        <li>Calendário personalizado</li>
                        <li>Lembretes por WhatsApp</li>
                    </ul>
                    <?php elseif ($servico['nome'] == 'Exames Laboratoriais'): ?>
                    <ul class="service-features">
                        <li>Hemograma completo</li>
                        <li>Bioquímico sanguíneo</li>
                        <li>Exame de urina</li>
                        <li>Parasitológico de fezes</li>
                    </ul>
                    <?php elseif ($servico['nome'] == 'Castração'): ?>
                    <ul class="service-features">
                        <li>Cirurgia minimamente invasiva</li>
                        <li>Anestesia segura</li>
                        <li>Acompanhamento pós-operatório</li>
                        <li>Kit medicamentos incluído</li>
                    </ul>
                    <?php elseif ($servico['nome'] == 'Emergência'): ?>
                    <ul class="service-features">
                        <li>Atendimento 24 horas</li>
                        <li>Estabilização do paciente</li>
                        <li>UTI veterinária disponível</li>
                        <li>Equipamentos de emergência</li>
                    </ul>
                    <?php endif; ?>
                    
                    <div class="service-price">
                        A partir de R$ <?= number_format($servico['preco'], 2, ',', '.') ?>
                    </div>
                    
                    <div class="service-duration">
                        ⏱️ Duração: <?= $servico['duracao_minutos'] ?> minutos
                    </div>
                    
                    <?php if (isLoggedIn()): ?>
                    <a href="../Model/agendamento.php?servico_id=<?= $servico['id'] ?>" class="btn full-width">Agendar Agora</a>
                    <?php else: ?>
                    <a href="login.php" class="btn full-width">Faça Login para Agendar</a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Banner de Emergência -->
            <div class="emergency-banner">
                <h3>Emergência 24 Horas</h3>
                <p>Seu pet precisa de atendimento urgente?</p>
                <p><strong>Ligue: (11) 99999-9999</strong></p>
                <p>Atendemos 24 horas por dia, 7 dias por semana</p>
            </div>

            <!-- Seção Informativa -->
            <div class="info-section">
                <div class="container">
                    <h2>Por que escolher a PetLove?</h2>
                    <div class="info-grid">
                        <div class="info-card">
                            <h3>Veterinários Experientes</h3>
                            <p>Nossa equipe é formada por profissionais altamente qualificados e especializados no cuidado animal.</p>
                        </div>
                        <div class="info-card">
                            <h3>Equipamentos Modernos</h3>
                            <p>Utilizamos tecnologia de ponta para oferecer diagnósticos precisos e tratamentos eficazes.</p>
                        </div>
                        <div class="info-card">
                            <h3>Cuidado Humanizado</h3>
                            <p>Tratamos cada pet como se fosse nosso, com carinho, paciência e dedicação total.</p>
                        </div>
                        <div class="info-card">
                            <h3>Agendamento Online</h3>
                            <p>Facilidade para agendar consultas e acompanhar o histórico do seu pet através do nosso sistema.</p>
                        </div>
                        <div class="info-card">
                            <h3>Preços Justos</h3>
                            <p>Oferecemos serviços de qualidade com preços acessíveis e diversas opções de pagamento.</p>
                        </div>
                        <div class="info-card">
                            <h3>Horários Flexíveis</h3>
                            <p>Atendemos de segunda a sábado, com horários que se adaptam à sua rotina.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2025 Clínica Veterinária PetLove. Todos os direitos reservados.</p>
            <p>Endereço: Rua dos Animals, 123 - São Paulo/SP | Telefone: (11) 99999-9999</p>
        </div>
    </footer>
</body>
</html>