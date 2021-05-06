<?php
namespace App\Exceptions;

use Exception;
/**
 * WebAPIとの通信に失敗した場合の例外
 *
 */
class ApiException extends Exception {
	public function __construct($statusCode){
		//400番台
		if($statusCode == 400){
			$msg = 'Bad Request：クライアントのリクエストが無効。';
		}elseif($statusCode == 401){
			$msg = 'Unauthorized：認証が必要です。';
		}elseif($statusCode == 403){
			$msg = 'Forbidden：アクセス権限がありません。';
		}elseif($statusCode == 404){
			$msg = 'Not Found：リソースが見つかりません。';
		}elseif($statusCode == 405){
			$msg = 'Method Not Allowed：メソッドが許可されていません。';
		}elseif($statusCode == 404){
			$msg = 'Not Found：リソースが見つかりません。';
		}elseif($statusCode == 406){
			$msg = 'Not Acceptable：文字コードや言語など、リクエスト先の情報が受理できない内容です。';
		}elseif($statusCode == 407){
			$msg = 'Proxy Authentication Required：プロキシの認証が必要です。';
		}elseif($statusCode == 408){
			$msg = 'Request Timeout：リクエストが時間以内に完了しませんでした。';
		}elseif($statusCode == 409){
			$msg = 'Conflict：現在のリソースとリクエストが矛盾するので完了できません。';
		}elseif($statusCode == 410){
			$msg = 'PGone：リクエストされたコンテンツが消滅しています。';
		}elseif($statusCode == 411){
			$msg = 'Length Required：Content-Lengthヘッダがないためサーバにアクセスを拒否されまｓｈんちあ。';
		}elseif($statusCode == 412){
			$msg = 'Precondition Failed：前提条件に誤りがあります。';
		}elseif($statusCode == 413){
			$msg = 'Request Entity Too Large：アップロード情報が大きすぎます。リクエストがサーバーの許容量を超えています。';
		}elseif($statusCode == 414){
			$msg = 'Request-URI Too Long：URIが長過ぎるため、サーバーが処理を拒否しました。';
		}elseif($statusCode == 415){
			$msg = 'Unsupported Media Type：サーバで指定されたメディアタイプがサポートされていません。';
		}elseif($statusCode == 416){
			$msg = 'Requested Range Not Satisfiable：要求したデータが、実リソースのサイズを超えています。';
			
		//500番台
		}elseif($statusCode == 503){
			$msg = 'Service Unavailable：サービスが一時的に使用できません。時間を置いてアクセスしてください。';
		}elseif($statusCode == 504){
			$msg = 'Gateway Timeout：サービスが一時的に使用できません。時間を置いてアクセスしてください。';
		}elseif($statusCode == 505){
			$msg = 'HTTP Version Not Supported：リクエストがサポートされていないHTTPバージョンです。WEBブラウザを最新バージョンにアップデートしてください。';
		}elseif(500 < $statusCode && $statusCode <= 502){
			$msg = 'Internal Server Error：リクエスト先のサーバーで何らかのエラーが発生しました。';		
		}else{
			$msg = 'その他のエラーが発生しました。';
		}

		parent::__construct($msg, $statusCode);
		//これでもOK
		//$this->code = 800;
		//$this->message = 'WebAPIの接続に失敗しました。';
	}
}