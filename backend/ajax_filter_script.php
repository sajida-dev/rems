<script src="js/jquery.min.js"></script>
<script>
    // $(document).ready(function() {
    //     $('#filter-form input, #filter-form select').on('change keyup', function() {
    //         var formData = $('#filter-form').serialize();
    //         $.ajax({
    //             url: 'backend/filter_properties.php',
    //             type: 'POST',
    //             data: formData,
    //             success: function(response) {
    //                 $('#properties-listing').html(response);
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error("Error: " + error);
    //             }
    //         });
    //     });
    // });

    $(document).ready(function() {
        // For text inputs, use keyup (with a slight delay or debounce if needed)
        $('#filter-form input[type="text"]').on('keyup', function() {
            updateProperties();
        });
        // For number inputs and selects, use change event
        $('#filter-form input[type="number"], #filter-form select').on('change', function() {
            updateProperties();
        });

        function updateProperties() {
            var formData = $('#filter-form').serialize();
            console.log("Form Data:", formData);
            $.ajax({
                url: 'backend/filter_properties.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log("AJAX Response:", response);
                    $('#properties-listing').html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                }
            });
        }
    });
</script>