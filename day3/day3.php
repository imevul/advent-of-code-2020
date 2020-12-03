<?php

namespace Imevul\AdventOfCode2020\Day3;

require_once '../Common/autoload.php';

/**
 * Get the puzzle input in a format we can handle.
 * @return array
 */
function getInput() : array {
	$lines = explode(PHP_EOL, file_get_contents('input.txt'));
	$result = [];

	foreach ($lines as $line) {
		$result[] = str_split($line);
	}

	return $result;
}

/**
 * Counts the number of trees for a given map and slope.
 *
 * @param array $map The map to use
 * @param int $dx The slope delta-x
 * @param int $dy The slope delta-y
 * @return int The number of trees found
 */
function countTrees(array $map, int $dx, int $dy) : int {
	$x = 0;
	$y = 0;
	$mx = count($map[0]);
	$my = count($map);

	$numTrees = 0;

	while ($y < $my) {
		if ($map[$y][$x] == '#') {
			$numTrees++;
		}

		$x = ($x + $dx + $mx) % $mx;
		$y = $y + $dy;
	}

	return $numTrees;
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part1(array $input) : int {
	return countTrees($input, 3, 1);
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input) : int {
	$slopes = [
		[1, 1],
		[3, 1],
		[5, 1],
		[7, 1],
		[1, 2],
	];

	$result = 1;

	foreach ($slopes as $slope) {
		$result *= countTrees($input, $slope[0], $slope[1]);
	}

	return $result;
}

$input = getInput();
echo 'Solution1: ' . part1($input) . PHP_EOL;
echo 'Solution2: ' . part2($input) . PHP_EOL;
