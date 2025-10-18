<style>
    /*-------------------- carrusel --------------------*/
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
    /*-------------------- tarjetas --------------------*/
    .card-header img{
        width: 60px;
    }
    .blockquote{
        color: #000;
        font-weight: bold;
        text-align: center;
    }
    .blockquote-footer{
        color: #000;
        text-align: center;
        text-decoration: none;
    }
</style>
    <link rel="stylesheet" href="../assets/css/style.css">
    <article>
        <div id="carrusel">
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
        </div>
        
<!---------------------------------------------------------------------->
        <div id="tarjetas">
            <div class="card">
                <div class="card-header">
                    <img src="../assets/img/icons/conocenos.png" alt="">
                </div>
                <div class="card-body">
                    <figure>
                    <blockquote class="blockquote">
                        <p>Conócenos</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        <p>Texto de ejemplo: Somos un restaurante familiar con más de 20 años de experiencia. Nuestros chefs preparan cada platillo con ingredientes frescos y de la más alta calidad. Nuestra pasión es brindar momentos inolvidables a cada uno de nuestros comensales.</p>
                    </figcaption>
                    </figure>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <img src="../assets/img/icons/telefono.png" alt="">
                </div>
                <div class="card-body">
                    <figure>
                    <blockquote class="blockquote">
                        <p>Contáctanos</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        <p>Texto</p>
                    </figcaption>
                    </figure>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <img src="../assets/img/icons/ubicacion.png" alt="">
                </div>
                <div class="card-body">
                    <figure>
                    <blockquote class="blockquote">
                        <p>Ubícanos</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        <p>Texto</p>
                    </figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </article>