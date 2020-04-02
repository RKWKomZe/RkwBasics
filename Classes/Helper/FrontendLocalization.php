<?php
namespace RKW\RkwBasics\Helper;

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
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Core\Localization\Locales;
use TYPO3\CMS\Core\Localization\LocalizationFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

$currentVersion = VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
if ($currentVersion < 8000000) {

    /**
     * Localization helper which should be used to fetch localized labels.
     *
     * We can not extend the basic class here, since the methods are used as static methods and this confuses translation-handling
     *
     * @api
     * @see \TYPO3\CMS\Extbase\Utility\LocalizationUtility, base is TYPO3 6.2
     */
    class FrontendLocalization
    {

        /**
         * Initial key of the language to use
         *
         * @var string
         */
        static protected $languageKeyInit = 'default';

        /**
         * @var string
         */
        static protected $locallangPath = 'Resources/Private/Language/';

        /**
         * Local Language content
         *
         * @var array
         */
        static protected $LOCAL_LANG = array();

        /**
         * Contains those LL keys, which have been set to (empty) in TypoScript.
         * This is necessary, as we cannot distinguish between a nonexisting
         * translation and a label that has been cleared by TS.
         * In both cases ['key'][0]['target'] is "".
         *
         * @var array
         */
        static protected $LOCAL_LANG_UNSET = array();

        /**
         * Local Language content charset for individual labels (overriding)
         *
         * @var array
         */
        static protected $LOCAL_LANG_charset = array();

        /**
         * Key of the language to use
         *
         * @var string
         */
        static protected $languageKey = 'default';

        /**
         * Pointer to alternative fall-back language to use
         *
         * @var array
         */
        static protected $alternativeLanguageKeys = array();

        /**
         * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
         */
        static protected $configurationManager = null;


        /**
         * Returns the localized label of the LOCAL_LANG key, $key.
         *
         * @author Steffen Kroggel <developer@steffenkroggel.de>
         * @param string $key The key from the LOCAL_LANG array for which to return the value.
         * @param string $extensionName The name of the extension
         * @param array  $arguments the arguments of the extension, being passed over to vsprintf
         * @param string $languageKey The intital languageKey for the translation
         * @return string|NULL The value from LOCAL_LANG or NULL if no translation was found.
         * @api
         * @todo : If vsprintf gets a malformed string, it returns FALSE! Should we throw an exception there?
         */
        static public function translate($key, $extensionName, $arguments = null, $languageKey = 'default')
        {

            self::$languageKeyInit = $languageKey;
            if (
                (!empty(self::$languageKeyInit))
                && (is_string(self::$languageKeyInit))
            ) {
                self::$languageKey = self::$languageKeyInit;
            }

            /** From here on it is an exact copy of \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate */
            $value = null;
            if (\TYPO3\CMS\Core\Utility\GeneralUtility::isFirstPartOfStr($key, 'LLL:')) {
                $value = self::translateFileReference($key);
            } else {
                self::initializeLocalization($extensionName);
                // The "from" charset of csConv() is only set for strings from TypoScript via _LOCAL_LANG
                if (!empty(self::$LOCAL_LANG[$extensionName][self::$languageKey][$key][0]['target'])
                    || isset(self::$LOCAL_LANG_UNSET[$extensionName][self::$languageKey][$key])
                ) {
                    // Local language translation for key exists
                    $value = self::$LOCAL_LANG[$extensionName][self::$languageKey][$key][0]['target'];
                    if (!empty(self::$LOCAL_LANG_charset[$extensionName][self::$languageKey][$key])) {
                        $value = self::convertCharset($value, self::$LOCAL_LANG_charset[$extensionName][self::$languageKey][$key]);
                    }
                } elseif (count(self::$alternativeLanguageKeys)) {
                    $languages = array_reverse(self::$alternativeLanguageKeys);
                    foreach ($languages as $language) {
                        if (!empty(self::$LOCAL_LANG[$extensionName][$language][$key][0]['target'])
                            || isset(self::$LOCAL_LANG_UNSET[$extensionName][$language][$key])
                        ) {
                            // Alternative language translation for key exists
                            $value = self::$LOCAL_LANG[$extensionName][$language][$key][0]['target'];
                            if (!empty(self::$LOCAL_LANG_charset[$extensionName][$language][$key])) {
                                $value = self::convertCharset($value, self::$LOCAL_LANG_charset[$extensionName][$language][$key]);
                            }
                            break;
                        }
                    }
                }
                if ($value === null && (!empty(self::$LOCAL_LANG[$extensionName]['default'][$key][0]['target'])
                        || isset(self::$LOCAL_LANG_UNSET[$extensionName]['default'][$key]))
                ) {
                    // Default language translation for key exists
                    // No charset conversion because default is English and thereby ASCII
                    $value = self::$LOCAL_LANG[$extensionName]['default'][$key][0]['target'];
                }

            }
            if (is_array($arguments) && $value !== null) {
                return vsprintf($value, $arguments);
            } else {
                return $value;
            }
        }


        /**
         * Returns the localized label of the LOCAL_LANG key, $key.
         *
         * @param string $key The language key including the path to a custom locallang file ("LLL:path:key").
         * @return string The value from LOCAL_LANG or NULL if no translation was found.
         * @see language::sL()
         * @see \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::sL()
         */
        static protected function translateFileReference($key)
        {
            if (TYPO3_MODE === 'FE') {
                $value = $GLOBALS['TSFE']->sL($key);

                return $value !== false ? $value : null;
            } elseif (is_object($GLOBALS['LANG'])) {
                $value = $GLOBALS['LANG']->sL($key);

                return $value !== '' ? $value : null;
            } else {
                return $key;
            }
        }

        /**
         * Loads local-language values by looking for a "locallang.php" (or "locallang.xml") file in the plugin resources directory
         * and if found includes it. Also locallang values set in the TypoScript property "_LOCAL_LANG" are merged onto the values
         * found in the "locallang.php" file.
         *
         * @param string $extensionName
         * @return void
         */
        static protected function initializeLocalization($extensionName)
        {
            if (isset(self::$LOCAL_LANG[$extensionName][self::$languageKey])) {
                return;
            }
            $locallangPathAndFilename = 'EXT:' . \TYPO3\CMS\Core\Utility\GeneralUtility::camelCaseToLowerCaseUnderscored($extensionName) . '/' . self::$locallangPath . 'locallang.xml';
            self::setLanguageKeys();
            $renderCharset = TYPO3_MODE === 'FE' ? $GLOBALS['TSFE']->renderCharset : $GLOBALS['LANG']->charSet;
            self::$LOCAL_LANG[$extensionName] = \TYPO3\CMS\Core\Utility\GeneralUtility::readLLfile($locallangPathAndFilename, self::$languageKey, $renderCharset);
            foreach (self::$alternativeLanguageKeys as $language) {
                $tempLL = \TYPO3\CMS\Core\Utility\GeneralUtility::readLLfile($locallangPathAndFilename, $language, $renderCharset);
                if (self::$languageKey !== 'default' && isset($tempLL[$language])) {
                    self::$LOCAL_LANG[$extensionName][$language] = $tempLL[$language];
                }
            }
            self::loadTypoScriptLabels($extensionName);
        }


        /**
         * Sets the currently active language/language_alt keys.
         * Default values are "default" for language key and "" for language_alt key.
         *
         * @author Steffen Kroggel <developer@steffenkroggel.de>
         * @return void
         */
        static protected function setLanguageKeys()
        {

            self::$languageKey = 'default';
            if (
                (!empty(self::$languageKeyInit))
                && (is_string(self::$languageKeyInit))
            ) {
                self::$languageKey = self::$languageKeyInit;
            }

            /** @var $locales \TYPO3\CMS\Core\Localization\Locales */
            $locales = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Localization\\Locales');
            self::$alternativeLanguageKeys = array();
            if (in_array(self::$languageKey, $locales->getLocales())) {
                foreach ($locales->getLocaleDependencies(self::$languageKey) as $language) {
                    self::$alternativeLanguageKeys[] = $language;
                }
            }
        }

        /**
         * Overwrites labels that are set via TypoScript.
         * TS locallang labels have to be configured like:
         * plugin.tx_myextension._LOCAL_LANG.languageKey.key = value
         *
         * @param string $extensionName
         * @return void
         */
        static protected function loadTypoScriptLabels($extensionName)
        {
            $configurationManager = static::getConfigurationManager();
            $frameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, $extensionName);
            if (!is_array($frameworkConfiguration['_LOCAL_LANG'])) {
                return;
            }
            self::$LOCAL_LANG_UNSET[$extensionName] = array();
            foreach ($frameworkConfiguration['_LOCAL_LANG'] as $languageKey => $labels) {
                if (!(is_array($labels) && isset(self::$LOCAL_LANG[$extensionName][$languageKey]))) {
                    continue;
                }
                foreach ($labels as $labelKey => $labelValue) {
                    if (is_string($labelValue)) {
                        self::$LOCAL_LANG[$extensionName][$languageKey][$labelKey][0]['target'] = $labelValue;
                        if ($labelValue === '') {
                            self::$LOCAL_LANG_UNSET[$extensionName][$languageKey][$labelKey] = '';
                        }
                        if (is_object($GLOBALS['LANG'])) {
                            self::$LOCAL_LANG_charset[$extensionName][$languageKey][$labelKey] = $GLOBALS['LANG']->csConvObj->charSetArray[$languageKey];
                        } else {
                            self::$LOCAL_LANG_charset[$extensionName][$languageKey][$labelKey] = $GLOBALS['TSFE']->csConvObj->charSetArray[$languageKey];
                        }
                    } elseif (is_array($labelValue)) {
                        $labelValue = self::flattenTypoScriptLabelArray($labelValue, $labelKey);
                        foreach ($labelValue as $key => $value) {
                            self::$LOCAL_LANG[$extensionName][$languageKey][$key][0]['target'] = $value;
                            if ($value === '') {
                                self::$LOCAL_LANG_UNSET[$extensionName][$languageKey][$key] = '';
                            }
                        }
                    }
                }
            }
        }

        /**
         * Flatten TypoScript label array; converting a hierarchical array into a flat
         * array with the keys separated by dots.
         *
         * Example Input:  array('k1' => array('subkey1' => 'val1'))
         * Example Output: array('k1.subkey1' => 'val1')
         *
         * @param array  $labelValues Hierarchical array of labels
         * @param string $parentKey the name of the parent key in the recursion; is only needed for recursion.
         * @return array flattened array of labels.
         */
        static protected function flattenTypoScriptLabelArray(array $labelValues, $parentKey = '')
        {
            $result = array();
            foreach ($labelValues as $key => $labelValue) {
                if (!empty($parentKey)) {
                    $key = $parentKey . '.' . $key;
                }
                if (is_array($labelValue)) {
                    $labelValue = self::flattenTypoScriptLabelArray($labelValue, $key);
                    $result = array_merge($result, $labelValue);
                } else {
                    $result[$key] = $labelValue;
                }
            }

            return $result;
        }

        /**
         * Converts a string from the specified character set to the current.
         * The current charset is defined by the TYPO3 mode.
         *
         * @param string $value string to be converted
         * @param string $charset The source charset
         * @return string converted string
         */
        static protected function convertCharset($value, $charset)
        {
            if (TYPO3_MODE === 'FE') {
                return $GLOBALS['TSFE']->csConv($value, $charset);
            } else {
                $convertedValue = $GLOBALS['LANG']->csConvObj->conv($value, $GLOBALS['LANG']->csConvObj->parse_charset($charset), $GLOBALS['LANG']->charSet, 1);

                return $convertedValue !== null ? $convertedValue : $value;
            }
        }

        /**
         * Returns instance of the configuration manager
         *
         * @return \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
         */
        static protected function getConfigurationManager()
        {
            if (!is_null(static::$configurationManager)) {
                return static::$configurationManager;
            }
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface');
            static::$configurationManager = $configurationManager;

            return $configurationManager;
        }
    }


} else {


    /**
     * Localization helper which should be used to fetch localized labels.
     *
     * We can not extend the basic class here, since the methods are used as static methods and this confuses translation-handling
     *
     * @api
     * @see \TYPO3\CMS\Extbase\Utility\LocalizationUtility, base is TYPO3 8.7
     */
    class FrontendLocalization
    {

        /**
         * Initial key of the language to use
         *
         * @var string
         */
        static protected $languageKeyInit = 'default';


        /**
         * @var string
         */
        protected static $locallangPath = 'Resources/Private/Language/';

        /**
         * Local Language content
         *
         * @var array
         */
        protected static $LOCAL_LANG = [];

        /**
         * Contains those LL keys, which have been set to (empty) in TypoScript.
         * This is necessary, as we cannot distinguish between a nonexisting
         * translation and a label that has been cleared by TS.
         * In both cases ['key'][0]['target'] is "".
         *
         * @var array
         */
        protected static $LOCAL_LANG_UNSET = [];

        /**
         * Key of the language to use
         *
         * @var string
         */
        protected static $languageKey = 'default';

        /**
         * Pointer to alternative fall-back language to use
         *
         * @var array
         */
        protected static $alternativeLanguageKeys = [];

        /**
         * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
         */
        protected static $configurationManager = null;

        /**
         * Returns the localized label of the LOCAL_LANG key, $key.
         *
         * @param string $key The key from the LOCAL_LANG array for which to return the value.
         * @param string|null $extensionName The name of the extension
         * @param array $arguments the arguments of the extension, being passed over to vsprintf
         * @param string $languageKey The intital languageKey for the translation
         * @return string|null The value from LOCAL_LANG or NULL if no translation was found.
         * @api
         * @todo : If vsprintf gets a malformed string, it returns FALSE! Should we throw an exception there?
         */
        public static function translate($key, $extensionName = null, $arguments = null, $languageKey = 'default')
        {
            // Edit RKW start
            self::$languageKeyInit = $languageKey;
            if (
                (!empty(self::$languageKeyInit))
                && (is_string(self::$languageKeyInit))
            ) {
                self::$languageKey = self::$languageKeyInit;
            }
            // Edit RKW end

            $value = null;
            if (GeneralUtility::isFirstPartOfStr($key, 'LLL:')) {
                $value = self::translateFileReference($key);
            } else {
                if (empty($extensionName)) {
                    throw new \InvalidArgumentException(
                        'Parameter $extensionName cannot be empty if a fully-qualified key is not specified.',
                        1498144052
                    );
                }
                self::initializeLocalization($extensionName);
                // The "from" charset of csConv() is only set for strings from TypoScript via _LOCAL_LANG
                if (!empty(self::$LOCAL_LANG[$extensionName][self::$languageKey][$key][0]['target'])
                    || isset(self::$LOCAL_LANG_UNSET[$extensionName][self::$languageKey][$key])
                ) {
                    // Local language translation for key exists
                    $value = self::$LOCAL_LANG[$extensionName][self::$languageKey][$key][0]['target'];
                } elseif (!empty(self::$alternativeLanguageKeys)) {
                    $languages = array_reverse(self::$alternativeLanguageKeys);
                    foreach ($languages as $language) {
                        if (!empty(self::$LOCAL_LANG[$extensionName][$language][$key][0]['target'])
                            || isset(self::$LOCAL_LANG_UNSET[$extensionName][$language][$key])
                        ) {
                            // Alternative language translation for key exists
                            $value = self::$LOCAL_LANG[$extensionName][$language][$key][0]['target'];
                            break;
                        }
                    }
                }
                if ($value === null && (!empty(self::$LOCAL_LANG[$extensionName]['default'][$key][0]['target'])
                        || isset(self::$LOCAL_LANG_UNSET[$extensionName]['default'][$key]))
                ) {
                    // Default language translation for key exists
                    // No charset conversion because default is English and thereby ASCII
                    $value = self::$LOCAL_LANG[$extensionName]['default'][$key][0]['target'];
                }
            }
            if (is_array($arguments) && $value !== null) {
                return vsprintf($value, $arguments);
            }
            return $value;
        }

        /**
         * Returns the localized label of the LOCAL_LANG key, $key.
         *
         * @param string $key The language key including the path to a custom locallang file ("LLL:path:key").
         * @return string The value from LOCAL_LANG or NULL if no translation was found.
         * @see language::sL()
         * @see \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController::sL()
         */
        protected static function translateFileReference($key)
        {
            if (TYPO3_MODE === 'FE') {
                $value = self::getTypoScriptFrontendController()->sL($key);
                return $value !== false ? $value : null;
            }
            if (is_object($GLOBALS['LANG'])) {
                $value = self::getLanguageService()->sL($key);
                return $value !== '' ? $value : null;
            }
            return $key;
        }

        /**
         * Loads local-language values by looking for a "locallang.xlf" (or "locallang.xml") file in the plugin resources directory and if found includes it.
         * Also locallang values set in the TypoScript property "_LOCAL_LANG" are merged onto the values found in the "locallang.xlf" file.
         *
         * @param string $extensionName
         */
        protected static function initializeLocalization($extensionName)
        {
            // Start RKW edit
            // if (isset(self::$LOCAL_LANG[$extensionName])) {
            //    return;
            //}

            if (isset(self::$LOCAL_LANG[$extensionName][self::$languageKey])) {
                return;
            }
            // End RKW edit

            $locallangPathAndFilename = 'EXT:' . GeneralUtility::camelCaseToLowerCaseUnderscored($extensionName) . '/' . self::$locallangPath . 'locallang.xlf';
            self::setLanguageKeys();

            /** @var $languageFactory LocalizationFactory */
            $languageFactory = GeneralUtility::makeInstance(LocalizationFactory::class);

            self::$LOCAL_LANG[$extensionName] = $languageFactory->getParsedData($locallangPathAndFilename, self::$languageKey, 'utf-8');
            foreach (self::$alternativeLanguageKeys as $language) {
                $tempLL = $languageFactory->getParsedData($locallangPathAndFilename, $language, 'utf-8');
                if (self::$languageKey !== 'default' && isset($tempLL[$language])) {
                    self::$LOCAL_LANG[$extensionName][$language] = $tempLL[$language];
                }
            }
            self::loadTypoScriptLabels($extensionName);
        }

        /**
         * Sets the currently active language/language_alt keys.
         * Default values are "default" for language key and "" for language_alt key.
         */
        protected static function setLanguageKeys()
        {
            self::$languageKey = 'default';
            self::$alternativeLanguageKeys = [];

            // Start RKW edit
            if (
                (!empty(self::$languageKeyInit))
                && (is_string(self::$languageKeyInit))
            ) {
                self::$languageKey = self::$languageKeyInit;
            }
            /** @var $locales \TYPO3\CMS\Core\Localization\Locales */
            $locales = GeneralUtility::makeInstance(Locales::class);
            if (in_array(self::$languageKey, $locales->getLocales())) {
                foreach ($locales->getLocaleDependencies(self::$languageKey) as $language) {
                    self::$alternativeLanguageKeys[] = $language;
                }
            }

            /*
                if (TYPO3_MODE === 'FE') {
                    if (isset(self::getTypoScriptFrontendController()->config['config']['language'])) {
                        self::$languageKey = self::getTypoScriptFrontendController()->config['config']['language'];
                        if (isset(self::getTypoScriptFrontendController()->config['config']['language_alt'])) {
                            self::$alternativeLanguageKeys[] = self::getTypoScriptFrontendController()->config['config']['language_alt'];
                        } else {
                            /** @var $locales \TYPO3\CMS\Core\Localization\Locales
                            $locales = GeneralUtility::makeInstance(Locales::class);
                            if (in_array(self::$languageKey, $locales->getLocales())) {
                                foreach ($locales->getLocaleDependencies(self::$languageKey) as $language) {
                                    self::$alternativeLanguageKeys[] = $language;
                                }
                            }
                        }
                    }
                } elseif (!empty($GLOBALS['BE_USER']->uc['lang'])) {
                    self::$languageKey = $GLOBALS['BE_USER']->uc['lang'];
                } elseif (!empty(self::getLanguageService()->lang)) {
                    self::$languageKey = self::getLanguageService()->lang;
                }
            // End RKW edit
            */
        }

        /**
         * Overwrites labels that are set via TypoScript.
         * TS locallang labels have to be configured like:
         * plugin.tx_myextension._LOCAL_LANG.languageKey.key = value
         *
         * @param string $extensionName
         */
        protected static function loadTypoScriptLabels($extensionName)
        {
            $configurationManager = static::getConfigurationManager();
            $frameworkConfiguration = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK, $extensionName);
            if (!is_array($frameworkConfiguration['_LOCAL_LANG'] ?? false)) {
                return;
            }
            self::$LOCAL_LANG_UNSET[$extensionName] = [];
            foreach ($frameworkConfiguration['_LOCAL_LANG'] as $languageKey => $labels) {
                if (!(is_array($labels) && isset(self::$LOCAL_LANG[$extensionName][$languageKey]))) {
                    continue;
                }
                foreach ($labels as $labelKey => $labelValue) {
                    if (is_string($labelValue)) {
                        self::$LOCAL_LANG[$extensionName][$languageKey][$labelKey][0]['target'] = $labelValue;
                        if ($labelValue === '') {
                            self::$LOCAL_LANG_UNSET[$extensionName][$languageKey][$labelKey] = '';
                        }
                    } elseif (is_array($labelValue)) {
                        $labelValue = self::flattenTypoScriptLabelArray($labelValue, $labelKey);
                        foreach ($labelValue as $key => $value) {
                            self::$LOCAL_LANG[$extensionName][$languageKey][$key][0]['target'] = $value;
                            if ($value === '') {
                                self::$LOCAL_LANG_UNSET[$extensionName][$languageKey][$key] = '';
                            }
                        }
                    }
                }
            }
        }

        /**
         * Flatten TypoScript label array; converting a hierarchical array into a flat
         * array with the keys separated by dots.
         *
         * Example Input:  array('k1' => array('subkey1' => 'val1'))
         * Example Output: array('k1.subkey1' => 'val1')
         *
         * @param array $labelValues Hierarchical array of labels
         * @param string $parentKey the name of the parent key in the recursion; is only needed for recursion.
         * @return array flattened array of labels.
         */
        protected static function flattenTypoScriptLabelArray(array $labelValues, $parentKey = '')
        {
            $result = [];
            foreach ($labelValues as $key => $labelValue) {
                if (!empty($parentKey)) {
                    if ($key === '_typoScriptNodeValue') {
                        $key = $parentKey;
                    } else {
                        $key = $parentKey . '.' . $key;
                    }
                }
                if (is_array($labelValue)) {
                    $labelValue = self::flattenTypoScriptLabelArray($labelValue, $key);
                    $result = array_merge($result, $labelValue);
                } else {
                    $result[$key] = $labelValue;
                }
            }
            return $result;
        }

        /**
         * Returns instance of the configuration manager
         *
         * @return \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
         */
        protected static function getConfigurationManager()
        {
            if (!is_null(static::$configurationManager)) {
                return static::$configurationManager;
            }
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $configurationManager = $objectManager->get(ConfigurationManagerInterface::class);
            static::$configurationManager = $configurationManager;
            return $configurationManager;
        }

        /**
         * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
         */
        protected static function getTypoScriptFrontendController()
        {
            return $GLOBALS['TSFE'];
        }

        /**
         * @return \TYPO3\CMS\Lang\LanguageService
         */
        protected static function getLanguageService()
        {
            return $GLOBALS['LANG'];
        }
    }
}

