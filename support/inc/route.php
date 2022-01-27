<?php

function is_route($route)
{
	return \Route::currentRouteName() == $route;
}