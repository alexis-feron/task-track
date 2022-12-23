<?php

/**
 * Classe qui permet la verification et le nettoyage des données rentrées par l'utilisateur
 */
class Validation {

    /**
     * Fonction qui nettoie une chaine de caractères
     * @param string|null $str
     * @return string|null
     */
    public static function nettoyerString(?string $str) : ?string{
        return filter_var($str, FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE);
    }

    /**
     * Fonction qui valide si un entier est positif
     * @param $int
     * @return mixed
     */
    public static function validerIntPossitif($int)
    {
        return filter_var($int, FILTER_VALIDATE_INT, array("min_range"=>1));
    }

    /**
     * Fonction qui valide si un nom est correct
     * @param $valeur
     * @param $nom
     * @return mixed
     */
    public static function validerNom($valeur, $nom): mixed
    {
        return filter_var($valeur, FILTER_VALIDATE_REGEXP, array("option" => array("regexp" => "$nom-[1-9][0-9]+$")));
    }

}

