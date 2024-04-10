<script>
    jQuery('#search_post_type').change(function(){
        let post_type = jQuery('#search_post_type').val();
        if ( post_type === 'bbp_search' ) {
            jQuery('#searchInput').attr('name', post_type)
            jQuery('#hidden_post_type').remove()
        } else if ( post_type === 'all' ) {
            jQuery('#hidden_post_type').remove()
        } else {
            jQuery('#hidden_post_type').val(post_type);
        }
    })
</script>