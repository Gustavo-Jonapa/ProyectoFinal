<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../assets/Bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="../assets/js/js/bootstrap.min.js"></script>
    <title>Carrusel</title>
</head>
<style>
    .button-menu{
        background-color: #F28322;
        width: 150px;
        height: 50px;
        border-radius: 40px;
        border: 0;
    }
    .button-menu:hover{
        color: #F3F2F1;
        transform: scale(1.1);
    }
    .button-menu a{
        color: #F3F2F1;
        text-decoration: none;
        font-size: large;
        font-weight: bold;
    }
</style>
<body>
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../assets/img/geometrico.jpeg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <button class="button-menu"><a href="../menu/index.php">Ver Menú</a></button>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../assets/img/geometrico.jpeg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <button class="button-menu"><a href="../menu/index.php">Ver Menú</a></button>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../assets/img/geometrico.jpeg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <button class="button-menu"><a href="../menu/index.php">Ver Menú</a></button>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</body>
</html>