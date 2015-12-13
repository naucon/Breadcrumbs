<?php
/*
 * Copyright 2008 Sven Sanzenbacher
 *
 * This file is part of the naucon package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Naucon\Breadcrumbs;

use Naucon\Breadcrumbs\BreadcrumbInterface;
use Naucon\Breadcrumbs\Exception\BreadcrumbsException;

/**
 * Breadcrumb Class
 *
 * @package     Breadcrumbs
 * @author      Sven Sanzenbacher
 */
class Breadcrumb implements BreadcrumbInterface
{
    /**
     * @var     string          breadcrumb title
     */
    protected $title;

    /**
     * @var     string          breadcrumb url
     */
    protected $url;


    /**
     * Constructor
     *
     * @param     string        breadcrumb title
     * @param     string        breadcrumb url
     */
    public function __construct($title, $url = null)
    {
        $this->setTitle($title);
        $this->setUrl($url);
    }

    /**
     * @return    string        breadcrumb title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param     string        breadcrumb title
     * @return    void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return    bool          true = has breadcrumb url
     */
    public function hasUrl()
    {
        if (!empty($this->url)) {
            return true;
        }
        return false;
    }

    /**
     * @return    string        breadcrumb url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param     string        breadcrumb url
     * @return    void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}