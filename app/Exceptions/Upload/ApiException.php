<?php
namespace App\Exceptions\Upload;

use Exception;
/**
 * WebAPIとの通信に失敗した場合の例外
 *
 */
class ApiException extends Exception {
	public function __construct($errMsg = null){
		//400番台
		if($errMsg == '400'){
			$errMsg = 'Bad Request：クライアントのリクエストが無効です。';
		}elseif($errMsg == '401'){
			$errMsg = 'Unauthorized：認証が必要です。';
		}elseif($errMsg == '403'){
			$errMsg = 'Forbidden：アクセス権限がありません。';
		}elseif($errMsg == '404'){
			$errMsg = 'Not Found：リソースが見つかりません。';
		}elseif($errMsg == '405'){
			$errMsg = 'Method Not Allowed：メソッドが許可されていません。';
		}elseif($errMsg == '404'){
			$errMsg = 'Not Found：リソースが見つかりません。';
		}elseif($errMsg == '406'){
			$errMsg = 'Not Acceptable：文字コードや言語など、リクエスト先の情報が受理できない内容です。';
		}elseif($errMsg == '407'){
			$errMsg = 'Proxy Authentication Required：プロキシの認証が必要です。';
		}elseif($errMsg == '408'){
			$errMsg = 'Request Timeout：リクエストが時間以内に完了しませんでした。';
		}elseif($errMsg == '409'){
			$errMsg = 'Conflict：現在のリソースとリクエストが矛盾するので完了できません。';
		}elseif($errMsg == '410'){
			$errMsg = 'PGone：リクエストされたコンテンツが消滅しています。';
		}elseif($errMsg == '411'){
			$errMsg = 'Length Required：Content-Lengthヘッダがないためサーバにアクセスを拒否されました。';
		}elseif($errMsg == '412'){
			$errMsg = 'Precondition Failed：前提条件に誤りがあります。';
		}elseif($errMsg == '413'){
			$errMsg = 'Request Entity Too Large：アップロード情報が大きすぎます。リクエストがサーバーの許容量を超えています。';
		}elseif($errMsg == '414'){
			$errMsg = 'Request-URI Too Long：URIが長過ぎるため、サーバーが処理を拒否しました。';
		}elseif($errMsg == '415'){
			$errMsg = 'Unsupported Media Type：サーバで指定されたメディアタイプがサポートされていません。';
		}elseif($errMsg == '416'){
			$errMsg = 'Requested Range Not Satisfiable：要求したデータが、実リソースのサイズを超えています。';
			
		//500番台
		}elseif($errMsg == '502' | $errMsg =='501'){
			$errMsg = 'Internal Server Error：リクエスト先のサーバーで何らかのエラーが発生しました。';
		}elseif($errMsg == '503'){
			$errMsg = 'Service Unavailable：サービスが一時的に使用できません。時間を置いてアクセスしてください。';
		}elseif($errMsg == '504'){
			$errMsg = 'Gateway Timeout：サービスが一時的に使用できません。時間を置いてアクセスしてください。';
		}elseif($errMsg == '505'){
			$errMsg = 'HTTP Version Not Supported：リクエストがサポートされていないHTTPバージョンです。WEBブラウザを最新バージョンにアップデートしてください。';
		}
		parent::__construct($errMsg);
		
// 		$errMsg = 'API' .$errMsg;
		
		//これでもOK
		//$this->code = 800;
		//$this->message = 'WebAPIの接続に失敗しました。';
	}
}