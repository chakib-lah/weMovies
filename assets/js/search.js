import $ from 'jquery';

$(document).ready(function() {
    $('#movie-search').on('input', function() {
        let query = $(this).val();

        // Clear the previous results
        $('#autocomplete-results').empty().hide();

        if (query.length > 2) {
            $.ajax({
                url: '/search',
                method: 'GET',
                data: { query: query },
                success: function(data) {
                    // Show the dropdown if there are results
                    if (data.length > 0) {
                        let resultsDropdown = $('#autocomplete-results');

                        data.forEach(movie => {
                            resultsDropdown.append(`<li class="list-group-item">${movie.title}</li>`);
                        });

                        resultsDropdown.show();
                    }
                },
                error: function() {
                    console.log('Error fetching autocomplete results');
                }
            });
        }
    });

    // Hide the dropdown when clicking outside
    $(document).click(function(event) {
        if (!$(event.target).closest('#movie-search, #autocomplete-results').length) {
            $('#autocomplete-results').fadeOut(200); // Smoothly fade out the dropdown
        }
    });

    // Handle click events on the list items
    $('#autocomplete-results').on('click', 'li', function() {
        let selectedMovieTitle = $(this).text();
        $('#movie-search').val(selectedMovieTitle);
        $('#autocomplete-results').fadeOut(200);
    });
});
