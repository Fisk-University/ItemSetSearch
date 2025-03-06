<?php
namespace ItemSetSearch\Site\BlockLayout;

use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Omeka\Site\BlockLayout\TemplateableBlockLayoutInterface;
use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Omeka\Form\Element as OmekaElement;
use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\View\Renderer\PhpRenderer;
use Omeka\Api\Manager as ApiManager;
use Laminas\Form\FormElementManager;

class EmpoweredCustomItemSetSearch extends AbstractBlockLayout implements TemplateableBlockLayoutInterface
{
    protected \FormElementManager $_formElements;

    protected ApiManger $_apiManager;

    public function getLabel()
    {
        return 'Item Set Search | Customizable | Empowered '; // @translate
    }

    public function __construct(FormElementManager $formElements, ApiManager $api)
    {
        $this->formElements = $formElements;
        $this->api = $api;
    }

    public function form(PhpRenderer $view, SiteRepresentation $site,
        SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null
    ) { 
        $defaults = [
            'includeBlankInItemSetList' => true,
            'conditionalSelect' => 'and',
            'searchTypeSelect' => 'sw',
            'searchField_01' => '',
            'placeHolder_01' => '',
            'searchField_02' => '',
            'placeHolder_02' => '',
        ];

        $data = $block ? $block->data() + $defaults : $defaults;
        
        $layoutForm = new Form();

        $includeBlankInItemSet = new Element\Checkbox();
        $includeBlankInItemSet->setName('o:block[__blockIndex__][o:data][includeBlankInItemSetList]');
        $includeBlankInItemSet->setLabel('Include a blank (search all) in item sets');
        if($data['includeBlankInItemSetList'] == 1) {
            $includeBlankInItemSet->setAttributes([
            'checked' => 'checked'
        ]);
        }
        $layoutForm->add([
			'name' => 'o:block[__blockIndex__][o:data][includeBlankInItemSetList]',
			'type' => Element\Checkbox::class,
			'options' => [
				'label' => 'Include a blank (search all) in item sets', // @translate
            ],
            'attributes' => [
                'checked' => ($data['includeBlankInItemSetList']) ? 'checked' : '', 
            ],
		]);

        try {
            $propertySelect = $this->formElements->get(OmekaElement\PropertySelect::class);
            $propertySelect->setName('o:block[__blockIndex__][o:data][searchField_01]');
            $propertySelect->setOptions([
                'label' => "Search Field01's Property", // @translate
                'empty_option' => 'Select a property…',
                'term_as_value' => false,
            ]);
            $propertySelect->setAttributes([
                'value' => $data['searchField_01'] ?? null,
                'required' => true,
                'data-column-data-key' => 'searchField_01',
            ]);
            $layoutForm->add($propertySelect);
        } catch (\Exception $e) {
            echo sprintf('<div class="error">%s</div>', $e->getMessage());
        }
        $layoutForm->add([
			'name' => 'o:block[__blockIndex__][o:data][placeHolder_01]',
			'type' => Element\Text::class,
			'options' => [
				'label' => 'Placeholder (aria) text for the addtional field', // @translate
            ],
            'attributes' => [
                'value' => $data['placeHolder_01'],
            ]
		]);
        $conditionalSelect = new Element\Select();
        $conditionalSelect->setName('o:block[__blockIndex__][o:data][conditionalSelect]');
        $conditionalSelect->setLabel('Join condition for the fields');
        $conditionalSelect->setOptions([
            'value_options' => [
                'and' => 'and',
                'or' => 'or',
            ],
        ]);
        $conditionalSelect->setAttribute('value',$data['conditionalSelect']);
        $layoutForm->add($conditionalSelect);

        $searchTypeSelect = new Element\Select();
        $searchTypeSelect->setName('o:block[__blockIndex__][o:data][searchTypeSelect]');
        $searchTypeSelect->setLabel('Search condition for the field 01');
        $searchTypeSelect->setOptions([
            'value_options' => [
                'in' => 'Contains',
                'eq' => 'Exact match',
                'sw' => 'Starts with',
            ],
        ]);
        $searchTypeSelect->setAttribute('value',$data['searchTypeSelect']);
        $layoutForm->add($searchTypeSelect);
        $layoutForm->prepare();

		$html = '';
		// $html .= $view->formCollection($propertySelect);
		$html .= $view->formCollection($layoutForm);
        return $html;
    }

    public function render(PhpRenderer $view, SitePageBlockRepresentation $block, $templateViewScript = 'common/block-layout/empowered-custom-item-set')
    {
        $blockData = ($block) ? $block->data() : [];
        return $view->partial($templateViewScript, $blockData);
    }
}