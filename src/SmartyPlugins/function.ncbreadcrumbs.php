<?php
/*
 * Copyright 2008 Sven Sanzenbacher
 *
 * This file is part of the naucon package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Smarty Form Tag Function Plugin
 * {ncbreadcrumbs from=$breadcrumbs tag='div'}
 *
 * @package		Breadcrumbs
 * @subpackage	SmartyPlugins
 * @author		Sven Sanzenbacher
 *
 * @param	array		parameters
 * @param	Smarty
 * @return	string
 */
function smarty_function_ncbreadcrumbs($params, &$smarty)
{
    $breadcrumbs = null;
    $breadcrumbSeparator = null;
    $breadcrumbReverse = null;
    $breadcrumbTag = null;
    $options = array();

    foreach ($params as $_key => $_val)
    {
        switch ($_key) {
            case 'style':
            case 'class':
            case 'id':
                $options[$_key] = (string)$_val;
                break;
            case 'from':
                $breadcrumbs = $_val;
                break;
            case 'tag':
                $breadcrumbTag = $_val;
                break;
            case 'separator':
                $breadcrumbSeparator = $_val;
                break;
            case 'reverse':
                $breadcrumbReverse = (bool)$_val;
                break;
            case 'skip-links':
                $breadcrumbSkipLinks = (bool)$_val;
                break;
            default:
                throw new \Exception("ncbreadcrumbs: unknown attribute '$_key'");
        }
    }

    if ($breadcrumbs instanceof Naucon\Breadcrumbs\BreadcrumbsInterface) {
        $breadcrumbsHelper = new Naucon\Breadcrumbs\Helper\BreadcrumbsHelper($breadcrumbs);
        if (!is_null($breadcrumbTag)) {
            $breadcrumbsHelper->setTag($breadcrumbTag);
        }
        if (!is_null($breadcrumbSeparator)) {
            $breadcrumbsHelper->setSeparator($breadcrumbSeparator);
        }
        if (!is_null($breadcrumbReverse)) {
            $breadcrumbsHelper->setReverse($breadcrumbReverse);
        }
        if (!is_null($breadcrumbSkipLinks)) {
            $breadcrumbsHelper->setSkipLinks($breadcrumbSkipLinks);
        }

        if (count($options)) {
            $breadcrumbsHelper->setOptions($options);
        }

        return $breadcrumbsHelper->render();
    }
    else {
        throw new \Exception("ncbreadcrumbs: attribute from is missing or not a instance of BreadcrumbsInterface");
    }
}