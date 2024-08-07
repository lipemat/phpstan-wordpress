<?php

/**
 * Stubs for the php-cli-tools library included in WP-CLI.
 *
 * Not part of core wp-cli stubs, but included in the wp-cli source.
 * - Support Progress Bar
 * - Support Table
 *
 * @link    https://github.com/php-stubs/wp-cli-stubs/pull/19
 * @link    https://app.asana.com/0/625351607402250/1207889298593878/f
 *
 * @todo    Kill this file on the next release of wp-cli-stubs. (2.10.1+)
 *          Update readme to reflect using the tools stubs from the wp-cli-stubs repo.
 *
 * Generated via running:
 * 1. Using GitHub Codespaces.
 * 2. Rename the `source/composer.json` to something other than `wp-cli-bundle`.
 *    1. Also delete the PHP 7.1 and ext requirements.
 * 3. `cd source`
 * 4. `composer require wp-cli/wp-cli-bundle`
 * 5. `cd ..`
 * 6. `bash -x generate.sh`
 *
 * @notice  Make have to delete the root `composer.lock` and run `composer install` to work.
 *
 * @version 0.11.22
 */

namespace cli;

/**
 * Parses command line arguments.
 */
class Arguments implements \ArrayAccess {
	protected $_flags = [];

	protected $_options = [];

	protected $_strict = false;

	protected $_input = [];

	protected $_invalid = [];

	protected $_parsed;

	protected $_lexer;


	/**
	 * Initializes the argument parser. If you wish to change the default behaviour
	 * you may pass an array of options as the first argument. Valid options are
	 * `'help'` and `'strict'`, each a boolean.
	 *
	 * `'help'` is `true` by default, `'strict'` is false by default.
	 *
	 * @param array $options An array of options for this parser.
	 */
	public function __construct( $options = [] ) {
	}


	/**
	 * Get the list of arguments found by the defined definitions.
	 *
	 * @return array
	 */
	public function getArguments() {
	}


	public function getHelpScreen() {
	}


	/**
	 * Encodes the parsed arguments as JSON.
	 *
	 * @return string
	 */
	public function asJSON() {
	}


	/**
	 * Returns true if a given argument was parsed.
	 *
	 * @param mixed $offset An Argument object or the name of the argument.
	 *
	 * @return bool
	 */
	#[\ReturnTypeWillChange]
	public function offsetExists( $offset ) {
	}


	/**
	 * Get the parsed argument's value.
	 *
	 * @param mixed $offset An Argument object or the name of the argument.
	 *
	 * @return mixed
	 */
	#[\ReturnTypeWillChange]
	public function offsetGet( $offset ) {
	}


	/**
	 * Sets the value of a parsed argument.
	 *
	 * @param mixed $offset An Argument object or the name of the argument.
	 * @param mixed $value  The value to set
	 */
	#[\ReturnTypeWillChange]
	public function offsetSet( $offset, $value ) {
	}


	/**
	 * Unset a parsed argument.
	 *
	 * @param mixed $offset An Argument object or the name of the argument.
	 */
	#[\ReturnTypeWillChange]
	public function offsetUnset( $offset ) {
	}


	/**
	 * Adds a flag (boolean argument) to the argument list.
	 *
	 * @param mixed $flag     A string representing the flag, or an array of strings.
	 * @param array $settings An array of settings for this flag.
	 *
	 * @setting string  description  A description to be shown in --help.
	 * @setting bool    default  The default value for this flag.
	 * @setting bool    stackable  Whether the flag is repeatable to increase the value.
	 * @setting array   aliases  Other ways to trigger this flag.
	 * @return $this
	 */
	public function addFlag( $flag, $settings = [] ) {
	}


	/**
	 * Add multiple flags at once. The input array should be keyed with the
	 * primary flag character, and the values should be the settings array
	 * used by {addFlag}.
	 *
	 * @param array $flags An array of flags to add
	 *
	 * @return $this
	 */
	public function addFlags( $flags ) {
	}


	/**
	 * Adds an option (string argument) to the argument list.
	 *
	 * @param mixed $option   A string representing the option, or an array of strings.
	 * @param array $settings An array of settings for this option.
	 *
	 * @setting string  description  A description to be shown in --help.
	 * @setting bool    default  The default value for this option.
	 * @setting array   aliases  Other ways to trigger this option.
	 * @return $this
	 */
	public function addOption( $option, $settings = [] ) {
	}


	/**
	 * Add multiple options at once. The input array should be keyed with the
	 * primary option string, and the values should be the settings array
	 * used by {addOption}.
	 *
	 * @param array $options An array of options to add
	 *
	 * @return $this
	 */
	public function addOptions( $options ) {
	}


	/**
	 * Enable or disable strict mode. If strict mode is active any invalid
	 * arguments found by the parser will throw `cli\arguments\InvalidArguments`.
	 *
	 * Even if strict is disabled, invalid arguments are logged and can be
	 * retrieved with `cli\Arguments::getInvalidArguments()`.
	 *
	 * @param bool $strict True to enable, false to disable.
	 *
	 * @return $this
	 */
	public function setStrict( $strict ) {
	}


	/**
	 * Get the list of invalid arguments the parser found.
	 *
	 * @return array
	 */
	public function getInvalidArguments() {
	}


	/**
	 * Get a flag by primary matcher or any defined aliases.
	 *
	 * @param mixed $flag   Either a string representing the flag or an
	 *                      cli\arguments\Argument object.
	 *
	 * @return array
	 */
	public function getFlag( $flag ) {
	}


	public function getFlags() {
	}


	public function hasFlags() {
	}


	/**
	 * Returns true if the given argument is defined as a flag.
	 *
	 * @param mixed $argument   Either a string representing the flag or an
	 *                          cli\arguments\Argument object.
	 *
	 * @return bool
	 */
	public function isFlag( $argument ) {
	}


	/**
	 * Returns true if the given flag is stackable.
	 *
	 * @param mixed $flag   Either a string representing the flag or an
	 *                      cli\arguments\Argument object.
	 *
	 * @return bool
	 */
	public function isStackable( $flag ) {
	}


	/**
	 * Get an option by primary matcher or any defined aliases.
	 *
	 * @param mixed $option  Either a string representing the option or an
	 *                       cli\arguments\Argument object.
	 *
	 * @return array
	 */
	public function getOption( $option ) {
	}


	public function getOptions() {
	}


	public function hasOptions() {
	}


	/**
	 * Returns true if the given argument is defined as an option.
	 *
	 * @param mixed $argument   Either a string representing the option or an
	 *                          cli\arguments\Argument object.
	 *
	 * @return bool
	 */
	public function isOption( $argument ) {
	}


	/**
	 * Parses the argument list with the given options. The returned argument list
	 * will use either the first long name given or the first name in the list
	 * if a long name is not given.
	 *
	 * @throws arguments\InvalidArguments
	 * @return array
	 */
	public function parse() {
	}
}

/**
 * The `Notify` class is the basis of all feedback classes, such as Indicators
 * and Progress meters. The default behaviour is to refresh output after 100ms
 * have passed. This is done to preventing the screen from flickering and keep
 * slowdowns from output to a minimum.
 *
 * The most basic form of Notifier has no maxim, and simply displays a series
 * of characters to indicate progress is being made.
 */
abstract class Notify {
	protected $_current = 0;

	protected $_first = true;

	protected $_interval;

	protected $_message;

	protected $_start;

	protected $_timer;

	protected $_tick;

	protected $_iteration = 0;

	protected $_speed = 0;


	/**
	 * Instatiates a Notification object.
	 *
	 * @param string $msg      The text to display next to the Notifier.
	 * @param int    $interval The interval in milliseconds between updates.
	 */
	public function __construct( $msg, $interval = 100 ) {
	}


	/**
	 * This method should be used to print out the Notifier. This method is
	 * called from `cli\Notify::tick()` after `cli\Notify::$_interval` has passed.
	 *
	 * @abstract
	 * @see cli\Notify::tick()
	 *
	 * @param boolean $finish
	 */
	public abstract function display( $finish = false );


	/**
	 * Reset the notifier state so the same instance can be used in multiple loops.
	 */
	public function reset() {
	}


	/**
	 * Returns the formatted tick count.
	 *
	 * @return string  The formatted tick count.
	 */
	public function current() {
	}


	/**
	 * Calculates the time elapsed since the Notifier was first ticked.
	 *
	 * @return int  The elapsed time in seconds.
	 */
	public function elapsed() {
	}


	/**
	 * Calculates the speed (number of ticks per second) at which the Notifier
	 * is being updated.
	 *
	 * @return int  The number of ticks performed in 1 second.
	 */
	public function speed() {
	}


	/**
	 * Takes a time span given in seconds and formats it for display. The
	 * returned string will be in MM:SS form.
	 *
	 * @param int $time The time span in seconds to format.
	 *
	 * @return string  The formatted time span.
	 */
	public function formatTime( $time ) {
	}


	/**
	 * Finish our Notification display. Should be called after the Notifier is
	 * no longer needed.
	 *
	 * @see cli\Notify::display()
	 */
	public function finish() {
	}


	/**
	 * Increments are tick counter by the given amount. If no amount is provided,
	 * the ticker is incremented by 1.
	 *
	 * @param int $increment The amount to increment by.
	 */
	public function increment( $increment = 1 ) {
	}


	/**
	 * Determines whether the display should be updated or not according to
	 * our interval setting.
	 *
	 * @return boolean  `true` if the display should be updated, `false` otherwise.
	 */
	public function shouldUpdate() {
	}


	/**
	 * This method is the meat of all Notifiers. First we increment the ticker
	 * and then update the display if enough time has passed since our last tick.
	 *
	 * @see cli\Notify::increment()
	 * @see cli\Notify::shouldUpdate()
	 * @see cli\Notify::display()
	 *
	 * @param int $increment The amount to increment by.
	 */
	public function tick( $increment = 1 ) {
	}
}

/**
 * A more complex type of Notifier, `Progress` Notifiers always have a maxim
 * value and generally show some form of percent complete or estimated time
 * to completion along with the standard Notifier displays.
 *
 * @see cli\Notify
 */
abstract class Progress extends \cli\Notify {
	protected $_total = 0;


	/**
	 * Instantiates a Progress Notifier.
	 *
	 * @see cli\Progress::setTotal()
	 *
	 * @param int    $total    The total number of ticks we will be performing.
	 * @param int    $interval The interval in milliseconds between updates.
	 * @param string $msg      The text to display next to the Notifier.
	 */
	public function __construct( $msg, $total, $interval = 100 ) {
	}


	/**
	 * Set the max increments for this progress notifier.
	 *
	 * @param int $total The total number of times this indicator should be `tick`ed.
	 *
	 * @throws \InvalidArgumentException  Thrown if the `$total` is less than 0.
	 */
	public function setTotal( $total ) {
	}


	/**
	 * Reset the progress state so the same instance can be used in multiple loops.
	 */
	public function reset( $total = null ) {
	}


	/**
	 * Behaves in a similar manner to `cli\Notify::current()`, but the output
	 * is padded to match the length of `cli\Progress::total()`.
	 *
	 * @see cli\Progress::total()
	 * @return string  The formatted and padded tick count.
	 */
	public function current() {
	}


	/**
	 * Returns the formatted total expected ticks.
	 *
	 * @return string  The formatted total ticks.
	 */
	public function total() {
	}


	/**
	 * Calculates the estimated total time for the tick count to reach the
	 * total ticks given.
	 *
	 * @see cli\Notify::speed()
	 * @see cli\Notify::elapsed()
	 * @return int  The estimated total number of seconds for all ticks to be
	 *              completed. This is not the estimated time left, but total.
	 */
	public function estimated() {
	}


	/**
	 * Forces the current tick count to the total ticks given at instatiation
	 * time before passing on to `cli\Notify::finish()`.
	 */
	public function finish() {
	}


	/**
	 * Increments are tick counter by the given amount. If no amount is provided,
	 * the ticker is incremented by 1.
	 *
	 * @param int $increment The amount to increment by.
	 */
	public function increment( $increment = 1 ) {
	}


	/**
	 * Calculate the percentage completed.
	 *
	 * @return float  The percent completed.
	 */
	public function percent() {
	}
}

namespace cli\progress;

/**
 * Displays a progress bar spanning the entire shell.
 *
 * Basic format:
 *
 *   ^MSG  PER% [=======================            ]  00:00 / 00:00$
 */
class Bar extends \cli\Progress {
	protected $_bars = '=>';

	protected $_formatMessage = '{:msg}  {:percent}% [';

	protected $_formatTiming = '] {:elapsed} / {:estimated}';

	protected $_format = '{:msg}{:bar}{:timing}';


	/**
	 * Prints the progress bar to the screen with percent complete, elapsed time
	 * and estimated total time.
	 *
	 * @see cli\out()
	 * @see cli\Notify::formatTime()
	 * @see cli\Notify::elapsed()
	 * @see cli\Progress::estimated();
	 * @see cli\Progress::percent()
	 * @see cli\Shell::columns()
	 *
	 * @param boolean $finish   `true` if this was called from
	 *                          `cli\Notify::finish()`, `false` otherwise.
	 */
	public function display( $finish = false ) {
	}


	/**
	 * This method augments the base definition from cli\Notify to optionally
	 * allow passing a new message.
	 *
	 * @see cli\Notify::tick()
	 *
	 * @param string $msg       The text to display next to the Notifier. (optional)
	 * @param int    $increment The amount to increment by.
	 */
	public function tick( $increment = 1, $msg = null ) {
	}
}

namespace cli\notify;

/**
 * A Notifer that displays a string of periods.
 */
class Dots extends \cli\Notify {
	protected $_dots;

	protected $_format = '{:msg}{:dots}  ({:elapsed}, {:speed}/s)';

	protected $_iteration;


	/**
	 * Instatiates a Notification object.
	 *
	 * @param string $msg      The text to display next to the Notifier.
	 * @param int    $dots     The number of dots to iterate through.
	 * @param int    $interval The interval in milliseconds between updates.
	 *
	 * @throws \InvalidArgumentException
	 */
	public function __construct( $msg, $dots = 3, $interval = 100 ) {
	}


	/**
	 * Prints the correct number of dots to `STDOUT` with the time elapsed and
	 * tick speed.
	 *
	 * @see cli\out_padded()
	 * @see cli\Notify::formatTime()
	 * @see cli\Notify::speed()
	 *
	 * @param boolean $finish   `true` if this was called from
	 *                          `cli\Notify::finish()`, `false` otherwise.
	 */
	public function display( $finish = false ) {
	}
}

/**
 * The `Spinner` Notifier displays an ASCII spinner.
 */
class Spinner extends \cli\Notify {
	protected $_chars = '-\\|/';

	protected $_format = '{:msg} {:char}  ({:elapsed}, {:speed}/s)';

	protected $_iteration = 0;


	/**
	 * Prints the current spinner position to `STDOUT` with the time elapsed
	 * and tick speed.
	 *
	 * @see cli\out_padded()
	 * @see cli\Notify::formatTime()
	 * @see cli\Notify::speed()
	 *
	 * @param boolean $finish   `true` if this was called from
	 *                          `cli\Notify::finish()`, `false` otherwise.
	 */
	public function display( $finish = false ) {
	}
}

namespace cli;

/**
 * Change the color of text.
 *
 * Reference: http://graphcomp.com/info/specs/ansi_col.html#colors
 */
class Colors {
	protected static $_colors = [ 'color' => [ 'black' => 30, 'red' => 31, 'green' => 32, 'yellow' => 33, 'blue' => 34, 'magenta' => 35, 'cyan' => 36, 'white' => 37 ], 'style' => [ 'bright' => 1, 'dim' => 2, 'underline' => 4, 'blink' => 5, 'reverse' => 7, 'hidden' => 8 ], 'background' => [ 'black' => 40, 'red' => 41, 'green' => 42, 'yellow' => 43, 'blue' => 44, 'magenta' => 45, 'cyan' => 46, 'white' => 47 ] ];

	protected static $_enabled = null;

	protected static $_string_cache = [];


	public static function enable( $force = true ) {
	}


	public static function disable( $force = true ) {
	}


	/**
	 * Check if we should colorize output based on local flags and shell type.
	 *
	 * Only check the shell type if `Colors::$_enabled` is null and `$colored` is null.
	 */
	public static function shouldColorize( $colored = null ) {
	}


	/**
	 * Set the color.
	 *
	 * @param string $color The name of the color or style to set.
	 *
	 * @return string
	 */
	public static function color( $color ) {
	}


	/**
	 * Colorize a string using helpful string formatters. If the `Streams::$out` points to a TTY coloring will be enabled,
	 * otherwise disabled. You can control this check with the `$colored` parameter.
	 *
	 * @param string  $string
	 * @param boolean $colored Force enable or disable the colorized output. If left as `null` the TTY will control coloring.
	 *
	 * @return string
	 */
	public static function colorize( $string, $colored = null ) {
	}


	/**
	 * Remove color information from a string.
	 *
	 * @param string $string A string with color information.
	 * @param int    $keep   Optional. If the 1 bit is set, color tokens (eg "%n") won't be stripped. If the 2 bit is set, color encodings
	 *                       (ANSI escapes) won't be stripped. Default 0.
	 *
	 * @return string A string with color information removed.
	 */
	public static function decolorize( $string, $keep = 0 ) {
	}


	/**
	 * Cache the original, colorized, and decolorized versions of a string.
	 *
	 * @param string $passed     The original string before colorization.
	 * @param string $colorized  The string after running through self::colorize.
	 * @param string $deprecated Optional. Not used. Default null.
	 */
	public static function cacheString( $passed, $colorized, $deprecated = null ) {
	}


	/**
	 * Return the length of the string without color codes.
	 *
	 * @param string $string the string to measure
	 *
	 * @return int
	 */
	public static function length( $string ) {
	}


	/**
	 * Return the width (length in characters) of the string without color codes if enabled.
	 *
	 * @param string      $string        The string to measure.
	 * @param bool        $pre_colorized Optional. Set if the string is pre-colorized. Default false.
	 * @param string|bool $encoding      Optional. The encoding of the string. Default false.
	 *
	 * @return int
	 */
	public static function width( $string, $pre_colorized = false, $encoding = false ) {
	}


	/**
	 * Pad the string to a certain display length.
	 *
	 * @param string      $string        The string to pad.
	 * @param int         $length        The display length.
	 * @param bool        $pre_colorized Optional. Set if the string is pre-colorized. Default false.
	 * @param string|bool $encoding      Optional. The encoding of the string. Default false.
	 * @param int         $pad_type      Optional. Can be STR_PAD_RIGHT, STR_PAD_LEFT, or STR_PAD_BOTH. If pad_type is not specified it is
	 *                                   assumed to be STR_PAD_RIGHT.
	 *
	 * @return string
	 */
	public static function pad( $string, $length, $pre_colorized = false, $encoding = false, $pad_type = STR_PAD_RIGHT ) {
	}


	/**
	 * Get the color mapping array.
	 *
	 * @return array Array of color tokens mapped to colors and styles.
	 */
	public static function getColors() {
	}


	/**
	 * Get the cached string values.
	 *
	 * @return array The cached string values.
	 */
	public static function getStringCache() {
	}


	/**
	 * Clear the string cache.
	 */
	public static function clearStringCache() {
	}
}

class Streams {
	protected static $out = STDOUT;

	protected static $in = STDIN;

	protected static $err = STDERR;


	static function _call( $func, $args ) {
	}


	public static function isTty() {
	}


	/**
	 * Handles rendering strings. If extra scalar arguments are given after the `$msg`
	 * the string will be rendered with `sprintf`. If the second argument is an `array`
	 * then each key in the array will be the placeholder name. Placeholders are of the
	 * format {:key}.
	 *
	 * @param string $msg The message to render.
	 * @param mixed    ...   Either scalar arguments or a single array argument.
	 *
	 * @return string  The rendered string.
	 */
	public static function render( $msg ) {
	}


	/**
	 * Shortcut for printing to `STDOUT`. The message and parameters are passed
	 * through `sprintf` before output.
	 *
	 * @see \cli\render()
	 *
	 * @param mixed   ...   Either scalar arguments or a single array argument.
	 * @param string $msg The message to output in `printf` format.
	 *
	 * @return void
	 */
	public static function out( $msg ) {
	}


	/**
	 * Pads `$msg` to the width of the shell before passing to `cli\out`.
	 *
	 * @see cli\out()
	 *
	 * @param mixed   ...   Either scalar arguments or a single array argument.
	 * @param string $msg The message to pad and pass on.
	 *
	 * @return void
	 */
	public static function out_padded( $msg ) {
	}


	/**
	 * Prints a message to `STDOUT` with a newline appended. See `\cli\out` for
	 * more documentation.
	 *
	 * @see cli\out()
	 */
	public static function line( $msg = '' ) {
	}


	/**
	 * Shortcut for printing to `STDERR`. The message and parameters are passed
	 * through `sprintf` before output.
	 *
	 * @param string $msg   The message to output in `printf` format. With no string,
	 *                      a newline is printed.
	 * @param mixed   ...   Either scalar arguments or a single array argument.
	 *
	 * @return void
	 */
	public static function err( $msg = '' ) {
	}


	/**
	 * Takes input from `STDIN` in the given format. If an end of transmission
	 * character is sent (^D), an exception is thrown.
	 *
	 * @param string  $format  A valid input format. See `fscanf` for documentation.
	 *                         If none is given, all input up to the first newline
	 *                         is accepted.
	 * @param boolean $hide    If true will hide what the user types in.
	 *
	 * @throws \Exception  Thrown if ctrl-D (EOT) is sent as input.
	 * @return string  The input with whitespace trimmed.
	 */
	public static function input( $format = null, $hide = false ) {
	}


	/**
	 * Displays an input prompt. If no default value is provided the prompt will
	 * continue displaying until input is received.
	 *
	 * @see cli\input()
	 *
	 * @param bool|string $default  A default value if the user provides no input.
	 * @param string      $marker   A string to append to the question and default value
	 *                              on display.
	 * @param boolean     $hide     Optionally hides what the user types in.
	 * @param string      $question The question to ask the user.
	 *
	 * @return string  The users input.
	 */
	public static function prompt( $question, $default = false, $marker = ': ', $hide = false ) {
	}


	/**
	 * Presents a user with a multiple choice question, useful for 'yes/no' type
	 * questions (which this public static function defaults too).
	 *
	 * @see cli\prompt()
	 *
	 * @param string $choice   A string of characters allowed as a response. Case is ignored.
	 * @param string $default  The default choice. NULL if a default is not allowed.
	 * @param string $question The question to ask the user.
	 *
	 * @return string  The users choice.
	 */
	public static function choose( $question, $choice = 'yn', $default = 'n' ) {
	}


	/**
	 * Displays an array of strings as a menu where a user can enter a number to
	 * choose an option. The array must be a single dimension with either strings
	 * or objects with a `__toString()` method.
	 *
	 * @see cli\line()
	 * @see cli\input()
	 * @see cli\err()
	 *
	 * @param array  $items   The list of items the user can choose from.
	 * @param string $default The index of the default item.
	 * @param string $title   The message displayed to the user when prompted.
	 *
	 * @return string  The index of the chosen item.
	 */
	public static function menu( $items, $default = null, $title = 'Choose an item' ) {
	}


	/**
	 * Sets one of the streams (input, output, or error) to a `stream` type resource.
	 *
	 * Valid $whichStream values are:
	 *    - 'in'   (default: STDIN)
	 *    - 'out'  (default: STDOUT)
	 *    - 'err'  (default: STDERR)
	 *
	 * Any custom streams will be closed for you on shutdown, so please don't close stream
	 * resources used with this method.
	 *
	 * @param string   $whichStream The stream property to update
	 * @param resource $stream      The new stream resource to use
	 *
	 * @throws \Exception Thrown if $stream is not a resource of the 'stream' type.
	 * @return void
	 */
	public static function setStream( $whichStream, $stream ) {
	}
}

abstract class Memoize {
	protected $_memoCache = [];


	public function __get( $name ) {
	}


	protected function _unmemo( $name ) {
	}
}

namespace cli\arguments;

class Lexer extends \cli\Memoize implements \Iterator {
	/**
	 * @param array $items A list of strings to process as tokens.
	 */
	public function __construct( array $items ) {
	}


	/**
	 * The current token.
	 *
	 * @return string
	 */
	#[\ReturnTypeWillChange]
	public function current() {
	}


	/**
	 * Peek ahead to the next token without moving the cursor.
	 *
	 * @return Argument
	 */
	public function peek() {
	}


	/**
	 * Move the cursor forward 1 element if it is valid.
	 */
	#[\ReturnTypeWillChange]
	public function next() {
	}


	/**
	 * Return the current position of the cursor.
	 *
	 * @return int
	 */
	#[\ReturnTypeWillChange]
	public function key() {
	}


	/**
	 * Move forward 1 element and, if the method hasn't been called before, reset
	 * the cursor's position to 0.
	 */
	#[\ReturnTypeWillChange]
	public function rewind() {
	}


	/**
	 * Returns true if the cursor has not reached the end of the list.
	 *
	 * @return bool
	 */
	#[\ReturnTypeWillChange]
	public function valid() {
	}


	/**
	 * Push an element to the front of the stack.
	 *
	 * @param mixed $item The value to set
	 */
	public function unshift( $item ) {
	}


	/**
	 * Returns true if the cursor is at the end of the list.
	 *
	 * @return bool
	 */
	public function end() {
	}
}

/**
 * Thrown when undefined arguments are detected in strict mode.
 */
class InvalidArguments extends \InvalidArgumentException {
	protected $arguments;


	/**
	 * @param array $arguments A list of arguments that do not fit the profile.
	 */
	public function __construct( array $arguments ) {
	}


	/**
	 * Get the arguments that caused the exception.
	 *
	 * @return array
	 */
	public function getArguments() {
	}
}

/**
 * Represents an Argument or a value and provides several helpers related to parsing an argument list.
 */
class Argument extends \cli\Memoize {
	/**
	 * The canonical name of this argument, used for aliasing.
	 *
	 * @param string
	 */
	public $key;


	/**
	 * @param string $argument The raw argument, leading dashes included.
	 */
	public function __construct( $argument ) {
	}


	/**
	 * Returns the raw input as a string.
	 *
	 * @return string
	 */
	public function __toString() {
	}


	/**
	 * Returns the formatted argument string.
	 *
	 * @return string
	 */
	public function value() {
	}


	/**
	 * Returns the raw input.
	 *
	 * @return mixed
	 */
	public function raw() {
	}


	/**
	 * Returns true if the string matches the pattern for long arguments.
	 *
	 * @return bool
	 */
	public function isLong() {
	}


	/**
	 * Returns true if the string matches the pattern for short arguments.
	 *
	 * @return bool
	 */
	public function isShort() {
	}


	/**
	 * Returns true if the string matches the pattern for arguments.
	 *
	 * @return bool
	 */
	public function isArgument() {
	}


	/**
	 * Returns true if the string matches the pattern for values.
	 *
	 * @return bool
	 */
	public function isValue() {
	}


	/**
	 * Returns true if the argument is short but contains several characters. Each
	 * character is considered a separate argument.
	 *
	 * @return bool
	 */
	public function canExplode() {
	}


	/**
	 * Returns all but the first character of the argument, removing them from the
	 * objects representation at the same time.
	 *
	 * @return array
	 */
	public function exploded() {
	}
}

/**
 * Arguments help screen renderer
 */
class HelpScreen {
	protected $_flags = [];

	protected $_flagMax = 0;

	protected $_options = [];

	protected $_optionMax = 0;


	public function __construct( \cli\Arguments $arguments ) {
	}


	public function __toString() {
	}


	public function setArguments( \cli\Arguments $arguments ) {
	}


	public function consumeArgumentFlags( \cli\Arguments $arguments ) {
	}


	public function consumeArgumentOptions( \cli\Arguments $arguments ) {
	}


	public function render() {
	}
}

namespace cli;

/**
 * The `Tree` class is used to display data in a tree-like format.
 */
class Tree {
	protected $_renderer;

	protected $_data = [];


	/**
	 * Sets the renderer used by this tree.
	 *
	 * @see   tree\Renderer
	 * @see   tree\Ascii
	 * @see   tree\Markdown
	 *
	 * @param tree\Renderer $renderer The renderer to use for output.
	 */
	public function setRenderer( \cli\tree\Renderer $renderer ) {
	}


	/**
	 * Set the data.
	 * Format:
	 *     [
	 *         'Label' => [
	 *             'Thing' => ['Thing'],
	 *         ],
	 *         'Thing',
	 *     ]
	 *
	 * @param array $data
	 */
	public function setData( array $data ) {
	}


	/**
	 * Render the tree and return it as a string.
	 *
	 * @return string|null
	 */
	public function render() {
	}


	/**
	 * Display the rendered tree
	 */
	public function display() {
	}
}

/**
 * The `Shell` class is a utility class for shell related tasks such as
 * information on width.
 */
class Shell {
	/**
	 * Returns the number of columns the current shell has for display.
	 *
	 * @todo Test on more systems.
	 * @return int  The number of columns.
	 */
	public static function columns() {
	}


	/**
	 * Checks whether the output of the current script is a TTY or a pipe / redirect
	 *
	 * Returns true if STDOUT output is being redirected to a pipe or a file; false is
	 * output is being sent directly to the terminal.
	 *
	 * If an env variable SHELL_PIPE exists, returned result depends it's
	 * value. Strings like 1, 0, yes, no, that validate to booleans are accepted.
	 *
	 * To enable ASCII formatting even when shell is piped, use the
	 * ENV variable SHELL_PIPE=0
	 *
	 * @return bool
	 */
	public static function isPiped() {
	}


	/**
	 * Uses `stty` to hide input/output completely.
	 *
	 * @param boolean $hidden Will hide/show the next data. Defaults to true.
	 */
	public static function hide( $hidden = true ) {
	}
}

namespace cli\tree;

/**
 * Tree renderers are used to change how a tree is displayed.
 */
abstract class Renderer {
	/**
	 * @param array $tree
	 *
	 * @return string|null
	 */
	public abstract function render( array $tree );
}

/**
 * The ASCII renderer renders trees with ASCII lines.
 */
class Markdown extends \cli\tree\Renderer {
	/**
	 * How many spaces to indent by
	 *
	 * @var int
	 */
	protected $_padding = 2;


	/**
	 * @param int $padding Optional. Default 2.
	 */
	function __construct( $padding = null ) {
	}


	/**
	 * Renders the tree
	 *
	 * @param array $tree
	 * @param int   $level Optional
	 *
	 * @return string
	 */
	public function render( array $tree, $level = 0 ) {
	}
}

/**
 * The ASCII renderer renders trees with ASCII lines.
 */
class Ascii extends \cli\tree\Renderer {
	/**
	 * @param array $tree
	 *
	 * @return string
	 */
	public function render( array $tree ) {
	}
}

namespace cli\table;

/**
 * Table renderers are used to change how a table is displayed.
 */
abstract class Renderer {
	protected $_widths = [];


	public function __construct( array $widths = [] ) {
	}


	/**
	 * Set the widths of each column in the table.
	 *
	 * @param array $widths   The widths of the columns.
	 * @param bool  $fallback Whether to use these values as fallback only.
	 */
	public function setWidths( array $widths, $fallback = false ) {
	}


	/**
	 * Render a border for the top and bottom and separating the headers from the
	 * table rows.
	 *
	 * @return string  The table border.
	 */
	public function border() {
	}


	/**
	 * Renders a row for output.
	 *
	 * @param array $row The table row.
	 *
	 * @return string  The formatted table row.
	 */
	public abstract function row( array $row );
}

/**
 * The tabular renderer is used for displaying data in a tabular format.
 */
class Tabular extends \cli\table\Renderer {
	/**
	 * Renders a row for output.
	 *
	 * @param array $row The table row.
	 *
	 * @return string  The formatted table row.
	 */
	public function row( array $row ) {
	}
}

/**
 * The ASCII renderer renders tables with ASCII borders.
 */
class Ascii extends \cli\table\Renderer {
	protected $_characters = [ 'corner' => '+', 'line' => '-', 'border' => '|', 'padding' => ' ' ];

	protected $_border = null;

	protected $_constraintWidth = null;

	protected $_pre_colorized = false;


	/**
	 * Set the widths of each column in the table.
	 *
	 * @param array $widths   The widths of the columns.
	 * @param bool  $fallback Whether to use these values as fallback only.
	 */
	public function setWidths( array $widths, $fallback = false ) {
	}


	/**
	 * Set the constraint width for the table
	 *
	 * @param int $constraintWidth
	 */
	public function setConstraintWidth( $constraintWidth ) {
	}


	/**
	 * Set the characters used for rendering the Ascii table.
	 *
	 * The keys `corner`, `line` and `border` are used in rendering.
	 *
	 * @param $characters  array  Characters used in rendering.
	 */
	public function setCharacters( array $characters ) {
	}


	/**
	 * Render a border for the top and bottom and separating the headers from the
	 * table rows.
	 *
	 * @return string  The table border.
	 */
	public function border() {
	}


	/**
	 * Renders a row for output.
	 *
	 * @param array $row The table row.
	 *
	 * @return string  The formatted table row.
	 */
	public function row( array $row ) {
	}


	/**
	 * Set whether items are pre-colorized.
	 *
	 * @param bool|array $colorized A boolean to set all columns in the table as pre-colorized, or an array of booleans keyed by column
	 *                              index (number) to set individual columns as pre-colorized.
	 */
	public function setPreColorized( $pre_colorized ) {
	}


	/**
	 * Is a column pre-colorized?
	 *
	 * @param int $column Column index to check.
	 *
	 * @return bool True if whole table is marked as pre-colorized, or if the individual column is pre-colorized; else false.
	 */
	public function isPreColorized( $column ) {
	}
}

namespace cli;

/**
 * The `Table` class is used to display data in a tabular format.
 */
class Table {
	protected $_renderer;

	protected $_headers = [];

	protected $_footers = [];

	protected $_width = [];

	protected $_rows = [];


	/**
	 * Initializes the `Table` class.
	 *
	 * There are 3 ways to instantiate this class:
	 *
	 *  1. Pass an array of strings as the first parameter for the column headers
	 *     and a 2-dimensional array as the second parameter for the data rows.
	 *  2. Pass an array of hash tables (string indexes instead of numerical)
	 *     where each hash table is a row and the indexes of the *first* hash
	 *     table are used as the header values.
	 *  3. Pass nothing and use `setHeaders()` and `addRow()` or `setRows()`.
	 *
	 * @param array $headers Headers used in this table. Optional.
	 * @param array $rows    The rows of data for this table. Optional.
	 * @param array $footers Footers used in this table. Optional.
	 */
	public function __construct( array $headers = null, array $rows = null, array $footers = null ) {
	}


	public function resetTable() {
	}


	/**
	 * Sets the renderer used by this table.
	 *
	 * @see   table\Renderer
	 * @see   table\Ascii
	 * @see   table\Tabular
	 *
	 * @param table\Renderer $renderer The renderer to use for output.
	 */
	public function setRenderer( \cli\table\Renderer $renderer ) {
	}


	/**
	 * Loops through the row and sets the maximum width for each column.
	 *
	 * @param array $row The table row.
	 *
	 * @return array $row
	 */
	protected function checkRow( array $row ) {
	}


	/**
	 * Output the table to `STDOUT` using `cli\line()`.
	 *
	 * If STDOUT is a pipe or redirected to a file, should output simple
	 * tab-separated text. Otherwise, renders table with ASCII table borders
	 *
	 * @see  cli\Table::renderRow()
	 * @uses cli\Shell::isPiped() Determine what format to output
	 *
	 */
	public function display() {
	}


	/**
	 * Get the table lines to output.
	 *
	 * @see cli\Table::display()
	 * @see cli\Table::renderRow()
	 *
	 * @return array
	 */
	public function getDisplayLines() {
	}


	/**
	 * Sort the table by a column. Must be called before `cli\Table::display()`.
	 *
	 * @param int $column The index of the column to sort by.
	 */
	public function sort( $column ) {
	}


	/**
	 * Set the headers of the table.
	 *
	 * @param array $headers An array of strings containing column header names.
	 */
	public function setHeaders( array $headers ) {
	}


	/**
	 * Set the footers of the table.
	 *
	 * @param array $footers An array of strings containing column footers names.
	 */
	public function setFooters( array $footers ) {
	}


	/**
	 * Add a row to the table.
	 *
	 * @see cli\Table::checkRow()
	 *
	 * @param array $row The row data.
	 */
	public function addRow( array $row ) {
	}


	/**
	 * Clears all previous rows and adds the given rows.
	 *
	 * @see cli\Table::addRow()
	 *
	 * @param array $rows A 2-dimensional array of row data.
	 */
	public function setRows( array $rows ) {
	}


	public function countRows() {
	}


	/**
	 * Set whether items in an Ascii table are pre-colorized.
	 *
	 * @see cli\Ascii::setPreColorized()
	 *
	 * @param bool|array $precolorized A boolean to set all columns in the table as pre-colorized, or an array of booleans keyed by column
	 *                                 index (number) to set individual columns as pre-colorized.
	 */
	public function setAsciiPreColorized( $pre_colorized ) {
	}
}
/**
 * PHP Command Line Tools
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 *
 * @author    James Logsdon <dwarf@girsbrain.org>
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @copyright 2010 James Logsdom (http://girsbrain.org)
 */

namespace cli;

/**
 * Handles rendering strings. If extra scalar arguments are given after the `$msg`
 * the string will be rendered with `sprintf`. If the second argument is an `array`
 * then each key in the array will be the placeholder name. Placeholders are of the
 * format {:key}.
 *
 * @param string $msg The message to render.
 * @param mixed    ...   Either scalar arguments or a single array argument.
 *
 * @return string  The rendered string.
 */
function render( $msg ) {
}

/**
 * Shortcut for printing to `STDOUT`. The message and parameters are passed
 * through `sprintf` before output.
 *
 * @see \cli\render()
 *
 * @param mixed   ...   Either scalar arguments or a single array argument.
 * @param string $msg The message to output in `printf` format.
 *
 * @return void
 */
function out( $msg ) {
}

/**
 * Pads `$msg` to the width of the shell before passing to `cli\out`.
 *
 * @see cli\out()
 *
 * @param mixed   ...   Either scalar arguments or a single array argument.
 * @param string $msg The message to pad and pass on.
 *
 * @return void
 */
function out_padded( $msg ) {
}

/**
 * Prints a message to `STDOUT` with a newline appended. See `\cli\out` for
 * more documentation.
 *
 * @see cli\out()
 */
function line( $msg = '' ) {
}

/**
 * Shortcut for printing to `STDERR`. The message and parameters are passed
 * through `sprintf` before output.
 *
 * @param string $msg   The message to output in `printf` format. With no string,
 *                      a newline is printed.
 * @param mixed   ...   Either scalar arguments or a single array argument.
 *
 * @return void
 */
function err( $msg = '' ) {
}

/**
 * Takes input from `STDIN` in the given format. If an end of transmission
 * character is sent (^D), an exception is thrown.
 *
 * @param string $format   A valid input format. See `fscanf` for documentation.
 *                         If none is given, all input up to the first newline
 *                         is accepted.
 *
 * @throws \Exception  Thrown if ctrl-D (EOT) is sent as input.
 * @return string  The input with whitespace trimmed.
 */
function input( $format = null ) {
}

/**
 * Displays an input prompt. If no default value is provided the prompt will
 * continue displaying until input is received.
 *
 * @see cli\input()
 *
 * @param string|false $default  A default value if the user provides no input. Default false.
 * @param string       $marker   A string to append to the question and default value on display.
 * @param boolean      $hide     If the user input should be hidden
 * @param string       $question The question to ask the user.
 *
 * @return string  The users input.
 */
function prompt( $question, $default = false, $marker = ': ', $hide = false ) {
}

/**
 * Presents a user with a multiple choice question, useful for 'yes/no' type
 * questions (which this function defaults too).
 *
 * @see                           cli\prompt()
 * @internal                      param string $valid  A string of characters allowed as a response. Case
 *                                is ignored.
 *
 * @param string|null $default  The default choice. NULL if a default is not allowed.
 * @param string      $question The question to ask the user.
 * @param string      $choice
 *
 * @return string  The users choice.
 */
function choose( $question, $choice = 'yn', $default = 'n' ) {
}

/**
 * Does the same as {@see choose()}, but always asks yes/no and returns a boolean
 *
 * @param string    $question The question to ask the user.
 * @param bool|null $default  The default choice, in a boolean format.
 *
 * @return bool
 */
function confirm( $question, $default = false ) {
}

/**
 * Displays an array of strings as a menu where a user can enter a number to
 * choose an option. The array must be a single dimension with either strings
 * or objects with a `__toString()` method.
 *
 * @see cli\line()
 * @see cli\input()
 * @see cli\err()
 *
 * @param array  $items   The list of items the user can choose from.
 * @param string $default The index of the default item.
 * @param string $title   The message displayed to the user when prompted.
 *
 * @return string  The index of the chosen item.
 */
function menu( $items, $default = null, $title = 'Choose an item' ) {
}

/**
 * Attempts an encoding-safe way of getting string length. If intl extension or PCRE with '\X' or mb_string extension aren't
 * available, falls back to basic strlen.
 *
 * @param string      $str      The string to check.
 * @param string|bool $encoding Optional. The encoding of the string. Default false.
 *
 * @return int  Numeric value that represents the string's length
 */
function safe_strlen( $str, $encoding = false ) {
}

/**
 * Attempts an encoding-safe way of getting a substring. If intl extension or PCRE with '\X' or mb_string extension aren't
 * available, falls back to substr().
 *
 * @param string        $str      The input string.
 * @param int           $start    The starting position of the substring.
 * @param int|bool|null $length   Optional, unless $is_width is set. Maximum length of the substring. Default false. Negative not
 *                                supported.
 * @param int|bool      $is_width Optional. If set and encoding is UTF-8, $length (which must be specified) is interpreted as spacing
 *                                width. Default false.
 * @param string|bool   $encoding Optional. The encoding of the string. Default false.
 *
 * @return bool|string  False if given unsupported args, otherwise substring of string specified by start and length parameters
 */
function safe_substr( $str, $start, $length = false, $is_width = false, $encoding = false ) {
}

/**
 * Internal function used by `safe_substr()` to adjust for East Asian double-width chars.
 *
 * @return string
 */
function _safe_substr_eaw( $str, $length ) {
}

/**
 * An encoding-safe way of padding string length for display
 *
 * @param string      $string   The string to pad.
 * @param int         $length   The length to pad it to.
 * @param string|bool $encoding Optional. The encoding of the string. Default false.
 *
 * @return string
 */
function safe_str_pad( $string, $length, $encoding = false ) {
}

/**
 * Get width of string, ie length in characters, taking into account multi-byte and mark characters for UTF-8, and multi-byte for non-UTF-8.
 *
 * @param string      $string   The string to check.
 * @param string|bool $encoding Optional. The encoding of the string. Default false.
 *
 * @return int  The string's width.
 */
function strwidth( $string, $encoding = false ) {
}

/**
 * Returns whether ICU is modern enough not to flake out.
 *
 * @return bool
 */
function can_use_icu() {
}

/**
 * Returns whether PCRE Unicode extended grapheme cluster '\X' is available for use.
 *
 * @return bool
 */
function can_use_pcre_x() {
}

/**
 * Get the regexs generated from Unicode data.
 *
 * @param string $idx Optional. Return a specific regex only. Default null.
 *
 * @return array|string  Returns keyed array if not given $idx or $idx doesn't exist, otherwise the specific regex string.
 */
function get_unicode_regexs( $idx = null ) {
}
