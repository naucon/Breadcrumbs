naucon Breadcrumbs Package
==========================

About
-----

The breadcrumb package helps to integrate a common breadcrumb navigation into a web application. The package includes two components: A breadcrumbs class to add breadcrumb elements and a breadcrumbs helper to render html markup in php or smarty templates.


### Features

* add breadcrumbs with a title and a optional URL
* breadcrumb handler (null - default, session)
* breadcrumb helper to render html markup 
* smarty plugins for breadcrumb helper
* reverse breadcrumb (fifo, lifo)
* fluent interface
** Breadcrumbs (add)
** BreadcrumbsHelper (setTag, setSeparator, setReverse, setOptions)


### Compatibility

* PHP7.2+

### Dependencies

* naucon Utility
* naucon Html Elements

Installation
------------

install the latest version via composer

    composer require naucon/breadcrumbs


Usage
-----

### initialize

To build a breadcrumb menu create a instance of `Breadcrumbs`.

    use Naucon\Breadcrumbs\Breadcrumbs;
    $breadcrumbs = new Breadcrumbs();

Afterwards you can add breadcrumbs to that instance with the method `add()`. This the first parameter a title of the breadcrumb must be defined. With the second parameter a URL can be defined (optional).

    $breadcrumbs->add('home', '/home/');
    $breadcrumbs->add('profile', '/profile/');
    $breadcrumbs->add('address');
    
Another way is with the fluent interface.

    $breadcrumbs->add('home', '/home/');
        ->add('profile', '/profile/');
        ->add('address');

With `foreach` you can iterate through the added breadcrumbs. The value is a instance of `Breadcrumb` which have methodes to access breadcrumb title and URL. The breadcrumbs a in the order they are added (FIFO).

    foreach ($breadcrumbs as $breadcrumb)
    {
        if ($breadcrumb->hasUrl()) {
            echo '<a href="' . $breadcrumb->getUrl() . '">' . $breadcrumb->getTitle() . '</a>';
        } else {
            echo $breadcrumb->getTitle();
        }
    }
    
The output of the example would be

    <a href="/home/">home</a><a href="/profile/">profile</a>address

To reverse the order of the breadcrumb use the method `getReverseIterator()`. The breadcrumbs will be interated in the reverse order they are added (LIFO).

    $breadcrumbsIterator = $breadcrumbs->getReverseIterator();
    foreach ($breadcrumbsIterator as $breadcrumb)
    {
        if ($breadcrumb->hasUrl()) {
            echo '<a href="' . $breadcrumb->getUrl() . '">' . $breadcrumb->getTitle() . '</a>';
        } else {
            echo $breadcrumb->getTitle();
        }
    }
    
The output of the example would be

    address<a href="/profile/">profile</a><a href="/home/">home</a>

### Breadcrumb Handler

Breadcrumb items are collected in a instance of `BreadcrumbCollection`. To read and write into the collection a handler is used.
The default handler is `BreadcrumbHandlerNull` which only adds or remove entries to the collection.

In some use cases the breadcrumb entries must persist between page loads. In this cases the `BreadcrumbHandlerSession` can be set. The Handler will read and write into the $_SESSION variable.

    // start session
    session_start();

    ...

    use Naucon\Breadcrumbs\Breadcrumbs;
    use Naucon\Breadcrumbs\Handler\BreadcrumbHandlerSession;
    $breadcrumbs = new Breadcrumbs();
    $breadcrumbs->setBreadcrumbHandler(new BreadcrumbHandlerSession());
    
    ...
    
    // add breadcrumb entry
    $breadcrumbs->add('Home', '/home/');

    ...

    // close session
    session_write_close();
    

Make sure that you started and close session befor and after you use the breadcrumb.

### Breadcrumb helper

With the breadcrumb helper a instance of `Breadcrumbs` can be rendered in HTML Markup.

To use the helper create a instance of `BreadcrumbsHelper` and give the constructor a instance of `Breadcrumbs`.

    use Naucon\Breadcrumbs\Helper\BreadcrumbsHelper;
    $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);

With the method `render()` the html markup will be generated an returned.

    echo $breadcrumbsHelper->render();

    // <a href="/home/">home</a><a href="/profile/">profile</a>address

With the method `setSeparator()` a separator between the breadcrumbs can be defined.

    $breadcrumbsHelper->setSeparator(' / ');
    echo $breadcrumbsHelper->render();

    // <a href="/home/">home</a> / <a href="/profile/">profile</a> / address

With the method `setReverse()` the order of the breadcrumbs can be reversed.

    $breadcrumbsHelper->setReversed(); // or $breadcrumbsHelper->setReversed(true);
    echo $breadcrumbsHelper->render();

    // address / <a href="/profile/">profile</a> / <a href="/home/">home</a>

With the method `setSkipLinks()` links will be skipped in render.

    $breadcrumbsHelper->setSkipLinks(); // or $breadcrumbsHelper->setSkipLinks(true);
    echo $breadcrumbsHelper->render();

    // home / profile / home

With the method `setTag()` a html element can be set surround the breadcrumb. The following html element are supported: span, div, li, ul, ol

Example with `span` element:

    $breadcrumbsHelper->setTag('span');
    $breadcrumbsHelper->setSeparator(' / ');
    echo $breadcrumbsHelper->render();
    
    // <span><a href="/home/">home</a></span> / <span><a href="/profile/">profile</a></span> / <span>address</span>

Example with `div` element:

    $breadcrumbsHelper->setTag('div');
    $breadcrumbsHelper->setSeparator(' / ');
    echo $breadcrumbsHelper->render();
    
    // <div><a href="/home/">home</a></div> / <div><a href="/profile/">profile</a></div> / <div>address</div>

Example with `li` element:

    $breadcrumbsHelper->setTag('div');
    $breadcrumbsHelper->setSeparator(' / ');
    echo $breadcrumbsHelper->render();
    
    // <li><a href="/home/">home</a></li> / <li><a href="/profile/">profile</a></li> / <li>address</li>

When using the tag `ul` or `ol` also the attributes `id`, `class`, `style` can be defined.

Example with `ul` element:

    $breadcrumbsHelper->setTag('ul');
    $breadcrumbsHelper->setOptions(array('id' => 'breadcrumb', 'class' => 'breadcrumbs'));
    echo $breadcrumbsHelper->render();
    
    // <ul id="breadcrumb" class="breadcrumbs"><li><a href="/home/">home</a></li><li><a href="/profile/">profile</a></li><li>address</li></ul>

Example with `ol` element:

    $breadcrumbsHelper->setTag('ol');
    $breadcrumbsHelper->setOptions(array('id' => 'breadcrumb', 'class' => 'breadcrumbs'));
    echo $breadcrumbsHelper->render();

    // <ol id="breadcrumb" class="breadcrumbs"><li><a href="/home/">home</a></li><li><a href="/profile/">profile</a></li><li>address</li></ol>


### Breadcrumb Smarty Plugin

When using the Smarty Template Engine the breadcrumb helper can be integrated with a smarty plugin.

First have hook up the smarty plugins to smarty.

    $smartyObject->plugins_dir[] = PATH_LIBRARY . 'vendor/naucon/Breadcrumbs/SmartyPlugins';

Next assign the instance of `Breadcrumbs` class to smarty.

	$smarty->assign('breadcrumbs', $breadcrumbs);

Then add the plugin to the template.

    {ncbreadcrumbs from=$breadcrumbs tag='span' separator=' / '}
    
or
    
    {ncbreadcrumbs from=$breadcrumbs tag='div' separator=' / '}

or
    
    {ncbreadcrumbs from=$breadcrumbs tag='ul' id='breadcrumb' class='breadcrumbs'}

or

    {ncbreadcrumbs from=$breadcrumbs tag='ol' id='breadcrumb' class='breadcrumbs'}

or

    {ncbreadcrumbs from=$breadcrumbs tag='ol' id='breadcrumb' class='breadcrumbs' reverse=true}

or

    {ncbreadcrumbs from=$breadcrumbs separator=' / ' skip-links=true}

The smarty plugin supports the following parameters

* from = assigned breadcrumbs variable (MUST)
* tag = define html tag surrounding the breadcrumb elements (optional)
* separator = define separator between the breadcrumb elements (optional)
* reverse = define the order that the breadcrumbs is iterated (optional)
* skip-links = links will not be rendered (optional)
* id = define a id attribute on a surrounding html element like ul and ol but not div, span or li (optional)
* class = define a id attribute on a surrounding html element like ul and ol but not div, span or li (optional)
* style = define a id attribute on a surrounding html element like ul and ol but not div, span or li (optional)












