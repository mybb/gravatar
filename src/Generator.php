<?php
/**
 * Gravatar Generator.
 *
 * @author    MyBB Group
 * @version   2.0.0
 * @package   mybb/gravatar
 * @copyright Copyright (c) 2015, MyBB Group
 * @license   https://github.com/mybb/gravatar/blob/master/LICENSE MIT LICENSE
 * @link      http://www.mybb.com
 */

namespace MyBB\Gravatar;

class Generator
{
	/**
	 * Base URL to the Gravatar service.
	 */
	const BASEURL = 'http://www.gravatar.com/avatar/';

	/**
	 * Base URL to the Gravatar service for secure connections (over HTTPS).
	 */
	const BASEURL_SECURE = 'https://secure.gravatar.com/avatar/';

	/**
	 * @var array
	 */
	private static $defaultGravatars = [
		'404',
		'mm',
		'identicon',
		'monsterid',
		'wavatar',
		'retro',
		'blank',
	];

	/**
	 * @var array
	 */
	private static $ageRatings = [
		'g',
		'pg',
		'r',
		'x',
	];

	/**
	 * @var boolean $secure
	 */
	protected $secure;

	/**
	 * @var string $email
	 */
	protected $email;

	/**
	 * @var string
	 */
	protected $extension;

	/**
	 * @var integer $size
	 */
	protected $size;

	/**
	 * @var string $default
	 */
	protected $default;

	/**
	 * @var boolean $forceDefault
	 */
	protected $forceDefault;

	/**
	 * @var string $rating
	 */
	protected $rating;

	/**
	 * Initialise a new generator instance.
	 *
	 * @param array $settings Default settings to use for the generator.
	 */
	public function __construct(array $settings = null)
	{
		$defaults = [
			'secure'        => true,
			'extension'     => '.png',
			'size'          => 80,
			'default'       => 'mm',
			'force_default' => false,
			'rating'        => 'g',
		];

		if ($settings !== null) {
			$defaults = array_merge($defaults, $settings);
		}

		$this->setSecure($defaults['secure']);
		$this->setExtension($defaults['extension']);
		$this->setSize($defaults['size']);
		$this->setDefault($defaults['default']);
		$this->setForceDefault($defaults['force_default']);
		$this->setRating($defaults['rating']);
	}

	/**
	 * Whether to use Https for gravatars.
	 *
	 * @param boolean $secure
	 *
	 * @return $this
	 */
	public function setSecure($secure = true)
	{
		$this->secure = (bool) $secure;

		return $this;
	}

	/**
	 * Set image extension.
	 *
	 * @param string $extension
	 *
	 * @return $this
	 */
	public function setExtension($extension = '.png')
	{
		if (substr($extension, 0, 1) != '.') {
			$extension = '.' . $extension;
		}

		$this->extension = $extension;

		return $this;
	}

	/**
	 * Set image size.
	 *
	 * @param integer $size The size to be used
	 *
	 * @return $this
	 */
	public function setSize($size = 32)
	{
		$size = (int) $size;

		// Gravatars can be sized 1px up to 2048px square: https://en.gravatar.com/site/implement/images/#size
		if ($size < 1) {
			$size = 1;
		}

		if ($size > 2048) {
			$size = 2048;
		}

		$this->size = $size;

		return $this;
	}

	/**
	 * Set the default gravatar should one not exist for the email.
	 *
	 * @param string $default
	 *
	 * @return $this
	 */
	public function setDefault($default)
	{
		$default = trim($default);

		if (in_array((string) $default, static::$defaultGravatars)) {
			$this->default = (string) $default;
		} elseif (strpos($default, 'http') !== false && filter_var($default, FILTER_VALIDATE_URL)) {
			$this->default = urlencode($default);
		}

		return $this;
	}

	/**
	 * Force the default avatar.
	 *
	 * @param boolean $force
	 *
	 * @return $this
	 */
	public function setForceDefault($force = true)
	{
		$this->forceDefault = (bool) $force;
	}

	/**
	 * Set age rating.
	 *
	 * @param string $rating
	 *
	 * @return $this
	 */
	public function setRating($rating = 'g')
	{
		$rating = (string) $rating;

		if (in_array($rating, static::$ageRatings)) {
			$this->rating = $rating;
		}

		return $this;
	}

	/**
	 * Shortcut method to get Gravatar.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->getGravatar();
	}

	/**
	 * Get the gravatar.
	 *
	 * @param string $email
	 *
	 * @return string
	 */
	public function getGravatar($email = null)
	{
		if (isset($email)) {
			$this->setEmail((string) $email);
		}

		$url = self::BASEURL;
		if ($this->secure) {
			$url = self::BASEURL_SECURE;
		}

		$url .= $this->email;
		$url .= $this->extension;
		$url .= '?s=' . $this->size;
		$url .= '&d=' . $this->default;

		if ($this->forceDefault) {
			$url .= '&forcedefault=y';
		}

		$url .= '&rating=' . $this->rating;

		return $url;
	}

	/**
	 * Set email address.
	 *
	 * @param String $email The email address
	 *
	 * @return $this
	 */
	public function setEmail($email = '')
	{
		$email = (string) $email;

		// According to the docs, emails should be lowercase: https://en.gravatar.com/site/implement/hash/
		$email = trim($email);
		$email = strtolower($email);

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new \InvalidArgumentException('Email should be a valid email address');
		}

		$this->email = md5($email);

		return $this;
	}
}
