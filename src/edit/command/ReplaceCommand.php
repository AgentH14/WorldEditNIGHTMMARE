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
use edit\functions\mask\BlockMask;

class ReplaceCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"�͈͓��̃u���b�N��u�������܂�",
			"//replace [�u��������u���b�N] <�u���u���b�N>"
		);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(!($sender instanceof Player)){
			return true;
		}

		$copyEntities = false;

		if(count($args) < 2){
			return true;
		}

		$items = explode(",", $args[0]);
		$blocks = [];

		foreach($items as $item){
			$blocks[] = Main::getInstance()->getBlockFactory()->parseFromInput($item);
		}

		$session = Main::getInstance()->getEditSession($sender);
		$mask = new BlockMask($session, $blocks);
		$pattern = Main::getInstance()->getPatternFactory()->parseFromInput($args[1]);

		$affected = $session->replaceBlocks($session->getRegionSelector($sender->getLevel())->getRegion(), $mask, $pattern);
		$session->remember();
		$sender->sendMessage(Main::LOGO.$affected."�u���b�N��ݒu���܂���");
		return true;
	}
}