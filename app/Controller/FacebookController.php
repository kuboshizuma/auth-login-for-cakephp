<?php

class FacebookController extends AppController {
  public $name = 'Facebook';
  public $autoRender = false;
  public $uses = 'User';
  public $components = array('Facebook');


  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow(array('login','fb_callback'));
  }


  //facebookの認証処理部分
  public function login() {
    //メールアドレスの取得の許可をユーザーから得る
    Configure::load("facebookConfig.php");
    define('APP_ID', Configure::read("facebookId"));
    define('APP_SECRET', Configure::read("facebookSecret"));
    define('CALLBACK', Configure::read("callback"));
    $authURL = 'http://www.facebook.com/dialog/oauth?client_id='.APP_ID.'&redirect_uri='.urlencode(CALLBACK).'&scope=email';
    $this->redirect($authURL);
  }


  public function fb_callback(){
    $this->autoLayout = false;
    if($this->Facebook->facebookUserCheck()){
        $myFbData = $this->Session->read('userInfo');
        $facebook_id = $myFbData['id'];
    }else{
        $url = $this->Facebook->getLoginUrl();
        $this->redirect($url);
    }

    $this->User->registerFacebookUser($myFbData);

    $this->request->data['User'] = array(
      'uid' => $facebook_id
    );

    if($this->Auth->login($this->request->data['User'])){
      $this->redirect('/users/success');
    }
  }


}
