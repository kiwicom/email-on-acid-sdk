<?php


namespace EmailOnAcid\Response;


class CodeAnalysisSeverity
{
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var int
	 */
	private $discrepancy_count;
	/**
	 * @var CodeAnalysisDiscrepancy[]
	 */
	private $discrepancies;

	/**
	 * CodeAnalysisSeverity constructor.
	 * @param string $name
	 * @param int $discrepancy_count
	 * @param CodeAnalysisDiscrepancy[] $discrepancies
	 */
	public function __construct(string $name, int $discrepancy_count, array $discrepancies)
	{
		$this->name = $name;
		$this->discrepancy_count = $discrepancy_count;
		$this->discrepancies = array_map(function (CodeAnalysisDiscrepancy $discrepancy) {
			return $discrepancy;
		}, $discrepancies);
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function getDiscrepancyCount(): int
	{
		return $this->discrepancy_count;
	}

	/**
	 * @return CodeAnalysisDiscrepancy[]
	 */
	public function getDiscrepancies(): array
	{
		return $this->discrepancies;
	}


}