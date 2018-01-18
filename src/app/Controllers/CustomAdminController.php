<?php

namespace Solunes\Product\App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Asset;

class CustomAdminController extends Controller {

	protected $request;
	protected $url;

	public function __construct(UrlGenerator $url) {
	  $this->middleware('auth');
	  $this->middleware('permission:dashboard');
	  $this->prev = $url->previous();
	  $this->module = 'admin';
	}

	public function getIndex() {
		$user = auth()->user();
		//$array['tasks'] = $user->active_product_tasks;
		$array['tasks'] = \Solunes\Product\App\ProductTask::limit(2)->get();
		$array['active_issues_products'] = \Solunes\Product\App\Product::has('active_product_issues')->with('active_product_issues')->get();
      	return view('product::list.dashboard', $array);
	}

	/* Módulo de Proyectos */

	public function allProducts() {
		$array['items'] = \Solunes\Product\App\Product::get();
      	return view('product::list.products', $array);
	}

	public function findProduct($id, $tab = 'description') {
		if($item = \Solunes\Product\App\Product::find($id)){
			$array = ['item'=>$item, 'tab'=>$tab];
      		return view('product::item.product', $array);
		} else {
			return redirect($this->prev)->with('message_error', 'Item no encontrado');
		}
	}

	public function findProductTask($id) {
		if($item = \Solunes\Product\App\ProductTask::find($id)){
			$array = ['item'=>$item];
      		return view('product::item.product-task', $array);
		} else {
			return redirect($this->prev)->with('message_error', 'Item no encontrado');
		}
	}

	public function findProjecIssue($id) {
		if($item = \Solunes\Product\App\ProductIssue::find($id)){
			$array = ['item'=>$item];
      		return view('product::item.product-issue', $array);
		} else {
			return redirect($this->prev)->with('message_error', 'Item no encontrado');
		}
	}

	public function allWikis($product_type_id = NULL, $wiki_type_id = NULL) {
		$array['product_type_id'] = $product_type_id;
		$array['wiki_type_id'] = $wiki_type_id;
		if($product_type_id&&$wiki_type_id){
			$array['items'] = \Solunes\Product\App\Wiki::where('product_type_id',$product_type_id)->where('wiki_type_id',$wiki_type_id)->get();
		} else if($product_type_id){
			$array['items'] = \Solunes\Product\App\WikiType::get();
		} else {
			$array['items'] = \Solunes\Product\App\ProductType::get();
		}
      	return view('product::list.wikis', $array);
	}

	public function findWiki($id) {
		if($item = \Solunes\Product\App\Wiki::find($id)){
			$array = ['item'=>$item];
      		return view('product::item.wiki', $array);
		} else {
			return redirect($this->prev)->with('message_error', 'Item no encontrado');
		}
	}

}