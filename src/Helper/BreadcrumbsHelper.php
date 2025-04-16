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
use Naucon\Breadcrumbs\Helper\Exception\BreadcrumbsHelperException;
use Naucon\HtmlBuilder\HtmlAnchor;
use Naucon\HtmlBuilder\HtmlBuilder;
use Naucon\HtmlBuilder\HtmlListItem;
use Naucon\HtmlBuilder\HtmlListUnordered;
use Naucon\HtmlBuilder\HtmlListOrdered;
use Naucon\HtmlBuilder\HtmlDiv;
use Naucon\HtmlBuilder\HtmlSpan;
use Naucon\Utility\ArrayPath;

/**
 * Breadcrumbs Helper Class
 *
 * @package     Breadcrumbs
 * @subpackage  Helper
 * @author      Sven Sanzenbacher
 */
class BreadcrumbsHelper extends BreadcrumbsHelperAbstract
{
    /**
     * @var         string
     */
    protected $tag = null;

    /**
     * @var         string
     */
    protected $separator = '';

    /**
     * @var         bool
     */
    protected $reverse = false;

    /**
     * @var         bool
     */
    protected $skipLinks = false;

    /**
     * @var         ArrayPath
     */
    protected $_optionsPathObject = null;


    /**
     * @return      bool                    true = has tag
     */
    public function hasTag()
    {
        if (!empty($this->tag)) {
            return true;
        }
        return false;
    }

    /**
     * @return      string                    tag
     */
    public function getTag()
    {
        return $this->tag;
    }
    
    /**
     * define tag that enclosed breadcrumb
     *
     * @param       string          $tag        separator (ul,li,div,span)
     * @return      BreadcrumbsInterface
     * @throws      BreadcrumbsHelperException
     */
    public function setTag($tag)
    {
        switch ($tag) {
            case 'span':
            case 'div':
            case 'ul':
            case 'ol':
            case 'li':
                $this->tag = $tag;
                break;
            default:
                throw new BreadcrumbsHelperException('Unkown or unsupported Tag set on Breadcrumb helper.');
        }
        return $this;
    }

    /**
     * @return      bool                    true = has separator
     */
    public function hasSeparator()
    {
        if (!empty($this->separator)) {
            return true;
        }
        return false;
    }

    /**
     * @return      string                    separator
     */
    public function getSeparator()
    {
        return $this->separator;
    }
    
    /**
     * define separator between breadcrumbs
     *
     * @param       string      $separator      separator
     * @return      BreadcrumbsInterface
     */
    public function setSeparator($separator = '')
    {
        $this->separator = $separator;
        return $this;
    }

    /**
     * @return      bool                    true = lifo, false = fifo
     */
    public function isReverse()
    {
        if (!empty($this->reverse)) {
            return true;
        }
        return false;
    }

    /**
     * @return      bool                    true = lifo, false = fifo
     */
    public function getReverse()
    {
        return $this->reverse;
    }

    /**
     * define the order that the breadcrumbs is iterated
     * fifo = first in first out (default)
     * lifo = last in first out = reverse
     *
     * @param       bool        $reverse        true = lifo (default), false = fifo
     * @return      BreadcrumbsInterface
     */
    public function setReverse($reverse = true)
    {
        $this->reverse = (bool)$reverse;
        return $this;
    }

    /**
     * @return      bool                    true = skip links
     */
    public function hasSkipLinks()
    {
        return $this->skipLinks;
    }

    /**
     * skip links in render
     *
     * @param       bool        $skip       true = skip links
     * @return      BreadcrumbsInterface
     */
    public function setSkipLinks($skip = true)
    {
        $this->skipLinks = (bool)$skip;
        return $this;
    }

    /**
     * @return      ArrayPath
     */
    public function getOptionsPathObject()
    {
        if (is_null($this->_optionsPathObject)) {
            $this->_optionsPathObject = new ArrayPath();
        }
        return $this->_optionsPathObject;
    }

    /**
     * @param       array       $options
     * @return      BreadcrumbsInterface
     */
    public function setOptions(array $options = array())
    {
        $this->getOptionsPathObject()->setAll($options);
        return $this;
    }

    /**
     * @return        string                    html output
     */
    public function render()
    {
        $htmlBuilder = new HtmlBuilder();

        if ($this->isReverse()) {
            $breadcrumbIterator = $this->getBreadcrumbs()->getReverseIterator();
        } else {
            $breadcrumbIterator = $this->getBreadcrumbs()->getIterator();
        }

        $breakcrumbsItems = array();
        $i = 0;
        $lastElementIndex = count($breadcrumbIterator)-1;
        foreach ($breadcrumbIterator as $breadcrumbObject) {
            if (!$this->hasSkipLinks() && $breadcrumbObject->hasUrl()) {
                $breakcrumbInner = new HtmlAnchor($breadcrumbObject->getUrl(), $breadcrumbObject->getTitle());
            } else {
                $breakcrumbInner = $breadcrumbObject->getTitle();
            }

            switch ($this->getTag()) {
                case 'div':
                    $breadcrumbOuter = new HtmlDiv($breakcrumbInner);
                    break;
                case 'span':
                    $breadcrumbOuter = new HtmlSpan($breakcrumbInner);
                    break;
                case 'ul':
                case 'ol':
                case 'li':
                    $breadcrumbOuter = new HtmlListItem($breakcrumbInner);
                    break;
                default:
                    $breadcrumbOuter = $breakcrumbInner;
                    break;
            }

            $childElementsArr = array();
            if (is_object($breadcrumbOuter) && method_exists($breadcrumbOuter, 'setAttribute')) {
                if ($breadcrumbOuter->hasChildElements()) {
                    $childElementCollection = $breadcrumbOuter->getChildElementCollection();
                    $childElements = $childElementCollection->toArray();
                    $childElement = $childElements[0];
                    if ($childElement->hasChildElements()) {
                        if ((!$this->isReverse() && $i == $lastElementIndex) || ($this->isReverse() && $i == 0)) {
                            $childElement->setAttribute('aria-current', 'page');
                            $childElementsArr[] = $childElement;
                            $breadcrumbOuter->setChildElements($childElementsArr);
                        }
                    } elseif (!$breadcrumbObject->hasUrl() &&
                    (!$this->isReverse() && $i == $lastElementIndex) ||
                    ($this->isReverse() && $i == 0)) {
                        $breadcrumbOuter->setAttribute('aria-current', 'page');
                    }
                }
            }
            $breakcrumbsItems[] = $breadcrumbOuter;
            $i++;
        }

        // surround breadcrumb string a container, depending on the tag
        switch ($this->getTag()) {
            case 'ol':
                $breadcrumbContainer = new HtmlListOrdered();
                $breadcrumbContainer->setChildElements($breakcrumbsItems);

                foreach ($this->getOptionsPathObject()->get() as $key => $value) {
                    // prevent, that already set attributes are overwritten by options
                    if (!$breadcrumbContainer->hasAttribute($key)) {
                        $breadcrumbContainer->setAttribute($key, $value);
                    }
                }

                return $htmlBuilder->render($breadcrumbContainer);
            case 'ul':
                $breadcrumbContainer = new HtmlListUnordered();
                $breadcrumbContainer->setChildElements($breakcrumbsItems);

                foreach ($this->getOptionsPathObject()->get() as $key => $value) {
                    // prevent, that already set attributes are overwritten by options
                    if (!$breadcrumbContainer->hasAttribute($key)) {
                        $breadcrumbContainer->setAttribute($key, $value);
                    }
                }

                return $htmlBuilder->render($breadcrumbContainer);
            default:
                // concat breadcrumb to one string
                return $breadcrumbContainerContent = implode($this->getSeparator(), $breakcrumbsItems);
        }
    }
}