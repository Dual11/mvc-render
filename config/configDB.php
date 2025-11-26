<?php

use  Cgarcher\Fix\Database\PDO;
class configDB {
    private static PDO $instance;
    private static string $host;
    private static string $user;
    private static string $pass;

    public function __construct() {
        if (!isset(self::$instance)) {
            $this->getValues();
            $this->connect();
        }
    }

    private function connect() {
        // Opciones recomendadas para MariaDB/SkySQL
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false, // SkySQL usa Let’s Encrypt
        ];

        self::$instance = new PDO(self::$host, self::$user, self::$pass, $options);
    }

    private function getValues() {
        // SI ESTAMOS EN RENDER → usamos variables de entorno
        if (getenv('DB_HOST')) {
            $host = getenv('DB_HOST');
            $port = getenv('DB_PORT') ?: '3306';
            $name = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');

            // DSN con SSL forzado (obligatorio en SkySQL serverless)
            self::$host = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4;sslmode=require";
            self::$user = $user;
            self::$pass = $pass;

        } else {
            // EN LOCAL → seguimos usando config.ini como siempre
            $conf = parse_ini_file('config.ini');
            self::$host = $conf['host'];
            self::$user = $conf['user'];
            self::$pass = $conf['pass'];
        }
    }

    public function getInstance(): PDO {
        return self::$instance;
    }
}
?>