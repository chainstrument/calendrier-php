<?php 

function get_pdo()
{
    return new PDO('mysql:host=localhost;dbname=tutocalendar', 'root', '',
    [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    ]);

}

function h(string $string): string
{
    return htmlentities($string);
}