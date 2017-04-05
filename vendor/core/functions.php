<?php

function dd($value)
{
	var_dump($value);
	die();
}

function redirect($url)
{
    header("Location: {$url}");
}

function json($arr)
{
    echo json_encode($arr);
}