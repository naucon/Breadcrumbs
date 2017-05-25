<?php
/*
 * Copyright 2008 Sven Sanzenbacher
 *
 * This file is part of the naucon package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Naucon\Breadcrumbs\Tests;

use Naucon\Breadcrumbs\Breadcrumbs;
use Naucon\Breadcrumbs\BreadcrumbsInterface;

class BreadcrumbsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return      BreadcrumbsInterface
     */
    public function testInit()
    {
        $breadcrumbs = new Breadcrumbs();
        return $breadcrumbs;
    }

    /**
     * @depends     testInit
     * @param       BreadcrumbsInterface        $breadcrumbs
     * @return      BreadcrumbsInterface
     */
    public function testAdd(BreadcrumbsInterface $breadcrumbs)
    {
        $breadcrumbs->add('home', '/home/');
        $breadcrumbs->add('profile', '/profile/');
        $breadcrumbs->add('address');

        return $breadcrumbs;
    }

    /**
     * @depends     testAdd
     * @param       BreadcrumbsInterface        $breadcrumbs
     * @return      BreadcrumbsInterface
     */
    public function testCount(BreadcrumbsInterface $breadcrumbs)
    {
        $this->assertEquals(3, $breadcrumbs->count());

        return $breadcrumbs;
    }

    /**
     * @depends     testAdd
     * @param       BreadcrumbsInterface        $breadcrumbs
     * @return      BreadcrumbsInterface
     */
    public function testIterator(BreadcrumbsInterface $breadcrumbs)
    {
        $breadcrumbIterator = $breadcrumbs->getIterator();

        $expectedBreadcrumbs = array();
        $expectedBreadcrumbs[0]['title'] = 'home';
        $expectedBreadcrumbs[0]['url'] = '/home/';
        $expectedBreadcrumbs[1]['title'] = 'profile';
        $expectedBreadcrumbs[1]['url'] = '/profile/';
        $expectedBreadcrumbs[2]['title'] = 'address';
        $expectedBreadcrumbs[2]['url'] = null;

        $i = 0;
        foreach ($breadcrumbIterator as $key => $breadcrumb) {
            $this->assertInstanceOf('Naucon\Breadcrumbs\BreadcrumbInterface', $breadcrumb);
            $this->assertEquals($expectedBreadcrumbs[$i]['title'], $breadcrumb->getTitle());
            $this->assertEquals($expectedBreadcrumbs[$i]['url'], $breadcrumb->getUrl());
            $i++;
        }
        $this->assertEquals(3, $i);

        return $breadcrumbs;
    }

    /**
     * @depends     testAdd
     * @param       BreadcrumbsInterface        $breadcrumbs
     * @return      BreadcrumbsInterface
     */
    public function testReverseIterator(BreadcrumbsInterface $breadcrumbs)
    {
        $breadcrumbIterator = $breadcrumbs->getReverseIterator();

        $expectedBreadcrumbs = array();
        $expectedBreadcrumbs[0]['title'] = 'address';
        $expectedBreadcrumbs[0]['url'] = null;
        $expectedBreadcrumbs[1]['title'] = 'profile';
        $expectedBreadcrumbs[1]['url'] = '/profile/';
        $expectedBreadcrumbs[2]['title'] = 'home';
        $expectedBreadcrumbs[2]['url'] = '/home/';

        $i = 0;
        foreach ($breadcrumbIterator as $key => $breadcrumb) {
            $this->assertInstanceOf('Naucon\Breadcrumbs\BreadcrumbInterface', $breadcrumb);
            $this->assertEquals($expectedBreadcrumbs[$i]['title'], $breadcrumb->getTitle());
            $this->assertEquals($expectedBreadcrumbs[$i]['url'], $breadcrumb->getUrl());
            $i++;
        }
        $this->assertEquals(3, $i);

        return $breadcrumbs;
    }

    /**
     * @depends     testAdd
     * @param       BreadcrumbsInterface        $breadcrumbs
     * @return      BreadcrumbsInterface
     */
    public function testClear(BreadcrumbsInterface $breadcrumbs)
    {
        $this->assertEquals(3, $breadcrumbs->count());

        $breadcrumbs->clear();

        $this->assertEquals(0, $breadcrumbs->count());

        return $breadcrumbs;
    }

    /**
     * @return      BreadcrumbsInterface
     */
    public function testAddWithFluentInterface()
    {
        $breadcrumbs = new Breadcrumbs();

        $breadcrumbs->add('home', '/home/')
            ->add('profile', '/profile/')
            ->add('address');

        return $breadcrumbs;
    }

    /**
     * @depends     testAddWithFluentInterface
     * @param       BreadcrumbsInterface        $breadcrumbs
     * @return      BreadcrumbsInterface
     */
    public function testCountWithFluentInterface(BreadcrumbsInterface $breadcrumbs)
    {
        $this->assertEquals(3, $breadcrumbs->count());

        return $breadcrumbs;
    }

    /**
     * @depends     testAddWithFluentInterface
     * @param       BreadcrumbsInterface        $breadcrumbs
     * @return      BreadcrumbsInterface
     */
    public function testIteratorWithFluentInterface(BreadcrumbsInterface $breadcrumbs)
    {
        $breadcrumbIterator = $breadcrumbs->getIterator();

        $expectedBreadcrumbs = array();
        $expectedBreadcrumbs[0]['title'] = 'home';
        $expectedBreadcrumbs[0]['url'] = '/home/';
        $expectedBreadcrumbs[1]['title'] = 'profile';
        $expectedBreadcrumbs[1]['url'] = '/profile/';
        $expectedBreadcrumbs[2]['title'] = 'address';
        $expectedBreadcrumbs[2]['url'] = null;

        $i = 0;
        foreach ($breadcrumbIterator as $key => $breadcrumb) {
            $this->assertInstanceOf('Naucon\Breadcrumbs\BreadcrumbInterface', $breadcrumb);
            $this->assertEquals($expectedBreadcrumbs[$key]['title'], $breadcrumb->getTitle());
            $this->assertEquals($expectedBreadcrumbs[$key]['url'], $breadcrumb->getUrl());
            $i++;
        }
        $this->assertEquals(3, $i);

        return $breadcrumbs;
    }
}
