<?php

Html::macro('isActive', function(array $urlArray)
{
    return in_array(URL::current(), $urlArray) ? 'active-menu' : '';
    // return Request::is($url) ? 'active-menu' : '';
});