<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /*
      Retorna una conexión PDO usando las variables de entorno.
     */
    protected function getConnection(): \PDO
    {
        $dsn      = $_ENV['DATABASE_DSN'] ?? 'mysql:host=127.0.0.1;dbname=crudApp;';
        $user     = $_ENV['DATABASE_USER'] ?? 'root';
        $password = $_ENV['DATABASE_PASSWORD'] ?? '';

        $pdo = new \PDO($dsn, $user, $password, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);

        return $pdo;
    }
}
