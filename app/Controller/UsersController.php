<?php

class UsersController extends AppController {
  public $name = 'Users';
  public $uses = 'User';

  public function beforeFilter() {
      parent::beforeFilter();
  }

  public function index() {
  }

  public function success() {
   $oauth_token = $this->Auth->user('oauth_token');
    $user_data = $this->User->getTwitterUser($oauth_token);
    $this->set('user_data', $user_data);
  }
}

?>
