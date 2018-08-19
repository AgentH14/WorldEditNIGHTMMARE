<?php

declare(strict_types=1);

namespace edit\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\Player;

use edit\Vector;
use edit\Main;
use edit\session\ClipboardHolder;
use edit\extent\clipboard\BlockArrayClipboard;
use edit\functions\operation\ForwardExtentCopy;
use edit\functions\operation\Operations;
use edit\command\util\FlagChecker;

class CopyCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"�I�����Ă���͈͂��N���b�v�{�[�h�ɃR�s�[���܂�",
			"//copy"
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
			$sender->sendMessage("��c����: ��a�I�����Ă���͈͂��N���b�v�{�[�h�ɃR�s�[���܂�\n".
					     "��c�g����: ��a//copy\n".
					     "��c�t���O: ��a-e: �G���e�B�e�B�[���R�s�[���܂�\n".
					     "��c      : ��a-m: -----------");
			return false;
		}

		$check = FlagChecker::check($args);

		$args = $check[0];
		$flags = $check[1];

		$copyEntities = false;

		foreach($flags as $flag){
			switch($flag){
				case "e":
					$copyEntities = true;
					break;
				case "m":
					break;
			}
		}

		$region = Main::getInstance()->getEditSession($sender)->getRegionSelector($sender->getLevel())->getRegion();

		$clipboard = new BlockArrayClipboard($region);
		$clipboard->setOrigin(Main::getInstance()->getEditSession($sender)->getPlacementPosition($sender));
		$copy = new ForwardExtentCopy(Main::getInstance()->getEditSession($sender), $region, $region->getMinimumPoint(), $clipboard, $region->getMinimumPoint());
		$copy->setCopyingEntities($copyEntities);
		//if($mask != null){
		//	$copy->setSourceMask($mask);
		//}
		Operations::completeLegacy($copy);
		Main::getInstance()->getEditSession($sender)->setClipboard(new ClipboardHolder($clipboard, Main::getInstance()->getEditSession($sender)->getWorld()));

		$sender->sendMessage(Main::LOGO.$region->getArea()."�u���b�N���R�s�[���܂���");
		return true;
	}
}