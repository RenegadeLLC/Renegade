<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

$perf_options = wd_asp()->o['asp_performance'];

if (ASP_DEMO) $_POST = null;
?>

<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . 'settings/assets/options_search.css?v='.ASP_CURR_VER; ?>" />
<div id="wpdreams" class='wpdreams asp_performance wrap<?php echo isset($_COOKIE['asp-accessibility']) ? ' wd-accessible' : ''; ?>'>
    <?php if (wd_asp()->updates->needsUpdate()): ?>
        <p class='infoMsgBox'>Version <strong><?php echo wd_asp()->updates->getVersionString(); ?></strong> is available.
            Download the new version from Codecanyon. <a target="_blank" href="https://documentation.ajaxsearchpro.com/update_notes.html">How to update?</a></p>
    <?php endif; ?>

    <?php
    $pstats = new wpd_Performance('asp_performance_stats');
    $asp_performance = $pstats->get_data();
    $_comp = wpdreamsCompatibility::Instance();
    if ($_comp->has_errors()):
        ?>
        <div class="wpdreams-box errorbox">
            <p class='errors'>Possible incompatibility! Please go to the <a href="<?php echo get_admin_url()."admin.php?page=asp_compatibility_settings"; ?>">error check</a> page to see the details and solutions!</p>
        </div>
    <?php endif; ?>

    <div class="wpdreams-box" style="float:left;">
        <?php ob_start(); ?>
        <div class="item">
            <?php $o = new wpdreamsYesNo("enabled", "Enable performance tracking?",
                $perf_options['enabled']
            ); ?>
        </div>
        <?php $_r = ob_get_clean(); ?>

        <?php
        $updated = false;
        if (isset($_POST) && isset($_POST['asp_performance']) && (wpdreamsType::getErrorNum()==0)) {
            $values = array(
                "enabled" => $_POST['enabled']
            );
            update_option('asp_performance', $values);
            asp_parse_options();
            $updated = true;
        }
        if (isset($_POST) && isset($_POST['asp_perf_clear'])) {
            $pstats = new wpd_Performance('asp_performance_stats');
            $pstats->reset();
        }
        ?>

        <div class='wpdreams-slider'>
            
            <?php if (ASP_DEMO): ?>
                <p class="infoMsg">DEMO MODE ENABLED - Please note, that these options are read-only</p>
            <?php endif; ?>

            <form name='asp_performance_settings' class="asp_performance_settings" method='post'>
                <?php if($updated): ?><div class='successMsg'>Performance options successfuly updated!</div><?php endif; ?>
                <fieldset>
                    <legend>Performance tracking options</legend>
                    <?php print $_r; ?>
                    <input type='hidden' name='asp_performance' value='1' />
                </fieldset>
            </form>
            <form name='asp_performance_settings_clear' class="asp_performance_settings_clear" method='post'>
                <?php if (is_array($asp_performance)): ?>
                    <fieldset>
                        <legend>Performance statistics</legend>
                        <ul>
                            <li>Search queries tracked: <strong><?php echo $asp_performance['run_count']; ?></strong></li>
                            <li>Average request runtime: <strong><?php echo number_format($asp_performance['average_runtime'], 3, '.', ''); ?> s</strong></li>
                            <li>Average request peak memory usage: <strong><?php echo wpd_mem_convert($asp_performance['average_memory']); ?></strong></li>
                            <li>Last request runtime: <strong><?php echo number_format($asp_performance['last_runtime'], 3, '.', ''); ?> s</strong></li>
                            <li>Last request peak memory usage: <strong><?php echo wpd_mem_convert($asp_performance['last_memory']); ?></strong></li>
                        </ul>
                        <div class="item">
                            <label for="perf_asp_submit">Clear performace statistics?</label>
                            <input type='submit' name="asp_perf_clear" id="asp_perf_clear" class='submit' value='Clear'/>
                        </div>
                    </fieldset>
                <?php endif; ?>
            </form>
            <fieldset>
                <legend>Performance quick FAQ</legend>
                <dl>
                    <dt>How come the performance tracker shows low runtime, yet the search results appear slower?</dt>
                    <dd>
                        The performance tracker only tracks the length of the search function.<br>
                        Before that WordPress initializes, loads all of the plugins, executes all the tasks needed and
                        then executes the search function. Depending on the number of plugins, server speed, this can take
                        some time. In this case not the search is slow, but actually the WordPress initialization.
                    </dd>
                    <dt>How can I make the ajax request run faster?</dt>
                    <dd>
                        Using less plugins is usually the best solution. Lots of plugins will decrease the WordPress
                        performance - thus increasing the response time of ajax requests.
                        Running a <a href="https://wordpress.org/plugins/p3-profiler/">performance profiler plugin</a> might give you an insight on which plugins take the most
                        resources during loading - but it might be different for ajax requests.
                    </dd>
                    <dt>Can't the plugin bypass the WordPress initialization and just run the search query?</dt>
                    <dd>
                        Partially, yes. If you go to the <strong>Compatibility settings</strong> and enable the <strong>Use custom ajax handler</strong>
                        option, the search will use a custom handler, which bypasses some of the loading process.<br>
                        This might not work with some plugins or themes.
                    </dd>
                </dl>
            </fieldset>
        </div>
    </div>
    <div id="asp-options-search">
        <a class="wd-accessible-switch" href="#"><?php echo isset($_COOKIE['asp-accessibility']) ? 'DISABLE ACCESSIBILITY' : 'ENABLE ACCESSIBILITY'; ?></a>
    </div>
    <div class="clear"></div>
    <script>
        jQuery(function ($) {
            $("form[name='asp_performance_settings'] .wpdreamsYesNoInner").on("click", function () {
                setTimeout(function () {
                    $("form[name='asp_performance_settings']").get(0).submit();
                }, 500);
            });
            $("form[name='asp_performance_settings_clear']").on("submit", function () {
                if (!confirm('Do you want to clear the performance statistics?')) {
                     return false;
                }
            });
        });
    </script>
</div>