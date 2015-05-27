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
    $uid = $this->Auth->user('uid');
    $user_data = $this->User->getUser($uid);
    $this->set('user_data', $user_data);
  }

  public function logout() {
    $this->Auth->logout();
    $this->redirect($this->Auth->logoutRedirect);
  }



}

?>
