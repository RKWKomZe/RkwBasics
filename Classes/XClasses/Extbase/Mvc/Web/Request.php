<?php
namespace RKW\RkwBasics\XClasses\Extbase\Mvc\Web;

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

use TYPO3\CMS\Extbase\Mvc\Web\ReferringRequest;

/**
 * Represents a web request.
 *
 * @api
 */
class Request extends \TYPO3\CMS\Extbase\Mvc\Web\Request
{


    /**
     * Get a freshly built request object pointing to the Referrer.
     *
     * @return ReferringRequest the referring request, or null if no referrer found
     * @throws \TYPO3\CMS\Extbase\Security\Exception\InvalidArgumentForHashGenerationException if the given string is not well-formatted
     * @throws \TYPO3\CMS\Extbase\Security\Exception\InvalidHashException if the hash did not fit to the data.
     */
    public function getReferringRequest()
    {
        if (isset($this->internalArguments['__referrer']['@request'])) {
            $referrerArray = unserialize($this->hashService->validateAndStripHmac($this->internalArguments['__referrer']['@request']), ['allowed_classes' => false]);
            $arguments = [];
            if (isset($this->internalArguments['__referrer']['arguments'])) {
                // This case is kept for compatibility in 7.6 and 6.2, but will be removed in 8
                $arguments = unserialize(base64_decode($this->hashService->validateAndStripHmac($this->internalArguments['__referrer']['arguments'])));
            }
            $referringRequest = new ReferringRequest();
            $referringRequest->setArguments(array_replace_recursive($arguments, $referrerArray));
            return $referringRequest;
        }
        return null;
    }
}
