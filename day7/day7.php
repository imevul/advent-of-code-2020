<?php

namespace Imevul\AdventOfCode2020\Day7;

use Exception;

require_once '../Common/autoload.php';

/**
 * Get the puzzle input in a format we can handle.
 * @return array
 * @throws Exception
 */
function getInput() : array {
	$lines = explode(PHP_EOL, file_get_contents('input.txt'));
	$rules = [];

	foreach ($lines as $line) {
		if (!preg_match('/^([\w ]+) bags contain ([\w ,]+)\.$/im', $line, $matches)) throw new Exception("Error in input parsing for line '$line'");
		$contains = explode(', ', $matches[2]);

		$bagRules = [];
		foreach ($contains as $contain) {
			$rule = trim(str_replace(['bags', 'bag'], '', $contain));
			if ($rule === 'no other') continue;
			preg_match('/^(\d+) (.+)$/i', $rule, $matches2);
			$bagRules[] = [(int)$matches2[1], $matches2[2]];
		}

		$rules[$matches[1]] = $bagRules;
	}

	return $rules;
}

/**
 * Get all bags that could at some point contain the specified target bag.
 *
 * @param array $rules Bag rules
 * @param string $bagType Target bag type
 * @return array
 */
function canContain(array $rules, string $bagType) : array {
	$result = [];

	foreach ($rules as $bag => $contains) {
		if (empty($contains)) continue;

		foreach ($contains as $bagTypes) {
			if ($bagTypes[1] === $bagType) {
				$result[] = $bag;
				$result = array_merge($result, canContain($rules, $bag));
			}
		}
	}

	return array_unique($result);
}

/**
 * Get all required bags that have to be inside of a specific bag type.
 *
 * @param array $rules Bag rules
 * @param string $bagType Starting type of bag
 * @param int $count Number of bags to start with
 * @return array A flat array containing count and type of all bags that have to be contained in the starting type
 */
function requiredBags(array $rules, string $bagType, int $count = 1) : array {
	$result = [];

	foreach ($rules as $bag => $contains) {
		if ($bag === $bagType) {
			foreach ($contains as $contain) {
				$result[] = [$contain[0] * $count, $contain[1]];
				$result = array_merge($result, requiredBags($rules, $contain[1], $contain[0] * $count));
			}
		}
	}

	return $result;
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part1(array $input) : int {
	return count(canContain($input, 'shiny gold'));
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input) : int {
	return array_sum(array_map(function ($b) { return $b[0]; }, requiredBags($input, 'shiny gold')));
}

/** @noinspection PhpUnhandledExceptionInspection */
$input = getInput();
echo 'Solution1: ' . part1($input) . PHP_EOL;
echo 'Solution2: ' . part2($input) . PHP_EOL;
