<?php
session_start(); // On démarre la session AVANT toute chose
require_once("conn.php");
$idCommande=$_GET['idCommande'];
$ps=$pdo->prepare("SELECT * FROM ligne_commande JOIN produit ON ligne_commande.code_prod=produit.code_prod WHERE id_com=?");
$ps->execute(array($idCommande));
$liste=$ps->fetchAll(PDO::FETCH_ASSOC);
/*header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=utf-8");
echo(json_encode($liste)); */

$data=array();
foreach($liste as $i=>$v){
    $fields=array();
    foreach($v as $key=>$value){
        $fields[$key] = utf8_encode($value);
    }
    $data[$i]=$fields;
}
header("Access-Control-Allow-Origin: *");
    header("Content-Type:application/json; charset=utf-8");
    echo(json_encode($data));
   