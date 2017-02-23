<?php

session_start(); // On démarre la session AVANT toute chose
require_once("./conn.php");
$data = array();
if (!isset($_SESSION['id_user'])) {
    $req = "SELECT id_com,date_com,date_livr, enseigne, libelle_statut FROM commande,fournisseur,statut "
            . "where commande.code_fou=fournisseur.code_fou and commande.code_statut=statut.code_statut "
            . "ORDER BY id_com ASC";
    $ps = $pdo->prepare($req);
    $ps->execute();
    $liste = $ps->fetchAll(PDO::FETCH_ASSOC);

    foreach ($liste as $i => $v) {
        $fields = array();
        foreach ($v as $key => $value) {
            $fields[$key] = utf8_encode($value);
        }
        $data[$i] = $fields;
    }
} else {
    $fields = array();
    $value = 'Veuillez vous connecter pour voir les commandes';
    $fields['erreur'] = utf8_encode($value);
    $fields['id_com'] = utf8_encode('0');
    $data[0] = $fields;
}

header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=utf-8");
echo(json_encode($data));
?>