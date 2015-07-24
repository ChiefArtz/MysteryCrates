<?php
namespace crates;

use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\Config;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;

use crates\CratekeyCommand;

class Main extends PluginBase implements Listener{

	public $plugin, $votereward;
	
	public function onEnable(){
		$this->saveDefaultConfig();
		$this->cratekey = new CratekeyCommand($this);
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	//	$this->votereward = $this->getServer()->getPluginManager()->getPlugin("VoteReward");
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
		$this->cratekey->onCommand($sender, $cmd, $label, $args);
	}
	
	public function onTouchCrate(PlayerInteractEvent $e){
		if($e->getBlock()->getId() == 54){
			if($e->getItem()->getId() == $this->getConfig()->get("cratekey-item")){
				if($e->getPlayer()->hasPermission("mysterycrates.crates.open")){
					$e->setCancelled();
					$this->openCrate($e->getPlayer());
				}
			}
		}
	}
	
	////////////////////////////////////////////////////////
	
	public function giveCratekeyAll(){
		foreach($this->getServer()->getOnlinePlayers() as $p){
			$p->getInventory()->addItem(Item::get($this->getConfig()->get("cratekey-item"), 0, 1));
		}
	}
	
	public function openCrate(Player $p){
		if($this->getConfig()->get("broadcast-message-on-open")){
			$this->getServer()->broadcastMessage(TextFormat::BOLD. TextFormat::GREEN. "[MysteryCrates] ". TextFormat::RESET. TextFormat::RED. $p->getName(). " opened a crate!");
			//TODO
		}
	}
	
	public function giveCrateKey(Player $p){
		$p->getInventory()->addItem(Item::get($this->getConfig()->get("cratekey-item"), 0, 1));
	}
	
	public function onVote(){
		//TODO
	}
}
