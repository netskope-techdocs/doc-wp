(function($){
    $(document).ready(function (){

        // Jquery mark
        $(function() {
            let mark = function() {
                // Read the keyword
                let keyword = $("input[name='filter']").val();
                // Determine selected options
                let options = {};
                $(".left-sidebar-results").unmark({
                    done: function() {
                        $(".left-sidebar-results").mark(keyword, options);
                    }
                });
            };
            $("input[name='filter']").on("input", mark);
        });

    });
})(jQuery)