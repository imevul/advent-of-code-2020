<?php

namespace Imevul\AdventOfCode2020\Day2;

/**
 * Get the puzzle input in a format we can handle.
 * @return array
 */
function getInput() : array {
	$lines = explode(PHP_EOL, file_get_contents('input.txt'));
	$result = [];

	foreach ($lines as $line) {
		if (!preg_match('/^(\d+)-(\d+) (\w): (\w+)$/',  $line, $parts)) {
			die("Invalid input: $line");
		}

		$result[] = [
			'min'      => (int)$parts[1],
			'max'      => (int)$parts[2],
			'char'     => $parts[3],
			'password' => $parts[4],
			'rule'     => $line,
		];
	}

	return $result;
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part1(array $input) : int {
	$result = 0;

	foreach ($input as $item) {
		$count = substr_count($item['password'], $item['char']);
		if ($count >= $item['min'] && $count <= $item['max']) {
			$result++;
		}
	}

	return $result;
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input) : int {
	$result = 0;

	foreach ($input as $item) {
		$count = (substr($item['password'], $item['min'] - 1, 1) == $item['char']) + (substr($item['password'], $item['max'] - 1, 1) == $item['char']);

		if ($count == 1) {
			$result++;
		}
	}

	return $result;
}

$input = getInput();
echo 'Solution1: ' . part1($input) . PHP_EOL;
echo 'Solution2: ' . part2($input) . PHP_EOL;
