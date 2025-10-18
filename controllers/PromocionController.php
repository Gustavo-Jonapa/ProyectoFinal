<?php
require_once 'models/Promocion.php';

class PromocionController {
    public function index() {
        $pageTitle = "Promociones - Las Tres Esencias";
        
        // Datos estáticos para prueba
        $promociones = [
            [
                'id' => 1,
                'titulo' => 'Combo Cumpleaños',
                'descripcion' => 'Mesa decorada + Pastel + Botella de vino',
                'precio' => 1200.00,
                'imagen' => 'https://images.unsplash.com/photo-1558636508-e0db3814bd1d?w=400'
            ],
            [
                'id' => 2,
                'titulo' => 'Aniversario de Boda',
                'descripcion' => 'Cena romántica para 2 + Champagne + Postre especial',
                'precio' => 1800.00,
                'imagen' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=400'
            ],
            [
                'id' => 3,
                'titulo' => 'Especial Navidad',
                'descripcion' => 'Menú navideño completo + Brindis + Música en vivo',
                'precio' => 2500.00,
                'imagen' => 'https://images.unsplash.com/photo-1512389142860-9c449e58a543?w=400'
            ],
            [
                'id' => 4,
                'titulo' => 'Año Nuevo',
                'descripcion' => 'Cena de gala + Barra libre + Show especial',
                'precio' => 3000.00,
                'imagen' => 'https://images.unsplash.com/photo-1467810563316-b5476525c0f9?w=400'
            ]
        ];
        
        require_once "views/layouts/header.php";
        require_once "views/promociones/index.php";
        require_once "views/layouts/footer.php";
    }
}
?>