<?php
/*
 * Copyright 2008 Sven Sanzenbacher
 *
 * This file is part of the naucon package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Naucon\Breadcrumbs\Handler;

use Naucon\Breadcrumbs\Breadcrumb;
use Naucon\Breadcrumbs\BreadcrumbInterface;
use Naucon\Breadcrumbs\BreadcrumbCollection;

/**
 * Breadcrumb Handler Session Class
 *
 * @package     Breadcrumbs
 * @author      Sven Sanzenbacher
 */
class BreadcrumbHandlerSession extends BreadcrumbHandlerAbstract
{
    /**
     * @var      string
     */
    protected $sessionNamespace = null;


    /**
     * Constructor
     *
     * @param    string     $namespace          session namespace
     */
    public function __construct($namespace = '__NcBreadcrumbStorage')
    {
        $this->setSessionNamespace($namespace);
    }


    /**
     * @return    string                        session namespace
     */
    public function getSessionNamespace()
    {
        return $this->sessionNamespace;
    }

    /**
     * @param     string        $namespace      session namespace
     * @return    void
     */
    public function setSessionNamespace($namespace)
    {
        $this->sessionNamespace = $namespace;
    }

    /**
     * @access    protected
     * @return    BreadcrumbCollection
     */
    protected function getBreadcrumbCollection()
    {
        if (is_null($this->breadcrumbCollection)) {
            $this->breadcrumbCollection = new BreadcrumbCollection();

            if (isset($_SESSION[$this->getSessionNamespace()])) {
                foreach ($_SESSION[$this->getSessionNamespace()] as $sessionEntry) {
                    if (isset($sessionEntry['title'])) {
                        $this->getBreadcrumbCollection()->add(new Breadcrumb($sessionEntry['title'], (isset($sessionEntry['url'])) ? $sessionEntry['url'] : null));
                    }
                }
            }
        }
        return $this->breadcrumbCollection;
    }

    /**
     * add breadcrumb
     *
     * @param       BreadcrumbInterface     $breadcrumb
     * @return      void
     */
    public function add(BreadcrumbInterface $breadcrumb)
    {
        $this->getBreadcrumbCollection()->add($breadcrumb);

        $_SESSION[$this->getSessionNamespace()][] = array('title' => $breadcrumb->getTitle(), 'url' => $breadcrumb->getUrl());
    }

    /**
     * clear breadcrumb
     *
     * @return      void
     */
    public function clear()
    {
        $_SESSION[$this->getSessionNamespace()] = array();

        $this->getBreadcrumbCollection()->clear();
    }
}