<?php

namespace BedrockPlugins\ItemRename\commands;

use BedrockPlugins\ItemRename\ItemRename;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;

class ItemRenameCommand extends Command {

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []) {
        $this->setPermission("command.itemrename");
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if (!$sender instanceof Player) return;
        if (!$sender->hasPermission("command.itemrename")) {
            $sender->sendMessage(ItemRename::$prefix . "You don't have permissions to use this command");
            return;
        }
        $item = $sender->getInventory()->getItemInHand();
        if ($item->getId() == Item::AIR) {
            $sender->sendMessage(ItemRename::$prefix . "You have to hold an item in your hand");
            return;
        }
        if (!isset($args[0])) {
            $sender->sendMessage(ItemRename::$prefix . "You have to enter a name");
            return;
        }
        $name = implode(" ", $args);
        if (strlen($name) > ItemRename::getMaxLength()) {
            $sender->sendMessage(ItemRename::$prefix . "The maximum length is " . strval(ItemRename::getMaxLength()));
            return;
        }
        if (!ItemRename::getAllowColor()) {
            $name = str_replace("§", "", $name);
        }
        $sender->getInventory()->setItemInHand($item->setCustomName($name));
        $sender->sendMessage(ItemRename::$prefix . "Item has been renamed");
    }

}