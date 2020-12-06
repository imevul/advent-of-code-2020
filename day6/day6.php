<?php

namespace Imevul\AdventOfCode2020\Day6;

require_once '../Common/autoload.php';

/**
 * Get the puzzle input in a format we can handle.
 * @return array
 */
function getInput() : array {
	$groupLines = explode(PHP_EOL . PHP_EOL, file_get_contents('input.txt'));

	// Split into lines within each group, and each line into characters
	return array_map(function ($g) {
		return array_map(function ($l) {
			return str_split($l);
		}, explode(PHP_EOL, $g));
	}, $groupLines);
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part1(array $input) : int {
	return array_sum(array_map(function ($g) {
		// Count number of answers in each group
		return count($g);
	}, array_map(function ($g) {
		// Combine all answers from all persons in each group
		return array_combine(array_merge(...$g), array_merge(...$g));
	}, $input)));
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input) : int {
	return array_sum(array_map(function ($g) {
		// Count number of answers in each group
		return count($g);
	}, array_map(function ($g) {
		// Get all intersecting answers from all persons in a group
		return array_combine(array_intersect(...$g), array_intersect(...$g));
	}, $input)));
}

$input = getInput();
echo 'Solution1: ' . part1($input) . PHP_EOL;
echo 'Solution2: ' . part2($input) . PHP_EOL;
