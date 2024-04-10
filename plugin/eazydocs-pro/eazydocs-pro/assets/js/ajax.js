(function ($) {
  'use strict'

  $(document).ready(function () {

    let hsearch = jQuery('#wp-spotlight-chat-search')
    let noresult = ''

    hsearch.on('keyup', function () {
      let keyword = jQuery('#wp-spotlight-chat-search').val()
      if (keyword == '') {
        jQuery('#chatbox-search-results').html(
          '<div class="chatbox-posts" tab-data="post">\n' +
          '<div class="post-item keyword-alert">' +
          '<p>Please type a keyword to search for contents.</p>' +
          '</div>' +
          '</div>'
      )
      } else {
        $.ajax({
          url: eazydocs_ajax_search.ajax_url,
          method: 'post',
          data: {
            action: 'eazydocs_ajax_search_result',
            keyword: keyword,
          },
          beforeSend: function () {
            $('#chatbox-search-results').html(
              '<?xml version="1.0" encoding="utf-8"?>\n' +
              '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">\n' +
              '<circle cx="50" cy="50" r="18" stroke-width="2" stroke="#4c4cf1" stroke-dasharray="28.274333882308138 28.274333882308138" fill="none" stroke-linecap="round">\n' +
              '  <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" keyTimes="0;1" values="0 50 50;360 50 50"></animateTransform>\n' +
              '</circle>\n' +
              '</svg>',
            )
          },
          success: function (response) {
            $('#chatbox-search-results').html(response)
          },
          error: function () {
            console.log('Oops! Something wrong, try again!')
          },
        })
      }
    });
    
    // Contributor [ Delete ] 
    function ezd_contribute_delete(){
      $('.ezd_contribute_delete').click(function(e){ 
        e.preventDefault();

        let contributor_id      = $(this).attr('data-contributor-delete');
        let data_doc_id         = $(this).attr('data-doc-id');
        let user_name           = $(this).attr('data_name');

          $.ajax({
            url: eazydocs_ajax_search.ajax_url,
            method: 'POST',
            data: {
              action: 'ezd_doc_contributor',
              contributor_delete: contributor_id,
              data_doc_id: data_doc_id
            },
            beforeSend: function () {
              $('.ezd_contribute_delete[data-contributor-delete='+contributor_id+']').html( '<span class="spinner-border ezd-contributor-loader"><span class="visually-hidden">Loading...</span></span>' )
            },
            success: function (response) {
              $('#to_add_contributors').append(response)
              $('#user-'+contributor_id).remove();
              $('.to-add-user-'+contributor_id).not(':last').remove();

              $('.ezdoc_contributed_user_avatar a[data-bs-original-title="'+user_name+'"]').remove();
              ezd_contributor_add();

            },
            error: function () {
              console.log('Oops! Something wrong, try again!')
            }
          });
      });
    }
    ezd_contribute_delete();
    
    // Contributor [ Add ] 
    function ezd_contributor_add(){
      $('.ezd_contribute_add').click(function(e){   
   
        e.preventDefault();        
        let contributor_add   = $(this).attr('data-contributor-add');
        let data_doc_id       = $(this).attr('data-doc-id');
        
        let user_img          = $(this).parent().parent().find('img').attr('src');
        let user_name         = $(this).attr('data_name');
        let user_url          = $(this).parent().parent().find('a').attr('href');
        console.log(user_name);
        $.ajax({
          url: eazydocs_ajax_search.ajax_url,
          method: 'POST',
          data: {
            action: 'ezd_doc_contributor',
            contributor_add: contributor_add,
            data_doc_id: data_doc_id
          },
          beforeSend: function () {
            $('.ezd_contribute_add[data-contributor-add='+contributor_add+']').html( '<span class="spinner-border ezd-contributor-loader"><span class="visually-hidden">Loading...</span></span>' )
          },
          success: function (response) {
            $('#added_contributors').append(response);
            $('#to-add-user-'+contributor_add).remove();

            $('.user-'+contributor_add).not(':last').remove();

            $('.contributed_user_list').append('<a title="'+user_name+'" href="'+user_url+'" data-bs-toggle="tooltip" data-bs-placement="bottom"><img width="24px" src="'+user_img+'"></a>');
            $('.contributed_user_list a[data-bs-original-title="'+user_name+'"]').remove();
            
            $('[data-bs-toggle="tooltip"]').tooltip();

            ezd_contribute_delete();
            
          },
          error: function () {
            console.log('Oops! Something wrong, try again!')
          }
        });
      });
    }
    ezd_contributor_add();
    
    // EazyDocs login submission
    $('.ezd-form-wrap').submit(function (e) {
        e.preventDefault();

        // Get form data
        var formData = $(this).serialize();
        var nonceValue = eazydocs_ajax_search.eazydocs_local_nonce;

        // Perform AJAX request
        $.ajax({
            type: 'POST',
            url: eazydocs_ajax_search.ajax_url,
            data: formData + '&action=ezd_login_check&nonce=' + nonceValue,
            dataType: 'json',
            beforeSend: function () {
                $('.ezd-login-error').html('<span class="spinner-border ezd-login-loader"><span class="visually-hidden">Loading...</span></span>');
            },
            success: function (response) {
              $('.ezd-login-error').html(response.message);
              // Check if login was successful
              if (response.success) {
                  // Redirect to a specific page after login
                  window.location.href = response.redirect_to ;
              }
            }
        });
    });
    // end
    
  });
})(jQuery);