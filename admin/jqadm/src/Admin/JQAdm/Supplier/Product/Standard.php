<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2021
 * @package Admin
 * @subpackage JQAdm
 */


namespace Aimeos\Admin\JQAdm\Supplier\Product;

sprintf( 'product' ); // for translation


/**
 * Default implementation of supplier product JQAdm client.
 *
 * @package Admin
 * @subpackage JQAdm
 */
class Standard
	extends \Aimeos\Admin\JQAdm\Common\Admin\Factory\Base
	implements \Aimeos\Admin\JQAdm\Common\Admin\Factory\Iface
{
	/** admin/jqadm/supplier/product/name
	 * Name of the product subpart used by the JQAdm supplier implementation
	 *
	 * Use "Myname" if your class is named "\Aimeos\Admin\Jqadm\Supplier\Product\Myname".
	 * The name is case-sensitive and you should avoid camel case names like "MyName".
	 *
	 * @param string Last part of the JQAdm class name
	 * @since 2017.10
	 * @category Developer
	 */


	/**
	 * Adds the required data used in the attribute template
	 *
	 * @param \Aimeos\MW\View\Iface $view View object
	 * @return \Aimeos\MW\View\Iface View object with assigned parameters
	 */
	public function data( \Aimeos\MW\View\Iface $view ) : \Aimeos\MW\View\Iface
	{
		$manager = \Aimeos\MShop::create( $this->context(), 'supplier/lists/type' );

		$search = $manager->filter( true )->slice( 0, 0x7fffffff );
		$search->setConditions( $search->compare( '==', 'supplier.lists.type.domain', 'product' ) );
		$search->setSortations( [$search->sort( '+', 'supplier.lists.type.position' )] );

		$view->productListTypes = $manager->search( $search );

		return $view;
	}


	/**
	 * Copies a resource
	 *
	 * @return string|null HTML output
	 */
	public function copy() : ?string
	{
		$view = $this->object()->data( $this->view() );
		$view->productBody = parent::copy();

		return $this->render( $view );
	}


	/**
	 * Creates a new resource
	 *
	 * @return string|null HTML output
	 */
	public function create() : ?string
	{
		$view = $this->object()->data( $this->view() );
		$view->productBody = parent::create();

		return $this->render( $view );
	}


	/**
	 * Returns a single resource
	 *
	 * @return string|null HTML output
	 */
	public function get() : ?string
	{
		$view = $this->object()->data( $this->view() );

		$total = 0;
		$params = $this->storeFilter( $view->param( 'sp', [] ), 'supplierproduct' );
		$listItems = $this->getListItems( $view->item, $params, $total );

		$view->productItems = $this->getProductItems( $listItems );
		$view->productData = $this->toArray( $listItems );
		$view->productBody = parent::search();
		$view->productTotal = $total;

		return $this->render( $view );
	}


	/**
	 * Saves the data
	 *
	 * @return string|null HTML output
	 */
	public function save() : ?string
	{
		$view = $this->view();

		$manager = \Aimeos\MShop::create( $this->context(), 'supplier/lists' );
		$manager->begin();

		try
		{
			$this->storeFilter( $view->param( 'sp', [] ), 'supplierproduct' );
			$this->fromArray( $view->item, $view->param( 'product', [] ) );
			$view->productBody = parent::save();

			$manager->commit();
		}
		catch( \Exception $e )
		{
			$manager->rollback();
			throw $e;
		}

		return null;
	}


	/**
	 * Returns the sub-client given by its name.
	 *
	 * @param string $type Name of the client type
	 * @param string|null $name Name of the sub-client (Default if null)
	 * @return \Aimeos\Admin\JQAdm\Iface Sub-client object
	 */
	public function getSubClient( string $type, string $name = null ) : \Aimeos\Admin\JQAdm\Iface
	{
		/** admin/jqadm/supplier/product/decorators/excludes
		 * Excludes decorators added by the "common" option from the supplier JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to remove a decorator added via
		 * "admin/jqadm/common/decorators/default" before they are wrapped
		 * around the JQAdm client.
		 *
		 *  admin/jqadm/supplier/product/decorators/excludes = array( 'decorator1' )
		 *
		 * This would remove the decorator named "decorator1" from the list of
		 * common decorators ("\Aimeos\Admin\JQAdm\Common\Decorator\*") added via
		 * "admin/jqadm/common/decorators/default" to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2017.07
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/supplier/product/decorators/global
		 * @see admin/jqadm/supplier/product/decorators/local
		 */

		/** admin/jqadm/supplier/product/decorators/global
		 * Adds a list of globally available decorators only to the supplier JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap global decorators
		 * ("\Aimeos\Admin\JQAdm\Common\Decorator\*") around the JQAdm client.
		 *
		 *  admin/jqadm/supplier/product/decorators/global = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "\Aimeos\Admin\JQAdm\Common\Decorator\Decorator1" only to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2017.07
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/supplier/product/decorators/excludes
		 * @see admin/jqadm/supplier/product/decorators/local
		 */

		/** admin/jqadm/supplier/product/decorators/local
		 * Adds a list of local decorators only to the supplier JQAdm client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap local decorators
		 * ("\Aimeos\Admin\JQAdm\Supplier\Decorator\*") around the JQAdm client.
		 *
		 *  admin/jqadm/supplier/product/decorators/local = array( 'decorator2' )
		 *
		 * This would add the decorator named "decorator2" defined by
		 * "\Aimeos\Admin\JQAdm\Supplier\Decorator\Decorator2" only to the JQAdm client.
		 *
		 * @param array List of decorator names
		 * @since 2017.07
		 * @category Developer
		 * @see admin/jqadm/common/decorators/default
		 * @see admin/jqadm/supplier/product/decorators/excludes
		 * @see admin/jqadm/supplier/product/decorators/global
		 */
		return $this->createSubClient( 'supplier/product/' . $type, $name );
	}


	/**
	 * Returns the supplier list items referencing the products
	 *
	 * @param \Aimeos\MShop\Supplier\Item\Iface $item Supplier item object
	 * @param array $params Associative list of GET/POST parameters
	 * @param integer $total Value/result parameter that will contain the item total afterwards
	 * @return \Aimeos\Map Supplier list items implementing \Aimeos\MShop\Common\Item\List\Iface referencing the products
	 */
	protected function getListItems( \Aimeos\MShop\Supplier\Item\Iface $item, array $params = [], &$total = null ) : \Aimeos\Map
	{
		$manager = \Aimeos\MShop::create( $this->context(), 'supplier/lists' );

		$search = $manager->filter();
		$search->setSortations( [
			$search->sort( '+', 'supplier.lists.position' ),
			$search->sort( '+', 'supplier.lists.refid' )
		] );

		$search = $this->initCriteria( $search, $params );
		$expr = [
			$search->getConditions(),
			$search->compare( '==', 'supplier.lists.parentid', $item->getId() ),
			$search->compare( '==', 'supplier.lists.domain', 'product' ),
		];
		$search->setConditions( $search->and( $expr ) );

		return $manager->search( $search, [], $total );
	}


	/**
	 * Returns the product items referenced by the given list items
	 *
	 * @param \Aimeos\Map $listItems Supplier list items implementing \Aimeos\MShop\Common\Item\List\Iface referencing the products
	 * @return \Aimeos\Map List of product IDs as keys and items implementing \Aimeos\MShop\Product\Item\Iface
	 */
	protected function getProductItems( \Aimeos\Map $listItems ) : \Aimeos\Map
	{
		$list = [];

		foreach( $listItems as $listItem ) {
			$list[] = $listItem->getRefId();
		}

		$manager = \Aimeos\MShop::create( $this->context(), 'product' );

		$search = $manager->filter()->slice( 0, count( $list ) );
		$search->setConditions( $search->compare( '==', 'product.id', $list ) );

		return $manager->search( $search );
	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of JQAdm client names
	 */
	protected function getSubClientNames() : array
	{
		/** admin/jqadm/supplier/product/subparts
		 * List of JQAdm sub-clients rendered within the supplier product section
		 *
		 * The output of the frontend is composed of the code generated by the JQAdm
		 * clients. Each JQAdm client can consist of serveral (or none) sub-clients
		 * that are responsible for rendering certain sub-parts of the output. The
		 * sub-clients can contain JQAdm clients themselves and therefore a
		 * hierarchical tree of JQAdm clients is composed. Each JQAdm client creates
		 * the output that is placed inside the container of its parent.
		 *
		 * At first, always the JQAdm code generated by the parent is printed, then
		 * the JQAdm code of its sub-clients. The product of the JQAdm sub-clients
		 * determines the product of the output of these sub-clients inside the parent
		 * container. If the configured list of clients is
		 *
		 *  array( "subclient1", "subclient2" )
		 *
		 * you can easily change the product of the output by reproducting the subparts:
		 *
		 *  admin/jqadm/<clients>/subparts = array( "subclient1", "subclient2" )
		 *
		 * You can also remove one or more parts if they shouldn't be rendered:
		 *
		 *  admin/jqadm/<clients>/subparts = array( "subclient1" )
		 *
		 * As the clients only generates structural JQAdm, the layout defined via CSS
		 * should support adding, removing or reproducting content by a fluid like
		 * design.
		 *
		 * @param array List of sub-client names
		 * @since 2017.07
		 * @category Developer
		 */
		return $this->context()->config()->get( 'admin/jqadm/supplier/product/subparts', [] );
	}


	/**
	 * Creates new and updates existing items using the data array
	 *
	 * @param \Aimeos\MShop\Supplier\Item\Iface $item Supplier item object without referenced domain items
	 * @param array $data Data array
	 * @return \Aimeos\MShop\Service\Item\Iface Modified supplier item
	 */
	protected function fromArray( \Aimeos\MShop\Supplier\Item\Iface $item, array $data ) : \Aimeos\MShop\Supplier\Item\Iface
	{
		$listManager = \Aimeos\MShop::create( $this->context(), 'supplier/lists' );
		$listItem = $listManager->create()->setParentId( $item->getId() )->setDomain( 'product' );
		$listIds = $this->val( $data, 'supplier.lists.id', [] );

		if( !empty( $listIds ) ) {
			$listItems = $listManager->search( $listManager->filter()->add( 'supplier.lists.id', '==', $listIds ) );
		} else {
			$listItems = map();
		}

		foreach( (array) $listIds as $idx => $listid )
		{
			$litem = $listItems->get( $listid ) ?: clone $listItem;

			if( isset( $data['supplier.lists.refid'][$idx] ) ) {
				$litem->setRefId( $this->val( $data, 'supplier.lists.refid/' . $idx ) );
			}

			if( isset( $data['supplier.lists.status'][$idx] ) ) {
				$litem->setStatus( (int) $this->val( $data, 'supplier.lists.status/' . $idx ) );
			}

			if( isset( $data['supplier.lists.type'][$idx] ) ) {
				$litem->setType( $this->val( $data, 'supplier.lists.type/' . $idx ) );
			}

			if( isset( $data['supplier.lists.position'][$idx] ) ) {
				$litem->setPosition( (int) $this->val( $data, 'supplier.lists.position/' . $idx ) );
			}

			if( isset( $data['supplier.lists.datestart'][$idx] ) ) {
				$litem->setDateStart( $this->val( $data, 'supplier.lists.datestart/' . $idx ) );
			}

			if( isset( $data['supplier.lists.dateend'][$idx] ) ) {
				$litem->setDateEnd( $this->val( $data, 'supplier.lists.dateend/' . $idx ) );
			}

			if( isset( $data['supplier.lists.config'][$idx] )
				&& ( $conf = json_decode( $this->val( $data, 'supplier.lists.config/' . $idx, '' ), true ) ) !== null
			) {
				$litem->setConfig( $conf );
			}

			if( $litem->getId() === null && isset( $data['config'][$idx]['key'] ) )
			{
				$conf = [];

				foreach( (array) $data['config'][$idx]['key'] as $pos => $key )
				{
					if( trim( $key ) !== '' && isset( $data['config'][$idx]['val'][$pos] ) ) {
						$conf[$key] = $data['config'][$idx]['val'][$pos];
					}
				}

				$litem->setConfig( $conf );
			}

			$listManager->save( $litem, false );
		}

		return $item;
	}


	/**
	 * Constructs the data array for the view from the given item
	 *
	 * @param \Aimeos\Map $listItems Supplier list items implementing \Aimeos\MShop\Common\Item\Lists\Iface and referencing the products
	 * @return string[] Multi-dimensional associative list of item data
	 */
	protected function toArray( \Aimeos\Map $listItems )
	{
		$data = [];

		foreach( $listItems as $listItem )
		{
			foreach( $listItem->toArray( true ) as $key => $value ) {
				$data[$key][] = $value;
			}
		}

		return $data;
	}


	/**
	 * Returns the rendered template including the view data
	 *
	 * @param \Aimeos\MW\View\Iface $view View object with data assigned
	 * @return string HTML output
	 */
	protected function render( \Aimeos\MW\View\Iface $view ) : string
	{
		/** admin/jqadm/supplier/product/template-item
		 * Relative path to the HTML body template of the product subpart for suppliers.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the result shown in the body of the frontend. The
		 * configuration string is the path to the template file relative
		 * to the templates directory (usually in admin/jqadm/templates).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "default" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "default"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating the HTML code
		 * @since 2016.04
		 * @category Developer
		 */
		$tplconf = 'admin/jqadm/supplier/product/template-item';
		$default = 'supplier/item-product-standard';

		return $view->render( $view->config( $tplconf, $default ) );
	}
}
