<?php
namespace RKW\RkwBasics\XClasses\Validation\Validator;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012-2018 Stanislas Rolland <typo3@sjbr.ca>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use SJBR\SrFreecap\Domain\Repository\WordRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Captcha validator
 */
class CaptchaValidator extends \SJBR\SrFreecap\Validation\Validator\CaptchaValidator
{

	/**
     * (added by MF)
     * JUST OVERRIDE "sr_freecap" TO "srFreecap" TO MAKE TYPOSCRIPT TRANSLATION POSSIBLE IN TYPO3 8.7
     *
     *
	 * Check the word that was entered against the hashed value
	 * Returns true, if the given property ($word) matches the session captcha value.
	 *
	 * @param string $word: the word that was entered and should be validated
	 * @return boolean true, if the word entered matches the hash value, false if an error occured
	 */
	public function isValid($word)
	{
		$isValid = false;
		// This validator needs a frontend user session
		if (is_object($GLOBALS ['TSFE']) && isset($GLOBALS ['TSFE']->fe_user)) {
			// Get session data
			$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
			$wordRepository = $objectManager->get(WordRepository::class);
			$wordObject = $wordRepository->getWord();
			$wordHash = $wordObject->getWordHash();
			// Check the word hash against the stored hash value
			if (!empty($wordHash) && !empty($word)) {
				if ($wordObject->getHashFunction() == 'md5') {
					// All freeCap words are lowercase.
					// font #4 looks uppercase, but trust me, it's not...
					if (md5(strtolower(utf8_decode($word))) == $wordHash) {
						// Reset freeCap session vars
						// Cannot stress enough how important it is to do this
						// Defeats re-use of known image with spoofed session id
						$wordRepository->cleanUpWord();
						$isValid = true;
					}
				}
			}
		} else {
			$isValid = empty($word);
		}
		if (!$isValid) {
			// Please enter the word or number as it appears in the image. The entered value was incorrect.
			$this->addError(
				$this->translateErrorMessage(
					'9221561048',
					'srFreecap'
				),
				9221561048
			);
		}
		return $isValid;
	}
}
