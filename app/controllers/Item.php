<?php
namespace app\controllers;

class Item extends \app\core\Controller{

	public function index(){

		$item = new \app\models\Item();
		$items = $item->getAll();
		
		//Gets all of the categorys for the catalog
	 	$category = new \app\models\Category();
	 	$categorys = $category->getAllCat();

		$item = new \app\models\Item();
	 	$lowStock = $item->getAllLow();

	 	$summary = new \app\models\Summary();
	 	$summary = $summary->getAll();

		$this->view('Item/index', ['item'=>$items, 'categorys'=>$categorys, 'lowStock'=>$lowStock, 'summary'=>$summary]);
	}

	#[\app\filters\Login]
	public function add(){
		if(isset($_POST['action'])){
			if($_POST['name'] == "" || $_POST['qty'] == "" || $_POST['Pprice'] == ""  || $_POST['Sprice'] == "" || $_POST['category'] == "None"){
				header('location:/Item/index?error=Please enter all info');
			} else{
				
				$category = new \app\models\Category();
	 			$category = $category->get($_POST['category']);
	 			
	 			$item = new \app\models\Item();
				$item->item_name = $_POST['name'];
				$item->qty = $_POST['qty'];
				$item->Pprice = $_POST['Pprice'];
				$item->Sprice = $_POST['Sprice'];
				$item->category_id = $category->category_id;

				$item->insert();
					header('location:/Item/index?message=Item Created');
				}
			}
	}

	#[\app\filters\Login]
	public function edit($item_id){
		$item = new \app\models\Item();
	 	$item = $item->get($item_id);
	 	
	 	$categorys = new \app\models\Category();
	 	$categorys = $categorys->getAll();


		if(isset($_POST['action'])){
			if($_POST['name'] == "" || $_POST['purchaseP'] == ""  || $_POST['sellingP'] == "" || $_POST['category'] == "None"){
				header('location:/Item/index?error=Please enter all info');
			} else{
				
				$category = new \app\models\Category();
	 			$category = $category->get($_POST['category']);
	 			
	 			
				$item->item_name = $_POST['name'];
				$item->Pprice = $_POST['purchaseP'];
				$item->Sprice = $_POST['sellingP'];
				$item->category_id = $category->category_id;

				if($_POST['qty'] != $item->qty){
					$summary = new \app\models\Summary();

					if($_POST['qtyS'] != ''){
						$summary->amount = "-" . $_POST['qtyS'];
						$summary->item_name = $_POST['name']; 
						$summary->discount = $_POST['discount']; 
						$summary->purchaseP = $_POST['purchaseP']; 
						$summary->sellingP = $_POST['sellingP']; 
						$summary->user = $_SESSION['username'];
						$summary->insert();
						$item->qty = $item->qty - $_POST['qtyS']; 
					}
					if($_POST['qtyP'] != ''){
						$summary->amount = "+" . $_POST['qtyP'];
						$summary->discount = null; 
						$summary->item_name = $_POST['name'];  
						$summary->purchaseP = $_POST['purchaseP']; 
						$summary->sellingP = $_POST['sellingP']; 
						$summary->user = $_SESSION['username'];
						$summary->insert();
						$item->qty = $_POST['qtyP'] + $item->qty; 
					}
				}

				$item->update();
				header('location:/Item/index?message=Item updated');
			}
		} else{
			$this->view('Item/edit', ['item'=>$item, 'categorys'=>$categorys]);
		}
	}

	#[\app\filters\Login]
	public function remove($item_id){
			$item = new \app\models\Item();
			$item = $item->get($item_id);

			$item->delete();
			
			header('location:/Item/index?error=Item deleted');
	}

	public function filterCategory($category_id){
		
		//If no filter is selected
		if($category_id == 'None'){
			
			//Gets all of the products for the catalog
			$item = new \app\models\Item();
	 		$items = $item->getAll();
	 		
	 		//Gets all of the categorys for the catalog
	 		$category = new \app\models\Category();
	 		$categorys = $category->getAllCat();

	 		$item = new \app\models\Item();
	 		$lowStock = $item->getAllLow();

			$this->view('Item/index', ['item'=>$items, 'categorys'=>$categorys, 'lowStock'=>$lowStock]);
		}else{
			
			//Gets all of the products for the specified category
			$item = new \app\models\Item();
			$items = $item->getAllForCat($category_id);
	 		
	 		//Gets all of the categorys for the catalog
	 		$category = new \app\models\Category();
	 		$categorys = $category->getAllCat();

	 		$item = new \app\models\Item();
	 		$lowStock = $item->getAllLow();

			$this->view('Item/index', ['item'=>$items, 'categorys'=>$categorys, 'lowStock'=>$lowStock]);
		}
	}
}