<?php

namespace RKW\RkwBasics\ViewHelpers;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

$currentVersion = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
if ($currentVersion < 8000000) {
    /**
     * Class RemoveSlashesViewHelper
     *
     * @author Steffen Kroggel <developer@steffenkroggel.de>
     * @copyright Rkw Kompetenzzentrum
     * @package RKW_RkwBasics
     * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
     * @deprecated
     */
    class RemoveSlashesViewHelper extends AbstractViewHelper
    {

        /**
         * Disable the escaping interceptor because otherwise the child nodes would be escaped before this view helper
         * can decode the text's entities.
         *
         * @var bool
         */
        protected $escapingInterceptorEnabled = false;

        /**
         * Returns static result
         *
         * @param string $value
         * @return string
         */
        public function render($value = null)
        {
            return static::renderStatic(
                array(
                    'value' => $value,
                ),
                $this->buildRenderChildrenClosure(),
                $this->renderingContext
            );
        }


        /**
         * Applies str_replace to the given value
         *
         * @param array $arguments
         * @param \Closure $renderChildrenClosure
         * @param \TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
         * @return string
         */
        public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, \TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface $renderingContext)
        {
            $value = $arguments['value'];
            if ($value === null) {
                $value = $renderChildrenClosure();
            }

            if (!is_string($value)) {
                return $value;
            }

            // remove slashes
            return str_replace('/', '-', $value);
        }
    }

} else {

    /**
     * Class RemoveSlashesViewHelper
     *
     * @author Steffen Kroggel <developer@steffenkroggel.de>
     * @copyright Rkw Kompetenzzentrum
     * @package RKW_RkwBasics
     * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
     */
    class RemoveSlashesViewHelper extends AbstractViewHelper
    {

        /**
         * Disable the escaping interceptor because otherwise the child nodes would be escaped before this view helper
         * can decode the text's entities.
         *
         * @var bool
         */
        protected $escapingInterceptorEnabled = false;

        /**
         * Returns static result
         *
         * @param string $value
         * @return string
         */
        public function render($value = null)
        {
            return static::renderStatic(
                array(
                    'value' => $value,
                ),
                $this->buildRenderChildrenClosure(),
                $this->renderingContext
            );
        }


        /**
         * Applies str_replace to the given value
         *
         * @param array $arguments
         * @param \Closure $renderChildrenClosure
         * @param RenderingContextInterface $renderingContext
         * @return string
         */
        public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
        {
            $value = $arguments['value'];
            if ($value === null) {
                $value = $renderChildrenClosure();
            }

            if (!is_string($value)) {
                return $value;
            }

            // remove slashes
            return str_replace('/', '-', $value);
        }

    }
}
