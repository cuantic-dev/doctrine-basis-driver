<?php

namespace Cuantic\Basis\Utility;

use Colors\Color;

/**
 * Traits to implement methods to write things to the console.
 *
 * @author Mauro Katzenstein <maurok@cuantic.com>
 * @link   https://github.com/mauroak/doctrine-basis-driver
 * @since  1.0
 */
trait Console
{
    /**
     * Prints a 'To do: implement this method' to the console.
     *
     * @param string $class The name of the class.
     * @param string $method The name of the method.
     *
     */
	function to_do_implement($class, $method)
	{
		$this->warn('To do: implement ' . $class . "::" . $method);
	}

    /**
     * Raises an 'Not yet implemented' Exception.
     *
     * @param string $class The name of the class.
     * @param string $method The name of the method.
     *
     */
	function not_yet_implemented($class, $method)
	{
		throw new \Exception('Not yet implemented ' . $class . "::" . $method);
	}

    /**
     * Prints a text with a warning color to the console.
     *
     * @param string $text The text to print.
     *
     */
    function warn($text)
	{
		$this->log_in_blue($text);
	}

    /**
     * Prints a text with an error color to the console.
     *
     * @param string $text The text to print.
     *
     */
	function error($text)
	{
		$this->log_in_red($text);
	}

    /**
     * Prints a text in blue color to the console.
     *
     * @param string $text The text to print.
     *
     */
	function log_in_blue($text)
	{
		$this->log($text, 'blue');
	}

    /**
     * Prints a text in red color to the console.
     *
     * @param string $text The text to print.
     *
     */
	function log_in_red($text)
	{
		$this->log($text, 'red');
	}

    /**
     * Prints a text in a color to the console.
     *
     * @param string $text The text to print.
     * @param string $color The color to print.
     *
     */
	function log($text, $color = 'white')
	{
        global $isRunningInTestMode;

        if( !isset($isRunningInTestMode) || !$isRunningInTestMode ) {
            return;
        }

        $c = new Color();
        echo $c($text)->$color() . PHP_EOL;
	}
}