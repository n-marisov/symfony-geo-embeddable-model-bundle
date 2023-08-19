<?php

namespace Maris\Symfony\Geo\Embeddable\Model;

use Maris\Symfony\Geo\Embeddable\Model\DependencyInjection\GeoEmbeddableModelExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class GeoEmbeddableModelBundle extends AbstractBundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new GeoEmbeddableModelExtension();
    }
}