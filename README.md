# 初期設定

## databaseの設定
app/Config/database.phpを設定する。
app/Config/database.php.default.phpをコピーして、database.phpを作成する。
その後、自分の環境に合わせて設定する。

## core.phpの設定
app/Config/core.phpを設定する。
app/Config/core.php.defaultをコピーして、core.phpを作成する。

## facebookの設定
app/Config/facebookConfig.phpを作成する。(適宜、値は用意）

```php:facebookConfig.php
<?php
$config['facebookId'] = '9348594754389823423';
$config['facebookSecret'] = 'ewf9v4ijfi943if9ei023ie';
$config['callback'] = 'http://dev.login.com/facebook/fb_callback';
?>
```

## twitterの設定
app/Config/core.phpの最下部に下記を記述。(適宜、値は用意)

```
/*Twitter-login設定*/
define('CONSUMER_KEY', 'fjkejfowjedsajfaskdjf');
define('CONSUMER_SECRET', 'sdfkajsdfviojdifoejwkdsjdk');
define('OAUTH_CALLBACK', 'http://dev.login.com/twitter/tw_callback');
```

## Debug.kitの設定
直下にpluginsを作成して「DebugKit」フォルダを作成する。

下記URLからDebugKitをダウンロード
https://github.com/cakephp/debug_kit/tree/2.2

## Virtual Hostの設定
### 1. httpd.confの編集
Virtual Hostの設定を可能にするため以下のコメントアウトをはずす。
/Applications/MAMP/conf/apache/httpd.conf

(変更前)

```
# Virtual hosts
# Include /Applications/MAMP/conf/apache/extra/httpd-vhosts.conf
```

(変更後)

```
# Virtual hosts
Include /Applications/MAMP/conf/apache/extra/httpd-vhosts.conf
```

### 2. httpd-vhosts.confの編集
バーチャルホストのドメインやポートを指定するために、/Applications/MAMP/conf/apache/extra/httpd-vhosts.confに追記。

```
<VirtualHost *:80>
    DocumentRoot "/Applications/MAMP/htdocs/login"
    ServerName dev.idearoom.com
    ErrorLog "logs/dev.login.com-error_log"
    CustomLog "logs/dev.login.com-access_log" common
</VirtualHost>
```

### 3. hotsの編集
バーチャルホストを有効にするために、/etc/hostsに以下を記述。

```
127.0.0.1 dev.login.com
```

### 4. MAMPでサーバーを再起動
再起動後、
http://dev.login.com
にアクセス可能になる。
