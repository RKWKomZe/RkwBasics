<?php

namespace RKW\RkwBasics\Domain\Repository;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

/**
 * ContentRepository
 *
 * The "findFlexformDataByUid"-function is needed several times. Initially created in the RkwRelated, is it also used
 * in the RkwTools extension, where we also need to fetch flexform data in AJAX context
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ContentRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @return void
     */
    public function initializeObject(): void
    {
        $this->defaultQuerySettings = $this->objectManager->get(Typo3QuerySettings::class);
        $this->defaultQuerySettings->setRespectStoragePage(false);
        $this->defaultQuerySettings->setRespectSysLanguage(false);
    }


    /**
     * fetchFlexFormDataByUid
     *
     * To integrate it directly in your settings:
     * -----
     *  foreach ($this->contentRepository->fetchFlexFormDataByUid(intval($this->configurationManager->getContentObject()->data['uid']), $this->request->getPluginName(), $this->extensionName) as $settingKey => $settingValue) {
     *		$this->settings[str_replace('settings.', '', $settingKey)] = $settingValue;
     *	}
     * -----
     *
     * @param int $ttContentUid
     * @param string $pluginName
     * @param string $extensionName
     * @return array
     * @deprecated This function is is deprecated and will be removed soon. Use Madj2k\AjaxApi\Domain\Repository\ContentRepository::fetchFlexFormDataByUid instead.
     */
    public function fetchFlexFormDataByUid(int $ttContentUid, string $pluginName, string $extensionName): array
    {

        trigger_error(
            'This method "' . __METHOD__ . '" is deprecated and will be removed soon. Do not use it anymore.',
            E_USER_DEPRECATED
        );

        $query = $this->createQuery();
        $query->statement('SELECT pi_flexform from tt_content where list_type="' . strtolower($extensionName) . '_' . strtolower($pluginName) . '" and uid = ' . $ttContentUid);
        $ttContent = $query->execute(true);
        $flexFormData = array();
        if (is_array($ttContent)) {

            $xml = simplexml_load_string($ttContent[0]['pi_flexform']);
            $flexFormData['uid'] = $ttContentUid;

            if (
                (isset($xml))
                && (isset($xml->data))
                && (is_object($xml->data->sheet))
            ) {
                foreach ($xml->data->sheet as $sheet) {
                    foreach ($sheet->language->field as $field) {
                        $flexFormData[str_replace('settings.flexform.', '', (string)$field->attributes())] = (string)$field->value;
                    }
                }
            }
        }

        return $flexFormData;
    }
}
