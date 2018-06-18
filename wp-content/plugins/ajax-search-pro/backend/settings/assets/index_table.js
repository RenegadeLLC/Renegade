jQuery(function ($) {
    // ------------- TAB HANDLING ---------------
    // Remove the # from the hash, as different browsers may or may not include it
    var hash = location.hash.replace('#','');
    if (hash != '') {
        hash = parseInt(hash);
        $('.tabs a[tabid=' + hash + ']').click();
    } else {
        $('.tabs a[tabid=1]').click();
    }

    $('.tabs a').on('click', function(){
        location.hash = $(this).attr('tabid');
    });
    // ------------------------------------------

    var post = null;
    var $buttons = $("#index_buttons input[type='button']");
    var $progress = $(".wd_progress_text, .wd_progress, .wd_progress_stop");
    var $progress_bar = $(".wd_progress span");
    var $progress_text = $(".wd_progress_text");
    var $overlay = $("#asp_it_disable");
    var $success = $("#asp_i_success");
    var $error = $("#asp_i_error");
    var $error_cont = $("#asp_i_error_cont");
    var data = "";
    var keywords_found = 0;
    var remaining_blogs = [];
    var blog = "";
    var initial_action = "";

    function asp_on_post_success(response) {
        var res = response.replace(/^\s*[\r\n]/gm, "");
        res = res.match(/!!!ASP_INDEX_START!!!(.*[\s\S]*)!!!ASP_INDEX_STOP!!!/);
        if (res != null && (typeof res[1] != 'undefined')) {
            res = JSON.parse(res[1]);

            if (
                typeof res.postsIndexed != "undefined" ||
                (typeof res.postsIndexed != "undefined" && remaining_blogs.length > 0)
            ) {
                // New or extend operation
                res.postsIndexed = Number(res.postsIndexed);
                res.postsToIndex = Number(res.postsToIndex);
                res.keywordsFound = Number(res.keywordsFound);
                res.totalKeywords = Number(res.totalKeywords);

                $("#indexed_counter").html(res.postsIndexed);
                $("#not_indexed_counter").html(res.postsToIndex);
                $("#keywords_counter").html(res.totalKeywords);

                if (res.postsToIndex > 0 || remaining_blogs.length > 0) {
                    var percent = (res.postsIndexed / (res.postsToIndex + res.postsIndexed)) * 100;
                    keywords_found += res.keywordsFound;

                    $progress_bar.css('width', percent + "%");

                    if ($('input[name=it_blog_ids]').val() != "")
                        $progress_text.html("Progress: " + percent.toFixed(2) + "% | Keywords found so far: " + keywords_found + " | Processing blog no. " + blog);
                    else
                        $progress_text.html("Progress: " + percent.toFixed(2) + "% | Keywords found so far: " + keywords_found);

                    var the_action = 'extend';
                    // No posts left, try switching the blog
                    if (res.postsToIndex <= 0 && remaining_blogs.length > 0) {
                        blog = remaining_blogs.shift();
                        if (initial_action == 'new')
                            the_action = 'switching_blog';
                    }

                    data = {
                        action: 'asp_indextable_admin_ajax',
                        asp_index_action: the_action,
                        blog_id: blog,
                        data: $('#asp_indextable_settings').serialize()
                    };

                    // Wait a bit to cool off the server
                    setTimeout(function () {
                        post = $.post(ajaxurl, data)
                            .done(asp_on_post_success)
                            .fail(asp_on_post_failure);
                    }, 1500);

                    return;
                }

                keywords_found += res.keywordsFound;
                $success.removeClass('hiddend').html("Success. <strong>" + keywords_found + "</strong> new keywords were added to the database.");
            } else {
                res.postsToIndex = Number(res.postsToIndex);
                res.totalKeywords = Number(res.totalKeywords);

                $("#indexed_counter").html(0);
                $("#not_indexed_counter").html(res.postsToIndex);
                $("#keywords_counter").html(res.totalKeywords);

                $success.removeClass('hiddend').html("Success. The index table was emptied.");
            }
        } else {
            $error.removeClass('hiddend').html('Something went wrong. Here is the error message returned: ');
            $error_cont.removeClass('hiddend').val(response);
        }

        $buttons.removeAttr('disabled');
        $progress.addClass('hiddend');
        $overlay.addClass('hiddend');
    }

    function asp_on_post_failure(response, t) {
        if (t === "timeout") {
            $error.removeClass('hiddend').html('Timeout error. Try lowering the <strong>Post limit per iteration</strong> option below.');
        } else {
            $error.removeClass('hiddend').html('Something went wrong. Here is the error message returned: ');
            console.log(response);
            if (
                typeof response.status != 'undefined' &&
                typeof response.statusText != 'undefined'
            ) {
                $error_cont.removeClass('hiddend').val("Status: " + response.status + "\nCode: " + response.statusText);
            } else {
                $error_cont.removeClass('hiddend').val(response);
            }
        }
        $buttons.removeAttr('disabled');
        $progress.addClass('hiddend');
        $overlay.addClass('hiddend');
    }


    $('#asp_index_new, #asp_index_extend, #asp_index_delete').on('click', function (e) {
        if (!confirm($(this).attr('index_msg'))) {
            return false;
        }

        $('.asp-notice-ri').css("display", "none");

        $('.wd_progress_stop').click();

        var blogids_input_val = $('input[name=it_blog_ids]').val().replace('xxx1', '');

        if ($('input.use-all-blogs').is(':checked')) {
            $(".wpdreamsBlogselect ul.connectedSortable li").each(function () {
                remaining_blogs.push($(this).attr('bid'));
            });
        } else if (blogids_input_val != "") {
            remaining_blogs = blogids_input_val.split('|');
        } else {
            remaining_blogs = ASP_IT.current_blog_id.slice(0);
        }

        // Still nothing
        if (remaining_blogs.length == 0)
            remaining_blogs = ASP_IT.current_blog_id.slice(0); // make a shadow clone, otherwise ASP_IT.curr.. will be altered

        blog = remaining_blogs.shift();
        $buttons.attr('disabled', 'disabled');
        $progress.removeClass('hiddend');
        $overlay.removeClass('hiddend');
        $success.addClass('hiddend');
        $error.addClass('hiddend');
        $error_cont.addClass('hiddend');

        initial_action = $(this).attr('index_action');

        data = {
            action: 'asp_indextable_admin_ajax',
            asp_index_action: $(this).attr('index_action'),
            blog_id: blog,
            data: $('#asp_indextable_settings').serialize()
        };

        // Wait a bit to cool off the server
        setTimeout(function () {
            post = $.post(ajaxurl, data)
                .done(asp_on_post_success)
                .fail(asp_on_post_failure);
        }, 250);
    });

    $('.wd_progress_stop').on('click', function (e) {
        if (post != null) post.abort();
        keywords_found = 0;
        data = "";
        $("#index_buttons input[type='button']").removeAttr('disabled');
        $(".wd_progress_text, .wd_progress, .wd_progress_stop").addClass('hiddend');
        $error.addClass('hiddend');
        $error_cont.addClass('hiddend');
        $progress_bar.css('width', "0%");
        $progress_text.html("Initializing, please wait.");
    });

    $("ul.connectedSortable", $('input[name=it_post_types]').parent()).on("sortupdate", function(){
        var val = JSON.parse( Base64.decode($('input[name=it_post_types]').val().replace(/^(_decode_)/,"")) );
        val = val.join(',');
        if ( val.indexOf('attachment') > -1 ) {
            $('#it_file_indexing').removeClass('disabled-opacity');
        } else {
            $('#it_file_indexing').addClass('disabled-opacity');
        }
    });
    $("ul.connectedSortable", $('input[name=it_post_types]').parent()).trigger("sortupdate");


    /**
     * @description determine if an array contains one or more items from another array.
     * @param {array} haystack the array to search.
     * @param {array} arr the array providing items to check for in the haystack.
     * @return {boolean} true|false if haystack contains at least one item from arr.
     */
    var findOne = function (haystack, arr) {
        return arr.some(function (v) {
            return haystack.indexOf(v) >= 0;
        });
    };
    var mimes = {
        'text' : [
            'text/plain',
            'text/csv',
            'text/tab-separated-values',
            'text/calendar',
            'text/css',
            'text/html'
        ],
        'richtext' : [
            'text/richtext',
            'application/rtf'
        ],
        'mso_word' : [
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-word.document.macroEnabled.12',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
            'application/vnd.ms-word.template.macroEnabled.12',
            'application/vnd.oasis.opendocument.text'
        ],
        'mso_excel' : [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel.sheet.macroEnabled.12',
            'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'application/vnd.ms-excel.template.macroEnabled.12',
            'application/vnd.ms-excel.addin.macroEnabled.12',
            'application/vnd.oasis.opendocument.spreadsheet',
            'application/vnd.oasis.opendocument.chart',
            'application/vnd.oasis.opendocument.database',
            'application/vnd.oasis.opendocument.formula'
        ],
        'mso_powerpoint' : [
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
            'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
            'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
            'application/vnd.openxmlformats-officedocument.presentationml.template',
            'application/vnd.ms-powerpoint.template.macroEnabled.12',
            'application/vnd.ms-powerpoint.addin.macroEnabled.12',
            'application/vnd.openxmlformats-officedocument.presentationml.slide',
            'application/vnd.ms-powerpoint.slide.macroEnabled.12',
            'application/vnd.oasis.opendocument.presentation',
            'application/vnd.oasis.opendocument.graphics'
        ]
    };
    $('textarea[name=it_attachment_mime_types]').on('click keyup change cut paste', function(){
        var val = $(this).val().toLowerCase().replace(' ', '');
        var vals_arr = val.split(',');

        if ( vals_arr.length > 0 ) {
            $.each(vals_arr, function(i, v){
                vals_arr[i] = v.trim();
            });
            $.each(mimes, function(i, v){
                $.each(v, function(ii, vv){
                    mimes[i][ii] = vv.toLowerCase();
                });
            });
            if ( findOne(mimes.text, vals_arr) ) {
                $('input[name=it_index_text_content]').closest('.item').removeClass('disabled');
            } else {
                $('input[name=it_index_text_content]').closest('.item').addClass('disabled');
            }
            if ( findOne(mimes.richtext, vals_arr) ) {
                $('input[name=it_index_richtext_content]').closest('.item').removeClass('disabled');
            } else {
                $('input[name=it_index_richtext_content]').closest('.item').addClass('disabled');
            }
            if ( findOne(mimes.mso_word, vals_arr) ) {
                $('input[name=it_index_msword_content]').closest('.item').removeClass('disabled');
            } else {
                $('input[name=it_index_msword_content]').closest('.item').addClass('disabled');
            }
            if ( findOne(mimes.mso_excel, vals_arr) ) {
                $('input[name=it_index_msexcel_content]').closest('.item').removeClass('disabled');
            } else {
                $('input[name=it_index_msexcel_content]').closest('.item').addClass('disabled');
            }
            if ( findOne(mimes.mso_powerpoint, vals_arr) ) {
                $('input[name=it_index_msppt_content]').closest('.item').removeClass('disabled');
            } else {
                $('input[name=it_index_msppt_content]').closest('.item').addClass('disabled');
            }
        }

        if ( $(this).val().toLowerCase().indexOf('application/pdf') > -1 ) {
           $('select[name=it_index_pdf_method]').closest('.item').removeClass('disabled');
        } else {
           $('select[name=it_index_pdf_method]').closest('.item').addClass('disabled');
        }


    });
    $('textarea[name=it_attachment_mime_types]').trigger('click');


    $("input[name=it_pool_size_auto]").on('change', function(){
       if ( $(this).val() == 1 ) {
           $('.it_pool_size.item').addClass('disabled');
       } else {
           $('.it_pool_size.item').removeClass('disabled');
       }
    });
    $("input[name=it_pool_size_auto]").change();
});