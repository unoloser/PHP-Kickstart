<?php

class ElectronicItems
{
	private $items = array();

	public function __construct(array $items){
		$this->items = $items;
	}

	/**
	* Returns the items depending on the sorting type requested
	*
	* @return array or false
	*/
	public function getSortedItems(){	
		$sorted = array();
		foreach ($this->items as $item){
			$sorted[($item->price * 100)] = $item;
		}
		if (ksort($sorted, SORT_NUMERIC)){
			return $sorted;
		}
		else {
			return false; 
		}
	}
	/**
	*
	* @param string $type
	* @return array
	*/
	public function getItemsByType($type){
		if (in_array($type, ElectronicItem::$types)){
			$callback = function($item) use ($type){
				return $item->getType() == $type;
			};
			$items = array_filter($this->items, $callback);
            return $items;
		}
	}
}

class ElectronicItem
{
	/**
	* @var float
	*/
	public $price;

	/**
	* @var string
	*/
	private $type;
	public $wired;

	const ELECTRONIC_ITEM_TELEVISION = 'television';
	const ELECTRONIC_ITEM_CONSOLE = 'console';
	const ELECTRONIC_ITEM_MICROWAVE = 'microwave';

	static $types = array(self::ELECTRONIC_ITEM_CONSOLE,
		self::ELECTRONIC_ITEM_MICROWAVE, self::ELECTRONIC_ITEM_TELEVISION);

	private $addOns = array();

	function getPrice(){
		return $this->price;
	}
	function getType(){
		return $this->type;
	}
	function getWired(){
		return $this->wired;
	}
	function setPrice($price){
		$this->price = $price;
	}
	function setType($type){
		$this->type = $type;
	}
	function setWired($wired){
		$this->wired = $wired;
	}
}


class Television extends ElectronicItem
{
	private $upperLimit = PHP_INT_MAX;

	function __construct(array $items) {
		$this->addOns = $items;
		$itemType = 'television';
        $this->setType($itemType);
    }
	
	public function maxExtras(){
		return ($addOns.count() < $upperLimit);
	}

	public function add(Controller $addOn){
		if ($this -> maxExtras()){
			array_push($addOns, $addOn);
			return true;
		}
		return false;
	}
}

class Console extends ElectronicItem
{
	private $upperLimit = 4;

	function __construct(array $items) {
		$this->addOns = $items;
		$itemType = 'console';
        $this->setType($itemType);
	}
	
	public function maxExtras(){
		return ($addOns.count() < $upperLimit);
	}
	public function add(Controller $addOn){
		if ($this -> maxExtras()){
			array_push($addOns, $addOn);
			return true;
		}
		return false;
	}
    
}

class Microwave extends ElectronicItem
{
	private $upperLimit = 0;

	function __construct(array $items) {
        $this->addOns = $items;
        $itemType = "microwave";
        $this->setType($itemType);
	}
	
	public function maxExtras(){
		return ($addOns.count() < $upperLimit);
	}
	public function add(Controller $addOn){
		if ($this -> maxExtras()){
			array_push($addOns, $addOn);
			return true;
		}
		return false;
	}
}

class Controller extends ElectronicItem
{
	private $upperLimit = 0;

	function __construct($wired) {
        $this->setWired($wired);
        $itemType = 'controller';
        $this->setType($itemType);
	}
	
	public function maxExtras(){
		return ($addOns.count() < $upperLimit);
	}
	public function add(Controller $addOn){
		if ($this -> maxExtras()){
			array_push($addOns, $addOn);
			return true;
		}
		return false;
	}
}




// Set up the console and four controllers
$consoleCtrl1 = new Controller(true);
$consoleCtrl2 = new Controller(true);
$consoleCtrl3 = new Controller(false);
$consoleCtrl4 = new Controller(false);

$consoleAdds = array( $consoleCtrl1, $consoleCtrl2, $consoleCtrl3, $consoleCtrl4 );
$consl = new Console($consoleAdds);
$consl->setPrice('800');

// Set up TV1 and two controllers
$tv1Ctrl1 = new Controller(false);
$tv1Ctrl2 = new Controller(false);

$tv1Adds = array( $tv1Ctrl1, $tv1Ctrl2);
$tv1 = new Television($tv1Adds);
$tv1->setPrice(500);

// Set up TV2 and one controllers
$tv2Ctrl1 = new Controller(false);

$tv2Adds = array( $tv2Ctrl1);
$tv2 = new Television($tv2Adds);
$tv2->setPrice(600);

// Set up microwave
$microwv = new Microwave(array());
$microwv -> setPrice(200);


// Set up the buy list
$buyList = array( $consl, $tv1, $tv2, $microwv);
$person = new ElectronicItems($buyList);

// Q1
$sortedList = $person -> getSortedItems();
$priceSum = 0;
echo "Item list sorted by increasing price is as follows: \n";
foreach ($sortedList as $indiv){
	print_r ($indiv-> getType()." (".$indiv ->getPrice().") ");
    $priceSum += $indiv->getPrice();
}
echo "The total price is $priceSum \n\n";

//Q2
$filteredList = $person -> getItemsByType('console');
$consoleSum = 0;
foreach ($filteredList as $indiv){
    $consoleSum += $indiv->getPrice();
}
echo "The total price for console(s) with controllers is $consoleSum \n";


?>