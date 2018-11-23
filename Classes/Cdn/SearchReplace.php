<?php

namespace RKW\RkwBasics\Cdn;

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
 * Class SearchReplace
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwBasics
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SearchReplace
{
    /**
     * @var array contains configuration
     */
    protected $config = array();

    /**
     * @var integer counter for replacements
     */
    protected $replacementCnt = 1;

    /**
     * @var integer counter for domains
     */
    protected $domainCnt = 1;

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct($config)
    {

        $this->config = $config;

        if (!is_array($this->config)) {
            $this->config = array();
        }

        // check if maxConnectionsPerDomain is set
        if (!$this->config['maxConnectionsPerDomain']) {
            $this->config['maxConnectionsPerDomain'] = 4;
        }

        // check if maximum of subdomains is defined
        if (!$this->config['maxSubdomains']) {
            $this->config['maxSubdomains'] = 10;
        }

        // set default if nothing is set
        if (!$this->config['search']) {
            $this->config['search'] = '/(href="|src="|srcset=")\/?((uploads\/media|uploads\/pics|typo3temp\/compressor|typo3temp\/GB|typo3conf\/ext|fileadmin)([^"]+))/i';
        }

        // check for SSL
        $this->config['protocol'] = 'http://';
        if (
            ($_SERVER['HTTPS'])
            || ($_SERVER['SERVER_PORT'] == '443')
        ) {
            $this->config['protocol'] = 'https://';
        }

    }

    /**
     * Adds static-domain to links and images
     *
     * @param string $prefix prefix
     * @param string $path path
     * @return string new path
     */
    public function addDomain($prefix, $path)
    {

        // check if counter has reached maximum and set new domain
        if ($this->replacementCnt > intval($this->config['maxConnectionsPerDomain'])) {
            if (($this->domainCnt + 1) <= $this->config['maxSubdomains']) {
                $this->domainCnt++;
            }
            $this->replacementCnt = 1;
        }

        // cut of leading backslash
        if (strpos($path, '/') === 0) {
            $path = substr($path, 1);
        }

        // strip protocol from domain
        $baseDomain = str_replace($this->config['protocol'], '', $this->config['baseDomain']);

        // build new subdomain
        $domain = 'static' . (intval($this->config['subdomainCountBase']) + $this->domainCnt) . '.' . $baseDomain;

        // Add one to counter
        $this->replacementCnt++;

        // add domain to url
        return $prefix . $this->config['protocol'] . $domain . '/' . $path;
        //===

    }


    /**
     * replaces paths in content
     *
     * @param string $content content to replace
     * @return string new content
     */
    public function searchReplace($content)
    {

        // Replace content
        $object = $this;
        $config = $this->config;
        $callback = function ($matches) use ($object, $config) {

            if ($config['ignoreIfContains']) {
                if (preg_match($config['ignoreIfContains'], $matches[2])) {
                    return $matches[1] . $matches[2];
                }
            }

            //===

            return $object->addDomain($matches[1], $matches[2]);
            //===
        };

        return preg_replace_callback($this->config['search'], $callback, $content);
        //===
    }


} 