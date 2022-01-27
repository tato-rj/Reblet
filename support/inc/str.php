<?php

function showtags($str)
{
	return htmlspecialchars($str);
}

function uuid()
{
	return (string) \Str::uuid();
}

function getExtension($name)
{
    return pathinfo($name, PATHINFO_EXTENSION);
}

function removeExtension($name)
{
    return pathinfo($name, PATHINFO_FILENAME);
}

function str_possessive($string) {
	return $string.'\''.($string[strlen($string) - 1] != 's' ? 's' : '');
}