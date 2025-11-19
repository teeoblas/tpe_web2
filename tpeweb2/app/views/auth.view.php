<?php

class AuthView {

    public function showLogin($error, $user) {
        require_once './templates/form_login.phtml';
    }

   public function showError($error, $user) {
        require_once'./templates/error.phtml';
}

}