<?php

namespace WoollenPanda275\PlayerFinder;


use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\level\{Level,Position};
use pocketmine\utils\Config;
use pocketmine\block\Block;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\Server;

class Main extends PluginBase implements Listener {
    
    public function onEnable() {
         @mkdir($this->getDataFolder());
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if (strtolower($command->getName()) == "findp") {
            if ($sender->hasPermission("find.player")) {
                if ($sender instanceof Player) {
                    if (isset($args[0])) {
                        if (isset($args[1])) {
                            if ($args[0] == "tp") {
                                $player = $args[1];
                                $world = $this->getServer()->getPlayer($player)->getLevel()->getFolderName();
                                $z = $this->getServer()->getPlayer($player)->getZ();
                                $x = $this->getServer()->getPlayer($player)->getX();
                                $y = $this->getServer()->getPlayer($player)->getY();
                                $this->getServer()->getPlayer($player)->teleport(new Position($x, $y, $z, $this->getServer()->getLevelByName($world)));
                                $sender->sendMessage(TextFormat::GREEN . "Teleported to: $world, $x, $y, $z");
                                return true;
                            } elseif ($args[0] == "find") {
                                $player = $args[1];
                                 $world = $this->getServer()->getPlayer($player)->getLevel()->getFolderName();
                                $z = $this->getServer()->getPlayer($player)->getZ();
                                $x = $this->getServer()->getPlayer($player)->getX();
                                $y = $this->getServer()->getPlayer($player)->getY();
                                $sender->sendMessage(TextFormat::GREEN . "Location found: $world, $x, $y, $z");
                            } elseif ($args[0] == "world") {
                                $player = $args[1];
                                $world = $this->getServer()->getPlayer($player)->getLevel()->getFolderName();
                                $sender->sendMessage(TextFormat::GREEN . "World Located: $world");
                                } else {
                                $sender->sendMessage(TextFormat::RED . "Commands: \n/findp tp {name}\n/findp find {player}\n/findp world {player}");
                            }
                        } else {
                            $sender->sendMessage(TextFormat::RED . "Set a player name!");
                        }
                    } else {
                        $sender->sendMessage(TextFormat::RED . "Commands: \n/findp tp {name}\n/findp find {player}\n/findp world {player}");
                    }
                } else {
                    $sender->sendMessage(TextFormat::RED . "Must run in-game!");
                }
            } else {
                $sender->sendMessage(TextFormat::RED . "No permissions!");
                return false;
            }
        }
        return false;
    }
}
