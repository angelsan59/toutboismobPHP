<?php

session_start(); // On démarre la session AVANT toute chose
require_once("conn.php");
$idCommande = $_GET['idCommande'];
//$ps = $pdo->prepare("SELECT * FROM ligne_commande lc JOIN produit ON ligne_commande.code_prod=produit.code_prod WHERE id_com=?");
$ps = $pdo->prepare("SELECT c.date_com , s.libelle_statut,p.designation,p.image,p.pu,lc.qte " .
        "FROM ligne_commande lc,commande c, statut s, produit p  " .
        "where lc.code_prod=p.code_prod and s.code_statut=c.code_statut and c.id_com = lc.id_com " .
        "and  c.id_com=?");
$ps->execute(array($idCommande));
$liste = $ps->fetchAll(PDO::FETCH_ASSOC);
/* header("Access-Control-Allow-Origin: *");
  header("Content-Type:application/json; charset=utf-8");
  echo(json_encode($liste)); */

$data = array();
$montant_ht = 0;
foreach ($liste as $i => $v) {
    $fields = array();
    foreach ($v as $key => $value) {
        $fields[$key] = utf8_encode($value);
    }
    $montant_ht = $montant_ht + $fields['pu'] * $fields['qte'];
    $montant_ttc = $montant_ht * 1.2;
    $montant_tva = $montant_ht * 0.2;

    $fields['montant_ht'] = utf8_encode($montant_ht);
    $fields['montant_ttc'] = utf8_encode($montant_ttc);
    $fields['montant_tva'] = utf8_encode($montant_tva);

    $data[$i] = $fields;
}
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=utf-8");
echo(json_encode($data));
