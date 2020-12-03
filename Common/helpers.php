<?php

function d(string $text) : void {
	echo '[' . date('H:i:s') . '] ' . $text . PHP_EOL;
}

function dd(...$args) : void {
	foreach ($args as $arg) {
		var_dump($arg);
	}

	die;
}
