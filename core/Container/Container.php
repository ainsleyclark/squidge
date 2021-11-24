<?php

/**
 * Container
 *
 * TODO
 *
 * @package     Squidge
 * @version     0.1.0
 * @category    Admin
 * @repo        https://github.com/ainsleyclark/wp-squidge
 *
 */

namespace Squidge\Container;

use Squidge\Services\Avif;
use Squidge\Services\JPG;
use Squidge\Services\PNG;
use Squidge\Services\SVG;
use Squidge\Services\WebP;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class Container
{

	/**
	 * The JPG Service.
	 *
	 * @var JPG
	 */
	public $JPG;

	/**
	 * The PNG Service.
	 *
	 * @var PNG
	 */
	public $PNG;

	/**
	 * The WebP Service.
	 *
	 * @var WebP
	 */
	public $WebP;

	/**
	 * The Avif Service.
	 *
	 * @var
	 */
	public $AVIF;

	/**
	 * Creates a new container for services.
	 *
	 * @since 0.1.0
	 * @date 24/11/2021
	 */
	public function __construct()
	{
		$this->JPG = new JPG();
		$this->PNG = new PNG();
		$this->WebP = new WebP();
		$this->AVIF = new Avif();
	}
}
