<?php
/*
 * Copyright 2008 Sven Sanzenbacher
 *
 * This file is part of the naucon package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Naucon\Breadcrumbs\Helper;

use Naucon\Breadcrumbs\BreadcrumbsInterface;
use Naucon\Breadcrumbs\BreadcrumbInterface;
use Naucon\Breadcrumbs\Helper\Exception\BreadcrumbsHelperException;

/**
 * Abstract Breadcrumbs Helper Class
 *
 * @package     Breadcrumbs
 * @subpackage  Helper
 * @author      Sven Sanzenbacher
 */
abstract class BreadcrumbsHelperAbstract
{
    /**
     * @var BreadcrumbsInterface
     */
    protected $breadcrumbs;

    /**
     * Constructor
     *
     * @param	BreadcrumbsInterface
     */
    public function __construct(BreadcrumbsInterface $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }


    /**
     * @return      BreadcrumbsInterface
     */
    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }

    /**
     * @abstract
     * @return      string
     */
    abstract public function render();
}