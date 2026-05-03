<?php
include '../includes/conexion.php';

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = trim($_POST['dni'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $mail = trim($_POST['mail'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $card_last3 = trim($_POST['card_last3'] ?? '');

    // Validate
    if (empty($dni) || empty($nombre) || empty($apellido) || empty($mail) || empty($telefono) || empty($card_last3)) {
        $error = 'Todos los campos son obligatorios.';
    } elseif (!preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
        $error = 'DNI inválido.';
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email inválido.';
    } elseif (!preg_match('/^[0-9]{9}$/', $telefono)) {
        $error = 'Teléfono inválido.';
    } elseif (!preg_match('/^[0-9]{3}$/', $card_last3)) {
        $error = 'Últimos 3 dígitos de la tarjeta deben ser 3 números.';
    } else {
        // Insert into cliente
        try {
            $stmt = $conexion->prepare("INSERT INTO cliente (DNI, NOMBRE, APELLIDO, MAIL, TELEFONO) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$dni, $nombre, $apellido, $mail, $telefono]);
            $success = true;
        } catch (PDOException $e) {
            $error = 'Error al guardar los datos: ' . $e->getMessage();
        }
    }
}

// Get booking data from POST
$checkin = $_POST['checkin'] ?? '';
$checkout = $_POST['checkout'] ?? '';
$adults = $_POST['adults'] ?? '';
$children = $_POST['children'] ?? '';
$room_type = $_POST['room_type'] ?? '';
$bed_type = $_POST['bed_type'] ?? '';
?>
<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Pago - MiHotel</title>
        <meta name="description" content="Pago de reserva">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">
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
                        <div class="col-lg-10">
                            <div class="section-tittle text-center mb-40">
                                <h2>Pago</h2>
                                <p>Completa tus datos para procesar el pago.</p>
                            </div>
                            <?php if ($error !== ''): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>
                            <?php if ($success): ?>
                                <div class="alert alert-success">Pago procesado correctamente. ¡Reserva confirmada!</div>
                                <a href="../index.php" class="btn btn-primary">Volver al inicio</a>
                            <?php else: ?>
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h4 class="card-title">Resumen de Reserva</h4>
                                        <ul>
                                            <li><strong>Check In:</strong> <?php echo htmlspecialchars($checkin); ?></li>
                                            <li><strong>Check Out:</strong> <?php echo htmlspecialchars($checkout); ?></li>
                                            <li><strong>Adultos:</strong> <?php echo htmlspecialchars($adults); ?></li>
                                            <li><strong>Niños:</strong> <?php echo htmlspecialchars($children); ?></li>
                                            <li><strong>Habitación:</strong> <?php echo htmlspecialchars($room_type); ?></li>
                                            <li><strong>Tipo de cama:</strong> <?php echo htmlspecialchars($bed_type); ?></li>
                                        </ul>
                                    </div>
                                </div>
                                <form action="pago.php" method="post">
                                    <input type="hidden" name="checkin" value="<?php echo htmlspecialchars($checkin); ?>">
                                    <input type="hidden" name="checkout" value="<?php echo htmlspecialchars($checkout); ?>">
                                    <input type="hidden" name="adults" value="<?php echo htmlspecialchars($adults); ?>">
                                    <input type="hidden" name="children" value="<?php echo htmlspecialchars($children); ?>">
                                    <input type="hidden" name="room_type" value="<?php echo htmlspecialchars($room_type); ?>">
                                    <input type="hidden" name="bed_type" value="<?php echo htmlspecialchars($bed_type); ?>">
                                    <div class="row">
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>DNI:</span>
                                                </div>
                                                <input type="text" name="dni" class="form-control" required pattern="[0-9]{8}[A-Z]" placeholder="12345678A">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>Nombre:</span>
                                                </div>
                                                <input type="text" name="nombre" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>Apellido:</span>
                                                </div>
                                                <input type="text" name="apellido" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>Email:</span>
                                                </div>
                                                <input type="email" name="mail" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>Teléfono:</span>
                                                </div>
                                                <input type="text" name="telefono" class="form-control" required pattern="[0-9]{9}" placeholder="600000000">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>Tarjeta Visa:</span>
                                                </div>
                                                <input type="text" name="card_last3" class="form-control" required pattern="{[0-9]{4}}4" placeholder="1234 1234 1234 1234">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>CVC:</span>
                                                </div>
                                                <input type="text" name="card_last3" class="form-control" required pattern="[0-9]{3}" placeholder="123">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Pagar</button>
                                        <a href="reserva.php" class="btn btn-secondary" style="margin-left: 10px;">Volver</a>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <script src="../assets/js/jquery-1.12.4.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
    </body>
</html>