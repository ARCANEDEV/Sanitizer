<?php namespace Arcanedev\Sanitizer\Tests;

use Arcanedev\Sanitizer\Sanitizer;

class SanitizerTestTest extends \PHPUnit_Framework_TestCase
{
	/* ------------------------------------------------------------------------------------------------
	 |  Properties
	 | ------------------------------------------------------------------------------------------------
	 */
	/**
	 * @var Sanitizer
	 */
	protected $sanitizer;

	/* ------------------------------------------------------------------------------------------------
	 |  Main Functions
	 | ------------------------------------------------------------------------------------------------
	 */
	public function setUp()
	{
		$this->sanitizer = new UserSanitizerTest;
	}

	/* ------------------------------------------------------------------------------------------------
	 |  Test Functions
	 | ------------------------------------------------------------------------------------------------
	 */
	public function testIfCanSetSanitizerRules()
	{
		$rules = [
			'email' => 'trim|strtolower',
		];

		$this->sanitizer->setRules($rules);

		$this->assertTrue($this->sanitizer->hasRules());
	}

	public function testIfCanRegisterSanitizer()
	{
		$this->registerSlugSanitizer();

		$this->assertTrue($this->sanitizer->hasSanitizers());
	}

	public function testIfCanSanitizeByPhpFunctions()
	{
		$data = [
			'email' => ' hello@GMAIL.com  '
		];

		$rules = [
			'email' => 'trim|strtolower',
		];

		$data = $this->sanitizer->sanitize($data, $rules);

		$this->assertTrue($this->sanitizer->hasRules());
		$this->assertEquals(['email' => 'hello@gmail.com'], $data);
	}

	public function testIfCanSanitizeByClassMethodsOne()
	{
		$data = [
			'message' => 'hElLo !'
		];

		$rules = [
			'message' => 'helloMessage',
		];

		$this->assertEquals(['message' => 'Hello !'], $this->sanitizer->sanitize($data, $rules));
	}

	public function testIfCanSanitizeByClassMethodsTwo()
	{
		$data = [
			'email' => 'hello@GMAIL.com'
		];

		$rules = [
			'email' => 'email',
		];

		$this->assertEquals(['email' => 'hello@gmail.com'], $this->sanitizer->sanitize($data, $rules));
	}

	public function testIfCanSanitizeByCustomSanitizer()
	{
		$data = [
			'title' => 'Slugify this title',
		];

		$rules = [
			'title' => 'slug'
		];

		$this->registerSlugSanitizer();

		$this->assertEquals([
			'title' => 'slugify-this-title'
		], $this->sanitizer->sanitize($data, $rules));
	}

	/**
	 * @expectedException \Arcanedev\Sanitizer\Exceptions\InvalidSanitizersException
	 */
	public function testMustThrowInvalidSanitizersException()
	{
		$data = [
			'email' => ' hello@GMAIL.com  '
		];

		$this->sanitizer->sanitize($data, 'trim|ucfirst');
	}

	/**
	 * @expectedException \Arcanedev\Sanitizer\Exceptions\SanitizeMethodNotFound
	 */
	public function testMustThrowSanitizeMethodNotFound()
	{
		$data = [
			'email' => ' hello@GMAIL.com  '
		];

		$rule = [
			'email' => 'lastname',
		];

		$this->sanitizer->sanitize($data, $rule);
	}

	/**
	 * @expectedException \Arcanedev\Sanitizer\Exceptions\SanitizerMethodAlreadyExistsException
	 */
	public function testMustThrowMethodAlreadyExists()
	{
		$this->registerSlugSanitizer();

		$this->registerSlugSanitizer();
	}

	/* ------------------------------------------------------------------------------------------------
	 |  Other Functions
	 | ------------------------------------------------------------------------------------------------
	 */
	private function registerSlugSanitizer()
	{
		$this->sanitizer->register('slug', function ($value) {
			return str_replace(' ', '-', strtolower(trim($value)));
		});
	}
}
