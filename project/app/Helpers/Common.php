<?php
function isSideBarActive($menu)
{
    if (is_array($menu)) {
        return (in_array(request()->segment(2), $menu)) ? 'nav-active' : '';
    } else {
        return (request()->segment(2) == $menu) ? 'nav-active' : '';
    }
}

function isSubMenuActive($subMenu, $class = null)
{
    if (!$class) {
        return (request()->routeIs($subMenu) && request('class') == 0) ? 'start active open' : '';
    } else {
        return (request()->routeIs($subMenu) && request('class') == $class) ? 'start active open' : '';
    }
}