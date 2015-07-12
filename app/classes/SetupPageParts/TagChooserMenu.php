<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace SetupPageParts;

/**
 * Description of TagChooserMenu
 *
 * @author adam
 */
class TagChooserMenu extends \ItemClassesOLD\service\TopicTagLoader {

    public function __construct($roservice) {
        $this->dao = $roservice;
        $this->loadTags();
    }

    /**
     * Prints the radioset for tag chooser div id=tagChooserArea name=tagChooser
     */
    public function radio($echo = TRUE) {
        $out = "<div id='tagChooserArea'>
            <label for='tagChooserSet'>Display questions and elements for</label><br/>
                <radioset  id='tagChooserSet'>";
        foreach (array_values($this->allTags) as $tag) {
            $t = "<label for='$tag'>$tag</label>"
                    . "<input type='radio' name='tagChooser' value='$tag' id='$tag' />";
            $out = $out . $t;
        }
        $end = "<label for='all'>All</label>"
                . "<input type='radio' name='tagChooser' value='all' id='all' />"
                . "</radioset>"
                . "</div>";
        $out = $out . $end;
        if ($echo === TRUE) {
            echo $out;
        } else {
            return $out;
        }
    }

    public function jsArray() {
        $end = count($this->allTags);
        $i = 1;
        $out = "'all' : ['all'], ";
        foreach (array_values($this->allTags) as $tag) {
            $it = "'$tag' : ['$tag']";
            if ($i < $end) {
                $it = $it . ", "; //decide whether to add comma
            }
            $out = $out . $it;
            $i++;
        }
        echo $out;
    }

}
