<?php

declare(strict_types=1);

namespace Duon\Session {
	function session_name(): string|false
	{
		return \Duon\Session\Tests\SessionNameIdFailureTest::sessionNameResult();
	}

	function session_id(): string|false
	{
		return \Duon\Session\Tests\SessionNameIdFailureTest::sessionIdResult();
	}
}

namespace Duon\Session\Tests;

use Duon\Session\RuntimeException;
use Duon\Session\Session;

final class SessionNameIdFailureTest extends TestCase
{
	private static bool $forceNameFalse = false;
	private static bool $forceIdFalse = false;

	public static function sessionNameResult(): string|false
	{
		if (self::$forceNameFalse) {
			return false;
		}

		return \session_name();
	}

	public static function sessionIdResult(): string|false
	{
		if (self::$forceIdFalse) {
			return false;
		}

		return \session_id();
	}

	protected function tearDown(): void
	{
		self::$forceNameFalse = false;
		self::$forceIdFalse = false;

		parent::tearDown();
	}

	public function testNameThrowsWhenUnavailable(): void
	{
		self::$forceNameFalse = true;
		$session = new Session();

		$this->expectException(RuntimeException::class);
		$this->expectExceptionMessage('Session name not available');

		$session->name();
	}

	public function testIdThrowsWhenUnavailable(): void
	{
		self::$forceIdFalse = true;
		$session = new Session();

		$this->expectException(RuntimeException::class);
		$this->expectExceptionMessage('Session id not available');

		$session->id();
	}
}
