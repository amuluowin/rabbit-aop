<?php

declare(strict_types=1);

namespace Rabbit\Aop;

use Go\Proxy\FunctionProxy as ProxyFunctionProxy;

/**
 * Class FunctionProxy
 * @package Rabbit\Aop
 */
class FunctionProxy extends ProxyFunctionProxy
{
    public function __toString()
    {
        $functionsCode = ($this->namespace->getDocComment() . "\n" . // Doc-comment for file
            'namespace ' . // 'namespace' keyword
            $this->namespace->getName() . // Name
            ";\n" . // End of namespace name
            implode("\n", $this->functionsCode) // Function definitions
        );

        return $functionsCode
            // Inject advices on call
            . PHP_EOL
            . '\\' . __CLASS__ . "::injectJoinPoints('"
            . $this->namespace->getName() . "',"
            . var_export($this->advices, true) . ');';
    }
}
