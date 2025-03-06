<?php
namespace ItemSetSearch\Site\BlockLayout;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use ItemSetSearch\Site\BlockLayout\EmpoweredCustomSchoolNameSearch;

class EmpoweredCustomSchoolSearchFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        return new EmpoweredCustomSchoolNameSearch($services->get('FormElementManager'), $services->get('Omeka\ApiManager'));
    }
}
