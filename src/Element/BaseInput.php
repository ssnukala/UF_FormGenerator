<?php

/*
 * UF Form Generator.
 *
 * @link https://github.com/lcharette/UF_FormGenerator
 *
 * @copyright Copyright (c) 2017 Louis Charette
 * @license   https://github.com/lcharette/UF_FormGenerator/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\FormGenerator\Element;

use UserFrosting\Sprinkle\Core\Facades\Translator;

/**
 * BaseInput class.
 *
 * Parse the schema data for a form input element to add the default
 * attributes values and transform other attributes.
 *
 * @abstract
 * @implements InputInterface
 */
abstract class BaseInput implements InputInterface
{
    /**
     * @var string The name of the input.
     */
    public $name;

    /**
     * @var object The input schema data.
     */
    public $element;

    /**
     * @var string The input value.
     */
    public $value;

    /**
     * Constructor.
     *
     * @param string $name
     * @param object $element
     * @param mixed  $value   (default: null)
     *
     * @return void
     */
    public function __construct($name, $element, $value = null)
    {
        $this->name = $name;
        $this->element = $element;
        $this->value = $value;
    }

    /**
     * parse function.
     *
     * Return the parsed input attributes
     *
     * @return void
     */
    public function parse()
    {
        $this->applyTransformations();

        return $this->element;
    }

    /**
     * translateArgValue function.
     *
     * Translate the value of passed argument using the Translator Facade
     *
     * @param string $argument
     *
     * @return void
     */
    public function translateArgValue($argument)
    {
        if (isset($this->element[$argument])) {
            $this->element[$argument] = Translator::translate($this->element[$argument]);
        }
    }

    /**
     * getValue function.
     *
     * Return the value of the current input element. If not value is set in
     * `$this->value`, return the default value (from the schema data), if any.
     *
     * @return string The input current value
     */
    public function getValue()
    {
        if (isset($this->value) && $this->value !== null) {
            return $this->value;
        } elseif (isset($this->element['default'])) {
            return $this->element['default'];
        } else {
            return '';
        }
    }

    /**
     * applyTransformations function.
     *
     * Add defaut attributes to the current input element. Also transform
     * attributes values passed from the schema
     *
     * @abstract
     *
     * @return void
     */
    abstract protected function applyTransformations();
}
