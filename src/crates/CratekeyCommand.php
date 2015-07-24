<?php
namespace crates;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat;
use pocketmine\Server;
use pocketmine\Player;

use crates\Main;

class CratekeyCommand{

	public $plugin;
	
	public function __construct(Main $pg) {
		$this->plugin = $pg;
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
		if(strtolower($cmd->getName('cratekey'))){
			if(count($args) == 0){
				$sender->sendMessage(TextFormat::RED. "/cratekey <give/giveall>");
			}
			if(count($args) == 1){
				if($args[0] == "giveall"){
					if($sender->hasPermission("mysterycrates.command.cratekey.giveall")){
						$this->plugin->giveCratekeyAll();
						$sender->sendMessage(TextFormat::GOLD. "You have given a cratekey to everyone on the server!");
						$sender->getServer()->broadcastMessage(TextFormat::BOLD. TextFormat::BLUE. "[MysteryCrates]". TextFormat::GREEN. TextFormat::RESET. " Everyone has been given a cratekey by ".TextFormat::GOLD. $sender->getName()."! ");
					}
				}
			}
				if(count($args) == 2){
			        if($args[0] == "give"){
						if($sender->hasPermission("mysterycrates.command.cratekey.give")){
							$player = $sender->getServer()->getPlayer($args[1]);
							if($player instanceof Player){
								$player->sendMessage(TextFormat::GREEN. "You have been given a cratekey by ". TextFormat::GOLD. $sender->getName());
								$sender->sendMessage(TextFormat::GOLD. "Given a cratekey to ".TextFormat::GOLD. $player->getName());
								$this->plugin->giveCratekey($player);
							} else{
								$sender->sendMessage(TextFormat::RED. "That player cannot be found");
							}
						}
					}
			}
		}
	}
}
