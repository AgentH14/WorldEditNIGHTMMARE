<?php

declare(strict_types=1);

namespace edit\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\Player;

use edit\Vector;
use edit\Main;
use edit\functions\pattern\Pattern;

class OverlayCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"範囲内のブロックの上にブロックを設置します",
			"//overlay <ブロックパターン>"
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
			$sender->sendMessage("§c効果: §a範囲内のブロックの上にブロックを設置します\n".
					     "§c使い方: §a//overlay <ブロックパターン>");
			return false;
		}

		if(count($args) < 1){
			$sender->sendMessage("§c使い方: §a//overlay <ブロックパターン>");
			return true;
		}

		$pattern = Main::getInstance()->getPatternFactory()->parseFromInput($args[0]);

		$session = Main::getInstance()->getEditSession($sender);

		$affected = $session->overlayCuboidBlocks($session->getRegionSelector($sender->getLevel())->getRegion(), $pattern);
		$session->remember();
		$sender->sendMessage(Main::LOGO.$affected."ブロックを生成しました");
		return true;
	}
}