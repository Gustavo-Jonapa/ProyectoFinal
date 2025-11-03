<?php
require_once 'models/Platillo.php';

class MenuController {
    public function index() {
        $pageTitle = "Menú - Tres Esencias";
        
        //pendiente
        $platillos = [
            [
                'id' => 1,
                'nombre' => 'Filete de Res Premium',
                'descripcion' => 'Jugoso filete con guarnición',
                'categoria' => 'Platos Fuertes',
                'precio' => 350.00,
                'imagen' => 'https://images.unsplash.com/photo-1558030006-450675393462?w=400'
            ],
            [
                'id' => 2,
                'nombre' => 'Salmón a la Parrilla',
                'descripcion' => 'Salmón fresco con limón',
                'categoria' => 'Platos Fuertes',
                'precio' => 280.00,
                'imagen' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=400'
            ],
            [
                'id' => 3,
                'nombre' => 'Pasta Alfredo',
                'descripcion' => 'Pasta cremosa con pollo',
                'categoria' => 'Platos Fuertes',
                'precio' => 220.00,
                'imagen' => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=400'
            ],
            [
                'id' => 4,
                'nombre' => 'Tiramisú Casero',
                'descripcion' => 'Postre italiano clásico',
                'categoria' => 'Postres',
                'precio' => 95.00,
                'imagen' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=400'
            ],
            [
                'id' => 5,
                'nombre' => 'Cheesecake de Fresa',
                'descripcion' => 'Suave cheesecake',
                'categoria' => 'Postres',
                'precio' => 85.00,
                'imagen' => 'https://images.unsplash.com/photo-1533134242820-b4f3f7be6486?w=400'
            ],
            [
                'id' => 6,
                'nombre' => 'Margarita Premium',
                'descripcion' => 'Margarita con tequila premium',
                'categoria' => 'Bebidas',
                'precio' => 120.00,
                'imagen' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=400'
            ]
        ];
        
        require_once "views/layouts/header.php";
        require_once "views/menu/index.php";
        require_once "views/layouts/footer.php";
    }
    
    public function categoria() {
        $categoria = $_GET['cat'] ?? 'platos';
        
        $categoriaMap = [
            'platos' => 'Platos Fuertes',
            'postres' => 'Postres',
            'bebidas' => 'Bebidas'
        ];
        
        $categoriaNombre = $categoriaMap[$categoria] ?? 'Platos Fuertes';
        $pageTitle = $categoriaNombre . " - Tres Esencias";
        
        // pendiente conexion con la base de datos
        $todosPlatillos = [
            [
                'id' => 1,
                'nombre' => 'Filete de Res Premium',
                'descripcion' => 'Jugoso filete con guarnición',
                'categoria' => 'Platos Fuertes',
                'precio' => 350.00,
                'imagen' => 'https://images.unsplash.com/photo-1558030006-450675393462?w=400'
            ],
            [
                'id' => 2,
                'nombre' => 'Salmón a la Parrilla',
                'descripcion' => 'Salmón fresco con limón',
                'categoria' => 'Platos Fuertes',
                'precio' => 280.00,
                'imagen' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=400'
            ],
            [
                'id' => 3,
                'nombre' => 'Pasta Alfredo',
                'descripcion' => 'Pasta cremosa con pollo',
                'categoria' => 'Platos Fuertes',
                'precio' => 220.00,
                'imagen' => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=400'
            ],
            [
                'id' => 4,
                'nombre' => 'Tiramisú Casero',
                'descripcion' => 'Postre italiano clásico',
                'categoria' => 'Postres',
                'precio' => 95.00,
                'imagen' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=400'
            ],
            [
                'id' => 5,
                'nombre' => 'Cheesecake de Fresa',
                'descripcion' => 'Suave cheesecake',
                'categoria' => 'Postres',
                'precio' => 85.00,
                'imagen' => 'https://www.splenda.com/wp-content/themes/bistrotheme/assets/recipe-images/strawberry-topped-cheesecake.jpg?w=400'
            ],
            [
                'id' => 6,
                'nombre' => 'Margarita Premium',
                'descripcion' => 'Margarita con tequila premium',
                'categoria' => 'Bebidas',
                'precio' => 120.00,
                'imagen' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=400'
            ]
        ];
        
        $platillos = array_filter($todosPlatillos, function($p) use ($categoriaNombre) {
            return $p['categoria'] === $categoriaNombre;
        });
        
        require_once "views/layouts/header.php";
        require_once "views/menu/categoria.php";
        require_once "views/layouts/footer.php";
    }
}
?>
