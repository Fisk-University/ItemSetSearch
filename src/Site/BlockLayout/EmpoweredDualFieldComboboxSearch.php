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

class EmpoweredDualFieldComboboxSearch extends AbstractBlockLayout implements TemplateableBlockLayoutInterface
{
    public function getLabel()
    {
        return 'Empowered | Dual Combobox | Search'; // @translate
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
            'conditionalSelect' => 'or',
            'searchTypeSelect01' => 'in',
            'searchTypeSelect02' => 'in',
            'searchField_01' => '',
            'placeHolder_01' => '',
            'searchField_02' => '',
            'placeHolder_02' => '',
        ];

        $data = $block ? $block->data() + $defaults : $defaults;
        
        $layoutForm = new Form();

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
            ],
		]);

        try {
            $propertySelect = $this->formElements->get(OmekaElement\PropertySelect::class);
            $propertySelect->setName('o:block[__blockIndex__][o:data][searchField_02]');
            $propertySelect->setOptions([
                'label' => "Search Field02's Property", // @translate
                'empty_option' => 'Select a property…',
                'term_as_value' => false,
            ]);
            $propertySelect->setAttributes([
                'value' => $data['searchField_02'] ?? null,
                'required' => true,
                'data-column-data-key' => 'searchField_02',
            ]);
            $layoutForm->add($propertySelect);
        } catch (\Exception $e) {
            echo sprintf('<div class="error">%s</div>', $e->getMessage());
        }
        $placeHolder02 = new Element\Text();
        $placeHolder02->setName('o:block[__blockIndex__][o:data][placeHolder_02]');
        $placeHolder02->setLabel('Placeholder (aria) text for the addtional field');
        $placeHolder02->setAttributes([
            'value' => $data['placeHolder_02'],
        ]);
        $layoutForm->add($placeHolder02);

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

        $searchTypeSelect01 = new Element\Select();
        $searchTypeSelect01->setName('o:block[__blockIndex__][o:data][searchTypeSelect01]');
        $searchTypeSelect01->setLabel('Search condition for the field 01');
        $searchTypeSelect01->setOptions([
            'value_options' => [
                'in' => 'Contains',
                'eq' => 'Exact match',
                'sw' => 'Starts with',
            ],
        ]);
        $searchTypeSelect01->setAttribute('value',$data['searchTypeSelect01']);
        $layoutForm->add($searchTypeSelect01);

        $searchTypeSelect02 = new Element\Select();
        $searchTypeSelect02->setName('o:block[__blockIndex__][o:data][searchTypeSelect02]');
        $searchTypeSelect02->setLabel('Search condition for the field 02');
        $searchTypeSelect02->setOptions([
            'value_options' => [
                'in' => 'Contains',
                'eq' => 'Exact match',
                'sw' => 'Starts with',
            ],
        ]);
        $searchTypeSelect02->setAttribute('value',$data['searchTypeSelect02']);
        $layoutForm->add($searchTypeSelect02);

        $layoutForm->prepare();

		$html = '';
		// $html .= $view->formCollection($propertySelect);
		$html .= $view->formCollection($layoutForm);
        return $html;
    }


    public function render(PhpRenderer $view, SitePageBlockRepresentation $block, $templateViewScript = 'common/block-layout/empowereddualfieldcombobox')
    {
        $blockData = ($block) ? $block->data() : [];
        return $view->partial($templateViewScript, $blockData);
    }
}