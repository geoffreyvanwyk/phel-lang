<?php

declare(strict_types=1);

namespace Phel\Analyzer\AnalyzeTuple;

use Phel\Analyzer;
use Phel\Ast\ThrowNode;
use Phel\Exceptions\AnalyzerException;
use Phel\Lang\Tuple;
use Phel\NodeEnvironment;

final class AnalyzeThrow
{
    private Analyzer $analyzer;

    public function __construct(Analyzer $analyzer)
    {
        $this->analyzer = $analyzer;
    }

    public function __invoke(Tuple $x, NodeEnvironment $env): ThrowNode
    {
        if (count($x) !== 2) {
            throw new AnalyzerException(
                "Exact one argument is required for 'throw",
                $x->getStartLocation(),
                $x->getEndLocation()
            );
        }

        return new ThrowNode(
            $env,
            $this->analyzer->analyze($x[1], $env->withContext(NodeEnvironment::CTX_EXPR)->withDisallowRecurFrame()),
            $x->getStartLocation()
        );
    }
}
