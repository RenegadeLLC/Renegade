<?php
if (!class_exists("wpdreamsSelectTags")) {
    /**
     * Class wpdreamsSelectTags
     *
     * Displays a tag selector element.
     *
     * @package  WPDreams/OptionsFramework/Classes
     * @category Class
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2015, Ernest Marcinko
     */
    class wpdreamsSelectTags extends wpdreamsType {
        function getType() {
            parent::getType();
            $this->processData();
            ?>
            <div class="wpdreamsSelectTags" id="wpdreamsSelectTags-<?php echo self::$_instancenumber; ?>">
                <div class="wpdreamsYesNoSt<?php echo $this->active == 1 ? " active" : ""; ?>">
                    <label><?php echo $this->label; ?></label>
                    <div class='wpdreamsYesNoInner'></div>
                </div>
                &nbsp;&nbsp;as&nbsp;
                <select class="wd_tagDisplayMode">
                    <option value="checkboxes"<?php echo $this->display_mode == "checkboxes" ? " selected" : ""; ?>>Checkboxes</option>
                    <option value="dropdown"<?php echo $this->display_mode == "dropdown" ? " selected" : ""; ?>>Drop-down list</option>
                    <option value="dropdownsearch"<?php echo $this->display_mode == "dropdownsearch" ? " selected" : ""; ?>>Drop-down list with search</option>
                    <option value="multisearch"<?php echo $this->display_mode == "multisearch" ? " selected" : ""; ?>>Multiselect list with search</option>
                    <option value="radio"<?php echo $this->display_mode == "radio" ? " selected" : ""; ?>>Radio buttons</option>
                </select>
                &nbsp;and show&nbsp;
                <select class="wd_tagSelectSource">
                    <option value="all"<?php echo $this->source == "all" ? " selected" : ""; ?>>All tags</option>
                    <option value="selected"<?php echo $this->source == "selected" ? " selected" : ""; ?>>Selected tags</option>
                </select>
                <?php
                $rule = "checkboxes-all";
                $showthis = ( strpos($rule, $this->source) !== false &&
                    strpos($rule, $this->display_mode) !== false ) ? "" : " hiddend";
                ?>
                <div showif="<?php echo $rule; ?>" class="showif_c wd_tagAllStatus<?php echo $showthis; ?>">
                    <label>Checkbox statuses</label>
                    <select class="wd_tagAllStatus">
                        <option value="checked"<?php echo $this->all_status == "checked" ? " selected" : ""; ?>>Checked</option>
                        <option value="unchecked"<?php echo $this->all_status == "unchecked" ? " selected" : ""; ?>>Unchecked</option>
                    </select>
                </div>
                <?php
                $rule1 = "checkboxes-dropdown-dropdownsearch-multisearch-radio-selected";
                $rule2 = "dropdown-dropdownsearch-multisearch-radio-all";
                $showthis = ( strpos($rule1, $this->source) !== false &&
                    strpos($rule1, $this->display_mode) !== false ) ? "" : " hiddend";
                $showlabel = ( strpos($rule2, $this->source) !== false &&
                    strpos($rule2, $this->display_mode) !== false ) ? "" : " hiddend";
                if ($showthis == " hiddend") {
                    $showthis = $showlabel;
                }
                ?>
                <div showif="<?php echo $rule1."|".$rule2; ?>"
                     class="showif_c wd_tagSelSearch<?php echo $showthis; ?>">
                    <label showif="<?php echo $rule2; ?>" class="showif_c<?php echo $showlabel; ?>">Default selected tag</label>
                    <span class="loading-small hiddend"></span>
                    <div class="wd_ts_close hiddend">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                            <polygon id="x-mark-icon" points="438.393,374.595 319.757,255.977 438.378,137.348 374.595,73.607 255.995,192.225 137.375,73.622 73.607,137.352 192.246,255.983 73.622,374.625 137.352,438.393 256.002,319.734 374.652,438.378 "></polygon>
                        </svg>
                    </div>
                    <input type="text" value="" placeholder="Search for tags" class="wd_tagSelectSearch">
                    <div class="wd_tagSearchResults"></div>
                </div>
                <?php
                $rule = "checkboxes-dropdown-dropdownsearch-multisearch-radio-selected";
                $showthis = ( strpos($rule, $this->source) !== false &&
                    strpos($rule, $this->display_mode) !== false ) ? "" : " hiddend";
                ?>
                <div showif="<?php echo $rule; ?>"
                     class="showif_c ts_selected wd_tagSelectContent<?php echo $showthis; ?>">
                    <?php
                    $tags = $this->getTagsOrdered();
                    foreach ($tags as $tag) {
                        echo "<span class='wd_tag' tagid='".$tag->term_id."'>
                              <a class='wd_tag_remove'></a>
                              <a class='".( in_array($tag->term_id, $this->c_tag_ids) ? "wd_tag_checked" : "wd_tag_unchecked")."'></a>".$tag->name."</span>";
                    }
                    ?>
                </div>
                <?php
                $rule = "dropdown-dropdownsearch-multisearch-radio-all";
                $showthis = ( strpos($rule, $this->source) !== false &&
                    strpos($rule, $this->display_mode) !== false ) ? "" : " hiddend";
                ?>
                <div showif="<?php echo $rule; ?>"
                     class="showif_c ts_all wd_tagSelectContent<?php echo $showthis; ?>">
                    <?php
                    if ( !empty($this->defaultTag) ) {
                        $the_tag = get_tag($this->defaultTag);
                        if ( isset( $the_tag->name) ) {
                            echo "<span class='wd_tag' tagid='".$the_tag->term_id."'>
                              <a class='wd_tag_remove'></a>
                              </a>".$the_tag->name."</span>";
                        }
                    }
                    ?>
                </div>
                <?php
                $rule = "dropdown-dropdownsearch-multisearch-radio-selected";
                $showthis = ( strpos($rule, $this->source) !== false &&
                    strpos($rule, $this->display_mode) !== false ) ? "" : " hiddend";
                ?>
                <div showif="<?php echo $rule; ?>"
                     class="descMsg showif_c<?php echo $showthis; ?>">
                    Note: If you have multiple items checked, the <strong>last checked</strong> item will be selected as default.
                </div>
                <?php
                $rule = "dropdown-dropdownsearch-multisearch-radio-all";
                $showthis = ( strpos($rule, $this->source) !== false &&
                    strpos($rule, $this->display_mode) !== false ) ? "" : " hiddend";
                ?>
                <div showif="<?php echo $rule; ?>"
                     class="descMsg showif_c<?php echo $showthis; ?>">
                    Note: If you don't have a default selected tag, the <strong>first tag</strong> will be selected as default.
                </div>
                <input isparam=1 type="hidden" value='<?php echo $this->data; ?>' name="<?php echo $this->name; ?>">
                <input type='hidden' value='wpdreamsSelectTags' name='classname-<?php echo $this->name; ?>'>
            </div>
            <?php
        }

        function processData() {

            $_raw = explode("|", $this->data);

            $this->active = $_raw[0];
            // Display mode
            $this->display_mode = $_raw[1];
            // Source
            $this->source = $_raw[2];
            // All tags checked or unchecked?
            $this->all_status = $_raw[3];
            // Selected tag ids
            $_raw[4] = trim($_raw[4]);
            // Checked tag ids
            $_raw[5] = trim($_raw[5]);
            // Default for drop and radio
            $this->defaultTag = trim($_raw[6]);

            if ($_raw[4] != "")
                $this->tag_ids = explode(",", $_raw[4]);
            else
                $this->tag_ids = array();

            if ($_raw[5] != "")
                $this->c_tag_ids = explode(",", $_raw[5]);
            else
                $this->c_tag_ids = array();

            $this->selected = array(
                "active" => $this->active,
                "display_mode"  => $this->display_mode,
                "source" => $this->source,
                "all_status" => $this->all_status,
                "tag_ids"=> $this->tag_ids,
                "checked_tag_ids"=> $this->c_tag_ids,
                "default_tag" => $this->defaultTag
            );

        }

        final function getData() {
            return $this->data;
        }

        final function getSelected() {
            return $this->selected;
        }

        private function getTagsOrdered() {

            if ( empty($this->tag_ids) ) return array();

            $tag_keys_arr = array();
            $final_tags_arr = array();

            foreach ($this->tag_ids as $position => $tag_id) {
                $tag_keys_arr[$tag_id] = $position;
            }

            $tags = get_terms("post_tag", array("include" => $this->tag_ids));

            foreach ($tags as $tag) {
                $final_tags_arr[$tag_keys_arr[$tag->term_id]] = $tag;
            }

            ksort($final_tags_arr);

            return $final_tags_arr;
        }

        static function searchTag() {
            $phrase = $_POST["wd_tag_phrase"];
            $tags = get_terms(array("post_tag"), array('search' => $phrase, 'number' => 10));
            $ret = "";
            if ( count($tags) > 0 )
                foreach ($tags as $tag) {
                    $ret .= "<p>".$tag->name."<span termid='".$tag->term_id."'>>>USE</span></p>";
                }
            else
                $ret = "No tags found for this phrase";
            print "!!WDSTART!!" . $ret . "!!WDEND!!";
            die();
        }
    }
}

if ( !has_action('wp_ajax_wd_search_tag') )
    add_action('wp_ajax_wd_search_tag', 'wpdreamsSelectTags::searchTag');