<?php

namespace Cwchong\ElementalAnimateBlock\Block;

use Cwchong\ElementalAnimateBlock\Models\TextBlock;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
// use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class AnimateBlock extends BaseElement {

    private static $table_name = 'C_EAB_AnimateBlock';
    private static $icon = 'font-icon-block-carousel';

    /**
     * Set to false to prevent an in-line edit form from showing in an elemental area. Instead the element will be
     * clickable and a GridFieldDetailForm will be used.
     *
     * @config
     * @var bool
     */
    private static $inline_editable = false;

    // xxx todo: add grid for more text items to render, along with their position
    // above might be tricky in terms of how react will look like since gridfield isnt react based
    // get the basic working; then basic with react
    // todo: figure out hasmany in elemental block; or other ssmod, if can be rendered react like

    private static $has_one = [
        'Image' => Image::class,
        'MobileImage' => Image::class, 
    ];

    private static $has_many = [
        'TextBlocks' => TextBlock::class,
    ];

    private static $owns = [
        'Image',
        'MobileImage',
    ];

    public function getCMSFields() {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            /** @var UploadField $uploadField */
            $uploadField = $fields->fieldByName('Root.Main.Image');
            $uploadField->setFolderName('blocks')->setAllowedFileCategories('image');
            /** @var UploadField $uploadField */
            $uploadField2 = $fields->fieldByName('Root.Main.MobileImage');
            $uploadField2->setFolderName('blocks')->setAllowedFileCategories('image');

            $fields->removeByName('TextBlocks'); // remove the tab as well
            $config = GridFieldConfig_RecordEditor::create();
            // $config->addComponent($sortable = new GridFieldSortableRows('SortOrder'));
            // $sortable->setAppendToTop(true);
            $gridField = GridField::create('TextBlocks', 'Text Blocks', $this->TextBlocks(), $config);
            $fields->push($gridField);
        });
        return parent::getCMSFields();
    }

    public function getType() {
        return 'Animate';
    }

    public function getSummary() {
        if($this->Image() && $this->Image()->exists()) {
            return $this->getSummaryThumbnail() . $this->Image()->Title;
        }
        return '';
    }

    // return meta info for summary section of ElementEditor
    protected function provideBlockSchema() {
        $blockSchema = parent::provideBlockSchema();
        if($this->Image() && $this->Image()->exists()) {
            $blockSchema['imageURL'] = $this->Image()->CMSThumbnail()->getURL();
            $blockSchema['imageTitle'] = $this->Image()->getTitle();
        }
        return $blockSchema;
    }

    // return thumbnail for use in gridfield preview
    public function getSummaryThumbnail() {
        $data = [];
        if ($this->Image() && $this->Image()->exists()) {
            // Stretch to maximum of 36px either way then trim the extra off
            if ($this->Image()->getOrientation() === Image_Backend::ORIENTATION_PORTRAIT) {
                $data['Image'] = $this->Image()->ScaleWidth(36)->CropHeight(36);
            } else {
                $data['Image'] = $this->Image()->ScaleHeight(36)->CropWidth(36);
            }
        }
        return $this->customise($data)->renderWith(__CLASS__ . '/SummaryThumbnail');
    }


    // xxxx add in additional stufff from BannerBlock


}