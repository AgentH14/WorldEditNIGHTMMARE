<?php

declare(strict_types=1);

namespace edit\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\Player;

use edit\Vector;
use edit\Main;
use edit\functions\mask\BlockMask;

class MaskCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"�u���V�̃t�B���^�[��ݒ肵�܂�",
			"//mask [�t�B���^�[]"
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
			$sender->sendMessage("��c����: ��a�u���V�̃t�B���^�[��ݒ肵�܂�\n".
					     "��c�g����: ��a//mask [�t�B���^�[]");
			return false;
		}

		if(count($args) < 1){
			Main::getInstance()->getBrushTool($sender->getInventory()->getItemInHand(), $sender)->setMask(null);
			$sender->sendMessage(Main::LOGO."�u���V�̃t�B���^�[�������ɂȂ�܂���");
		}else{
			$items = explode(",", $args[0]);
			$blocks = [];

			foreach($items as $item){
				$blocks[] = Main::getInstance()->getBlockFactory()->parseFromInput($item);
			}

			$session = Main::getInstance()->getEditSession($sender);
			$mask = new BlockMask($session, $blocks);

			Main::getInstance()->getBrushTool($sender->getInventory()->getItemInHand(), $sender)->setMask($mask);

			$sender->sendMessage(Main::LOGO."�u���V�̃t�B���^�[��ݒ肵�܂���");
		}
		return true;
	}
}