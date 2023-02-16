<?php

class DbPDO
{
    private static string $server = 'localhost';
    private static string $username = 'root';
    private static string $password = '';
    private static string $database = 'workbrench';
    private static ?PDO $db = null;

    public static function connect(): ?PDO {
        if (self::$db == null){
            try {
                self::$db = new PDO("mysql:host=".self::$server.";dbname=".self::$database, self::$username, self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Vous êtes login";
            }
            catch (PDOException $e) {
                echo "Erreur de la connexion à la dn : " . $e->getMessage();
                die();
            }
        }
        return self::$db;
    }

    public static function showStudent(){
        $request = self::$db->prepare("SELECT el.prenom, el.nom, ei.rue, ei.cp, ei.ville, ei.pays, comp.titre, comp.description 
        FROM eleve as el
        INNER JOIN eleve_information as ei ON el.information_id = ei.id
        INNER JOIN eleve_competence as ec ON ec.eleve_id = el.id
        INNER JOIN competence as comp ON comp.id = ec.competence_id");

        $check = $request->execute();
        if ($check){
            echo "<pre>";
            print_r($request->fetchAll());
            echo "</pre>";
        }
        else{
            echo "Un problème est survenu";
        }
    }
}