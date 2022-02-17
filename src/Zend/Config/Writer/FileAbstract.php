<?php
/**
 * Zend Framework.
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 *
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

// require_once "Zend/Config/Writer.php";

/**
 * Abstract File Writer.
 *
 * @category   Zend
 *
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 *
 * @version    $Id$
 */
class Zend_Config_Writer_FileAbstract extends Zend_Config_Writer
{
    /**
     * Filename to write to.
     *
     * @var string
     */
    protected $_filename = null;

    /**
     * Wether to exclusively lock the file or not.
     *
     * @var bool
     */
    protected $_exclusiveLock = false;

    /**
     * Set the target filename.
     *
     * @param string $filename
     *
     * @return Zend_Config_Writer_Array
     */
    public function setFilename($filename)
    {
        $this->_filename = $filename;

        return $this;
    }

    /**
     * Set wether to exclusively lock the file or not.
     *
     * @param bool $exclusiveLock
     *
     * @return Zend_Config_Writer_Array
     */
    public function setExclusiveLock($exclusiveLock)
    {
        $this->_exclusiveLock = $exclusiveLock;

        return $this;
    }

    /**
     * Write configuration to file.
     *
     * @param string      $filename
     * @param Zend_Config $config
     * @param bool        $exclusiveLock
     */
    public function write($filename = null, Zend_Config $config = null, $exclusiveLock = null)
    {
        if (null !== $filename) {
            $this->setFilename($filename);
        }

        if (null !== $config) {
            $this->setConfig($config);
        }

        if (null !== $exclusiveLock) {
            $this->setExclusiveLock($exclusiveLock);
        }

        if (null === $this->_filename) {
            // require_once 'Zend/Config/Exception.php';
            throw new Zend_Config_Exception('No filename was set');
        }

        if (null === $this->_config) {
            // require_once 'Zend/Config/Exception.php';
            throw new Zend_Config_Exception('No config was set');
        }

        $configString = $this->render();

        $flags = 0;

        if ($this->_exclusiveLock) {
            $flags |= LOCK_EX;
        }

        $result = @file_put_contents($this->_filename, $configString, $flags);

        if (false === $result) {
            // require_once 'Zend/Config/Exception.php';
            throw new Zend_Config_Exception('Could not write to file "'.$this->_filename.'"');
        }
    }

    /**
     * Render a Zend_Config into a config file string.
     *
     * @since 1.10
     *
     * @todo For 2.0 this should be redone into an abstract method.
     *
     * @return string
     */
    public function render()
    {
        return '';
    }
}
