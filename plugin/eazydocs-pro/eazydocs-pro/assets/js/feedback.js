(function($){
    $(document).ready(function(){
        // NEW DOC
        function feedback_archived() {
          $(document).on('click', 'a.ezd-feedback-archive', function (e) {
              e.preventDefault();
              let href = $(this).attr('href');

              Swal.fire({
                  title: eazydocspro_local_object.feedback_prompt_archive_title,
                  text: eazydocspro_local_object.feedback_prompt_archive_desc,
                  showCancelButton: true,
                  icon: 'warning',
                  confirmButtonText: 'Mark as Archive',
                }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                      document.location.href = href;
                  }
                })
                
          })
      }
      feedback_archived();

      function feedback_open() {
          $(document).on('click', 'a.ezd-feedback-open', function (e) {
              e.preventDefault();
              let href = $(this).attr('href');
              Swal.fire({
                  title: eazydocspro_local_object.feedback_prompt_open_title,
                  text: eazydocspro_local_object.feedback_prompt_open_desc,
                  showCancelButton: true,
                  icon: 'success',
                  showCancelButton: true,
                  confirmButtonText: 'Mark as Open',
                }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                      document.location.href = href;
                  }
                })
          })
      }
      feedback_open();
      
      function feedback_delete() {
        $(document).on('click', 'a.ezd-feedback-delete', function (e) {
            e.preventDefault();
            let href = $(this).attr('href');
            Swal.fire({
                title: eazydocspro_local_object.feedback_prompt_delete_title,
                text: eazydocspro_local_object.feedback_prompt_delete_desc,
                showCancelButton: true,
                icon: 'error',
                showCancelButton: true,
                confirmButtonText: 'Delete',
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    document.location.href = href;
                }
              })
        })
    }
    feedback_delete();

    })
})(jQuery)