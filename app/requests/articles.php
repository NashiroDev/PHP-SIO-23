<?php

include_once('/app/config/mysql.php');

/**
 * Find all articles
 *
 * @return array of articles
 */
function findAllArticles(): array
{
    global $db;

    $query = 'SELECT * FROM articles';

    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

function findAllArticlesWithUser(): array
{
    global $db;

    $query = 'SELECT a.*, u.nom, u.prenom FROM articles a JOIN utilisateurs u ON a.user_id = u.id';

    $sqlStatement = $db->prepare($query);
    $sqlStatement->execute();

    return $sqlStatement->fetchAll();
}

/**
 * Function tp create a new article
 *
 * @param string $titre
 * @param string $description
 * @param string $date
 * @param integer $user_id which is the user that created the article
 * @return boolean
 */
function createArticle(string $titre, string $description, string $date, int $user_id): bool
{
    global $db;

    try {
        $query = 'INSERT INTO articles (titre, description, date, user_id) VALUES (:titre, :description, :date, :user_id)';
        $sqlStatement = $db->prepare($query);
        $sqlStatement->execute([
            'titre' => $titre,
            'description' => $description,
            'date' => $date,
            'user_id' => $user_id,
        ]);
    } catch (PDOException $e) {

        var_dump($e->getMessage());
        return false;
    }

    return true;
}
