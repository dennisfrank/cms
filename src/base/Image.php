<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   https://craftcms.com/license
 */

namespace craft\base;

use craft\errors\ImageException;
use craft\helpers\Image as ImageHelper;
use yii\base\Object;

/**
 * Base Image class.
 *
 * @property boolean $isTransparent Whether the image is transparent
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  3.0
 */
abstract class Image extends Object
{
    /**
     * Returns the width of the image.
     *
     * @return integer
     */
    abstract public function getWidth();

    /**
     * Returns the height of the image.
     *
     * @return integer
     */
    abstract public function getHeight();

    /**
     * Returns the file extension.
     *
     * @return string
     */
    abstract public function getExtension();

    /**
     * Loads an image from a file system path.
     *
     * @param string $path
     *
     * @return static Self reference
     * @throws ImageException if the file cannot be loaded
     */
    abstract public function loadImage($path);

    /**
     * Crops the image to the specified coordinates.
     *
     * @param integer $x1
     * @param integer $x2
     * @param integer $y1
     * @param integer $y2
     *
     * @return static Self reference
     */
    abstract public function crop($x1, $x2, $y1, $y2);

    /**
     * Scale the image to fit within the specified size.
     *
     * @param integer      $targetWidth
     * @param integer|null $targetHeight
     * @param boolean      $scaleIfSmaller
     *
     * @return static Self reference
     */
    abstract public function scaleToFit($targetWidth, $targetHeight = null, $scaleIfSmaller = true);

    /**
     * Scale and crop image to exactly fit the specified size.
     *
     * @param integer      $targetWidth
     * @param integer|null $targetHeight
     * @param boolean      $scaleIfSmaller
     * @param string       $cropPosition
     *
     * @return static Self reference
     */
    abstract public function scaleAndCrop($targetWidth, $targetHeight = null, $scaleIfSmaller = true, $cropPosition = 'center-center');

    /**
     * Resizes the image.
     *
     * @param integer      $targetWidth  The target width
     * @param integer|null $targetHeight The target height. Defaults to $targetWidth if omitted, creating a square.
     *
     * @return static Self reference
     */
    abstract public function resize($targetWidth, $targetHeight = null);

    /**
     * Saves the image to the target path.
     *
     * @param string  $targetPath
     * @param boolean $autoQuality
     *
     * @return boolean
     * @throws ImageException if the image cannot be saved.
     */
    abstract public function saveAs($targetPath, $autoQuality = false);

    /**
     * Returns whether the image is transparent.
     *
     * @return boolean
     */
    abstract public function getIsTransparent();

    // Protected Methods
    // =========================================================================

    /**
     * Normalizes the given dimensions.  If width or height is set to 'AUTO', we calculate the missing dimension.
     *
     * @param integer|string|null $width
     * @param integer|string|null $height
     */
    protected function normalizeDimensions(&$width, &$height)
    {
        // See if $width is in "XxY" format
        if (preg_match('/^([\d]+|AUTO)x([\d]+|AUTO)/', $width, $matches)) {
            $width = $matches[1] !== 'AUTO' ? (int)$matches[1] : null;
            $height = $matches[2] !== 'AUTO' ? (int)$matches[2] : null;
        }

        if (!$height || !$width) {
            list($width, $height) = ImageHelper::calculateMissingDimension($width, $height, $this->getWidth(), $this->getHeight());
        }
    }
}
