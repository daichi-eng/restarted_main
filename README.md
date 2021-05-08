# au Payマーケット商品登録システム

システムのリンク：[au Payマーケット商品登録システム](っっっｓ)

## システムの概要
「au Payマーケット」にて無料で提供しているAPIを利用して、「au Payマーケット」に出店している自店舗に商品登録を行えるシステムです。

## システムの意義
「au Payマーケット」では、標準機能では商品の同時複数登録を行うことができません。
同時登録を行うには、au Payマーケット提供のCSVアップロードシステムを利用できますが、利用料金が約10000円/月がかかります。
本システムは、auPAYマーケットが無料で提供するAPIを利用して商品登録を行えるため、月額の10000円のコストカットを行うことができる。

## 使用言語・環境・ツール
* 言語：PHP、scss、HTML
* フレームワーク：Laravel、BootStrap
* DB：MySQL
* IDE：Eclipse
* ローカル開発環境：xampp

## システムの利用者像
* auPAYマーケットに出店している店舗運営者。
* 資本力の低い個人店舗経営者。
* 他のモールにてネットショップを運営していて、一括アップロードするCSVの素材を持っている。

## 苦労したところ
### API仕様に合わせたデータ整形のアルゴリズム
auPAYマーケットのAPI仕様に基づいたリクエストを送信するために、同時にアップロードした2つのCSVを結合するアルゴリズムを考えるのに苦労しました。
ただ、__処理フローを考えるのは、システム開発してて一番楽しい部分でした。__
  参考：UploadController.php

### ユーザーの使用権限の設計
ユーザーのアプリ使用権限に拡張をもたせるテーブル設計について苦労しました。usersテーブルに権限をもたせるのではなく、テーブルを分割して管理者画面から新規アプリと権限を追加できるように設計しました。「アプリを新しく開発して、個別に権限を制限したい」といった要件を満たすことができます。
アプリの使用権限の設計はusersテーブルにフィールドを追加する方法や、アプリマスタをconfigファイルに直接記載する方法などを考えましたが、所属しているプログラミングサークルで色々と助言をいただき今の形になりました。  

 - __アプリマスタ（m_app）__ ...システムにアプリを登録するマスタ（管理者テーブルのユーザーしか登録できない。）

| 物理名称   |論理名称      |
|:-----------|------------:|
| m_app_id   | ID          |
| app_no     | アプリ番号   |
| app_name   | アプリ名称   |

 - __アプリ使用権限（app_roles）__ ...アプリ番号とユーザーIDをキーにユーザーごとに使用できるアプリを制限する。

| 物理名称   |論理名称    |
|:-----------|----------:|
|ID         |app_role_id|
|アプリ番号 |app_no     |
|ユーザID   |user_id    |

## 改善点
### Laravelで管理者と一般ユーザーでの分割方法について理解できなかったこと。  
  管理者と一般ユーザーで画面・機能・権限を分けていますが、内容を理解できずただのコピペに終わってしまいました。
### 実際にユーザーに使ってもらうことができなかったこと。  
  バグが起きないか不安でユーザーに公開できず、自分でしか使用しませんでした。
### 最初から凝ったシステムにしすぎたこと。  
  もう少し軽めのシステムを開発したサクサク作れて、モチベーションも継続しやすかったと反省しています。
### au PAYのアカウントがないと使えないシステムであること。  
  せっかくポートフォリオにするのに、動作を見てもらうことができません。私もアカウントを保持しておらず、知り合った方のアカウントを借りていましたが、その人のアカントもなくなってしまいました...
　


<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
