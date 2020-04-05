<?php

namespace BedrockPlugins\ItemRename;

use BedrockPlugins\ItemRename\commands\ItemClearNameCommand;
use BedrockPlugins\ItemRename\commands\ItemRenameCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class ItemRename extends PluginBase {

    public static $prefix = TextFormat::AQUA . "ItemRename " . TextFormat::DARK_GRAY . "» " . TextFormat::GRAY;

    private static $max = 20, $allowcolor = true;

    public function onEnable() {
        $this->saveResource("config.yml", false);

        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        if ($config->exists("maxlength") && is_numeric($config->get("maxlength"))) {
            self::$max = $config->get("maxlength");
        }
        if ($config->exists("allowcolor") && is_bool($config->get("allowcolor"))) {
            self::$allowcolor = $config->get("allowcolor");
        }

        $this->getServer()->getCommandMap()->register("itemrename", new ItemRenameCommand("itemrename", "Renames the item you're holding", null, ["rename"]));
        $this->getServer()->getCommandMap()->register("itemclearname", new ItemClearNameCommand("itemclearname", "Clears the custom name of the item in your hand", null, ["clearname", "itemclear"]));
    }

    public static function getMaxLength() : int {
        return self::$max;
    }

    public static function getAllowColor() : bool {
        return self::$allowcolor;
    }

}