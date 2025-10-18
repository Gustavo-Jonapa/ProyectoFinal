<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Las Tres Esencias'; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="views/css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #8C451C 0%, #F28322 100%);">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold fs-4" href="index.php?controller=inicio">
                <i class="bi bi-cup-hot-fill"></i> Las Tres Esencias
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=inicio">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=menu">Menú</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=reservacion">Reservaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=promocion">Promociones</a>
                    </li>
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?php echo $_SESSION['usuario_nombre']; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?controller=auth&action=logout">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-warning text-dark px-3 ms-2" href="index.php?controller=auth&action=login">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mensajes de alerta -->
    <?php if (isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <?php 
        echo $_SESSION['mensaje']; 
        unset($_SESSION['mensaje']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        <?php 
        echo $_SESSION['error']; 
        unset($_SESSION['error']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>