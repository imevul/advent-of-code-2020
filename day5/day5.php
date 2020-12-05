<?php

namespace Imevul\AdventOfCode2020\Day5;

require_once '../Common/autoload.php';

/**
 * Get the puzzle input in a format we can handle.
 * @return array
 */
function getInput() : array {
	return explode(PHP_EOL, file_get_contents('input.txt'));
}

/**
 * Calculate the seat coordinate based on a partitioning string.
 *
 * @param string $partitioning A 10 character string containing the letters F,B,R,L.
 * @return int[] An array [x, y] containing the column(x) and row(y) of the seat.
 */
function getSeatCoordinate(string $partitioning) : array {
	$s = [[0, 7], [0, 127]];

	for ($i = 0, $l = strlen($partitioning); $i < $l; $i++) {
		// Binary space partitioning map
		$s = match ($partitioning[$i]) {
			'F' => [$s[0], [$s[1][0], $s[1][0] + (int)floor(($s[1][1] - $s[1][0]) / 2)]],
			'B' => [$s[0], [$s[1][0] + (int)ceil(($s[1][1] - $s[1][0]) / 2), $s[1][1]]],
			'R' => [[$s[0][0] + (int)ceil(($s[0][1] - $s[0][0]) / 2), $s[0][1]], $s[1]],
			'L' => [[$s[0][0], $s[0][0] + (int)floor(($s[0][1] - $s[0][0]) / 2)], $s[1]],
		};
	}

	return [$s[0][0], $s[1][0]];
}

/**
 * Calculate a SeatID for a specific coordinate.
 *
 * @param array $coordinate [x, y] array containing the column(x) and row(y) of the seat we want to calculate the ID for.
 * @return int
 */
function getSeatIDFromCoordinate(array $coordinate) : int {
	return $coordinate[1] * 8 + $coordinate[0];
}

/**
 * Calculate a SeatID from a partitioning string.
 *
 * @param string $partitioning A 10 character string containing the letters F,B,R,L.
 * @return int The SeatID for the seat found based on the space partitioning.
 */
function getSeatID(string $partitioning) : int {
	return getSeatIDFromCoordinate(getSeatCoordinate($partitioning));
}


/**
 * @param array $input The list of input
 * @return int The result
 */
function part1(array $input) : int {
	return max(array_map(function($p) { return getSeatID($p); }, $input));
}

/**
 * @param array $input The list of input
 * @return int The result
 */
function part2(array $input) : int {
	$seats = array_fill(0, 127, array_fill(0, 7, 0));
	$seatIDs = array_map(function($p) { return getSeatID($p); }, $input);

	// Loop through seats and mark seats we have boarding passes for as found
	foreach ($seats as $y => $row) {
		foreach ($row as $x => $value) {
			if (in_array(getSeatIDFromCoordinate([$x, $y]), $seatIDs)) {
				$seats[$y][$x] = 1;
			}
		}
	}

	// Loop through not found seats and disqualify them if their neighbours are not found either
	foreach ($seats as $y => $row) {
		foreach ($row as $x => $value) {
			if ($value === 0) {
				if (!in_array(getSeatIDFromCoordinate([$x, $y]) - 1, $seatIDs) || !in_array(getSeatIDFromCoordinate([$x, $y]) + 1, $seatIDs)) {
					$seats[$y][$x] = -1;
				}
			}
		}
	}

	// Remaining "not found" seat is our seat
	foreach ($seats as $y => $row) {
		foreach ($row as $x => $value) {
			if ($value === 0) {
				return getSeatIDFromCoordinate([$x, $y]);
			}
		}
	}

	return 0;
}

$input = getInput();
echo 'Solution1: ' . part1($input) . PHP_EOL;
echo 'Solution2: ' . part2($input) . PHP_EOL;
