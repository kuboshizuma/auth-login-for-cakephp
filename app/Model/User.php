<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
  public $name = 'User';

  function registerTwitterUser($content) {

    $params = array(
      'conditions' => array(
        'User.uid' => $content['id']
      )
    );

    $user_data = $this->find('first', $params);

    // 未登録であれば、登録開始
    if (!$user_data) {
      $passwordHasher = new SimplePasswordHasher();
      $password = $passwordHasher->hash('twitter');
      $data = array(
        'User' =>
          array(
            'username' => $content['name'],
            'auth_type' => 3,
            'user_image' => $content['profile_image_url'],
            'uid' => $content['id'],
            'password' => $password,
            'is_activate' => 1
          )
      );
      $this->save($data);
    }
  }


  function registerFacebookUser($myFbData) {

    $params = array(
      'conditions' => array(
        'User.uid' => $myFbData['id']
      )
    );

    $user_data = $this->find('first', $params);

    // 未登録であれば、登録開始
    if (!$user_data) {
      $passwordHasher = new SimplePasswordHasher();
      $password = $passwordHasher->hash('facebook');
      $data = array(
        'User' =>
          array(
            'username' => $myFbData['first_name'].' '.$myFbData['last_name'],
            'auth_type' => 2,
            'user_image' => 'https://graph.facebook.com/'.$myFbData['id'].'/picture',
            'uid' => $myFbData['id'],
            'email' => $myFbData['email'],
            'password' => $password,
            'is_activate' => 1
          )
      );
      $this->save($data);
    }
  }


  public function getUser($uid) {
     $params = array(
      'conditions' => array(
        'User.uid' => $uid
      )
    );
    $user_data = $this->find('first', $params);
    return $user_data;
  }


}
