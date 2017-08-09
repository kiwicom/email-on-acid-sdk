<?php

namespace EmailOnAcid\Tests\Request;

use EmailOnAcid\BaseSettings;
use EmailOnAcid\Request\TestSearchRequest;
use EmailOnAcid\Response\Test;
use PHPUnit\Framework\TestCase;

class TestSearchRequestTest extends TestCase
{

	public function testObject()
	{

		$request = new TestSearchRequest();

		$from = new \DateTimeImmutable();
		$to = new \DateTimeImmutable();
		$headers = ['head' => 'shot'];
		$tags = ['meta' => 'test'];
		$results = 50;
		$page = 300;
		$subject = 'some crazy subject';
		$type = Test::TYPE_EMAIL;

		$this->assertSame(
			$from,
			$request->setFrom($from)->getFrom()
		);

		$this->assertSame(
			$to,
			$request->setTo($to)->getTo()
		);

		$this->assertSame(
			$headers,
			$request->setHeaders($headers)->getHeaders()
		);

		$this->assertSame(
			$tags,
			$request->setTags($tags)->getTags()
		);

		$this->assertSame(
			$results,
			$request->setResults($results)->getResults()
		);

		$this->assertSame(
			$page,
			$request->setPage($page)->getPage()
		);

		$this->assertSame(
			$type,
			$request->setType($type)->getType()
		);

		$this->assertSame(
			$subject,
			$request->setSubject($subject)->getSubject()
		);

		$search = $request->jsonSerialize();

		ksort($search);

		$search2 = [
			'from'    => $from->format(BaseSettings::getDateTimeFormat()),
			'to'      => $to->format(BaseSettings::getDateTimeFormat()),
			'subject' => $subject,
			'type'    => $type,
			'headers' => $headers,
			'tags'    => $tags,
			'results' => $results,
			'page'    => $page
		];

		ksort($search2);

		$this->assertSame(json_encode($search), json_encode($search2));

		$this->assertSame(json_encode([]), json_encode((new TestSearchRequest())->jsonSerialize()));

	}

}
