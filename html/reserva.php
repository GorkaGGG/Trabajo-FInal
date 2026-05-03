<?php
session_start();
include '../includes/conexion.php';

$error = '';
$showForm = false;
$showConfirm = false;

$cliente = $_SESSION['cliente'] ?? null;
$booking = $_SESSION['booking'] ?? null;

if (!$cliente || !$booking) {
    header('Location: login.php');
    exit;
}

$checkin = $booking['checkin'];
$checkout = $booking['checkout'];
$adults = isset($booking['adults']) ? (int) $booking['adults'] : 0;
$children = isset($booking['children']) ? (int) $booking['children'] : 0;
$room_type = isset($_POST['room_type']) ? trim($_POST['room_type']) : '';
$bed_type = isset($_POST['bed_type']) ? trim($_POST['bed_type']) : '';

$fecha1 = $checkin ? DateTime::createFromFormat('d/m/Y', $checkin) : null;
$fecha2 = $checkout ? DateTime::createFromFormat('d/m/Y', $checkout) : null;
$noches = ($fecha1 && $fecha2) ? $fecha1->diff($fecha2)->days : 0;

$rooms = [
    ['value' => 'Business', 'label' => 'Habitación Business', 'image' => '../assets/img/rooms/AAA_179475_43.avif', 'Precio' => 32 * $noches * $adults + 20 * $noches * $children],
    ['value' => 'Business XL', 'label' => 'Habitación Business XL', 'image' => '../assets/img/rooms/AAA_179489_panopv.avif', 'Precio' => 45 * $noches * $adults + 30 * $noches * $children],
    ['value' => 'Deluxe', 'label' => 'Habitación Deluxe', 'image' => '../assets/img/rooms/AAA_179497_panopv.webp', 'Precio' => 61 * $noches * $adults + 38 * $noches * $children],
    ['value' => 'Suite', 'label' => 'Suite', 'image' => '../assets/img/rooms/AAA_179479_panopv.avif', 'Precio' => 87 * $noches * $adults + 50 * $noches * $children],
];

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($room_type === '' || $bed_type === '') {
        $error = 'Selecciona habitación y tipo de cama para continuar.';
        $showForm = true;
    } else {
        $totalPersonas = $adults + $children;
        $tipoHabitacion = mapRoomTypeToHabitacionTipo($room_type);
        $camaDB = strtoupper($bed_type);
        $fecha_ent = $fecha1->format('Y-m-d');
        $fecha_sal = $fecha2->format('Y-m-d');

        $stmt = $conexion->prepare(
            'SELECT h.NUM_HAB FROM habitacion h
             WHERE UPPER(h.TIPO) = ?
               AND UPPER(h.CAMA) = ?
               AND h.PERSONAS >= ?
               AND NOT EXISTS (
                    SELECT 1 FROM reserva r
                    WHERE r.HABITACION = h.NUM_HAB
                      AND NOT (r.FECHA_SAL <= ? OR r.FECHA_ENT >= ?)
                )
             ORDER BY h.NUM_HAB ASC
             LIMIT 1'
        );
        $stmt->execute([$tipoHabitacion, $camaDB, $totalPersonas, $fecha_ent, $fecha_sal]);
        $habitacion = $stmt->fetchColumn();

        if (!$habitacion) {
            $error = 'No hay habitaciones disponibles para esa selección. Elige otra opción.';
            $showForm = true;
        } else {
            try {
                $stmt = $conexion->prepare('INSERT INTO reserva (CLIENTE, HABITACION, FECHA_ENT, FECHA_SAL) VALUES (?, ?, ?, ?)');
                $stmt->execute([$cliente['DNI'], $habitacion, $fecha_ent, $fecha_sal]);
                unset($_SESSION['booking']);
                $showConfirm = true;
            } catch (PDOException $e) {
                $error = 'Error al guardar la reserva: ' . $e->getMessage();
                $showForm = true;
            }
        }
    }
} else {
    $showForm = true;
}
?>
<!doctype html>
<html class="no-js" lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Reserva - MiHotel</title>
        <meta name="description" content="Reserva de habitación">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">
        <style>
            .room-option {
                transition: all 0.3s ease !important;
            }
            .room-option.selected {
                border-color: #007bff !important;
                border-width: 2px !important;
                background-color: #e7f3ff;
                box-shadow: 0 0 8px rgba(0, 123, 255, 0.4);
            }
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
                        <div class="col-lg-10">
                            <div class="section-tittle text-center mb-40">
                                <h2>Reserva</h2>
                                <p>Cliente: <?php echo htmlspecialchars($cliente['NOMBRE'] . ' ' . $cliente['APELLIDO']); ?> (<?php echo htmlspecialchars($cliente['DNI']); ?>)</p>
                            </div>
                            <?php if ($error !== ''): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>

                            <?php if ($showConfirm): ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Confirmación de Reserva</h4>
                                        <p>Gracias por elegir MiHotel. Tu reserva se ha registrado correctamente.</p>
                                        <ul>
                                            <li><strong>Cliente:</strong> <?php echo htmlspecialchars($cliente['NOMBRE'] . ' ' . $cliente['APELLIDO']); ?></li>
                                            <li><strong>DNI:</strong> <?php echo htmlspecialchars($cliente['DNI']); ?></li>
                                            <li><strong>Check In:</strong> <?php echo htmlspecialchars($checkin); ?></li>
                                            <li><strong>Check Out:</strong> <?php echo htmlspecialchars($checkout); ?></li>
                                            <li><strong>Adultos:</strong> <?php echo htmlspecialchars($adults); ?></li>
                                            <li><strong>Niños:</strong> <?php echo htmlspecialchars($children); ?></li>
                                            <li><strong>Habitación:</strong> <?php echo htmlspecialchars($room_type); ?></li>
                                            <li><strong>Tipo de cama:</strong> <?php echo htmlspecialchars($bed_type); ?></li>
                                        </ul>
                                        <a href="../index.php" class="btn btn-primary">Volver al inicio</a>
                                    </div>
                                </div>
                            <?php elseif ($showForm): ?>
                                <form action="reserva.php" method="post">
                                    <input type="hidden" name="checkin" value="<?php echo htmlspecialchars($checkin); ?>">
                                    <input type="hidden" name="checkout" value="<?php echo htmlspecialchars($checkout); ?>">
                                    <input type="hidden" name="adults" value="<?php echo htmlspecialchars($adults); ?>">
                                    <input type="hidden" name="children" value="<?php echo htmlspecialchars($children); ?>">
                                    <div class="row">
                                        <div class="col-12 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>Habitación:</span>
                                                </div>
                                                <div class="row">
                                                    <?php foreach ($rooms as $room): ?>
                                                        <div class="col-md-6 mb-20">
                                                            <label class="room-option" style="display: block; border: 1px solid #ddd; border-radius: 8px; padding: 12px; cursor: pointer; transition: border-color .2s;">
                                                                <input type="radio" name="room_type" value="<?php echo htmlspecialchars($room['value']); ?>" required style="display: none;" <?php echo $room_type === $room['value'] ? 'checked' : ''; ?> />
                                                                <div style="display: flex; align-items: center; gap: 12px;">
                                                                    <img src="<?php echo htmlspecialchars($room['image']); ?>" alt="<?php echo htmlspecialchars($room['label']); ?>" style="width: 100px; height: 80px; object-fit: cover; border-radius: 6px;">
                                                                    <div>
                                                                        <strong><?php echo htmlspecialchars($room['label']); ?></strong><br>
                                                                        <strong><?php echo htmlspecialchars($room['Precio']); ?>€</strong>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <div class="single-select-box">
                                                <div class="boking-tittle">
                                                    <span>Tipo de cama:</span>
                                                </div>
                                                <div class="select-this">
                                                    <div class="select-itms">
                                                        <select name="bed_type" required>
                                                            <option value="">Selecciona cama</option>
                                                            <option value="Individual" <?php echo $bed_type === 'Individual' ? 'selected' : ''; ?>>Individual</option>
                                                            <option value="Doble" <?php echo $bed_type === 'Doble' ? 'selected' : ''; ?>>Doble</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Continuar</button>
                                        <a href="../index.php" class="btn btn-secondary" style="margin-left: 10px;">Volver al inicio</a>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <script src="../assets/js/vendor/jquery-1.12.4.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('input[name="room_type"]').forEach(function (input) {
                    input.addEventListener('change', function () {
                        document.querySelectorAll('.room-option').forEach(function (label) {
                            label.classList.remove('selected');
                        });
                        input.closest('label.room-option').classList.add('selected');
                    });
                });
                var checked = document.querySelector('input[name="room_type"]:checked');
                if (checked) {
                    checked.closest('label.room-option').classList.add('selected');
                }
            });
        </script>
    </body>
</html>
