<?php
namespace ItemSetSearch\Site\BlockLayout;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use ItemSetSearch\Site\BlockLayout\EmpoweredCustomItemSetSearch ;

class EmpoweredCustomItemSetFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        return new EmpoweredCustomItemSetSearch($services->get('FormElementManager'), $services->get('Omeka\ApiManager'));
    }
}
