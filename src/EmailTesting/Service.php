<?php

namespace EmailOnAcid\EmailTesting;

use EmailOnAcid\BaseService;
use EmailOnAcid\Exception\InvalidApiResponseData;
use EmailOnAcid\Response\CodeAnalysisDiscrepancy;
use EmailOnAcid\Response\CodeAnalysisSeverity;
use EmailOnAcid\Response\EmailClientTestResult;
use EmailOnAcid\Response\LinkValidation;
use EmailOnAcid\Response\LinkValidationLink;
use EmailOnAcid\Response\NewEmailTest;
use EmailOnAcid\Response\NewSpamTest;
use EmailOnAcid\Response\ReprocessScreenShot;
use EmailOnAcid\Response\ScreenShotResult;
use EmailOnAcid\Response\SpamTestResult;
use EmailOnAcid\Response\Test;
use EmailOnAcid\Response\TestContent;
use EmailOnAcid\Response\TestInfo;
use EmailOnAcid\Response\TestStatusDetail;
use EmailOnAcid\ValidatorFactory;

class Service extends BaseService
{
	/**
	 * @var Validator
	 */
	protected $validator;

	/**
	 * Service constructor.
	 * @param ValidatorFactory|null $validatorFactory
	 */
	public function __construct(ValidatorFactory $validatorFactory = null)
	{
		$this->validator = isset($validatorFactory) ? $validatorFactory->createEmailTestingValidator() : (new ValidatorFactory())->createEmailTestingValidator();
	}


	/**
	 * @param array $response
	 * @return NewEmailTest
	 */
	public function createEmailTest(array $response): NewEmailTest
	{
		$this->validator->validateCreateEmailTest($response);
		if (isset($response['spam'])) {
			$spam = new NewSpamTest(
				$response['spam']['key'],
				isset($response['reference_id']) ? $response['reference_id'] : null,
				isset($response['customer_id']) ? $response['customer_id'] : null,
				isset($response['spam']['address_list']) ? $response['spam']['address_list'] : []
			);
		} else {
			$spam = null;
		}
		return new NewEmailTest(
			$response['id'],
			isset($response['reference_id']) ? $response['reference_id'] : null,
			isset($response['customer_id']) ? $response['customer_id'] : null,
			$spam
		);

	}

	/**
	 * @param array $response
	 * @return ReprocessScreenShot[]
	 */
	public function createReprocessScreenshots(array $response): array
	{
		$result = [];
		foreach ($response as $client_id => $client_data) {
			$this->validator->validateCreateReprocessScreenshots($client_data);
			$result[$client_id] = new ReprocessScreenShot(
				$client_id,
				$client_data['success'],
				$client_data['remaining_reprocesses'],
				$client_data['regional'],
				isset($client_data['reason']) ? $client_data['reason'] : null
			);
		}
		return $result;
	}

	/**
	 * @param array $response
	 * @return Test[]
	 */
	public function getEmailTests(array $response): array
	{
		return $this->getTests($response);
	}

	/**
	 * @param array $response
	 * @return TestInfo
	 */
	public function getEmailTestInfo(array $response): TestInfo
	{
		$this->validator->validateGetEmailTestInfo($response);
		return new TestInfo(
			$response['subject'],
			\DateTimeImmutable::createFromFormat('U', $response['date']),
			isset($response['completed']) ? $response['completed'] : [],
			isset($response['processing']) ? $response['processing'] : [],
			isset($response['bounced']) ? $response['bounced'] : []
		);
	}

	/**
	 * @param array $response
	 * @return EmailClientTestResult[]
	 */
	public function getResults(array $response): array
	{
		$results = [];
		foreach ($response as $client_data) {
			$this->validator->validateGetResults($client_data);
			$status_detail_data = $client_data['status_details'];
			$status_detail = new TestStatusDetail(
				\DateTimeImmutable::createFromFormat('U', $status_detail_data['submitted']),
				isset($status_detail_data['attempts']) ? $status_detail_data['attempts'] : null,
				isset($status_detail_data['completed']) ? \DateTimeImmutable::createFromFormat('U', $status_detail_data['completed']) : null,
				isset($status_detail_data['bounce_code']) ? $status_detail_data['bounce_code'] : null,
				isset($status_detail_data['bounce_message']) ? $status_detail_data['bounce_message'] : null
			);
			$screenshots = [];
			foreach ($client_data['screenshots'] as $type => $url) {
				$screenshots[] = new ScreenShotResult($type, $url);
			}
			$results[] = new EmailClientTestResult(
				$client_data['id'],
				$client_data['display_name'],
				$client_data['client'],
				$client_data['os'],
				$client_data['category'],
				$status_detail,
				isset($client_data['browser']) ? $client_data['browser'] : null,
				$screenshots,
				isset($client_data['thumbnail']) ? $client_data['thumbnail'] : null,
				isset($client_data['status']) ? $client_data['status'] : null
			);
		}
		return $results;
	}

	/**
	 * @param array $response
	 * @return TestContent
	 */
	public function getTestContent(array $response): TestContent
	{
		$this->validator->validateGetTestContent($response);
		return new TestContent($response['content']);
	}

	/**
	 * @param array $response
	 * @return CodeAnalysisSeverity[]
	 * @throws InvalidApiResponseData
	 */
	public function getClientCodeAnalysis(array $response): array
	{
		$result = [];
		if (!isset($response['code_analysis'])) {
			throw new InvalidApiResponseData('Missing code_analysis index in data');
		}
		foreach ($response['code_analysis'] as $severity) {
			$severity = $severity['severity'];
			$this->validator->validateGetClientCodeAnalysis($severity);
			$discrepancies = [];
			foreach ($severity['discrepancies'] as $discrepancy) {
				$discrepancies[] = new CodeAnalysisDiscrepancy(
					$discrepancy['property'],
					$discrepancy['message'],
					$discrepancy['lines']
				);
			}
			$result[] = new CodeAnalysisSeverity(
				$severity['name'],
				$severity['discrepancy_count'],
				$discrepancies
			);;
		}
		return $result;
	}

	/**
	 * @param array $response
	 * @return LinkValidation
	 */
	public function getLinkValidation(array $response): LinkValidation
	{
		$this->validator->validateGetLinkValidation($response);
		$links = [];
		foreach($response['links'] as $link){
			$this->validator->validateGetLinkValidationLink($link);
			$links[] = new LinkValidationLink(
				$link['url'],
				$link['type'],
				$link['redirects'],
				$link['status'],
				$link['mime'],
				$link['warning'],
				$link['alt'],
				$link['error']
			);
		}
		return new LinkValidation(
			$links,
			$response['uribl']
		);
	}

	/**
	 * @param array $response
	 * @return SpamTestResult[]
	 */
	public function getSpamResult(array $response): array
	{
		$result = [];
		foreach ($response as $result_data) {
			$this->validator->validateGetSpamResult($result_data);
			$result[] = new SpamTestResult(
				$result_data['client'],
				$result_data['type'],
				$result_data['spam'],
				$result_data['details']
			);
		}
		return $result;
	}

}