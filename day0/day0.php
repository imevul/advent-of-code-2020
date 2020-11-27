<?php

namespace Imevul\AdventOfCode2020\Day0;

require_once '../Common/autoload.php';

/**
 * Get the puzzle input in a format we can handle.
 * @return array
 */
function getInput() : array {
	$lines = explode("\r\n", file_get_contents('input.txt'));

	return $lines;
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part1(array $input) : int {
	$result = 0;

	foreach ($input as $change) {
		$result += (int)$change;
	}

	return $result;
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input) : int {
	$result = 0;

//	foreach ($input as $change) {
//		$result += (int)$change;
//	}
	
	return $result;
}

$input = getInput();
echo 'Solution1: ' . part1($input) . PHP_EOL;
echo 'Solution2: ' . part2($input) . PHP_EOL;
