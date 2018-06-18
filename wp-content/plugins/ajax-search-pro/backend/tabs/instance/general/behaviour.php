<fieldset>
    <legend>Logic and matching</legend>
    <div class="item item-flex-nogrow" style="flex-wrap: wrap;">
        <?php
        $o = new wpdreamsCustomSelect("keyword_logic", "Primary keyword logic",
            array(
                'selects' => array(
                    array('option' => 'OR', 'value' => 'or'),
                    array('option' => 'OR with exact word matches', 'value' => 'orex'),
                    array('option' => 'AND', 'value' => 'and'),
                    array('option' => 'AND with exact word matches', 'value' => 'andex')
                ),
                'value' => $sd['keyword_logic']
            ));
        $params[$o->getName()] = $o->getData();

        $o = new wpdreamsCustomSelect('secondary_kw_logic', "Secondary logic",
            array(
                'selects' => array(
                    array('option' => 'Disabled', 'value' => 'none'),
                    array('option' => 'OR', 'value' => 'or'),
                    array('option' => 'OR with exact word matches', 'value' => 'orex'),
                    array('option' => 'AND', 'value' => 'and'),
                    array('option' => 'AND with exact word matches', 'value' => 'andex')
                ),
                'value' => $sd['secondary_kw_logic']
            ));
        $params[$o->getName()] = $o->getData();
        ?>
        <div class="descMsg" style="min-width: 100%;flex-wrap: wrap;flex-basis: auto;flex-grow: 1;box-sizing: border-box;">
            <strong>Secodary logic</strong> is used when the results count does not reach the limit. More <a href="https://goo.gl/Cu5Egs" target="_blank">information about logics here</a>.
        </div>
    </div>
    <div class="item item-flex-nogrow item-conditional" style="flex-wrap: wrap;">
        <?php
        $o = new wpdreamsYesNo("exactonly", "Show exact matches only?",
            $sd['exactonly']);
        $params[$o->getName()] = $o->getData();

        $o = new wpdreamsCustomSelect('exact_match_location', "..and match fields against the search phrase",
            array(
                'selects' => array(
                    array('option' => 'Anywhere', 'value' => 'anywhere'),
                    array('option' => 'Starting with phrase', 'value' => 'start'),
                    array('option' => 'Ending with phrase', 'value' => 'end')
                ),
                'value' => $sd['exact_match_location']
            ));
        $params[$o->getName()] = $o->getData();
        ?>
        <div class="descMsg" style="margin-top:4px;min-width: 100%;flex-wrap: wrap;flex-basis: auto;flex-grow: 1;box-sizing: border-box;">
        <?php
        $o = new wpdreamsYesNo("exact_m_secondary", " ..allow Secondary logic when exact matching?",
            $sd['exact_m_secondary']);
        $params[$o->getName()] = $o->getData();
        ?></div>
        <div class="descMsg" style="min-width: 100%;flex-wrap: wrap;flex-basis: auto;flex-grow: 1;box-sizing: border-box;">
            If this is enabled, the Regular search engine is used. Index table engine doesn't support exact matches.
        </div>
    </div>
    <div class="item">
        <?php
        $o = new wpdreamsTextSmall("min_word_length", "Minimum word length", $sd['min_word_length']);
        $params[$o->getName()] = $o->getData();
        ?>
        <p class="descMsg">
            Words shorter than this will not be treated as separate keywords. Higher value increases performance, lower increase accuracy. Recommended values: 2-5
        </p>
    </div>
</fieldset>
<fieldset>
    <legend>Trigger and redirection behavior</legend>
    <div class="item">
        <?php
        $o = new wpdreamsYesNo("trigger_on_facet", "Trigger <strong>live</strong> search when changing a facet on settings?",
            $sd['trigger_on_facet']);
        $params[$o->getName()] = $o->getData();
        ?>
        <p class="descMsg">
            Will trigger the search if the user changes a checkbox, radio button, slider on the frontend
            search settings panel.
        </p>
    </div>
    <div class="item">
        <?php
        $o = new wpdreamsYesNo("triggerontype", "Trigger <strong>live</strong> search when typing?",
            $sd['triggerontype']);
        $params[$o->getName()] = $o->getData();
        ?>
    </div>
    <div class="item">
        <?php
        $o = new wpdreamsTextSmall("charcount", "Minimal character count to trigger search", $sd['charcount']);
        $params[$o->getName()] = $o->getData();
        ?>
    </div>
    <div class="item item-flex-nogrow" style="flex-wrap: wrap;">
        <?php
        $o = new wpdreamsCustomSelect("click_action", "Action when clicking <strong>the magnifier</strong> icon",
            array(
                'selects' => $_red_opts,
                'value' => $sd['click_action']
            ));
        $params[$o->getName()] = $o->getData();
        $o = new wpdreamsCustomSelect("click_action_location", " location: ",
            array(
                'selects' => array(
                    array('option' => 'Use same tab', 'value' => 'same'),
                    array('option' => 'Open new tab', 'value' => 'new')
                ),
                'value' => $sd['click_action_location']
            ));
        $params[$o->getName()] = $o->getData();
        ?>
    </div>
    <div class="item item-flex-nogrow" style="flex-wrap: wrap;">
        <?php
        $o = new wpdreamsCustomSelect("return_action", "Action when pressing <strong>the return</strong> button",
            array(
                'selects' => $_red_opts,
                'value' => $sd['return_action']
            ));
        $params[$o->getName()] = $o->getData();
        $o = new wpdreamsCustomSelect("return_action_location", " location: ",
            array(
                'selects' => array(
                    array('option' => 'Use same tab', 'value' => 'same'),
                    array('option' => 'Open new tab', 'value' => 'new')
                ),
                'value' => $sd['return_action_location']
            ));
        $params[$o->getName()] = $o->getData();
        ?>
    </div>
    <div class="item">
        <?php
        $o = new wpdreamsText("redirect_url", "Custom redirect URL",
            $sd['redirect_url']);
        $params[$o->getName()] = $o->getData();
        ?>
        <p class="descMsg">You can use the <string>asp_redirect_url</string> filter to add more variables. See <a href="http://wp-dreams.com/go/?to=kb-redirecturl" target="_blank">this tutorial</a>.</p>
    </div>
    <div class="item item-flex-nogrow" style="flex-wrap: wrap;">
        <?php
        $o = new wpdreamsYesNo("override_default_results", "<b>Override</b> the default WordPress search results with results from this search instance?",
            $sd['override_default_results']);
        $params[$o->getName()] = $o->getData();
        ?>
        <?php
        $o = new wpdreamsCustomSelect("override_method", " method ", array(
            "selects" =>array(
                array("option" => "Post", "value" => "post"),
                array("option" => "Get", "value" => "get")
            ),
            "value" => $sd['override_method']
        ));
        $params[$o->getName()] = $o->getData();
        ?>
        <div class="descMsg" style="min-width: 100%;flex-wrap: wrap;flex-basis: auto;flex-grow: 1;box-sizing: border-box;">If this is enabled, the plugin will try to replace the default results with it's own. Might not work with themes which temper the search query themselves (very very rare).</div>
    </div>
    <div class="item">
        <?php
        $o = new wpdreamsTextSmall("results_per_page", "Results count per page?",
            $sd['results_per_page']);
        $params[$o->getName()] = $o->getData();
        ?>
        <p class="descMsg">The number of results per page, on the results page.</p>
        <p class="errorMsg">
            <strong>WARNING:</strong> This should be set to the same as the number of results originally displayed on the results page!<br>
            Most themes use the system option found on the <strong>General Options -> Reading</strong> submenu, which is 10 by default. <br>
            If you set it differently, or your theme has a different option for that, then <strong>set this option to the same value</strong> as well.
        </p>
    </div>
</fieldset>
<fieldset id="res_live_search">
    <legend>Results page live loader</legend>
    <div class="errorMsg">
        <strong>Disclaimer:</strong> Live loading items to a page causes the script event handlers to detach on the affected elements - if there are
        interactive elements (pop-up buttons etc..) controlled by a script within the results, they will probably stop working after a live load.
        This cannot be prevented from this plugins perspective. <a href="https://documentation.ajaxsearchpro.com/behavior/results_page_live_loader" target="_blank">More information here.</a>
    </div>
    <div class="item">
        <?php
        $o = new wpdreamsYesNo("res_live_search", "Live load the results on the results page? <strong>(experimental)</strong>",
            $sd['res_live_search']);
        $params[$o->getName()] = $o->getData();
        ?>
        <div class="descMsg">If this is enabled, and the current page is the results page, the plugin will try to load the results there, without reloading the page.</div>
    </div>
    <div class="item">
        <?php
        $o = new wpdreamsText("res_live_selector", "Results container jQuery element selector", $sd['res_live_selector']);
        $params[$o->getName()] = $o->getData();
        ?>
        <div class="descMsg">In many themes this is <strong>#main</strong>, but it can be different. This is very important to get right, or this will surely not work. The plugin will try other values as well, if this fails.</div>
    </div>
</fieldset>