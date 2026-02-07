<?php

namespace illuminate\Support\Database;

use illuminate\Support\Models\Model;

class TableBlueprint extends Model
{

    protected array $columns = [];
    protected array $indexes = [];
    protected array $foreignKeys = [];

    public function __construct(?string $tableName)
    {
        parent::__construct();
        $this->table = $tableName;
    }


    public function id()
    {
        $column = new DBTableColumns('id', 'id');
        $this->columns[] = $column;
        return $column;
    }

    public function int(string $name)
    {
        $column = new DBTableColumns($name, 'int');
        $this->columns[] = $column;
        return $column;
    }

    public function bigInt(string $name)
    {
        $column = new DBTableColumns($name, 'bigint');
        $this->columns[] = $column;
        return $column;
    }

    public function string(string $name, int $length = 255)
    {
        $column = new DBTableColumns($name, 'string', compact('length'));
        $this->columns[] = $column;
        return $column;
    }

    public function text(string $name)
    {
        $column = new DBTableColumns($name, 'text');
        $this->columns[] = $column;
        return $column;
    }

    public function dateTime(string $name)
    {
        $column = new DBTableColumns($name, 'dateTime');
        $this->columns[] = $column;
        return $column;
    }

    public function date(string $name)
    {
        $column = new DBTableColumns($name, 'date');
        $this->columns[] = $column;
        return $column;
    }

    public function json(string $name)
    {
        $column = new DBTableColumns($name, 'json');
        $this->columns[] = $column;
        return $column;
    }

    public function decimal(string $name, int $precision = 8, int $scale = 2)
    {
        $column = new DBTableColumns($name, 'decimal', compact('precision', 'scale'));
        $this->columns[] = $column;
        return $column;
    }

    public function float(string $name, int $precision = 8, int $scale = 2)
    {
        $column = new DBTableColumns($name, 'float', compact('precision', 'scale'));
        $this->columns[] = $column;
        return $column;
    }

    public function double(string $name, int $precision = 8, int $scale = 2)
    {
        $column = new DBTableColumns($name, 'double', compact('precision', 'scale'));
        $this->columns[] = $column;
        return $column;
    }

    public function boolean(string $name)
    {
        $column = new DBTableColumns($name, 'boolean');
        $this->columns[] = $column;
        return $column;
    }

    public function enum(string $name, array $allowed)
    {
        $column = new DBTableColumns(
            name: $name,
            type: 'enum',
            options: ['allowed' => $allowed]
        );
        $this->columns[] = $column;
        return $column;
    }




    public function timestamps()
    {
        $this->columns[] = new DBTableColumns('created_at', 'timestamp');
        $this->columns[] = new DBTableColumns('updated_at', 'timestamp');
    }


    public function toSql(): ?string
    {
        $driver = $this->connectionType;
        $cols = [];
        $constraints = [];
        foreach ($this->columns as $column) {
            $cols[] = $this->compileColumn($column, $driver);
            if ($column->unique) {
                $constraints[] = "UNIQUE ({$column->name})";
            }

            if ($column->index) {
                $this->indexes[] = $column->name;
            }


            if ($column->foreign) {
                $fk = "FOREIGN KEY ({$column->name}) 
                REFERENCES {$column->foreign['table']}({$column->foreign['column']})";

                if (!empty($column->onDelete)) {
                    $fk .= " ON DELETE {$column->onDelete}";
                } elseif (!empty($column->foreign['onDelete'])) {
                    $fk .= " ON DELETE {$column->foreign['onDelete']}";
                }

                if (!empty($column->onUpdate)) {
                    $fk .= " ON UPDATE {$column->onUpdate}";
                } elseif (!empty($column->foreign['onUpdate'])) {
                    $fk .= " ON UPDATE {$column->foreign['onUpdate']}";
                }

                $this->foreignKeys[] = $fk;
            }
        }

        $columnsSql = implode(",\n", array_merge($cols, $constraints, $this->foreignKeys));

        return "CREATE TABLE IF NOT EXISTS {$this->table} (\n{$columnsSql}\n)";

    }


    protected function compileColumn(DBTableColumns $column, string $driver): string
    {
        $sql = match ($column->type) {

            'id' => $driver === 'sqlite'
                ? 'id INTEGER PRIMARY KEY AUTOINCREMENT'
                : 'id BIGINT AUTO_INCREMENT PRIMARY KEY',

            'int' => $driver === 'sqlite'
                ? "{$column->name} INTEGER"
                : "{$column->name} INT",

            'bigint' => $driver === 'sqlite'
                ? "{$column->name} INTEGER"
                : "{$column->name} BIGINT",

            'string' => $driver === 'sqlite'
                ? "{$column->name} TEXT"
                : "{$column->name} VARCHAR({$column->options['length']})",

            'dateTime' => $driver === 'sqlite'
                ? "{$column->name} DATETIME"
                : "{$column->name} TIMESTAMP DEFAULT CURRENT_TIMESTAMP",


            'date' => $driver === 'sqlite'
                ? "{$column->name} DATE"
                : "{$column->name} DATE",

            'text' => "{$column->name} TEXT",

            'json' => $driver === 'sqlite'
                ? "{$column->name} TEXT"
                : "{$column->name} JSON",

            'decimal' => "{$column->name} DECIMAL({$column->options['precision']}, {$column->options['scale']})",
            'double' => "{$column->name} DOUBLE({$column->options['precision']}, {$column->options['scale']})",
            'float' => "{$column->name} FLOAT({$column->options['precision']}, {$column->options['scale']})",

            'boolean' => $driver === 'sqlite'
                ? "{$column->name} INTEGER"
                : "{$column->name} TINYINT(1)",

            'timestamp' => $driver === 'sqlite'
                ? "{$column->name} TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
                : "{$column->name} TIMESTAMP DEFAULT CURRENT_TIMESTAMP",

            'enum' => $this->compileEnum($column, $driver),

            default => throw new \Exception("Unsupported column type: {$column->type}")
        };

        // modifiers
        if ($column->nullable) $sql .= ' NULL';
        if ($column->default !== null) $sql .= " DEFAULT '{$column->default}'";
        if ($column->unique) $sql .= ' UNIQUE';
        return $sql;
    }


    protected function compileEnum(DBTableColumns $column, string $driver): string
    {
        $values = array_map(
            fn($v) => "'" . str_replace("'", "''", $v) . "'",
            $column->options['allowed']
        );

        $list = implode(', ', $values);

        return $driver === 'sqlite'
            ? "{$column->name} TEXT CHECK({$column->name} IN ({$list}))"
            : "{$column->name} ENUM({$list})";
    }


    public function down(): ?string
    {
        return "DROP DATABASE $this->table";
    }
}
