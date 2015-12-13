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

use Naucon\Breadcrumbs\Breadcrumb;
use Naucon\Breadcrumbs\Breadcrumbs;
use Naucon\Breadcrumbs\Handler\BreadcrumbHandlerInterface;
use Naucon\Breadcrumbs\Handler\BreadcrumbHandlerSession;

class BreadcrumbHandlerSessionTest extends \PHPUnit_Framework_TestCase
{
    public static $sessionData = array();

    public function setUp()
    {
        $_SESSION = self::$sessionData;
    }

    public function tearDown()
    {
        self::$sessionData = $_SESSION;
    }

    /**
     * @return      BreadcrumbHandlerInterface
     */
    public function testInit()
    {
        $breadcrumbHandler = new BreadcrumbHandlerSession();
        return $breadcrumbHandler;
    }

    /**
     * @depends     testInit
     * @param       BreadcrumbHandlerInterface
     * @return      BreadcrumbHandlerInterface
     */
    public function testAdd(BreadcrumbHandlerInterface $breadcrumbHandler)
    {
        $breadcrumbHandler->add(new Breadcrumb('home', '/home/'));
        $breadcrumbHandler->add(new Breadcrumb('profile', '/profile/'));
        $breadcrumbHandler->add(new Breadcrumb('address'));

        return $breadcrumbHandler;
    }

    /**
     * @depends     testAdd
     * @param       BreadcrumbHandlerInterface
     * @return      BreadcrumbHandlerInterface
     */
    public function testCount(BreadcrumbHandlerInterface $breadcrumbHandler)
    {
        $expectedSessionNamespace = '__NcBreadcrumbStorage';

        $this->assertEquals(3, $breadcrumbHandler->count());
        $this->assertCount(3, $_SESSION[$expectedSessionNamespace]);

        return $breadcrumbHandler;
    }

    /**
     * @depends     testAdd
     * @param       BreadcrumbHandlerInterface
     * @return      BreadcrumbHandlerInterface
     */
    public function testIterator(BreadcrumbHandlerInterface $breadcrumbHandler)
    {
        $expectedSessionNamespace = '__NcBreadcrumbStorage';

        $breadcrumbIterator = $breadcrumbHandler->getIterator();

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

        $this->assertEquals($expectedBreadcrumbs, $_SESSION[$expectedSessionNamespace]);

        return $breadcrumbHandler;
    }

    /**
     * @depends     testAdd
     * @param       BreadcrumbHandlerInterface
     * @return      BreadcrumbHandlerInterface
     */
    public function testReverseIterator(BreadcrumbHandlerInterface $breadcrumbHandler)
    {
        $expectedSessionNamespace = '__NcBreadcrumbStorage';

        $breadcrumbIterator = $breadcrumbHandler->getReverseIterator();

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

        return $breadcrumbHandler;
    }

    /**
     * @depends     testAdd
     * @param       BreadcrumbsInterface
     * @return      BreadcrumbsInterface
     */
    public function testClear(BreadcrumbHandlerInterface $breadcrumbHandler)
    {
        $expectedSessionNamespace = '__NcBreadcrumbStorage';

        $this->assertEquals(3, $breadcrumbHandler->count());
        $this->assertCount(3, $_SESSION[$expectedSessionNamespace]);

        $breadcrumbHandler->clear();

        $this->assertEquals(0, $breadcrumbHandler->count());
        $this->assertCount(0, $_SESSION[$expectedSessionNamespace]);

        return $breadcrumbHandler;
    }
}
