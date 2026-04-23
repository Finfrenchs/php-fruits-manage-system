<?php
try {
    $p = new PDO('mysql:host=127.0.0.1', 'root', 'Hkayat100897');
    echo "CONNECTION OK\n";
    $p->exec("CREATE DATABASE IF NOT EXISTS fruits_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "DATABASE CREATED\n";
} catch(Exception $e) {
    echo "FAIL: " . $e->getMessage() . "\n";
}
