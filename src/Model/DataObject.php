<?php
/**
 * Ares (https://ares.to)
 *
 * @license https://gitlab.com/arescms/ares-backend/LICENSE (MIT License)
 */

namespace Ares\Framework\Model;

use JsonSerializable;

/**
 * Class DataObject
 *
 * @package Ares\Framework\Model
 */
class DataObject implements JsonSerializable
{
    /** @var string */
    public const PRIMARY_KEY = 'id';

    /** @var string */
    public const TABLE = '';

    /** @var array */
    public const HIDDEN = [];

    /** @var array */
    public const RELATIONS = [];

    /**
     * DataObject constructor.
     *
     * @param $data
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => &$value) {
            $this->setData($key, $value);
        }
    }

    /**
     * Get data by key.
     *
     * @param string|null $key
     * @return mixed|array|null
     */
    public function getData($key = null)
    {
        if (!$key) {
            return (array) $this ?? [];
        }

        if (!isset($this->{$key})) {
            return null;
        }

        return $this->{$key};
    }

    /**
     * Set data by key.
     *
     * @param string $key
     * @param $value
     * @return $this
     */
    public function setData(string $key, $value)
    {
        $this->{$key} = $value;
        return $this;
    }

    /**
     * Clears DataObject from relations.
     *
     * @return DataObject
     */
    public function clearRelations(): DataObject
    {
        foreach ($this::RELATIONS as $relationKey => $relation) {
            unset($this->{$relationKey});
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): DataObject
    {
        foreach ($this::HIDDEN as &$hidden) {
            unset($this->{$hidden});
        }

        return $this;
    }
}
