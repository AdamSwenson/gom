<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace SetupPageParts;

/**
 * Description of CommentSettingsPanelMaker
 *
 * @author adam
 */
class CommentSettingsPanelMaker
{
    
    public static $areas = array('missing', 'poor', 'competent', 'excellent');
    
    public function make_panel($qnum, $subnum)
    {
        $out = '';
        foreach(self::$areas as $area){
            $out .= "<div class='settingsDiv'>";
            $id = "s{$qnum}_{$subnum}_$area";
            $out .= $this->make_text_setting($id, $area);
            $out .= $this->make_range_setting($id, $area);
            $out .= "</div>";
        }
        return $out;
    }
    
    public function make_text_setting($id, $label)
    {
        return <<< HTML
        <div class='textSetting panelPart'>
            <label for='{$id}'>{$label}</label><br />
            <input type='text' id='{$id}' class='' /><br />
            <input type='hidden' id='{$id}_textID' class='' />
            <select id='{$id}_select' data='{$id}' class='textSettingSelect' >
                <option>--Canned preface text--</option>
            </select>
        </div>
HTML;
    }
    
    public function make_range_setting($id, $label)
    {
        return <<< HTML
        <div class='rangeSetting panelPart'>
            <div class='minSpinnerDiv spinnerDiv'>
                <label for=''>Min</label>
                <input type='text' id='{$id}_{$label}_min_score' class='minspinner spinner rangeSpinner' />
            </div>
            <div class='maxSpinnerDiv spinnerDiv'>         
                <label for=''>Max</label>
                <input type='text' id='{$id}_{$label}_max_score' class='maxspinner spinner rangeSpinner' />
            </div>
        </div>
HTML;
    }
}
