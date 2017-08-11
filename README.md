# LobiShoutSystem
Lobiにサーバの起動・停止情報を自動投稿

GitHubにもコードを置いておくことにしました。
更新？たまーにします(おい)

#機能
このプラグインは下記の機能があります
サーバ起動·停止時に自動投稿
/Whitelist on,off実行時に自動投稿
/lobi 任意の文
で指定グループに投稿する機能

#設定方法

##logintype
自分のログインタイプに応じてmailもしくはtwitterと入力してください。
メールアドレスの方は「mail」と入力
Twitterの方は「twitter」と入力
これ以外のを入力するとエラーが発生します。

##mail
LobiまたはTwitterにログインする際のメールアドレスを入力してください

##pass
LobiまたはTwitterにログインする際のパスワードを入力してください。

##g_id
投稿したいグループのIDを入力してください。
グループIDは/group/の後にあるのがグループIDとなります。
https://web.lobi.co/game/minecraftpe/group/*********************
*がグループIDです。

##swich
trueの場合シャウトありで投稿されます
falseの場合シャウトなしで投稿されます
初期設定ではfalseとなっています。

#メッセージ表示について
infoには[ ]内の内容を変えることが出来ます。
run_messageは起動時のメッセージをカスタマイズできます
stop_messageは停止時のメッセージをカスタマイズできます
初期では
[Server!NFO]サーバを起動しました
[Server!NFO]サーバを停止しました
と投稿されます。
whitelist_onMessageは/whitelist on実行時にLobiに投稿されるメッセージをカスタマイズ出来ます
whitelist_offMessage/whitelist off実行時に投稿されるメッセージをカスタマイズ出来ます

#ライセンス/注意事項
このプラグインはNewDelion氏が制作したLobiAPIを利用しています。
尚LobiAPlは下記URLからダウンロードできます(GitHubにて公開されています。)
https://github.com/NewDelion/LobiAPI-PHP
このプラグインの改変はOKですが二次配布はお止め下さい。
不具合.意見·感想はTwitter@ikatyo0702までお願いします。
皆さんのご意見は出来るだけプラグインへ反映させて頂きます。
