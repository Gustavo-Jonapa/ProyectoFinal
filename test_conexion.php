<?php
session_start();
require_once 'config/database.php';

echo "<h2>Test de Conexión SQL Server</h2>";

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    if ($conn) {
        echo "✅ <strong>Conexión exitosa a SQL Server</strong><br>";
        
        // Probar una consulta simple
        $stmt = $conn->query("SELECT @@VERSION as version");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "📌 Versión de SQL Server:<br>";
        echo "<pre>" . $result['version'] . "</pre>";
    } else {
        echo "❌ <strong>Error: No se pudo conectar</strong>";
    }
} catch (Exception $e) {
    echo "❌ <strong>Error:</strong> " . $e->getMessage();
}
?>