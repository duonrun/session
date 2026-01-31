<?php

declare(strict_types=1);

namespace Duon\Session\Tests;

use Duon\Session\Session;

final class HandlerTest extends TestCase
{
	public function testCustomHandler(): void
	{
		$handler = new TestSessionHandler();
		$session = new Session('custom', handler: $handler);
		$session->start();
		$session->set('test', 'value');

		self::assertSame('custom', $session->name());
		self::assertSame('value', $session->get('test'));
		self::assertTrue($handler->visited);

		$session->forget();
	}
}
