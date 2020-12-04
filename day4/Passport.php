<?php

namespace Imevul\AdventOfCode2020\Day4;

/**
 * Class Passport
 * @package Imevul\AdventOfCode2020\Day4
 */
class Passport {
	/** @var string Birth Year */
	public string $byr;
	/** @var string Issue Year */
	public string $iyr;
	/** @var string Expiration Year */
	public string $eyr;
	/** @var string Height */
	public string $hgt;
	/** @var string Hair Color */
	public string $hcl;
	/** @var string Eye Color */
	public string $ecl;
	/** @var string Passport ID */
	public string $pid;
	/** @var string Country ID */
	public string $cid;
	/** @var string Definition string */
	public string $definition;

	/**
	 * Factory function to create a new Passport from a definition string.
	 * @param string $definition Key:Value pairs separated by space or newline.
	 * @return static
	 */
	public static function create(string $definition) : self {
		$passport = new Passport();
		$passport->definition = str_replace(PHP_EOL, ' ', $definition);
		$fields = explode(' ', $passport->definition);

		foreach ($fields as $field) {
			[$key, $value] = explode(':', $field);

			if (property_exists($passport, $key)) {
				$passport->{$key} = $value;
			}
		}

		return $passport;
	}

	/**
	 * Check if the Passport has all required fields and is valid.
	 *
	 * @param bool $useRules TRUE to use strict field rules. FALSE to just check that the field exists.
	 * @return bool TRUE if the Passport is valid, otherwise FALSE.
	 */
	public function isValid(bool $useRules = TRUE) : bool {
		$rules = $this->rules();

		foreach ($rules as $field => $validator) {
			if (empty($this->{$field})) return FALSE;
			if (!$useRules) continue;
			if (!$validator($this->{$field})) return FALSE;
		}

		return TRUE;
	}

	/**
	 * @return array Returns the validation rules for the Passport fields.
	 */
	protected function rules(): array {
		return [
			'byr' => function($v) { return mb_strlen($v) === 4 && (int)$v >= 1920 && (int)$v <= 2002; },
			'iyr' => function($v) { return mb_strlen($v) === 4 && (int)$v >= 2010 && (int)$v <= 2020; },
			'eyr' => function($v) { return mb_strlen($v) === 4 && (int)$v >= 2020 && (int)$v <= 2030; },
			'hgt' => function($v) {
				if (!preg_match('/^(\d+)(cm|in)$/', $v, $matches)) return FALSE;

				return match($matches[2]) {
					'cm' => (int)$matches[1] >= 150 && (int)$matches[1] <= 193,
					'in' => (int)$matches[1] >= 59 && (int)$matches[1] <= 76,
					default => FALSE,
				};
			},
			'hcl' => function($v) { return preg_match('/^#[a-f0-9]{6}$/i', $v); },
			'ecl' => function($v) { return in_array($v, ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']); },
			'pid' => function($v) { return preg_match('/^\d{9}$/', $v); },
		];
	}
}
