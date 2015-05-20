<?php

class User extends AppModel{
  public $name = 'User';

  function registerUser($access_token, $content){
    $params = array(
      'conditions' => array(
        'User.oauth_token' => $access_token['oauth_token']
      )
    );

    $user_data = $this->find('first', $params);
    // 未登録であれば、登録開始
    if (!$user_data) {
      $data = array(
        'User' =>
          array(
            'twitter_id' => $access_token['user_id'],
            'account' => $access_token['screen_name'],
            'username' => $content['name'],
            'image' => $content['profile_image_url'],
            'oauth_token' => $access_token['oauth_token'],
            'oauth_token_secret' => $access_token['oauth_token_secret']
          )
      );
      $this->save($data);
    }
  }

  public function getTwitterUser($oauth_token){
     $params = array(
      'conditions' => array(
        'User.oauth_token' => $oauth_token
      )
    );
    $user_data = $this->find('first', $params);
    return $user_data;
  }

}
