<?php

interface Gateway
{
    public function inserer( $nom, $listeId);
    public function modifier($tacheAModifier);
    public function ssupprimer($id);
}