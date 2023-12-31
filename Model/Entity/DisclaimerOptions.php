<?php

class DisclaimerOptions{
    //création de 3 propriétés privées : identifiant du disclaimer,contenu du message à afficher dans le disclaimer
    //url de redirection en cas de réponse négative par le visiteur.
    private $id_disclaimer;
    private $message_disclaimer;
    private $redirection_ko;

    function __construct($id_disclaimer = "Nc", $message_disclaimer = "Nc", $redirection_ko = "Nc") {
        $this->id_disclaimer = $id_disclaimer;
        $this->message_disclaimer = $message_disclaimer;
        $this->redirection_ko = $redirection_ko;
    }

    //On encapsule les propriétés avec des "« getter »" et "« setter »" (accesseur et mutateur)
    /**
     * Get the value of id_disclaimer
     */ 
    public function getIdDisclaimer()
    {
        return $this->id_disclaimer;
    }

    /**
     * Get the value of message_disclaimer
     */ 
    public function getMessageDisclaimer()
    {
        return $this->message_disclaimer;
    }

    /**
     * Set the value of message_disclaimer
     *
     * @return  self
     */ 
    public function setMessageDisclaimer($message_disclaimer)
    {
        $this->message_disclaimer = $message_disclaimer;

        return $this;
    }

    /**
     * Get the value of redirection_ko
     */ 
    public function getRedirectionko()
    {
        return $this->redirection_ko;
    }

    /**
     * Set the value of redirection_ko
     *
     * @return  self
     */ 
    public function setRedirectionko($redirection_ko)
    {
        $this->redirection_ko = $redirection_ko;

        return $this;
    }
}