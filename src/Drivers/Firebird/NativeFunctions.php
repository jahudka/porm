<?php

declare(strict_types=1);

namespace PORM\Drivers\Firebird;

use PORM\SQL\AST\Node as AST;


class NativeFunctions {

    public static function CAST(AST\Expression $expression, AST\Expression $as) : array {
        return ['CAST(%s AS %s)', [$expression, $as instanceof AST\Literal ? $as->value : $as]];
    }

    public static function CONCAT(AST\Expression ... $expressions) : array {
        return ['(' . implode(' || ', array_fill(0, count($expressions), '%s')) . ')', $expressions];
    }

    public static function CURRENT_DATE() : array {
        return ['CURRENT_DATE', null];
    }

    public static function CURRENT_TIME() : array {
        return ['CURRENT_TIME', null];
    }

    public static function CURRENT_TIMESTAMP() : array {
        return ['CURRENT_TIMESTAMP', null];
    }

    public static function DATEDIFF(AST\Literal $unit, AST\Expression $a, AST\Expression $b) : array {
        return ['DATEDIFF(%s, %s, %s)', [$unit->value, $a, $b]];
    }

    public static function EXTRACT(AST\Literal $unit, AST\Identifier $from) : array {
        return ['EXTRACT(%s FROM %s)', [$unit->value, $from]];
    }

    public static function LIST_DISTINCT(AST\Expression $expression, ?AST\Expression $separator = null) : array {
        $params = [$expression];
        $placeholders = '%s';

        if ($separator) {
            $params[] = $separator;
            $placeholders .= ', %s';
        }

        return ["LIST(DISTINCT $placeholders)", $params];
    }

}
