<?php

include_once('/app/config/mysql.php');

/**
 * Find all users in the database
 *
 * @return array
 */
function findAllUsers(): array 
{
    global $db;

    $query = 'SELECT * FROM utilisateurs';
    /** @var PDO $db */
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

/**
 * Find a user using the id
 *
 * @param integer $id of a user
 * @return array|boolean
 */
function findUserById(int $id): array|bool
{
    global $db;

    $query = "SELECT u.id, u.nom, u.prenom, u.email, u.roles FROM utilisateurs u WHERE u.id = :id";
    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute([
        'id'=> $id,
    ]);

    return $sqlStatement->fetch();
}

/**
 * Find a user using an email address
 *
 * @param string $email
 * @return array|boolean
 */
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

/**
 * Add a user in the database
 *
 * @param string $nom 
 * @param string $prenom
 * @param string $email
 * @param string $plainPassword
 * @param array $roles
 * @return boolean
 */
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

/**
 * Update info of a user using his id, password exempted
 *
 * @param integer $id 
 * @param string $nom
 * @param string $prenom
 * @param string $email
 * @param array $roles
 * @return boolean
 */
function updateUser(int $id, string $nom, string $prenom, string $email, array $roles = ['ROLE_USER']): bool
{
    global $db;

    try {
        $query = "UPDATE utilisateurs SET nom = :nom, prenom = :prenom, email = :email, id = :id, roles = :roles WHERE id = :id";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'roles' => json_encode($roles),
        ]);
    } catch(PDOException $e) {
        return false;
    }
    return true;
}




?>