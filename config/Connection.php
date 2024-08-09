<?php
class connection
{
    public static function connect()
    {
        try {
            $dataConnect = new mysqli("localhost", "root", "", "neolabdb");
            return $dataConnect;
        } catch (mysqli_sql_exception $e) {
            echo "Connection error: " . $e->getMessage();
            return null;
        }
    }
}
