<?php
namespace FDG\Tests\Utils;

function fdg_error_log(string $text): string {

		return "\n\033[32m" . $text . "\033[0m\n";
}