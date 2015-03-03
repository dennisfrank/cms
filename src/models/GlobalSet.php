<?php
/**
 * @link http://buildwithcraft.com/
 * @copyright Copyright (c) 2013 Pixel & Tonic, Inc.
 * @license http://buildwithcraft.com/license
 */

namespace craft\app\models;

use craft\app\base\FieldLayoutTrait;
use craft\app\enums\AttributeType;
use craft\app\enums\ElementType;
use craft\app\helpers\UrlHelper;

/**
 * GlobalSet model class.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 3.0
 */
class GlobalSet extends BaseElementModel
{
	// Traits
	// =========================================================================

	use FieldLayoutTrait;

	// Properties
	// =========================================================================

	/**
	 * @var The element type that global sets' field layouts should be associated with.
	 */
	private $_fieldLayoutElementType = ElementType::GlobalSet;

	/**
	 * @var string
	 */
	protected $elementType = ElementType::GlobalSet;

	// Public Methods
	// =========================================================================

	/**
	 * Use the global set's name as its string representation.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->name;
	}

	/**
	 * @inheritDoc BaseElementModel::getCpEditUrl()
	 *
	 * @return string|false
	 */
	public function getCpEditUrl()
	{
		return UrlHelper::getCpUrl('globals/'.$this->handle);
	}

	// Protected Methods
	// =========================================================================

	/**
	 * @inheritDoc Model::defineAttributes()
	 *
	 * @return array
	 */
	protected function defineAttributes()
	{
		return array_merge(parent::defineAttributes(), [
			'name'          => AttributeType::Name,
			'handle'        => AttributeType::Handle,
			'fieldLayoutId' => AttributeType::Number,
		]);
	}
}
