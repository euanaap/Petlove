<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function isVeterinario(): bool {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'veterinario';
}

function createSqliteSchema(PDO $pdo): void {
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        senha TEXT NOT NULL,
        telefone TEXT,
        endereco TEXT,
        tipo TEXT NOT NULL DEFAULT 'cliente',
        created_at TEXT DEFAULT CURRENT_TIMESTAMP
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS veterinarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        usuario_id INTEGER NOT NULL UNIQUE,
        nome TEXT NOT NULL,
        crmv TEXT,
        especialidade TEXT,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS servicos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        descricao TEXT,
        preco REAL NOT NULL,
        duracao_minutos INTEGER NOT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS pets (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        especie TEXT NOT NULL,
        raca TEXT,
        idade INTEGER,
        peso REAL,
        observacoes TEXT,
        cliente_id INTEGER NOT NULL,
        FOREIGN KEY (cliente_id) REFERENCES usuarios(id)
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS agendamentos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        cliente_id INTEGER NOT NULL,
        pet_id INTEGER NOT NULL,
        veterinario_id INTEGER,
        servico_id INTEGER NOT NULL,
        data_agendamento TEXT NOT NULL,
        hora_agendamento TEXT NOT NULL,
        observacoes TEXT,
        status TEXT NOT NULL DEFAULT 'pendente',
        created_at TEXT DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (cliente_id) REFERENCES usuarios(id),
        FOREIGN KEY (pet_id) REFERENCES pets(id),
        FOREIGN KEY (veterinario_id) REFERENCES veterinarios(id),
        FOREIGN KEY (servico_id) REFERENCES servicos(id)
    )");

    $stmt = $pdo->query("SELECT COUNT(*) FROM servicos");
    if ((int) $stmt->fetchColumn() === 0) {
        $insertServico = $pdo->prepare("INSERT INTO servicos (nome, descricao, preco, duracao_minutos) VALUES (?, ?, ?, ?)");
        $insertServico->execute(['Consulta Geral', 'Consulta veterinária completa para avaliação da saúde do pet.', 120.00, 40]);
        $insertServico->execute(['Vacinação', 'Aplicação de vacinas com orientação completa.', 90.00, 20]);
        $insertServico->execute(['Exames Laboratoriais', 'Coleta e análise de exames clínicos.', 180.00, 50]);
        $insertServico->execute(['Castração', 'Procedimento cirúrgico com acompanhamento pós-operatório.', 450.00, 90]);
        $insertServico->execute(['Emergência', 'Atendimento veterinário urgente.', 250.00, 60]);
    }

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute(['veterinario@clinica.com']);
    $veterinarioUserId = $stmt->fetchColumn();

    if (!$veterinarioUserId) {
        $insertUser = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, telefone, endereco, tipo) VALUES (?, ?, ?, ?, ?, 'veterinario')");
        $insertUser->execute([
            'Dra. Ana Martins',
            'veterinario@clinica.com',
            password_hash('123456', PASSWORD_DEFAULT),
            '(11) 99999-9999',
            'Clínica PetLove',
        ]);
        $veterinarioUserId = (int) $pdo->lastInsertId();
    }

    $stmt = $pdo->prepare("SELECT id FROM veterinarios WHERE usuario_id = ?");
    $stmt->execute([$veterinarioUserId]);
    if (!$stmt->fetchColumn()) {
        $insertVet = $pdo->prepare("INSERT INTO veterinarios (usuario_id, nome, crmv, especialidade) VALUES (?, ?, ?, ?)");
        $insertVet->execute([$veterinarioUserId, 'Dra. Ana Martins', 'SP-12345', 'Clínica Geral']);
    }
}

function connectDatabase(): PDO {
    $dsn = getenv('DB_DSN');
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') ?: '';

    if (!$dsn) {
        $dbHost = getenv('DB_HOST');
        $dbName = getenv('DB_NAME');

        if ($dbHost && $dbName) {
            $dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";
        }
    }

    if ($dsn) {
        try {
            return new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            // Fallback automático para SQLite local quando a conexão principal falha.
        }
    }

    $sqlitePath = dirname(__DIR__) . '/database/petlove.sqlite';
    $pdo = new PDO('sqlite:' . $sqlitePath, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    createSqliteSchema($pdo);
    return $pdo;
}

$pdo = connectDatabase();
