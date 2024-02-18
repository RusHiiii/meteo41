<?php

namespace App\Core\Doctrine;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class CastAsInteger extends FunctionNode
{
    public $stringPrimary;

    public function getSql(SqlWalker $sqlWalker)
    {
        return 'CAST(' . $this->stringPrimary->dispatch($sqlWalker) . ' AS int)';
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->stringPrimary = $parser->StringPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
