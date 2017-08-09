<?php

namespace EmailOnAcid\Tests;


use EmailOnAcid\BaseService;
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
		$this->validator = isset($validatorFactory) ? $validatorFactory->createTestsValidator() : (new ValidatorFactory())->createTestsValidator();
	}

}