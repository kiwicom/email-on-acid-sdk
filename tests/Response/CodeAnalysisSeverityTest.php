<?php

namespace EmailOnAcid\Response;

use PHPUnit\Framework\TestCase;

class CodeAnalysisSeverityTest extends TestCase
{
	public function testObject()
	{
		$name = 'asdasd';
		$discrepancy_count = 44;
		$discrepancies = [
			new CodeAnalysisDiscrepancy(
				'asdad',
				'adsad',
				[44]
			)
		];

		$object = new CodeAnalysisSeverity(
			$name,
			$discrepancy_count,
			$discrepancies
		);

		$this->assertSame($name, $object->getName());
		$this->assertSame($discrepancy_count, $object->getDiscrepancyCount());
		$this->assertSame($discrepancies, $object->getDiscrepancies());
	}

}
