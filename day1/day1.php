<?php

namespace Imevul\AdventOfCode2020\Day1;

/**
 * Get the puzzle input in a format we can handle.
 * @return array
 */
function getInput() : array {
	return explode(PHP_EOL, file_get_contents('input.txt'));
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part1(array $input) : int {
	foreach ($input as $item1) {
		foreach ($input as $item2) {
			if ($item1 + $item2 == 2020) {
				return $item1 * $item2;
			}
		}
	}

	return 0;
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input) : int {
	foreach ($input as $item1) {
		foreach ($input as $item2) {
			foreach ($input as $item3) {
				if ($item1 + $item2 + $item3 == 2020) {
					return $item1 * $item2 * $item3;
				}
			}
		}
	}

	return 0;
}

$input = getInput();
echo 'Solution1: ' . part1($input) . PHP_EOL;
echo 'Solution2: ' . part2($input) . PHP_EOL;
