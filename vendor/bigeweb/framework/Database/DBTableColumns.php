<?php

namespace illuminate\Support\Database;

class DBTableColumns
{
    public function __construct(
        public string $name,
        public string $type,
        public array $options = []
    ) {}

    // modifiers
    public bool $nullable = false;
    public mixed $default = null;
    public bool $unique = false;
    public bool $index = false;
    public ?array $foreign = null;
    public ?string $onDelete = null;
    public ?string $onUpdate = null;

    /* ========= Modifiers ========= */


    /**
     * @return $this
     *
     */
    public function nullable(): self
    {
        $this->nullable = true;
        return $this;
    }


    /**
     * @param mixed $value
     * @return $this
     *
     */
    public function default(mixed $value): self
    {
        $this->default = $value;
        return $this;
    }


    /**
     * @return $this
     *
     */
    public function unique(): self
    {
        $this->unique = true;
        return $this;
    }


    /**
     * @return $this
     *
     */
    public function index(): self
    {
        $this->index = true;
        return $this;
    }

    /**
     * @param string $action
     * @return $this
     *
     */
    public function onDelete(string $action)
    {
        $this->onDelete = strtoupper($action);
        return $this;
    }

    /**
     * @param string $action
     * @return $this
     *
     */
    public function onUpdate(string $action)
    {
        $this->onUpdate = strtoupper($action);
        return $this;
    }

    /**
     * @param string $table
     * @param string $column
     * @return $this
     */
    public function foreign(string $table, string $column = 'id'): self
    {
        $this->foreign = compact('table', 'column');
        return $this;
    }
}