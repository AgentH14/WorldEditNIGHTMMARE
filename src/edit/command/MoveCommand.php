<?php

declare(strict_types=1);

namespace edit\command;

use pocketmine\block\Block;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\Player;

use edit\Vector;
use edit\Main;
use edit\blocks\BaseBlock;
use edit\functions\operation\Operations;
use edit\command\util\FlagChecker;
use edit\math\transform\AffineTransform;

class MoveCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"�I�����Ă���͈͂��ړ����܂�",
			"//move [����] [����] [���O]"
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
			$sender->sendMessage("��c����: ��a�I�����Ă���͈͂��ړ����܂�\n".
					     "��c�g����: ��a//move [����] [����] [���O]\n".
					     "��c�t���O: ��a-s: �ړ���͈̔͂�I�����܂�");
			return false;
		}

		$check = FlagChecker::check($args);

		$args = $check[0];
		$flags = $check[1];

		$moveSelection = false;

		foreach($flags as $flag){
			switch($flag){
				case "s":
					$moveSelection = true;
					break;
			}
		}

		$count = 1;
		if(isset($args[0])) $count = (int) $args[0];

		if(count($args) < 2){
			$direction = Main::getCardinalDirection($sender);
		}else{
			$direction = Main::getFlipDirection($sender, $args[1]);
		}

		$session = Main::getInstance()->getEditSession($sender);

		$replace = new BaseBlock(Block::AIR);
		$session->moveRegion($session->getRegionSelector($sender->getLevel())->getRegion(), $direction, $count, true, $replace);
		$session->remember();
		$sender->sendMessage(Main::LOGO."�u���b�N���ړ����܂���");
		return true;
	}
}