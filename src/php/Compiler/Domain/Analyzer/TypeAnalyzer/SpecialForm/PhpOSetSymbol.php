<?php

declare(strict_types=1);

namespace Phel\Compiler\Domain\Analyzer\TypeAnalyzer\SpecialForm;

use Phel\Compiler\Domain\Analyzer\Ast\PhpObjectCallNode;
use Phel\Compiler\Domain\Analyzer\Ast\PhpObjectSetNode;
use Phel\Compiler\Domain\Analyzer\Environment\NodeEnvironment;
use Phel\Compiler\Domain\Analyzer\Environment\NodeEnvironmentInterface;
use Phel\Compiler\Domain\Analyzer\Exceptions\AnalyzerException;
use Phel\Compiler\Domain\Analyzer\TypeAnalyzer\WithAnalyzerTrait;
use Phel\Lang\Collections\LinkedList\PersistentListInterface;

final class PhpOSetSymbol implements SpecialFormAnalyzerInterface
{
    use WithAnalyzerTrait;

    public function analyze(PersistentListInterface $list, NodeEnvironmentInterface $env): PhpObjectSetNode
    {
        $left = $this->analyzer->analyze($list->get(1), $env->withContext(NodeEnvironment::CONTEXT_EXPRESSION));
        $right = $this->analyzer->analyze($list->get(2), $env->withContext(NodeEnvironment::CONTEXT_EXPRESSION));

        if (!$left instanceof PhpObjectCallNode) {
            throw AnalyzerException::withLocation('First argument of php/oget must be a property access', $list);
        }

        if ($left->isMethodCall() === true) {
            throw AnalyzerException::withLocation('First argument of php/oget must be a property access', $list);
        }

        return new PhpObjectSetNode(
            $env,
            $left,
            $right,
            $list->getStartLocation(),
        );
    }
}
