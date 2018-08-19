<?php

declare(strict_types=1);

namespace edit\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\Player;

use edit\Vector;
use edit\Main;

class UndoCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"���ɖ߂�",
			"//undo [��]"
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
			$sender->sendMessage("��c����: ��a���ɖ߂��܂�\n".
					     "��c�g����: ��a//undo [��]");
			return false;
		}

		$session = Main::getInstance()->getEditSession($sender);

		$times = isset($args[0]) ? max(1, $args[0]) : 1;

		for($i = 0;$i < $times;$i++){
			$undone = false;
			$undone = $session->undo();
			if($undone) $sender->sendMessage(Main::LOGO."���ɖ߂��܂���");
		}
		return true;
	}
}