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

class EmpoweredItemSetSpecific extends AbstractBlockLayout implements TemplateableBlockLayoutInterface
{
    protected \FormElementManager $_formElements;

    protected ApiManger $_apiManager;

    public function getLabel()
    {
        return 'Empowered | Item Set Specific | Single Field'; // @translate
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
            'selectedItemSet' => '',
            'conditionalSelect' => 'and',
            'searchTypeSelect' => 'in',
            'searchField_01' => '',
            'placeHolder_01' => '',
        ];

        $data = $block ? $block->data() + $defaults : $defaults;
        
        $layoutForm = new Form();

        try {
            $itemSetSelect = $this->formElements->get(OmekaElement\ItemSetSelect::class);
            $itemSetSelect->setName('o:block[__blockIndex__][o:data][selectedItemSet]');
            $itemSetSelect->setOptions([
                'label' => "Item Set to which this search will be restricted.", // @translate
                'empty_option' => 'Select an item set …',
                'term_as_value' => false,
            ]);
            $itemSetSelect->setAttributes([
                'value' => $data['selectedItemSet'] ?? null,
                'required' => true,
                'data-column-data-key' => 'item_set_id',
            ]);
            $layoutForm->add($itemSetSelect);
        } catch (\Exception $e) {
            echo sprintf('<div class="error">%s</div>', $e->getMessage());
        }
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
        $layoutForm->add([
			'name' => 'o:block[__blockIndex__][o:data][searchTypeSelect]',
			'type' => Element\Text::class,
			'options' => [
            ],
            'attributes' => [
                'value' => $data['searchTypeSelect'],
                'hidden' => 'hidden',
            ]
		]);
        $layoutForm->prepare();

		$html = '';
		// $html .= $view->formCollection($propertySelect);
		$html .= $view->formCollection($layoutForm);
        return $html;
    }

    public function render(PhpRenderer $view, SitePageBlockRepresentation $block, $templateViewScript = 'common/block-layout/empowereditemsetspecific')
    {
        $blockData = ($block) ? $block->data() : [];
        return $view->partial($templateViewScript, $blockData);
    }
}