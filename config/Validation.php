<?php
class Validation {
    public static function nettoyerString(?string $str) : ?string{
        return filter_var($str, FILTER_SANITIZE_STRING, FILTER_NULL_ON_FAILURE);
    }

    public static function validerTacheEffectuee($faite) : bool{
        return filter_var($faite, FILTER_VALIDATE_BOOL);
    }

    public static function validerIntPossitif($int){
        return filter_var($int, FILTER_VALIDATE_INT, array("min_range"=>1));
    }
/*
    public static function validerNom($valeur, $nom){
        return filter_var($valeur, FILTER_VALIDATE_REGEXP, array("option" => array("regexp" => "$nom-[1-9][0-9]+$")));
    }
*/
    public static function nettoyerEtValiderTache(string $nom, bool $faite){
        $nom = self::nettoyerString($nom);
        $faiteValide = self::validerTacheEffectuee($faite);
        if($nom == null || !$faiteValide){
            throw new UnexpectedValueException("Une des valeurs de $nom n'est pas correcte.");
        }
        return array(
            'nom' => $nom,
            'faite' => $faite
        );
    }
}
?>

