<?php

declare(strict_types=1);

namespace edit\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\Player;

use edit\Vector;
use edit\Main;
use edit\functions\operation\Operations;
use edit\command\util\FlagChecker;
use edit\math\transform\AffineTransform;

class RotateCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"クリップボードを回転します",
			"//rotate <Y軸> [<X軸>] [<Z軸>]"
		);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(!($sender instanceof Player)){
			return true;
		}

		if($args[0] === "help"){
			$sender->sendMessage("§c効果: §aクリップボードを回転します\n".
					     "§c使い方: §a//rotate <Y軸> [<X軸>] [<Z軸>]");
			return false;
		}

		if(count($args) < 1){
			$sender->sendMessage("§c使い方: §a//rotate <Y軸> [<X軸>] [<Z軸>]");
			return;
		}

		$session = Main::getInstance()->getEditSession($sender);

		$holder = $session->getClipboard();
		$transform = new AffineTransform();
		$transform = $transform->rotateY(-(isset($args[0]) ? $args[0] : 0));
		$transform = $transform->rotateX(-(isset($args[1]) ? $args[1] : 0));
		$transform = $transform->rotateZ(-(isset($args[2]) ? $args[2] : 0));
		$holder->setTransform($holder->getTransform()->combine($transform));

		$sender->sendMessage(Main::LOGO."クリップボードを回転しました");
		return true;
	}
}