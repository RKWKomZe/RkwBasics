<?php
namespace RKW\RkwBasics\XClasses\Core\Resource;

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

/**
 * Override default .htaccess-file
 */
class ResourceCompressor extends \TYPO3\CMS\Core\Resource\ResourceCompressor
{

    /**
     * @var string
     */
    protected $htaccessTemplate = '<FilesMatch "\\.(js|css)(\\.gzip)?$">
	<IfModule mod_expires.c>
		ExpiresActive on
		ExpiresDefault "access plus 365 days"
	</IfModule>
	FileETag MTime Size
</FilesMatch>';

}
