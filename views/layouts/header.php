<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Las Tres Esencias</title>
</head>
<style>
    *{
    margin: 0;
    padding: 0;
    }
    body{
        width: 100%;
    }
    header{
    background-color: #8C451C;
    height: 60px;
    width: 100%;
    }
    #menu-toggle{
        display: none;
    }
    .menu-icon{
        position: absolute;
        top: 15px;
        left: 15px;
        width: 30px;
        height: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
        z-index: 1002;
    }
    .menu-icon span {
        display: block;
        height: 4px;
        width: 100%;
        background: white;
        border-radius: 2px;
        transition: all 0.3s ease;
        transform-origin: center;
    }
    .sidebar{
        position: fixed;
        top: 0;
        left: -250px;
        width: 250px;
        height: 100%;
        background-color: #8C451C;
        color: white;
        transition: left 0.7s ease;
        padding-top: 60px;
        z-index: 1001;
    }
    .sidebar a{
        display: block;
        padding: 1rem 1.5rem;
        text-decoration: none;
        color: white;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        transition: background 0.2s;
    }
    .sidebar a:hover{
        background-color: #F28322;
        color: white;
    }
    .overlay{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease;
        z-index: 1000;
    }
    #menu-toggle:checked ~ .sidebar{
        left: 0;
    }
    #menu-toggle:checked ~ .overlay{
        opacity: 1;
        visibility: visible;
    }
    #menu-toggle:checked + .menu-icon span:nth-child(1) {
        transform: rotate(45deg) translateY(14px);
    }
    #menu-toggle:checked + .menu-icon span:nth-child(2) {
        opacity: 0;
    }
    #menu-toggle:checked + .menu-icon span:nth-child(3) {
        transform: rotate(-45deg) translateY(-14px);
    }
</style>
<body>
    <header>
        <div>
            <input type="checkbox" id="menu-toggle">
            <label for="menu-toggle" class="menu-icon">
                <span></span>
                <span></span>
                <span></span>
            </label>
        	<div class="sidebar">
            	<a href="../inicio/index.php">Inicio</a>
        		<a href="../menu/index.php">Menú</a>
        		<a href="../promociones/index.php">Promociones</a>
        		<a href="../reservaciones/index.php">Reservaciones</a>
            	<a href="../autentificacion/login.php">Inicio de sesión</a>
        	</div>
            <label for="menu-toggle" class="overlay"></label>
        </div>
    </header>