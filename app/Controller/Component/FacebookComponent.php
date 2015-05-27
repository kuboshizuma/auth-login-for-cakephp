<?php
App::uses('Component', 'Controller');
App::import('Vendor', 'facebook/facebook');

class FacebookComponent extends Component {
  public $uses = array('User');
  public $components = array(
    'Session'
  );


  public function facebookUserCheck(){

    //facebookインスタンスの生成
    $facebook = $this->createFacebook();
    //ユーザーの取得
    $user = $facebook->getUser();
    if($user){//認証後
      //ユーザの基本情報を日本語で取得
      $me = $facebook->api('/me', 'GET', array('locale'=>'ja_JP'));
      //ユーザの基本情報をセッションに保存
      $this->Session->write('userInfo',$me);
      //ログイン成功
      //セッションからの呼び出し
      return true;
    }else{//認証前
      return false;
    }
  }

  public function getLoginUrl(){
    //facebookインスタンスの生成
    $facebook = $this->createFacebook();
    $url = $facebook->getLoginUrl(
      array(
        'scope'      => '',
        'canvas'     => 1,
        'fbconnect'  => 0
      )
    );
    return $url;
  }

  //facebookインスタンスの生成
  private function createFacebook() {
    Configure::load("facebookConfig.php");
    return new Facebook(array(
      'appId' => Configure::read("facebookId"),
      'secret' => Configure::read("facebookSecret")
    ));
  }

}

?>
