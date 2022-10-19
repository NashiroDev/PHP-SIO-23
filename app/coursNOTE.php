<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My PHP app</title>
</head>
<body>
    <h1>My PHP app</h1>
    <?php
    echo 'Bonjour';
    echo '<p>Café</p>';
    echo 'Monde';
    ?><?= 'hellow'; ?>
    <h1>Sep</h1>
    <?php
        $firstName = 'Nathan';
        $lastName = 'PAUCHON';
        $fullName = $firstName." ".$lastName;

        echo "<p>$fullName</p>";

        // comm unique
        /*
        commentaire multi
        */

        //phpinfo(); // affiche info du serveur php

        $result = 10+10;

        echo $result;

        $connected = 'oui';

        if($connected === 'oui') {
            echo 'Vrai';
        } elseif($connected === 'non') {
            echo 'Faux';
        } else {
            echo 'No data';
        }

        //if (!$var) est la négation de $var pour un booléen

        $isAutorized = true;
        $isOwner = true;

        if ($isAutorized && $isOwner) { // && = et || = ou
            echo 'Rights granted';
        } else {
            echo 'Rights refused';
        }
        ?>

        <?php if($isAutorized && $isOwner) : ?>
            <h1>Show if true</h1>
        <?php else : ?>
            <h1>Show if false/h1>
        <?php endif ; ?>

        <h1>Sep</h1>

        <?php
        $note = 13;

        switch ($note){ // uniquement sur les égalitées
            case 0:
                echo 'nul';
                break;
            case 5:
                echo 'nul aussi';
                break;
            case 10:
                echo 'c\'est ok';
                break;
            default:
                echo 'default show';
        }
        ?>
        <h1>Sep</h1>
        <?php

        $userAge = 25;
        $majeur = ($userAge >= 18) ? true : false; //Ternaire, $majeur prend la valeur true si la condition et vrai et false sin inversement, peut être n'importe quel valeure x : y 
        echo $majeur;

        ?>
        <h1>Sep</h1>
        <?php
        // premier user
        $userEmail = 'test@gmail.com';
        $userName = 'Test';
        $UserPassword = 'Test';

        //deuxième user
        $userEmail2 = 'test@gmail.com';
        $userName2 = 'Test';
        $UserPassword2 = 'Test';

        $user1 = ['Test', 'test@gmail.com', 'test1234', 34, true]; // Nom mail mdp age booléen
        $user2 = ['Test2', 'test2@gmail.com', 'test1234', 20, true];
        $user3 = ['Test3', 'test3@gmail.com', 'test1234', 55, true];

        $users = [$user1, $user2, $user3];

        foreach ($users as $user) {
            echo "<p>$user[0]</p>";
        }

        //definir une clef => valeur
        $utilisateur = [
            'prenom' => 'Nathan',
            'nom' => 'Pauchon',
            'age' => 20,
            'email' => 'nathan.pauchon@gmail.com',
        ];

        echo $utilisateur['prenom'];
        
        ?>
        <h1>Sep</h1>
        <?php

        foreach($utilisateur as $key => $value) { // x => y reconnait la clef et valeur dans le tableau
            echo "$key : $value<br/>";
        }


        if (array_key_exists('prenom', $utilisateur)) { // verifie l'existance d'une clef dans un array et renvoi 0 ou 1|| in_array() pour une valeur || array_search() pour une valeur et renvoi la clef ou false si n'existe pas
            echo 'la clef existe';
        } else {
            echo 'la clef n\'existe pas';
        }

        ?>
    
</body>

</html>