<?php

namespace Cwchong\ElementalAnimateBlock\Models;

use Cwchong\ElementalAnimateBlock\Block\AnimateBlock;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\Requirements;

class TextBlock extends DataObject {
    
    private static $table_name = 'C_EAB_TextBlock';
    // xxx this will prob not look react without schemaComponent; so we will need to build that
    // xxx reading issues on ss doesnt seem available atm; consider open in another detail form instead (there is a setting for this)

    private static $db = [
        'Name' => 'Varchar(255)',
        'Content' => 'HTMLText', // xxx this needs special styling
        'Direction' => 'Enum("left,right")', 
        'OffsetLeft' => 'Varchar(16)',
        'OffsetRight' => 'Varchar(16)',
        'OffsetTop' => 'Varchar(16)',
        'OffsetBottom' => 'Varchar(16)',
    ];

    private static $defaults = [
        'Direction' => 'left',
    ];

    private static $has_one = [
        'AnimateBlock' => AnimateBlock::class,
    ];

    private static $summary_fields = [
        'Name' => 'Name',
        'Summary' => 'Content',
    ];
    
    public function getCMSFields() {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->removeByName('AnimateBlockID');

            $contentField = $fields->fieldByName('Root.Main.Content');
            $contentField->setRows(5)->addExtraClass('textblock');
        });
        Requirements::javascript('cwchong/elemental-animateblock:client/dist/js/EditorLocale.js');
        return parent::getCMSFields();
    }

    public function getSummary() {
        return $this->dbObject('Content')->Summary(20);
    }

}