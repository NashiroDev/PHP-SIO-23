<?php

include_once('/app/config/mysql.php');

function findAllUsers(): array 
{
    global $db;

    $query = 'SELECT * FROM utilisateurs';
    /** @var PDO $db */
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

function findUserByEmail(string $email): array|bool
{
    global $db;

    $query = "SELECT * FROM utilisateurs WHERE email = :email";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute(
        [
            'email' => $email,
        ]
    );

    return $sqlStatement->fetch();
}

function addUser(string $nom, string $prenom, string $email, string $plainPassword, array $roles = ['ROLE_USER']): bool
{
    global $db;

    try {
        $query = "INSERT INTO utilisateurs(nom, prenom, email, password, roles) VALUE (:nom, :prenom, :email, :password, :roles)";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => password_hash($plainPassword, PASSWORD_DEFAULT),
            'roles' => json_encode($roles), 
        ]);
    } catch(PDOException $e) {

        var_dump($e->getMessage());
        return false;
    }

    return true;
}





?>