<?php
namespace ItemSetSearch\Site\BlockLayout;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use ItemSetSearch\Site\BlockLayout\EmpoweredDualFieldComboboxSearch;

class EmpoweredDualFieldComboboxSearchFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        return new EmpoweredDualFieldComboboxSearch($services->get('FormElementManager'), $services->get('Omeka\ApiManager'));
    }
}
