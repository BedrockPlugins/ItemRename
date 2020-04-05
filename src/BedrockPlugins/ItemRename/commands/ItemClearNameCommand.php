<?php

namespace BedrockPlugins\ItemRename\commands;

use BedrockPlugins\ItemRename\ItemRename;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;

class ItemClearNameCommand extends Command {

    public function __construct(string $name, string $description = "", string $usageMessage = null, array $aliases = []) {
        $this->setPermission("command.itemclearname");
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if (!$sender instanceof Player) return;
        if (!$sender->hasPermission("command.itemclearname")) {
            $sender->sendMessage(ItemRename::$prefix . "You don't have permissions to use this command");
            return;
        }
        $item = $sender->getInventory()->getItemInHand();
        if ($item->getId() == Item::AIR) {
            $sender->sendMessage(ItemRename::$prefix . "You have to hold an item in your hand");
            return;
        }
        $name = $sender->getInventory()->getItemInHand()->getCustomName();
        if ($name === "") {
            $sender->sendMessage(ItemRename::$prefix . "This item doesn't have a custom name");
            return;
        }
        $sender->sendMessage(ItemRename::$prefix . "Item name has been cleared");
        $sender->getInventory()->setItemInHand($item->clearCustomName());
    }

}