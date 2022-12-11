<?php

namespace Tests;


use Mockery as m;
use App\Mobile;
use App\Call;
use App\Contact;
use App\Sms;
use App\Services\ContactService;
use App\Services\Providers\IVerizon;
use App\Services\Providers\IMobile;
use App\Interfaces\CarrierInterface;

use PHPUnit\Framework\TestCase;
/**
 * @runTestsInSeparateProcesses
 */
class MobileTest extends TestCase
{

	protected $provider;

	/**
	 * @runTestsInSeparateProcesses
	 */
	protected function setUp(): void
	{
		parent::setUp();

		$this->provider = m::mock(CarrierInterface::class);
	}

	/**
	 * @runTestsInSeparateProcesses
	 */
	/** @test */
	public function it_returns_null_when_name_empty()
	{
		$mobile = new Mobile($this->provider);

		$this->assertNull($mobile->makeCallByName(''));
	}

	/**
	 * @runTestsInSeparateProcesses
	 */
	/** @test */
	public function it_returns_a_call_instance_when_calling_by_name()
	{
		$call = m::mock('overload:'.Call::class);

		$contact = m::mock('overload:'.Contact::class);
		$contact->name = "Jean Sullon";
		$contact->number = "912285851";

		$this->provider->shouldReceive('dialContact')
			->withArgs([$contact]);

		$this->provider->shouldReceive('makeCall')
			->andReturn($call);

		m::mock('alias:'.ContactService::class)
			->shouldReceive('findByName')
			->withArgs(['Jean Sullon'])
			->andReturn($contact);
		
		$mobile = new Mobile($this->provider);

		$this->assertInstanceOf(Call::class, $mobile->makeCallByName('Jean Sullon'));
	}


	/**
	 * @runTestsInSeparateProcesses
	 */
	/** @test */
	public function it_throws_an_error_exception_if_invalid_phonenumber()
	{
		$sms = m::mock('overload:'.Sms::class);

		m::mock('alias:'.ContactService::class)
			->shouldReceive('validateNumber')
			->withArgs(['0001'])
			->andReturn(false);

		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('Number provided is invalid');

		$mobile = new Mobile($this->provider);
		$mobile->sendSms('0001', 'This is a test message!');
	}

}
