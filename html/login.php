<?php
session_start();
include '../includes/conexion.php';

$error = '';
$showRegister = false;
$booking = [
    'checkin' => trim($_POST['checkin'] ?? ''),
    'checkout' => trim($_POST['checkout'] ?? ''),
    'adults' => trim($_POST['adults'] ?? ''),
    'children' => trim($_POST['children'] ?? ''),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($booking['checkin'] === '' || $booking['checkout'] === '' || $booking['adults'] === '' || $booking['children'] === '') {
        $error = 'Faltan datos de reserva. Vuelve al formulario principal y completa todas las fechas y personas.';
    } else {
        $checkinDate = DateTime::createFromFormat('d/m/Y', $booking['checkin']);
        $checkoutDate = DateTime::createFromFormat('d/m/Y', $booking['checkout']);
        if (!$checkinDate || !$checkoutDate) {
            $error = 'Las fechas deben tener formato dd/mm/aaaa.';
        } elseif ($checkoutDate <= $checkinDate) {
            $error = 'La fecha de salida debe ser posterior a la fecha de entrada.';
        } else {
            $_SESSION['booking'] = $booking;
            if (isset($_POST['login_submit'])) {
                $dni = strtoupper(trim($_POST['dni'] ?? ''));
                $password = trim($_POST['password'] ?? '');

                if ($dni === '' || $password === '') {
                    $error = 'DNI y contraseña son obligatorios.';
                } elseif (!preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
                    $error = 'DNI inválido. Usa el formato 12345678A.';
                } else {
                    $stmt = $conexion->prepare('SELECT * FROM cliente WHERE DNI = ?');
                    $stmt->execute([$dni]);
                    $cliente = $stmt->fetch();
                    if (!$cliente) {
                        $error = 'Cliente no encontrado. Puedes registrarte si aún no tienes cuenta.';
                        $showRegister = true;
                    } else {
                        $dbPassword = $cliente['CONTRASEÑA'];
                        $isValid = false;
                        if ($dbPassword !== '') {
                            if (password_verify($password, $dbPassword)) {
                                $isValid = true;
                            }
                        }
                        if (!$isValid && $password === $dbPassword) {
                            $isValid = true;
                        }

                        if (!$isValid) {
                            $error = 'Contraseña incorrecta.';
                            $showRegister = false;
                        } else {
                            $_SESSION['cliente'] = [
                                'DNI' => $cliente['DNI'],
                                'NOMBRE' => $cliente['NOMBRE'],
                                'APELLIDO' => $cliente['APELLIDO'],
                                'MAIL' => $cliente['MAIL'],
                                'TELEFONO' => $cliente['TELEFONO'],
                            ];
                            header('Location: reserva.php');
                            exit;
                        }
                    }
                }
            } elseif (isset($_POST['register_submit'])) {
                $dni = strtoupper(trim($_POST['dni'] ?? ''));
                $nombre = trim($_POST['nombre'] ?? '');
                $apellido = trim($_POST['apellido'] ?? '');
                $mail = trim($_POST['mail'] ?? '');
                $telefono = trim($_POST['telefono'] ?? '');
                $password = trim($_POST['password'] ?? '');
                $passwordConfirm = trim($_POST['password_confirm'] ?? '');

                if ($dni === '' || $nombre === '' || $apellido === '' || $mail === '' || $telefono === '' || $password === '' || $passwordConfirm === '') {
                    $error = 'Todos los datos son obligatorios para crear la cuenta.';
                    $showRegister = true;
                } elseif (!preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
                    $error = 'DNI inválido. Usa el formato 12345678A.';
                    $showRegister = true;
                } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    $error = 'Email inválido.';
                    $showRegister = true;
                } elseif (!preg_match('/^[0-9]{9}$/', $telefono)) {
                    $error = 'Teléfono inválido. Debe tener 9 dígitos.';
                    $showRegister = true;
                } elseif ($password !== $passwordConfirm) {
                    $error = 'Las contraseñas no coinciden.';
                    $showRegister = true;
                } elseif (strlen($password) < 6) {
                    $error = 'La contraseña debe tener al menos 6 caracteres.';
                    $showRegister = true;
                } else {
                    $stmt = $conexion->prepare('SELECT DNI FROM cliente WHERE DNI = ?');
                    $stmt->execute([$dni]);
                    if ($stmt->fetch()) {
                        $error = 'Ya existe un cliente con ese DNI. Inicia sesión en su lugar.';
                        $showRegister = false;
                    } else {
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $conexion->prepare('INSERT INTO cliente (DNI, NOMBRE, APELLIDO, MAIL, TELEFONO, CONTRASEÑA) VALUES (?, ?, ?, ?, ?, ?)');
                        $stmt->execute([$dni, $nombre, $apellido, $mail, $telefono, $passwordHash]);
                        $_SESSION['cliente'] = [
                            'DNI' => $dni,
                            'NOMBRE' => $nombre,
                            'APELLIDO' => $apellido,
                            'MAIL' => $mail,
                            'TELEFONO' => $telefono,
                        ];
                        header('Location: reserva.php');
                        exit;
                    }
                }
            }
        }
    }
}
?>
<!doctype html>
<html class="no-js" lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Acceso / Registro - MiHotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <style>
        .toggle-link { cursor: pointer; color: #007bff; }
        .toggle-link:hover { text-decoration: underline; }
        .form-section { display: none; }
        .form-section.active { display: block; }
    </style>
</head>
<body>
    <header>
        <div class="header-area header-sticky">
            <div class="main-header">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-2 col-lg-2">
                            <div class="logo">
                                <a href="../index.php"><img src="../assets/img/logo/logo.png" alt="MiHotel" style="max-width: 100px;"></a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10">
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="../index.php">Home</a></li>
                                        <li><a href="about.php">About</a></li>
                                        <li><a href="rooms.php">Habitaciones</a></li>
                                        <li><a href="contact.php">Contacto</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <section class="booking-area" style="padding: 60px 0;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-tittle text-center mb-40">
                            <h2>Iniciar sesión o registrarse</h2>
                            <p>Para continuar con tu reserva, primero ingresa con tu DNI y contraseña.</p>
                        </div>
                        <?php if ($error !== ''): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <div class="text-center mb-4">
                            <span class="toggle-link" id="show-login">Ya tengo cuenta</span> | 
                            <span class="toggle-link" id="show-register">Necesito registrarme</span>
                        </div>
                        <div class="card mb-4 form-section <?php echo !$showRegister ? 'active' : ''; ?>" id="login-section">
                            <div class="card-body">
                                <h4 class="card-title">Iniciar sesión</h4>
                                <form action="login.php" method="post">
                                    <input type="hidden" name="checkin" value="<?php echo htmlspecialchars($booking['checkin']); ?>">
                                    <input type="hidden" name="checkout" value="<?php echo htmlspecialchars($booking['checkout']); ?>">
                                    <input type="hidden" name="adults" value="<?php echo htmlspecialchars($booking['adults']); ?>">
                                    <input type="hidden" name="children" value="<?php echo htmlspecialchars($booking['children']); ?>">
                                    <div class="row">
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle"><span>DNI:</span></div>
                                                <input type="text" name="dni" class="form-control" required pattern="[0-9]{8}[A-Z]" placeholder="12345678A">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle"><span>Contraseña:</span></div>
                                                <input type="password" name="password" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="login_submit" class="btn btn-primary">Entrar</button>
                                        <a href="../index.php" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-4 form-section <?php echo $showRegister ? 'active' : ''; ?>" id="register-section">
                            <div class="card-body">
                                <h4 class="card-title">Registrarse</h4>
                                <form action="login.php" method="post">
                                    <input type="hidden" name="checkin" value="<?php echo htmlspecialchars($booking['checkin']); ?>">
                                    <input type="hidden" name="checkout" value="<?php echo htmlspecialchars($booking['checkout']); ?>">
                                    <input type="hidden" name="adults" value="<?php echo htmlspecialchars($booking['adults']); ?>">
                                    <input type="hidden" name="children" value="<?php echo htmlspecialchars($booking['children']); ?>">
                                    <div class="row">
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle"><span>DNI:</span></div>
                                                <input type="text" name="dni" class="form-control" required pattern="[0-9]{8}[A-Z]" placeholder="12345678A">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle"><span>Nombre:</span></div>
                                                <input type="text" name="nombre" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle"><span>Apellido:</span></div>
                                                <input type="text" name="apellido" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle"><span>Email:</span></div>
                                                <input type="email" name="mail" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle"><span>Teléfono:</span></div>
                                                <input type="text" name="telefono" class="form-control" pattern="[0-9]{9}" required placeholder="600000000">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle"><span>Contraseña:</span></div>
                                                <input type="password" name="password" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle"><span>Confirmar contraseña:</span></div>
                                                <input type="password" name="password_confirm" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" name="register_submit" class="btn btn-primary">Crear cuenta y continuar</button>
                                        <a href="../index.php" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="../assets/js/jquery-1.12.4.min.js"></script>
    <script>
        document.getElementById('show-login').addEventListener('click', function() {
            document.getElementById('login-section').classList.add('active');
            document.getElementById('register-section').classList.remove('active');
        });
        document.getElementById('show-register').addEventListener('click', function() {
            document.getElementById('register-section').classList.add('active');
            document.getElementById('login-section').classList.remove('active');
        });
    </script>
</body>
</html>
