<?php
namespace ItemSetSearch;

use Omeka\Module\AbstractModule;

class Module extends AbstractModule
{
    public function getConfig()
    {
        return [
            'block_layouts' => [
                'factories' => [
                    'empoweredCustomItemSetSearch' => Site\BlockLayout\EmpoweredCustomItemSetFactory::class,
                    'empoweredCustomSchoolNameSearch' => Site\BlockLayout\EmpoweredCustomSchoolSearchFactory::class,
                    'empoweredDualFieldComboboxSearch' => Site\BlockLayout\EmpoweredDualFieldComboboxSearchFactory::class,
                    'empoweredItemSetSpecific' => Site\BlockLayout\EmpoweredItemSetSpecificFactory::class,
                ],
            ],
            'view_manager' => [
                'template_path_stack' => [
                    OMEKA_PATH.'/modules/ItemSetSearch/view',
                ],
            ],
        ];
    }
}