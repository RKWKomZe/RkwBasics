<?php

namespace RKW\RkwBasics\Resource;

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
 * Class AssetFileNotFound
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class AssetFileNotFound
{

    /**
     * @var string
     */
    public static $assetPath = 'typo3temp/assets/images';


    /**
     * Searches for a file that begins with the same filename and sets a symlink to it
     *
     * @param string $url
     * @return bool|array
     */
    public static function searchFile(string $url)
    {

        $parsedUrl = parse_url($url);
        if (
            ($pathInfo = pathinfo($parsedUrl['path']))
            && ($fileName = $pathInfo['filename'])
            && ($fileExtension = $pathInfo['extension'])
            && ($fileNameParts = explode('_', $fileName))
            && ($fileNameParts[0] == 'csm')
        ){

            // use the first three parts to search for a file
            $sourceFile = $fileName . '.' . $fileExtension;
            $sourcePathRelative = self::$assetPath . '/' . $sourceFile;
            $sourcePathAbsolute = PATH_site . $sourcePathRelative;
            $searchPattern = $fileNameParts[0] . '_' . $fileNameParts[1] . '_' . $fileNameParts[2];

            // check if file exists
            if (file_exists($sourcePathAbsolute)) {
                return [
                    'absolutePath' => $sourcePathAbsolute,
                    'relativePath' => $sourcePathRelative,
                    'file' => $sourceFile,
                    'extension' => $fileExtension,
                    'size' => filesize($sourcePathAbsolute)
                ];
            }

            // go through folder and search for pattern
            $files = scandir(PATH_site . self::$assetPath);
            foreach ($files as $dirFile) {

                // search for pattern and extension
                if (
                    (strpos($dirFile, $searchPattern) === 0)
                    && (strrpos($dirFile, $fileExtension) === (strlen($dirFile) - strlen($fileExtension)))
                )  {

                    // return file data and set symlink
                    $targetPathRelative = self::$assetPath . '/' . $dirFile;
                    $targetPathAbsolute = PATH_site . $targetPathRelative;
                    symlink($targetPathAbsolute, $sourcePathAbsolute);

                    return [
                        'absolutePath' => $targetPathAbsolute,
                        'relativePath' => $targetPathRelative,
                        'file' => $dirFile,
                        'extension' => $fileExtension,
                        'size' => filesize($targetPathAbsolute)
                    ];
                }
            }
        }

        return false;
    }

}