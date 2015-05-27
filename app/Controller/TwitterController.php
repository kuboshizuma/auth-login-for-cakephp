<?php

App::import('Vendor', 'twitteroauth/OAuth');
App::import('Vendor', 'twitteroauth/twitteroauth');

class TwitterController extends AppController {
  public $name = 'Twitter';
  public $autoRender = false;
  public $uses = 'User';


  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow(array('login','tw_callback'));
  }


  public function login() {
    CakeSession::start();
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

    $request_token = $connection->getRequestToken(OAUTH_CALLBACK);
    $this->Session->write('oauth_token', $request_token['oauth_token']);
    $this->Session->write('oauth_token_secret', $request_token['oauth_token_secret']);

    //エラー処理
    if ($connection->http_code) {
        $url = $connection->getAuthorizeURL($request_token['oauth_token']);
        $this->redirect($url);
    } else {
        $this->redirect('/');
    }
  }


  // アクセストークンを取得（登録とログインを含む）
  public function tw_callback() {
    CakeSession::start();

    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $this->Session->read('oauth_token'), $this->Session->read('oauth_token_secret'));

    //セッションからリクエストトークンを削除
    $this->Session->delete('oauth_token');
    $this->Session->delete('oauth_token_secret');

    //アクセストークン
    $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

    // ユーザーの名前とアイコンを取得
    $content = $connection->get('account/verify_credentials');
    $content = (array)$content;

    $user_id = $content['id'];

    $this->User->registerTwitterUser($content);

    // ログイン
    $this->request->data['User'] = array(
      'uid' => $user_id
    );

    if ($this->Auth->login($this->request->data['User'])){
      $this->redirect('/users/success');
    }
  }


}

?>
