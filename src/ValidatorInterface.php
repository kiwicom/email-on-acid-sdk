<?php


namespace EmailOnAcid;


interface ValidatorInterface
{

	public function validateSuccessResponse(array $response);

	public function validateGetTests(array $testData);

}