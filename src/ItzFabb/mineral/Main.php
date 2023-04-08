<?php



namespace ItzFabb\mineral;

//Essentials Class
use Closure;
use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\command\Command;
use pocketmine\command\Commandsender;

use pocketmine\inventory\transaction\action\SlotChangeAction;

use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\data\bedrock\EnchantmentIds;
use pocketmine\data\bedrock\EnchantmentIdMap;

use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\item\enchantment\{Enchantment, EnchantmentInstance};
use pocketmine\utils\TextFormat;
use pocketmine\utils\TextFormat as TF;

use pocketmine\event\block\BlockBreakEvent;

use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

use pocketmine\event\player\PlayerLoginEvent;

use pocketmine\utils\Config;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;

use jojoe77777\FormAPI\{SimpleForm, CustomForm};
use vanilla\FortuneEnchantment;
use onebone\economyapi\EconomyAPI;
use onebone\coinapi\CoinAPI;

class Main extends PluginBase implements Listener {

	public const LAPIZ = 0;
	public const BLOCKLAPIZ = 1;
	public const REDSTONE = 2;
	public const BLOCKREDSTONE = 3;
	public const COAL = 4;
	public const BLOCKCOAL = 5;
	public const IRON_ORE = 6;
	public const BLOCKIRON = 7;
	public const GOLD_ORE = 8;
	public const BLOCKGOLD = 9;
	public const DIAMOND = 10;
	public const BLOCKDIAMOND = 11;
	public const EMERALD = 12;
	public const BLOCKEMERALD = 13;
	public const COBLESTONE = 14;

	public $database;

	public static $instance;

	public function onEnable(): void {
		//OnEnable 
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		@mkdir($this->getDataFolder() . "players/");
		$this->id = new Config($this->getDataFolder() . "id.yml", Config::YAML);
		$this->auto = new Config($this->getDataFolder() . "auto.yml", Config::YAML);
		$this->int = new Config($this->getDataFolder() . "int.yml", Config::YAML);
		$this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
		self::$instance = $this;
		$this->getLogger()->info("\n\n\n§l§9PLUGIN §5MINERAL \n§aAUTHOR: §4ItzFabb\n§aUPGRADE: §4ClickedTran\n\n");
        @mkdir($this->getDataFolder());
        $this->saveResource("message.yml");
        $this->saveResource("sell.yml");
        $this->sell = new Config($this->getDataFolder(). "sell.yml", Config::YAML);
        $this->message = new Config($this->getDataFolder(). "message.yml", Config::YAML);
		$this->saveDefaultConfig();

        $this->prefix = $this->message->get("Prefix");
		if (!InvMenuHandler::isRegistered()) {
			InvMenuHandler::register($this);
		}
		//Log Info

	}

	public function onJoin(PlayerJoinEvent $ev) {
		if (!$this->auto->exists($ev->getPlayer()->getName())) {
			$this->auto->set($ev->getPlayer()->getName(), "off");
			$this->auto->save();
		}
	}

	public function onbreak(BlockBreakEvent $ev) {
		$player = $ev->getPlayer();
		$this->data = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
		$level = $player->getInventory()->getItemInHand()->getEnchantmentLevel(EnchantmentIdMap::getInstance()->fromId(18)) + 1;

		if (!$ev->isCancelled()) {
			if ($this->auto->get($player->getName()) == "on") {
                          if($player->isCreative(true)){}else{
				if ($ev->getBlock()->getId() == 56) {
					$ev->setDrops(array());
					$id = mt_rand(0,$level);
					$this->data->set(self::DIAMOND, ($this->data->get(self::DIAMOND) + $id));
					$this->data->save();
				}
				//COAL
				if ($ev->getBlock()->getId() == 16) {
					$ev->setDrops(array());
					$id = mt_rand(0,$level);
					$this->data->set(self::COAL, ($this->data->get(self::COAL) + $id));
					$this->data->save();
				}
				///GOLD BLOCK
				if ($ev->getBlock()->getId() == 41) {
					$ev->setDrops(array());
					$this->data->set(self::BLOCKGOLD, ($this->data->get(self::BLOCKGOLD) + 1));
					$this->data->save();
				}
				//IRON BLOCK
				if ($ev->getBlock()->getId() == 42) {
					$ev->setDrops(array());
					$this->data->set(self::BLOCKIRON, ($this->data->get(self::BLOCKIRON) + 1));
					$this->data->save();
			     }
				//COBLESTONE
				if ($ev->getBlock()->getId() == 4) {
					$ev->setDrops(array());
					$this->data->set(self::COBLESTONE, ($this->data->get(self::COBLESTONE) + 1));
					$this->data->save();
				}
				//DIAMOND BLOCK
				if ($ev->getBlock()->getId() == 57) {
					$ev->setDrops(array());
					$this->data->set(self::BLOCKDIAMOND, ($this->data->get(self::BLOCKDIAMOND) + 1));
					$this->data->save();
				}
				//REDSTONE
				if ($ev->getBlock()->getId() == 73) {
					$ev->setDrops(array());
					$id = mt_rand(0,$level);
					$this->data->set(self::REDSTONE, ($this->data->get(self::REDSTONE) + $id));
					$this->data->save();
				}
				//EMERALD BLOCK
				if ($ev->getBlock()->getId() == 133) {
					$ev->setDrops(array());
					$this->data->set(self::BLOCKEMERALD, ($this->data->get(self::BLOCKEMERALD) + 1));
					$this->data->save();
				}
				//EMERALD
				if ($ev->getBlock()->getId() == 129) {
					$ev->setDrops(array());
					$id = mt_rand(0,$level);
					$this->data->set(self::EMERALD, ($this->data->get(self::EMERALD) + $id));
					$this->data->save();
				}
				//COAL BLOCK
				if ($ev->getBlock()->getId() == 173) {
					$ev->setDrops(array());
					$this->data->set(self::BLOCKCOAL, ($this->data->get(self::BLOCKCOAL) + 1));
					$this->data->save();
				}
				//LAPIZ
				if ($ev->getBlock()->getId() == 21) {
					$ev->setDrops(array());
					$id = mt_rand(0, $level);
					$this->data->set(self::LAPIZ, ($this->data->get(self::LAPIZ) + $id));
					$this->data->save();
				}
				//LAPIZ BLOCK
				if ($ev->getBlock()->getId() == 22) {
					$ev->setDrops(array());
					$this->data->set(self::BLOCKLAPIZ, ($this->data->get(self::BLOCKLAPIZ) + 1));
					$this->data->save();
				}
				//REDSTONE BLOCK
				if ($ev->getBlock()->getId() == 152) {
					$ev->setDrops(array());
					$this->data->set(self::BLOCKREDSTONE, ($this->data->get(self::BLOCKREDSTONE) + 1));
					$this->data->save();
				}
				//IRON ORE
			    if($ev->getBlock()->getId() == 15){
				    $ev->setDrops(array());
				    $id = mt_rand(0, $level);
				    $this->data->set(self::IRON_ORE, ($this->data->get(self::IRON_ORE) + 1 * $id));
				    $this->data->save();
				}
				//GOLD ORE
				if($ev->getBlock()->getId() == 14){
				    $ev->setDrops(array());
				    $id = mt_rand(0, $level);
				    $this->data->set(self::GOLD_ORE, ($this->data->get(self::GOLD_ORE) + 1 * $id));
				    $this->data->save();
				}
				//STONE -> COBLESTONE
				if($ev->getBlock()->getId() == 1){
				    $ev->setDrops(array());
				    $this->data->set(self::COBLESTONE, ($this->data->get(self::COBLESTONE) + 1));
				    $this->data->save();
				}
			}
                    }
		}
	}

	public function getNumber(int $type, Player $player): int {
		$this->data = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
		return $this->data->get($type);
	}

	public function addNumber64(int $type, Player $player) {
		$this->data = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
		$this->data->set($type, ($this->data->get($type) + 64));
		$this->data->save();
	}

	public function addNumber48(int $type, Player $player) {
		$this->data = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
		$this->data->set($type, ($this->data->get($type) + 48));
		$this->data->save();
	}

	public function addNumber32(int $type, Player $player) {
		$this->data = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
		$this->data->set($type, ($this->data->get($type) + 32));
		$this->data->save();
	}

	public function addNumber16(int $type, Player $player) {
		$this->data = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
		$this->data->set($type, ($this->data->get($type) + 16));
		$this->data->save();
	}

	public function addNumber1(int $type, Player $player) {
		$this->data = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
		$this->data->set($type, ($this->data->get($type) + 1));
		$this->data->save();
	}

	public function descreaseNumber64(int $type, Player $player) {
		$this->data = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
		$this->data->set($type, ($this->data->get($type) - 64));
		$this->data->save();
	}

	public function descreaseNumber48(int $type, Player $player) {
		$this->data = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
		$this->data->set($type, ($this->data->get($type) - 48));
		$this->data->save();
	}

	public function descreaseNumber32(int $type, Player $player) {
		$this->data = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
		$this->data->set($type, ($this->data->get($type) - 32));
		$this->data->save();
	}

	public function descreaseNumber16(int $type, Player $player) {
		$this->data = new Config($this->getDataFolder() . "players/" . $player->getName() . ".yml", Config::YAML);
		$this->data->set($type, ($this->data->get($type) - 16));
		$this->data->save();
	}



	public function onCommand(CommandSender $sender, Command $command, String $label, array $args): bool {
		switch ($command->getName()) {
			case "khokhoangsan":
			case "kho":
			case "kks":
				$this->kho($sender);
				break;
			case "khoauto":
				$name = $sender->getName();
				$auto = $this->auto->get($name);
				if ($auto == "on") {
					$this->auto->set($name, "off");
					$sender->sendMessage("§l§c•§aAutomatic §fOff");
				}
				if ($auto == "off") {
					$this->auto->set($name, "on");
					$sender->sendMessage("§l§c•§aAutomatic §fOn");
				}
				return true;
		}
		return true;
	}

	public function kho($sender) {
		$this->menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
		$this->menu->readonly();
		$this->menu->setListener(Closure::fromCallable([$this, "khomenu"]));
		$this->menu->setName($this->message->getNested("menu.name"));
		$inventory = $this->menu->getInventory();


		//Chest Section 1-8
		for($i = 0; $i <= 8; $i++){
		$inventory->setItem($i, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		}
		//Chest Section 9-17
		$inventory->setItem(9, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));

		$inventory->setItem(13, ItemFactory::getInstance()->get(4, 0, 1)->setCustomName("§rCOBLESTONE "));
		
		$inventory->setItem(17, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		//Chest Section 18-26
		$inventory->setItem(18, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		$inventory->setitem(19, ItemFactory::getInstance()->get(351, 4, 1)->setCustomName(" §r LAPIZ "));
		$inventory->setItem(20, ItemFactory::getInstance()->get(331, 0, 1)->setCustomName(" §r REDSTONE "));
		$inventory->setItem(21, ItemFactory::getInstance()->get(263, 0, 1)->setCustomName(" §rCOAL "));
		$inventory->setItem(22, ItemFactory::getInstance()->get(15, 0, 1)->setCustomName(" §rIRON ORE "));
		$inventory->setItem(23, ItemFactory::getInstance()->get(14, 0, 1)->setCustomName(" §rGOLD ORE "));
		$inventory->setItem(24, ItemFactory::getInstance()->get(264, 0, 1)->setCustomName(" §rDIAMOND "));
		$inventory->setItem(25, ItemFactory::getInstance()->get(388, 0, 1)->setCustomName(" §rEMERALD "));
		$inventory->setItem(26, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		//Chest Section 27-35
		$inventory->setItem(27, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		$inventory->setItem(28, ItemFactory::getInstance()->get(22, 0, 1)->setCustomName(" §r LAPIZ BLOCK "));
		$inventory->setItem(29, ItemFactory::getInstance()->get(152, 0, 1)->setCustomName(" §rREDSTONE BLOCK "));
		$inventory->setItem(30, ItemFactory::getInstance()->get(173, 0, 1)->setCustomName(" §rCOAL BLOCK "));
		$inventory->setItem(31, ItemFactory::getInstance()->get(42, 0, 1)->setCustomName(" §rIRON BLOCK "));
		$inventory->setItem(32, ItemFactory::getInstance()->get(41, 0, 1)->setCustomName(" §rGOLD BLOCK "));
		$inventory->setItem(33, ItemFactory::getInstance()->get(57, 0, 1)->setCustomName(" §rDIAMOND BLOCK "));
		$inventory->setItem(34, ItemFactory::getInstance()->get(133, 0, 1)->setCustomName(" §rEMERALD BLOCK"));
		$inventory->setItem(35, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		//Chest Section 36-44
		$inventory->setItem(36, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
	
		$inventory->setItem(44, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		//Chest Section 45-53
		$inventory->setItem(45, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		$inventory->setitem(46, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		$inventory->setItem(47, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		$inventory->setItem(48, ItemFactory::getInstance()->get(386, 0, 1)->setCustomName(str_replace(["{line}", "{lapiz_block}", "{diamond_block}", "{iron_block}", "{gold_block}", "{redstone_block}", "{emerald_block}", "{coal_block}", "{coblestone}"], ["\n", $this->getNumber(self::BLOCKLAPIZ, $sender), $this->getNumber(self::BLOCKDIAMOND, $sender), $this->getNumber(self::BLOCKIRON, $sender), $this->getNumber(self::BLOCKGOLD, $sender), $this->getNumber(self::BLOCKREDSTONE, $sender), $this->getNumber(self::BLOCKEMERALD, $sender), $this->getNumber(self::BLOCKCOAL, $sender), $this->getNumber(self::COBLESTONE, $sender)], $this->message->getNested("menu.ore_block"))));
		$inventory->setItem(49, ItemFactory::getInstance()->get(152, 0, 1)->setCustomName($this->message->getNested("menu.exit")));
		$inventory->setItem(50, ItemFactory::getInstance()->get(386, 0, 1)->setCustomName(str_replace(["{line}", "{lapiz}", "{diamond}", "{iron_ore}", "{gold_ore}", "{redstone}", "{emerald}", "{coal}", "{coblestone}"], ["\n", $this->getNumber(self::LAPIZ, $sender), $this->getNumber(self::DIAMOND, $sender), $this->getNumber(self::IRON_ORE, $sender), $this->getNumber(self::GOLD_ORE, $sender), $this->getNumber(self::REDSTONE, $sender), $this->getNumber(self::EMERALD, $sender), $this->getNumber(self::COAL, $sender), $this->getNumber(self::COBLESTONE, $sender)], $this->message->getNested("menu.ore"))));
		$inventory->setItem(51, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		$inventory->setItem(52, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		$inventory->setItem(53, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));

		$this->menu->send($sender);
	}
	public function khomenu(InvMenuTransaction $action): InvMenuTransactionResult {
		$item = $action->getOut();
		$itemN = $item->getCustomName();
		$sender = $action->getPlayer();
		$inventory = $action->getAction()->getInventory();
		$hand = $sender->getInventory()->getItemInHand()->getCustomName();
		if ($itemN == $this->message->getNested("menu.exit")) {
			$sender->removeCurrentWindow($inventory);
			return $action->discard();
		}

		if ($item->getId() == 4) {

			$this->int->set($sender->getName(), self::COBLESTONE);
			$this->id->set($sender->getName(), 4);
			$this->item($sender);
			return $action->discard();
		}
		if ($item->getId() == 351 && $item->getMeta() == 4) {

			$this->int->set($sender->getName(), self::LAPIZ);
			$this->id->set($sender->getName(), 351);
			$this->item($sender);
			return $action->discard();
		}

		if ($item->getId() == 22) {

			$this->int->set($sender->getName(), self::BLOCKLAPIZ);
			$this->id->set($sender->getName(), 22);
			$this->item($sender);
			return $action->discard();
		}
		if ($item->getId() == 331) {
			$this->int->set($sender->getName(), self::REDSTONE);
			$this->id->set($sender->getName(), 331);
			$this->item($sender);
			return $action->discard();
		}
		if ($item->getId() == 152) {

			$this->int->set($sender->getName(), self::BLOCKREDSTONE);
			$this->id->set($sender->getName(), 152);
			$this->item($sender);
			return $action->discard();
		}
		if ($item->getId() == 263) {

			$this->int->set($sender->getName(), self::COAL);
			$this->id->set($sender->getName(), 263);
			$this->item($sender);
			return $action->discard();
		}
		if ($item->getId() == 15) {

			$this->int->set($sender->getName(), self::IRON_ORE);
			$this->id->set($sender->getName(), 15);
			$this->item($sender);
			return $action->discard();
		}
		if ($item->getId() == 42) {

			$this->int->set($sender->getName(), self::BLOCKIRON);
			$this->id->set($sender->getName(), 42);
			$this->item($sender);
			return $action->discard();
		}
		if ($item->getId() == 173) {

			$this->int->set($sender->getName(), self::BLOCKCOAL);
			$this->id->set($sender->getName(), 173);
			$this->item($sender);
			return $action->discard();
		}
		if ($item->getId() == 14) {

			$this->int->set($sender->getName(), self::GOLD_ORE);
			$this->id->set($sender->getName(), 14);
			$this->item($sender);
			return $action->discard();
		}
		if ($item->getId() == 41) {

			$this->int->set($sender->getName(), self::BLOCKGOLD);
			$this->id->set($sender->getName(), 41);
			$this->item($sender);
			return $action->discard();
		}
		if ($item->getId() == 264) {

			$this->int->set($sender->getName(), self::DIAMOND);
			$this->id->set($sender->getName(), 264);
			$this->item($sender);
			return $action->discard();
		}
		if ($item->getId() == 57) {

			$this->int->set($sender->getName(), self::BLOCKDIAMOND);
			$this->id->set($sender->getName(), 57);
			$this->item($sender);
			return $action->discard();
		}
		if ($item->getId() == 388) {

			$this->int->set($sender->getName(), self::EMERALD);
			$this->id->set($sender->getName(), 388);
			$this->item($sender);
			return $action->discard();
		}
		if ($item->getId() == 133) {

			$this->int->set($sender->getName(), self::BLOCKEMERALD);
			$this->id->set($sender->getName(), 133);
			$this->item($sender);
			return $action->discard();
		}
		return $action->discard();
	}

	public function item(Player $sender) {
		$type = $this->id->get($sender->getName());
		$meta = 0;
		if ($type == 351) {
			$meta = 4;
		}
		$id = $this->int->get($sender->getName());
		$this->menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
		$this->menu->readonly();
		$this->menu->setListener(Closure::fromCallable([$this, "lapizmenu"]));
		$this->menu->setName($this->message->getNested("menu.name"));
		$inventory = $this->menu->getInventory();


		//Chest Section 1-8
		for ($i = 0; $i <= 9; $i++) {
			$inventory->setItem($i, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		}
		$inventory->setItem(10, ItemFactory::getInstance()->get(0, 8, 1));
		$inventory->setItem(11, ItemFactory::getInstance()->get(0, 8, 1));
		$inventory->setItem(12, ItemFactory::getInstance()->get(0, 9, 1));
		$inventory->setItem(13, ItemFactory::getInstance()->get($type, $meta, 1)->setCustomName(str_replace(["{line}", "{amount}"], ["\n", $this->getNumber($id, $sender)], $this->message->get("quantity_available"))));
		$inventory->setItem(14, ItemFactory::getInstance()->get(0, 9, 1));
		$inventory->setItem(15, ItemFactory::getInstance()->get(0, 8, 1));
		$inventory->setItem(16, ItemFactory::getInstance()->get(0, 8, 1));
		$inventory->setItem(17, ItemFactory::getInstance()->get(160, 9, 1));
		//Chest Section 18-26
		$inventory->setItem(18, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		$inventory->setitem(19, ItemFactory::getInstance()->get(0, 0, 1));
		$inventory->setItem(20, ItemFactory::getInstance()->get(160, 5, 1));
		$inventory->setItem(21, ItemFactory::getInstance()->get(0, 0, 1));
		$inventory->setItem(22, ItemFactory::getInstance()->get(208, 0, 1));
		$inventory->setItem(23, ItemFactory::getInstance()->get(0, 0, 1));
		$inventory->setItem(24, ItemFactory::getInstance()->get(160, 14, 1));
		$inventory->setItem(25, ItemFactory::getInstance()->get(0, 0, 1));
		$inventory->setItem(26, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		//Chest Section 27-35
		$inventory->setItem(27, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		$inventory->setItem(28, ItemFactory::getInstance()->get(339, 11, 1)->setCustomName($this->message->getNested("add.x16")));
		$inventory->setItem(29, ItemFactory::getInstance()->get(339, 12, 1)->setCustomName($this->message->getNested("add.x32")));
		$inventory->setItem(30, ItemFactory::getInstance()->get(339, 13, 1)->setCustomName($this->message->getNested("add.x64")));
		$inventory->setItem(31, ItemFactory::getInstance()->get(54, 0, 1)->setCustomName($this->message->getNested("elective.menu")));
		$inventory->setItem(32, ItemFactory::getInstance()->get(339, 0, 1)->setCustomName($this->message->getNested("take.x16")));
		$inventory->setItem(33, ItemFactory::getInstance()->get(339, 1, 1)->setCustomName($this->message->getNested("take.x32")));
		$inventory->setItem(34, ItemFactory::getInstance()->get(339, 2, 1)->setCustomName($this->message->getNested("take.x64")));
		$inventory->setItem(35, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		//Chest Section 36-44
		$inventory->setItem(36, ItemFactory::getInstance()->get(160, 9, 1));
		$inventory->setItem(37, ItemFactory::getInstance()->get(0, 8, 1));
		$inventory->setItem(38, ItemFactory::getInstance()->get(0, 8, 1));
		$inventory->setItem(39, ItemFactory::getInstance()->get(0, 9, 1));
		$inventory->setItem(40, ItemFactory::getInstance()->get(208, 0, 1));
		$inventory->setItem(41, ItemFactory::getInstance()->get(0, 9, 1));
		$inventory->setItem(42, ItemFactory::getInstance()->get(0, 8, 1));
		$inventory->setItem(43, ItemFactory::getInstance()->get(0, 8, 1));
		$inventory->setItem(44, ItemFactory::getInstance()->get(160, 9, 1));
		//Chest Section 45-53
		$inventory->setItem(45, ItemFactory::getInstance()->get(386, 0, 1)->setCustomName($this->message->getNested("menu.back")));
		
		for ($i = 46; $i <= 52; $i++) {
			$inventory->setItem($i, ItemFactory::getInstance()->get(160, 9, 1)->setCustomName(" §r §7 §r"));
		}
		
		$inventory->setItem(53, ItemFactory::getInstance()->get(399, 0, 1)->setCustomName($this->message->getNested("sell.name")));

		$this->menu->send($sender);
	}
	public function lapizmenu(InvMenuTransaction $action): InvMenuTransactionResult {
		$item = $action->getOut();
		$itemN = $item->getCustomName();
		$sender = $action->getPlayer();
		$inv = $action->getAction()->getInventory();
		$id = $this->id->get($sender->getName());
		$metan = 0;
		if ($id == 351) {
			$metan = 4;
		}
		$type = $this->int->get($sender->getName());
		$hand = $sender->getInventory()->getItemInHand()->getCustomName();
		$inventory = $this->menu->getInventory();
		if ($itemN == $this->message->getNested("menu.back")) {
			$this->kho($sender);
			return $action->discard();
		}
		
		if($itemN == $this->message->getNested("sell.name")){
			$this->sell($sender);
			$sender->removeCurrentWindow($inventory);
			return $action->discard();
		}

		if($item->getId() == 54){
			$this->elective($sender);
		    $sender->removeCurrentWindow($inventory);
			return $action->discard();
		}

		$meta = $item->getMeta();
		switch ($meta) {
			case 11:
				if ($sender->getInventory()->contains(ItemFactory::getInstance()->get($id, $metan, 16))) {
					$sender->getInventory()->removeItem(ItemFactory::getInstance()->get($id, $metan, 16));
					$this->addNumber16($type, $sender);
					$this->item($sender);
					$sender->sendMessage($this->prefix. $this->message->getNested("add.message_x16"));
				} else {
					$sender->removeCurrentWindow($inventory);
					$sender->sendMessage($this->prefix. $this->message->getNested("add.message_error"));
					return $action->discard();
				}
				break;
			case 12:
				if ($sender->getInventory()->contains(ItemFactory::getInstance()->get($id, $metan, 32))) {
					$sender->getInventory()->removeItem(ItemFactory::getInstance()->get($id, $metan, 32));
					$this->addNumber32($type, $sender);
					$this->item($sender);
					$sender->sendMessage($this->prefix. $this->message->getNested("add.message_x32"));
				} else {
					$sender->removeCurrentWindow($inventory);
					$sender->sendMessage($this->prefix. $this->message->getNested("add.message_x32"));
					return $action->discard();
				}
				break;
			case 13:
				if ($sender->getInventory()->contains(ItemFactory::getInstance()->get($id, $metan, 64))) {
					$sender->getInventory()->removeItem(ItemFactory::getInstance()->get($id, $metan, 64));
					$this->addNumber64($type, $sender);
					$this->item($sender);
					$sender->sendMessage($this->prefix. $this->message->getNested("add.message_x64"));
				} else {
					$sender->removeCurrentWindow($inventory);
					$sender->sendMessage($this->prefix. $this->message->getNested("add.message_error"));
					return $action->discard();
				}
				break;
			case 0:
				if ($this->getNumber($type, $sender) >= 16) {
					if ($sender->getInventory()->firstEmpty() === -1) {
						$sender->sendMessage($this->prefix. $this->message->get("full_inventory"));
						$sender->removeCurrentWindow($inventory);
					} else {
						$sender->getInventory()->addItem(ItemFactory::getInstance()->get($id, $metan, 16));
						$this->descreaseNumber16($type, $sender);
						$this->item($sender);
						$sender->sendMessage($this->prefix. $this->message->getNested("take.message_x16"));
					}
				} else {
					$sender->removeCurrentWindow($inventory);
					$sender->sendMessage($this->prefix. $this->message->getNested("take.message_error"));
					return $action->discard();
				}
				break;
			case 1:
				if ($this->getNumber($type, $sender) >= 32) {
					if ($sender->getInventory()->firstEmpty() === -1) {
						$sender->sendMessage($this->prefix. $this->message->get("full_inventory"));
						$sender->removeCurrentWindow($inventory);
					} else {
						$sender->getInventory()->addItem(ItemFactory::getInstance()->get($id, $metan, 32));
						$this->descreaseNumber32($type, $sender);
						$this->item($sender);
						$sender->sendMessage($this->prefix. $this->message->getNested("take.message_x32"));
					}
				} else {
					$sender->removeCurrentWindow($inventory);
					$sender->sendMessage($this->prefix. $this->message->getNested("take.message_error"));
					return $action->discard();
				}
				break;
			case 2:
				if ($this->getNumber($type, $sender) >= 64) {
					if ($sender->getInventory()->firstEmpty() === -1) {
						$sender->sendMessage($this->prefix. $this->message->get("full_inventory"));
						$sender->removeCurrentWindow($inventory);
					} else {
						$sender->getInventory()->addItem(ItemFactory::getInstance()->get($id, $metan, 64));
						$this->descreaseNumber64($type, $sender);
						$this->item($sender);
						$sender->sendMessage($this->prefix. $this->message->getNested("take.message_x64"));
					}
				} else {
					$sender->removeCurrentWindow($inventory);
					$sender->sendMessage($this->prefix. $this->message->getNested("take.message_error"));
					return $action->discard();
				}
				break;
		}
		return $action->discard();
	}
	
/**DON'T DELETE PUBLIC HERE
*                   | |
*                   \/
*/

	public function elective(Player $sender){
	  $form = new CustomForm(function (Player $sender, $data){
		$result = $data;
		 if($result == null){
			 $this->electiveMenu($sender);
			 return true;
		 }
		    $id = $this->id->get($sender->getName());
	        $metan = 0;
	        if ($id == 351) {
		         $metan = 4;
	        }
		    $type = $this->int->get($sender->getName());
		     if(!is_numeric($data[0])){
			     $sender->sendMessage($this->prefix. $this->message->getNested("elective.error1"));
			     return true;
			 }
				if($data[0] < 0){
					$sender->sendMessage($this->prefix. $this->message->getNested("elective.error2"));
				}else{
				    if($this->getNumber($type, $sender) >= $data[0]){
					    if ($sender->getInventory()->firstEmpty() === -1) {
						     $sender->sendMessage($this->prefix. $this->message->get("full_inventory")); 
					    }else{
						     $sender->getInventory()->addItem(ItemFactory::getInstance()->get($id, $metan, $data[0]));
						     $this->data = new Config($this->getDataFolder() . "players/" . $sender->getName() . ".yml", Config::YAML);
		                     $this->data->set($type, ($this->data->get($type) - $data[0]));
		                     $this->data->save();
						     $sender->sendMessage($this->prefix. str_replace(["{line}", "{amount}"], ["\n", $data[0]], $this->message->getNested("elective.successfully")));
					    }
				   } else {
					        $sender->sendMessage($this->prefix. $this->message->getNested("elective.error3"));
			}
		 }
		});
		$form->setTitle($this->message->getNested("elective.title"));
		$form->addInput($this->message->getNested("elective.input"));
		$form->sendToPlayer($sender);
	}
	
/**                /\
*                    | |
*DON'T DELETE PUBLIC HERE
*/

	public function electiveMenu(Player $sender){
		$form = new CustomForm(function (Player $sender, $data){
		$result = $data;
		 if($result == null){
			 return true;
		 }
		    $id = $this->id->get($sender->getName());
	        $metan = 0;
	        if ($id == 351) {
		         $metan = 4;
	        }
		    $type = $this->int->get($sender->getName());
		     if(!is_numeric($data[0])){
			     $sender->sendMessage($this->prefix. $this->message->getNested("elective.error1"));
			     return true;
			 }
			 if(!ctype_digit($data[0]) == "0.1"){
        $sender->sendMessage($this->prefix. $this->message->getNested("elective.error1"));
			   return true;
         }
				if($data[0] < 0){
					$sender->sendMessage($this->prefix. $this->message->getNested("elective.error2"));
				}else{
				    if($this->getNumber($type, $sender) >= $data[0]){
					    if ($sender->getInventory()->firstEmpty() === -1) {
						     $sender->sendMessage($this->prefix. $this->message->get("full_inventory")); 
					    }else{
						     $sender->getInventory()->addItem(ItemFactory::getInstance()->get($id, $metan, $data[0]));
						     $this->data = new Config($this->getDataFolder() . "players/" . $sender->getName() . ".yml", Config::YAML);
		                     $this->data->set($type, ($this->data->get($type) - $data[0]));
		                     $this->data->save();
						     $sender->sendMessage($this->prefix. str_replace(["{line}", "{amount}"], ["\n", $data[0]], $this->message->getNested("elective.successfully")));
					    }
				   } else {
					        $sender->sendMessage($this->prefix. $this->message->getNested("elective.error3"));
			}
		 }
		});
		$form->setTitle($this->message->getNested("elective.title"));
		$form->addInput($this->message->getNested("elective.input"));
		$form->sendToPlayer($sender);
	}
	
	public function sell(Player $sender){
	 $menu = InvMenu::create(InvMenu::TYPE_HOPPER);
	 $menu->setName($this->message->getNested("sell.name"));
	 $menu->setListener(Closure::fromCallable([$this, "sellMenu"]));
	 $menu->readonly();
	 $inv = $menu->getInventory();
	 
	 $inv->setItem(1, ItemFactory::getInstance()->get(399, 0, 1)->setCustomName($this->message->getNested("sell.all")));
	 $inv->setItem(3, ItemFactory::getInstance()->get(399, 0, 1)->setCustomName($this->message->getNested("sell.elective")));
	
	$menu->send($sender);
   }
   
   public function sellMenu(InvMenuTransaction $action): InvMenuTransactionResult{
     $item = $action->getOut();
     $itemN = $item->getCustomName();
     $sender = $action->getPlayer();
     $inv = $action->getAction()->getInventory();
     $id = $this->id->get($sender->getName());
	 $metan = 0;
	  if ($id == 351) {
		   $metan = 4;
	    }
     $type = $this->int->get($sender->getName());
		
     if($itemN == $this->message->getNested("sell.all")){
     	$price = $this->sell->get($type) * $this->data->get($type);
	     if($this->getNumber($type, $sender) > 0){
		     $this->data = new Config($this->getDataFolder() . "players/" . $sender->getName() . ".yml", Config::YAML);
		     $this->data->set($type, 0);
		     $this->data->save();
		     EconomyAPI::getInstance()->addMoney($sender, $price);
             $sender->sendMessage($this->prefix. str_replace(["{money}", "{ore}"], [$price, $type], $this->message->getNested("sell.successfully")));
       }else{
        	$sender->sendMessage($this->prefix. $this->message->getNested("sell.fail"));
      }
      $sender->removeCurrentWindow($inv);
      return $action->discard();
    }
     
     if($itemN == $this->message->getNested("sell.elective")){
     	$this->sellElective($sender);
         $sender->removeCurrentWindow($inv);
         return $action->discard();
     }
     return $action->discard();
  }

/**DON'T DELETE PUBLIC HERE
*                   | |
*                   \/
*/
  
  public function sellElective(Player $sender){
   $form = new CustomForm(function(Player $sender, $data){
     $result = $data;
     if($result == null){
     	$this->sellElectiveMenu($sender);
         return true;
      }
      $price = $this->sell->get($type) * $this->data->get($type);
	     if($this->getNumber($type, $sender) >= $data[0]){
		     $this->data = new Config($this->getDataFolder() . "players/" . $sender->getName() . ".yml", Config::YAML);
		     $this->data->set($type, $this->data->get($type) - $data[0]);
		     $this->data->save();
		     EconomyAPI::getInstance()->addMoney($sender, $price);
             $sender->sendMessage($this->prefix. str_replace(["{money}", "{ore}"], [$price, $type], $this->message->getNested("sell.successfully")));
       }else{
        	$sender->sendMessage($this->prefix. $this->message->getNested("sell.fail"));
      }
    });
    $form->setTitle($this->message->getNested("sell.name"));
    $form->addInput($this->message->getNested("sell.input"));
    $form->sendToPlayer($sender);
   }

/**                /\
*                    | |
*DON'T DELETE PUBLIC HERE
*/  
  public function sellElectiveMenu(Player $sender){
   $form = new CustomForm(function(Player $sender, $data){
     $result = $data;
     if($result == null){
     	$this->kho($sender);
         return true;
      }
      $id = $this->id->get($sender->getName());
	  $metan = 0;
	  if ($id == 351) {
		   $metan = 4;
      }
     $type = $this->int->get($sender->getName());
		if(!is_numeric($data[0])){
			 $sender->sendMessage($this->prefix. $this->message->getNested("elective.error1"));
			   return true;
         }
    if(!ctype_digit($data[0]) == "0.1"){
        $sender->sendMessage($this->prefix. $this->message->getNested("elective.error1"));
			   return true;
         }
	if($data[0] >= 0){
		$price = $this->sell->get($type) * $data[0];
	     if($this->getNumber($type, $sender) >= $data[0]){
		     $this->data = new Config($this->getDataFolder() . "players/" . $sender->getName() . ".yml", Config::YAML);
		     $this->data->set($type, $this->data->get($type) - $data[0]);
		     $this->data->save();
		     EconomyAPI::getInstance()->addMoney($sender, $price);
             $sender->sendMessage($this->prefix. str_replace(["{money}", "{ore}"], [$price, $type], $this->message->getNested("sell.successfully")));
        }else{
        	$sender->sendMessage($this->prefix. $this->message->getNested("sell.fail"));
       }
      }else{
     	$sender->sendMessage($this->prefix. $this->message->getNested("elective.error2"));
	 }
    });
    $form->setTitle($this->message->getNested("sell.name"));
    $form->addInput($this->message->getNested("sell.input"));
    $form->sendToPlayer($sender);
   }
}
