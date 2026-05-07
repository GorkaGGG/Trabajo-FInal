<?php
session_start();
include '../includes/conexion.php';

$error = '';
$success = false;
$cliente = $_SESSION['cliente'] ?? null;
$booking = $_SESSION['booking'] ?? [];

// Build booking data from POST or session fallback.
function mapRoomTypeToHabitacionTipo(string $roomType): string
{
    $map = [
        'BUSINESS' => 'BUSINESS',
        'BUSINESSXL' => 'XL',
        'DELUXE' => 'DELUXE',
        'SUITE' => 'SUITE',
    ];

    $key = strtoupper(str_replace(' ', '', $roomType));
    return $map[$key] ?? strtoupper($roomType);
}

$checkin = $_POST['checkin'] ?? $booking['checkin'] ?? '';
$checkout = $_POST['checkout'] ?? $booking['checkout'] ?? '';
$adults = $_POST['adults'] ?? $booking['adults'] ?? '';
$children = $_POST['children'] ?? $booking['children'] ?? '';
$room_type = $_POST['room_type'] ?? '';
$bed_type = $_POST['bed_type'] ?? '';

$totalPersonas = (int) $adults + (int) $children;

$dni = trim($_POST['dni'] ?? $cliente['DNI'] ?? '');
$nombre = trim($_POST['nombre'] ?? $cliente['NOMBRE'] ?? '');
$apellido = trim($_POST['apellido'] ?? $cliente['APELLIDO'] ?? '');
$mail = trim($_POST['mail'] ?? $cliente['MAIL'] ?? '');
$telefono = trim($_POST['telefono'] ?? $cliente['TELEFONO'] ?? '');
$card_number = trim($_POST['card_number'] ?? '');
$card_cvc = trim($_POST['card_cvc'] ?? '');

if ($room_type !== '' && $bed_type !== '') {
    $tipoHabitacion = mapRoomTypeToHabitacionTipo($room_type);
    $camaDB = strtoupper($bed_type);
    $stmt = $conexion->prepare(
        'SELECT COUNT(*) FROM habitacion h
         WHERE UPPER(h.TIPO) = ?
           AND UPPER(h.CAMA) = ?
           AND h.PERSONAS = ?'
    );
    $stmt->execute([$tipoHabitacion, $camaDB, $totalPersonas]);
    $roomMatchCount = (int) $stmt->fetchColumn();

    if ($roomMatchCount === 0) {
        $error = 'No existe ninguna habitación con esa combinación exacta de personas y tipo de cama. Vuelve a elegir otra opción.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($dni) || empty($nombre) || empty($apellido) || empty($mail) || empty($telefono) || empty($card_number) || empty($card_cvc)) {
        $error = 'Todos los campos son obligatorios.';
    } elseif (!preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
        $error = 'DNI inválido.';
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email inválido.';
    } elseif (!preg_match('/^[0-9]{9}$/', $telefono)) {
        $error = 'Teléfono inválido.';
    } elseif (!preg_match('/^[0-9]{16}$/', $card_number)) {
        $error = 'Número de tarjeta inválido. Debe tener 16 dígitos.';
    } elseif (!preg_match('/^[0-9]{3}$/', $card_cvc)) {
        $error = 'CVC inválido. Debe tener 3 dígitos.';
    } else {
        if (!$cliente) {
            try {
                $stmt = $conexion->prepare("INSERT INTO cliente (DNI, NOMBRE, APELLIDO, MAIL, TELEFONO) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$dni, $nombre, $apellido, $mail, $telefono]);
                $_SESSION['cliente'] = [
                    'DNI' => $dni,
                    'NOMBRE' => $nombre,
                    'APELLIDO' => $apellido,
                    'MAIL' => $mail,
                    'TELEFONO' => $telefono,
                ];
                $cliente = $_SESSION['cliente'];
            } catch (PDOException $e) {
                $error = 'Error al guardar los datos: ' . $e->getMessage();
            }
        }

        if ($error === '') {
            $fecha1 = $checkin ? DateTime::createFromFormat('d/m/Y', $checkin) : null;
            $fecha2 = $checkout ? DateTime::createFromFormat('d/m/Y', $checkout) : null;
            $fecha_ent = $fecha1 ? $fecha1->format('Y-m-d') : null;
            $fecha_sal = $fecha2 ? $fecha2->format('Y-m-d') : null;

            if (!$fecha_ent || !$fecha_sal) {
                $error = 'Fechas de reserva inválidas.';
            } else {
                try {
                    $stmt = $conexion->prepare(
                        'SELECT h.NUM_HAB FROM habitacion h
                         WHERE UPPER(h.TIPO) = ?
                           AND UPPER(h.CAMA) = ?
                           AND h.PERSONAS = ?
                           AND NOT EXISTS (
                                SELECT 1 FROM reserva r
                                WHERE r.HABITACION = h.NUM_HAB
                                  AND NOT (r.FECHA_SAL <= ? OR r.FECHA_ENT >= ?)
                            )
                         ORDER BY h.NUM_HAB ASC
                         LIMIT 1'
                    );
                    $stmt->execute([mapRoomTypeToHabitacionTipo($room_type), strtoupper($bed_type), $totalPersonas, $fecha_ent, $fecha_sal]);
                    $habitacion = $stmt->fetchColumn();

                    if (!$habitacion) {
                        $error = 'No hay habitaciones disponibles para esa selección.';
                    } else {
                        $stmt = $conexion->prepare('INSERT INTO reserva (CLIENTE, HABITACION, FECHA_ENT, FECHA_SAL) VALUES (?, ?, ?, ?)');
                        $stmt->execute([$cliente['DNI'], $habitacion, $fecha_ent, $fecha_sal]);
                        unset($_SESSION['booking']);
                    }
                } catch (PDOException $e) {
                    $error = 'Error al guardar la reserva: ' . $e->getMessage();
                }
            }
        }

        if ($error === '') {
            $success = true;
        }
    }
}
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
                                <?php if ($cliente): ?>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h4 class="card-title">Resumen del Cliente</h4>
                                            <p class="mb-3">Datos cargados desde tu cuenta.</p>
                                            <ul>
                                                <li><strong>DNI:</strong> <?php echo htmlspecialchars($cliente['DNI']); ?></li>
                                                <li><strong>Nombre:</strong> <?php echo htmlspecialchars($cliente['NOMBRE']); ?></li>
                                                <li><strong>Apellido:</strong> <?php echo htmlspecialchars($cliente['APELLIDO']); ?></li>
                                                <li><strong>Email:</strong> <?php echo htmlspecialchars($cliente['MAIL']); ?></li>
                                                <li><strong>Teléfono:</strong> <?php echo htmlspecialchars($cliente['TELEFONO']); ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
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
                                                <input type="text" name="dni" class="form-control" required pattern="[0-9]{8}[A-Z]" value="<?php echo htmlspecialchars($dni); ?>" placeholder="12345678A">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>Nombre:</span>
                                                </div>
                                                <input type="text" name="nombre" class="form-control" required value="<?php echo htmlspecialchars($nombre); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>Apellido:</span>
                                                </div>
                                                <input type="text" name="apellido" class="form-control" required value="<?php echo htmlspecialchars($apellido); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>Email:</span>
                                                </div>
                                                <input type="email" name="mail" class="form-control" required value="<?php echo htmlspecialchars($mail); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>Teléfono:</span>
                                                </div>
                                                <input type="text" name="telefono" class="form-control" required pattern="[0-9]{9}" value="<?php echo htmlspecialchars($telefono); ?>" placeholder="600000000">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>Número de tarjeta:</span>
                                                </div>
                                                <input type="text" name="card_number" class="form-control" required pattern="[0-9]{16}" value="<?php echo htmlspecialchars($card_number); ?>" placeholder="1234123412341234">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>CVC:</span>
                                                </div>
                                                <input type="text" name="card_cvc" class="form-control" required pattern="[0-9]{3}" value="<?php echo htmlspecialchars($card_cvc); ?>" placeholder="123">
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