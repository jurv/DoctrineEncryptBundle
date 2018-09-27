<?php

namespace Jurv\DoctrineEncryptBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Jurv\DoctrineEncryptBundle\DependencyInjection\DoctrineEncryptExtension;
use Jurv\DoctrineEncryptBundle\DependencyInjection\Compiler\RegisterServiceCompilerPass;

class JurvDoctrineEncryptBundle extends Bundle {
    
    public function build(ContainerBuilder $container) {
        parent::build($container);
        $container->addCompilerPass(new RegisterServiceCompilerPass(), PassConfig::TYPE_AFTER_REMOVING);
    }
    
    public function getContainerExtension()
    {
        return new DoctrineEncryptExtension();
    }
}
