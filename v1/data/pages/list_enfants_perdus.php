<?php

/* On ajoute la finction cors qui permet le cross-origin */
/* pour authoriser l'appel du fichier entre backend et frontend*/
require "../includes/cors.php";
/*on appelle la fonction cors*/
cors();

/* connexion à la db */
require "../includes/connexiondb.php";

/* on a ajouté le type du fichier */
header('Content-Type: application/json');


/*
    on construit un tableau php
    ICI, on doir respecter le format demandé car les frontends  (dans cet exercice)
    s'attendent à recevoir se format
    
    pour une première itération/intéraction avec les frontends

*/
$reponse = [
    "error"         => true, /* indique si il y a une erreur ou non */
    "error_message" => "Uknown error", /* il indique le message d'erreur pour les front */
    "details"          => "" /* il sert à afficher se qu'on envoie aux front - les données de réponses */
];

$sql = "SELECT * FROM childs;";
$stmtnt = $bdd->prepare($sql);
$stmtnt->execute();


// on vérifie si il y a des données de la requête SQL (1 seul résultat) 
if($stmtnt && $stmtnt->rowCount() > 0)
{
    //on récuèpre le résultat et on le met sur la detail
    //on traite l'entrée du résultat de la requête
    $detail = $stmtnt->fetchAll(PDO::FETCH_ASSOC);
    //on met le nom et le prenom dans $reponse["details"]
    $reponse["details"] = $detail;
    //on dit qu'il n'y a pas d'erreur
    $reponse["error"] = false;
    //on dit qu'il n'y a pas d'erreur donc pas de message d'erreur
    $reponse["error_message"] = "";
}
else
{
    //on affiche le message si la condition n'est pas remplie (pas d'entrées dans ce cas)
    $reponse["error_message"] = "Pas de données";
}

/* on convertit en json le tableau $reponse et on l'affiche avec echo*/
echo json_encode($reponse);

/*on termine le script*/
die();