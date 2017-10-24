<?php
namespace ikatyo\LobiShoutSystem;

use pocketmine\Player;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerCommandPreProcessEvent;
use pocketmine\utils\TextFormat;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\event\Listener;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\level\particle\Particle;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\level\Position\getLevel;
use pocketmine\plugin\PluginManager;
use pocketmine\plugin\Plugin;
use pocketmine\math\Vector3;
use pocketmine\utils\config;
include("LobiAPI.php");

/*
    //Configは必ず毎回取得処理を
    $config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
    $g_id = $config->get("g_id");
    $swich = $config->get("swich");
    $info = $config->get("info");
    $runmessage = $config->get("runmessage");
    $message = '['.$info.']'.$runmessage;
    ."\n時刻:".date("H時i分s秒")
    //投稿処理へ移行
    $this->post($g_id, $message, $shout = $swich);
*/

class Main extends PluginBase implements Listener{
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
        $this->saveDefaultConfig();
		$config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
		$this->getLogger()->info("§aLobiShoutSystem§eを読み込みました。");
		$this->getLogger()->info("§c二次配布は禁止です§b作者 ikatyo");
		$area = "Asia/Tokyo";
		date_default_timezone_set($area);

        $g_id = $config->get("g_id");
        $swich = $config->get("swich");

        $info = $config->get("info");
        $runmessage = $config->get("runmessage");
        $message = '['.$info.']'.$runmessage."\n時刻:".date("H時i分s秒");

		$this->post($g_id, $message, $shout = $swich);
    }

    public function onDisable(){
        $config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);

        $g_id = $config->get("g_id");
        $swich = $config->get("swich");

        $info = $config->get("info");
        $stopmessage = $config->get("stopmessage");
        $message = '['.$info.']'.$stopmessage."\n時刻:".date("H時i分s秒");

        $this->post($g_id, $message, $shout = $swich);
    }

    public function login(){
    	$config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
    	$logintype = $config->get("logintype");
    	$api = new LobiAPI();

        if ($logintype == 'mail') { //Config[logintype]の判定(mailだった場合)
                $mail = $config->get("mail");
                $pass = $config->get("pass");
                if ($api->Login($mail, $pass)) {//twitter認証の場合はTwitterLoginを使用する
                    $this->getLogger()->info(TextFormat::AQUA . 'ログイン成功');
                } else {
                    $this->getLogger()->info(TextFormat::RED . 'ログイン失敗');
                    $this->getLogger()->info(TextFormat::RED . 'Configを確認してください');
                    $this->getServer()->getPluginManager()->disablePlugin($this);
                }
                //mailだった場合の処理はここまで

            } else {//twitterだった場合(正確に言えばconfigの値がmail以外だった場合)
                if ($logintype == 'twitter') {
                $mail = $config->get("mail");
                $pass = $config->get("pass");
                if ($api->TwitterLogin($mail, $pass)) {//twitter認証の場合はTwitterLoginを使用する
                    $this->getLogger()->info(TextFormat::AQUA . 'ログイン成功');
                } else {
                    $this->getLogger()->info(TextFormat::RED . 'ログイン失敗');
                    $this->getLogger()->info(TextFormat::RED . 'Configを確認してください');
                    $this->getServer()->getPluginManager()->disablePlugin($this);
                }

                } else {
                $this->getLogger()->info(TextFormat::RED . '入力形式が不正です');
                $this->getLogger()->info(TextFormat::RED . 'メール認証の場合はmailと入力');
                $this->getLogger()->info(TextFormat::RED . 'Twitter認証の場合はtwitterと入力');
                $this->getServer()->getPluginManager()->disablePlugin($this);
            }
        }
    }

    public function post($g_id,$message,$swich){
        $api = new LobiAPI();
        $this->login();
    	$api->MakeThread($g_id, $message, $shout = $swich);
    	$this->getLogger()->info(TextFormat::AQUA . '[LobiShoutSystem]PostSucces!');
    }

    function whitelist(PlayerCommandPreprocessEvent $wl){
        	if($wl->getMessage() == "/whitelist on"){
            	$config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
            	$g_id = $config->get("g_id");
            	$swich = $config->get("swich");
            	$info = $config->get("info");
            	$whitelist_onMessage = $config->get("whitelist_onMessage");
            	$message = '['.$info.']'.$whitelist_onMessage."\n時刻:".date("H時i分s秒");

            	$this->post($g_id, $message, $shout = $swich);
        	}else{
         	if($wl->getMessage() == "/whitelist off"){
            	$config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
            	$g_id = $config->get("g_id");
            	$swich = $config->get("swich");
            	$info = $config->get("info");
            	$whitelist_offMessage = $config->get("whitelist_offMessage");
            	$message = '['.$info.']'.$whitelist_offMessage."\n時刻:".date("H時i分s秒");
            	
            	$this->post($g_id, $message, $shout = $swich);
        	}
    	}
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args):bool{
		switch(strtolower($command->getName())){
			case "lobi":
			if($sender->isOp()){
                $config = new Config($this->getDataFolder() . "/config.yml", Config::YAML);
                $g_id = $config->get("g_id");
                $swich = $config->get("swich");
                $message = '[Message]'.$args[0]."\n投稿者:".$sender->getName()."\n時刻:".date("H時i分s秒");
                $this->post($g_id, $message, $shout = $swich);
                $sender->sendMessage("INFO:§aメッセージを投稿しました");
            }else{
                    $sender->sendMessage("§c[Error]運営コマンドのため一般プレイヤーは利用できません。");
            }
            break;
        }
    }

}