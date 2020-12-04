<?php

namespace Imevul\AdventOfCode2020\Day4;

require_once '../Common/autoload.php';
require_once 'Passport.php';

/**
 * Get the puzzle input in a format we can handle.
 * @return array
 */
function getInput() : array {
	$batchLines = explode(PHP_EOL . PHP_EOL, file_get_contents('input.txt'));
	$passports = [];

	foreach ($batchLines as $batchLine) {
		$passports[] = Passport::create($batchLine);
	}

	return $passports;
}

/**
 * @param Passport[] $input The list of input
 * @return int The result
 */
function part1(array $input) : int {
	return count(array_filter($input, function(Passport $passport) {return $passport->isValid(FALSE); }));
}

/**
 * @param Passport[] $input The list of input
 * @return int The result
 */
function part2(array $input) : int {
	return count(array_filter($input, function(Passport $passport) {return $passport->isValid(); }));
}

$input = getInput();
echo 'Solution1: ' . part1($input) . PHP_EOL;
echo 'Solution2: ' . part2($input) . PHP_EOL;
