(function ($) {
  $(document).ready(function () {
    // Onchange of select docs page
    $(".docs-page-wrap select").on("change", function () {
      let url = $("#get_docs_archive").attr("href");
      let value = url.substring(url.lastIndexOf("/") + 1);
      let x = "?p=";
      let result =
        x +
        this.value +
        "?autofocus[panel]=docs-page&autofocus[section]=docs-archive-page";
      url = url.replace(value, result);
      $("#get_docs_archive").attr("href", url);
    });

    // Order by Sortable ajax
    if ($(".sortable").length) {
      $(".sortable").sortable({
        placeholder: "ui-state-highlight",
        connectWith: ".easydocs-accordion-item",
        update: function (event, ui) {
          let page_id_array = [];
          $("li, .child-docs-wrap").each(function () {
            page_id_array.push($(this).attr("data-id"));
          });
          $.ajax({
            url: eazydocs_local_object.ajaxurl,
            method: "POST",
            data: {
              action: "eazydocs_sortable_docs",
              page_id_array: page_id_array,
            },
          });
        },
      });
    }

    // Doc Visibility
    function ezd_doc_visibility() {
      $("a.docs-visibility").click(function (e) {
        e.preventDefault();
        let href = $(this).attr("href");

 
        Swal.fire({
          title: "Visibility Options.",
          html:
            '<div class="docs_visibility_wrapper">' +
            "<p>The selected visibility option will apply to the child docs as well.</p>" +
            '<div class="docs_visibility_field_wrap">' +
            '<label for="ezd_docs_sidebar">Select Doc Visibility</label>' +
            '<input type="radio" id="ezd_status_public" name="ezd_doc_status" value="publish">' +
            '<label for="ezd_status_public">Public</label>' +
            '<input type="radio" id="ezd_status_private" name="ezd_doc_status" value="private">' +
            '<label for="ezd_status_private">Private</label>' +
            '<input type="radio" id="ezd_status_protected" name="ezd_doc_status" value="protected">' +
            '<label for="ezd_status_protected">Password protected</label>' +
            '<input type="text" id="ezd_password_input" name="ezd_password_input" value="" placeholder="Insert Password">' +
            "</div>" +
            "</div>",
          showCancelButton: true,
          showCancelButton: true,
          confirmButtonText: "Update",
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            var ezd_doc_status = $('input[name="ezd_doc_status"]:checked').val();

            
            var ezd_password_input = document.getElementById("ezd_password_input").value;
            var  ezd_password_inputfdsfd = ezd_password_input.replaceAll( "#", ";hash;" );

            document.location.href = href + "&doc_visibility_type=" + ezd_doc_status + "&doc_password_input=" + ezd_password_inputfdsfd;
 
          }
        });

        $("#ezd_password_input").hide();
        $('input[name="ezd_doc_status"]').click(function () {
          var ezd_doc_status = $('input[name="ezd_doc_status"]:checked').val();
          if (ezd_doc_status == "protected") {
            $("#ezd_password_input").show();
          } else {
            $("#ezd_password_input").hide();
          }
        });
      });
    }
    ezd_doc_visibility();

    // Doc Visibility
    function ezd_doc_export() {
      $(document).on("click", "a.ezdoc-export", function (e) {
        e.preventDefault();
        let href = $(this).attr("href");
        Swal.fire({
          title: "Do you want to export this Doc?",
          html: "We're here to help you to do this service",
          showCancelButton: true,
          showCancelButton: true,
          confirmButtonText: "Update",
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            document.location.href = href;
          }
        });
      });
    }
    ezd_doc_export();

    // Docs Sidebar
    function ezd_docs_sidebar() {
      $(document).on("click", ".docs-sidebar", function (e) {
        e.preventDefault();
        let href = $(this).attr("href");

        // function created to get parameter from edit url
        $.urlParams = function (name) {
          var doc_results = new RegExp("[?&]" + name + "=([^&#]*)").exec(href);
          if (doc_results == null) {
            return "";
          }
          return decodeURI(doc_results[1]) || "";
        };

        let left_type = $.urlParams("left_type");
        let right_type = $.urlParams("right_type");

        let left_content = "";
        if (left_type != "widget_data") {
          left_content = $.urlParams("left_content");
        }

        let right_content = "";
        if (right_type != "widget_data_right") {
          right_content = $.urlParams("right_content");
        }

        Swal.fire({
          title: "Doc Sidebar",
          html:
            '<div class="create_onepage_doc_area">' +
            '<div class="ezd_content_btn_wrap">' +
            '<div class="left_btn_link ezd_left_active">Left Sidebar</div>' +
            '<div class="right_btn_link">Right Sidebar</div>' +
            "</div>" +
            '<div class="ezd_left_content">' +
            '<div class="ezd_docs_content_type_wrap">' +
            '<label for="ezd_docs_content_type">Content Type:</label>' +
            '<input type="radio" id="widget_data" name="ezd_docs_content_type" value="widget_data">' +
            '<label for="widget_data">Reusable Blocks</label>' +
            '<input type="radio" checked id="string_data" name="ezd_docs_content_type" value="string_data">' +
            '<label for="string_data">Normal Content</label>' +
            "</div>" +
            '<div class="ezd_shortcode_content_wrap">' +
            '<label for="ezd-shortcode">Content (Optional) </label><br>' +
            '<textarea name="ezd-shortcode-content" id="ezd-shortcode-content" rows="5" class="widefat">' +
            left_content +
            "</textarea>" +
            '<span class="ezd-text-support">*The field will support text and html formats.</span>' +
            "</div>" +
            '<div class="ezd_widget_content_wrap">' +
            eazydocs_local_object.get_reusable_block +
            eazydocs_local_object.manage_reusable_blocks +
            "</div>" +
            "</div>" +
            '<div class="ezd_right_content">' +
            '<div class="ezd_docs_content_type_wrap">' +
            '<label for="ezd_docs_content_type">Content Type:</label>' +
            '<input type="radio" id="widget_data_right" name="ezd_docs_content_type_right" value="widget_data_right">' +
            '<label for="widget_data_right">Reusable Blocks</label>' +
            '<input type="radio" checked id="string_data_right" name="ezd_docs_content_type_right" value="string_data_right">' +
            '<label for="string_data_right">Normal Content</label>' +
            '<input type="radio" id="shortcode_right" name="ezd_docs_content_type_right" value="shortcode_right">' +
            '<label for="shortcode_right">Doc Sidebar</label>' +
            '<div class="ezd-doc-sidebar-intro">To show the doc sidebar data, you have to go to <b>appearance</b> then <b>widgets</b> and just add your content inside <b>Doc Right Sidebar</b> location. If you cant find the location in the Widgets area, go to <b>EazyDocs</b> -> <b>Settings</b>. Then go to <b>Doc Single</b> -> <b>Right Sidebar</b> and then enable the option called <b>"Widgets Area"</b>' +
            "</div>" +
            "</div>" +
            '<div class="ezd_shortcode_content_wrap_right">' +
            '<label for="ezd-shortcode">Content (Optional) </label><br>' +
            '<textarea name="ezd-shortcode-content-right" id="ezd-shortcode-content-right" rows="5" class="widefat">' +
            right_content +
            "</textarea>" +
            '<span class="ezd-text-support">*The field will support text and html formats.</span>' +
            "</div>" +
            '<div class="ezd_widget_content_wrap_right">' +
            eazydocs_local_object.get_reusable_blocks_right +
            eazydocs_local_object.manage_reusable_blocks +
            "</div>" +
            "</div>",
          confirmButtonText: "Update",
          showCancelButton: true,
        }).then((result) => {
          if (result.isConfirmed) {
            let left_content = document.getElementById(
              "ezd-shortcode-content"
            ).value;
            let right_content = document.getElementById(
              "ezd-shortcode-content-right"
            ).value;

            let get_left_content = left_content.replace(/<!--(.*?)-->/gm, "");
            let style_attr_update1 = get_left_content.replaceAll(
              "style=",
              "style@"
            );
            let style_attr_update2 = style_attr_update1.replaceAll(
              "#",
              ";hash;"
            );
            let style_attr_update = style_attr_update2.replaceAll(
              "style&equals;",
              "style@"
            );

            let get_right_content = right_content.replace(/<!--(.*?)-->/gm, "");
            let right_style_attr_update1 = get_right_content.replaceAll(
              "style=",
              "style@"
            );
            let right_style_attr_update2 = right_style_attr_update1.replaceAll(
              "#",
              ";hash;"
            );
            let right_style_attr_update = right_style_attr_update2.replaceAll(
              "style&equals;",
              "style@"
            );

            encoded = encodeURIComponent(JSON.stringify(style_attr_update));
            encoded_right = encodeURIComponent(
              JSON.stringify(right_style_attr_update)
            );

            window.location.href =
              href +
              "&content_type=" +
              document.querySelector(
                "input[name=ezd_docs_content_type]:checked"
              ).value +
              "&left_side_sidebar=" +
              document.getElementById("left_side_sidebar").value +
              "&shortcode_content=" +
              encoded +
              "&shortcode_right=" +
              document.querySelector(
                "input[name=ezd_docs_content_type_right]:checked"
              ).value +
              "&shortcode_content_right=" +
              encoded_right +
              "&right_side_sidebar=" +
              document.getElementById("right_side_sidebar").value;
          }
        });

        // check widget save left sidebar
        if (left_type == "shortcode") {
          $(".ezd_doc_left_shortcode").prop("checked", true);
        } else if (left_type == "widget_data") {
          $(".ezd_widget_content_wrap").css("display", "block");
          $(".ezd_shortcode_content_wrap").css("display", "none");
          $("#widget_data").prop("checked", true);
          let get_left_widget = $.urlParams("left_content");
          $('#left_side_sidebar option[value="' + get_left_widget + '"]')
            .prop("selected", true)
            .trigger("change");
        }

        $(".ezd_content_btn_wrap .left_btn_link").addClass("ezd_left_active");
        $(".ezd_left_content").addClass("ezd_left_content_active");

        $(".ezd_content_btn_wrap .left_btn_link").click(function () {
          $(this).addClass("ezd_left_active");
          $(".ezd_left_content").addClass("ezd_left_content_active");
          $(".ezd_right_content").removeClass("ezd_left_content_active");
          $(".ezd_content_btn_wrap .right_btn_link").removeClass(
            "ezd_right_active"
          );
        });
        $(".ezd_content_btn_wrap .right_btn_link").click(function () {
          $(this).addClass("ezd_right_active");
          $(".ezd_left_content").removeClass("ezd_left_content_active");
          $(".ezd_right_content").addClass("ezd_left_content_active");
          $(".ezd_content_btn_wrap .left_btn_link").removeClass(
            "ezd_left_active"
          );
        });

        $("input[type=radio]#widget_data").click(function () {
          if ($(this).prop("checked")) {
            $(".ezd_shortcode_content_wrap").hide();
            $(".ezd_widget_content_wrap").show();
          }
        });

        $("input[type=radio]#string_data").click(function () {
          if ($(this).prop("checked")) {
            $(".ezd_shortcode_content_wrap").show();
            $(".ezd_widget_content_wrap").hide();
          }
        });

        // RIGHT TAB
        $(".ezd_widget_content_wrap_right,.ezd-doc-sidebar-intro").hide();

        $("input[type=radio]#string_data_right").click(function () {
          if ($(this).prop("checked")) {
            $(".ezd_widget_content_wrap_right").hide();
            $(".ezd_shortcode_content_wrap_right").show();
            $(".ezd-doc-sidebar-intro").hide();
          }
        });

        $("input[type=radio]#shortcode_right").click(function () {
          if ($(this).prop("checked")) {
            $(".ezd_widget_content_wrap_right").hide();
            $(".ezd_shortcode_content_wrap_right").hide();
            $(".ezd-doc-sidebar-intro").show();
          }
        });

        $("input[type=radio]#widget_data_right").click(function () {
          if ($(this).prop("checked")) {
            $(".ezd_widget_content_wrap_right").show();
            $(
              ".ezd_shortcode_content_wrap_right,.ezd-doc-sidebar-intro"
            ).hide();
          }
        });

        // check widget save
        if (right_type == "shortcode_right") {
          $("#shortcode_right").prop("checked", true);
          $(".ezd_shortcode_content_wrap_right").css("display", "none");
          $(".ezd-doc-sidebar-intro").css("display", "block");
        } else if (right_type == "widget_data_right") {
          $(".ezd_widget_content_wrap_right").css("display", "block");
          $(".ezd_shortcode_content_wrap_right,.ezd-doc-sidebar-intro").css(
            "display",
            "none"
          );
          $("#widget_data_right").prop("checked", true);
          let get_right_widget = $.urlParams("right_content");
          $('#right_side_sidebar option[value="' + get_right_widget + '"]')
            .prop("selected", true)
            .trigger("change");
        }
      });
    }
    ezd_docs_sidebar();
  });
})(jQuery);
