<?php

function create($class, $attributes = [], $amount = null)
{
	return $class::factory($attributes)->create();
}

function make($class, $attributes = [], $amount = null)
{
	return $class::factory($attributes)->make();
}
