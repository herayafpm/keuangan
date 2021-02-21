<?php

namespace App\Validation;

class MyRules
{
	public function less_than_or_same_money(int $str, $money = 0): bool
	{
		if ($str <= $money) {
			return true;
		}
		return false;
	}
	public function update_pass(string $str, $length = 6): bool
	{
		if (empty($str)) {
			return true;
		}
		if (strlen($str) >= $length) {
			return true;
		}
		return false;
	}
	public function min_length_array(array $arr, $length = 5): bool
	{
		$arr = $arr[0];
		$arr = explode(',', $arr);
		if (sizeof($arr) >= $length && $arr[0] != "") {
			return true;
		}
		return false;
	}
}
