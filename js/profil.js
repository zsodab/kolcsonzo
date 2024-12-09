$(document).ready(function () {

    $('.tab-content').hide();


    function showTab(target) {
        $('.tab-content').hide();
        $('#' + target).show();
        $('.tab-link').removeClass('active');
        $('.tab-link[data-target="' + target + '"]').addClass('active');
    }


    function loadBookings() {
        console.log('Sending AJAX request to searchBooking.php');
        $.ajax({
            url: BASE_URL + 'search/searchBooking.php',
            type: 'POST',
            success: function (response) {
                console.log('Bokkings AJAX request successful');
                console.log(response);
                $('#car-results').html(response);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + status + ' ' + error);
            }
        });
    }


    function loadConversations() {
        console.log('Sending AJAX request to searchConversation.php');
        $.ajax({
            url: BASE_URL + 'search/searchConversation.php',
            type: 'POST',
            success: function (response) {
                console.log('AJAX request successful');
                console.log(response);
                $('#convList').html(response);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + status + ' ' + error);
            }
        });
    }


    function loadReviews() {
        console.log('Sending AJAX request to searchReviews.php');
        /*$.ajax({
            url: BASE_URL + 'search/searchReviews.php',
            type: 'POST',
            success: function (response) {
                console.log('AJAX request successful');
                console.log(response);
                $('#reviews').html(response);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + status + ' ' + error);
            }
        });*/
    }


    function newBooking() {
        $('.tab-content').hide();
        console.log('Sending AJAX request to newbooking.php');
        $.ajax({
            url: BASE_URL + 'new/newbooking.php',
            type: 'POST',
            data: {
                requesttype: 'newBooking',
                carID: requestCarID
            },
            success: function (response) {
                console.log('AJAX request successful');
                console.log(response);
                $('#newBooking').html(response);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + status + ' ' + error);
            }
        });
    }

    function createNewBooking() {
        console.log('Sending AJAX request to updatebooking.php');
        $.ajax({
            url: BASE_URL + 'update/updatebooking.php',
            type: 'POST',
            data: {
                requesttype: 'createBooking',
                carID: requestCarID,
                startDate: $('#startDate').val(),
                endDate: $('#endDate').val(),
                message: $('#message').val()
            },
            success: function (response) {
                console.log('AJAX request successful');
                console.log(response);
                $('#newBooking').html(response);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + status + ' ' + error);
            }
        });
    }


    /*function newBooking() 
    {
        //if ($('#conversations').attr('requesttype') == 'newBooking') {
        $('.tab-content').hide();
        $('#newBooking').show();
        
    }*/


    const tabLoaders = {
        bookings: loadBookings,
        //conversations: loadConversations,
        reviews: loadReviews
    };


    function handleTabChange(target) {
        showTab(target);
        window.history.pushState(null, null, '#tab=' + target);
        if (tabLoaders[target]) {
            tabLoaders[target]();
        }
    }

    //tab click
    $('.tab-link').click(function () {
        const target = $(this).data('target');
        handleTabChange(target);
    });

    // url check
    const hash = window.location.hash;
    const tab = hash ? hash.split('=')[1] : null;
    console.log('Tab parameter:', tab);
    if (tab) {
        handleTabChange(tab);
    } else {
        handleTabChange('bookings'); // Default tab
    }

    
    if(tab == 'conversations')
    {
        if (requestType === 'newBooking') {
            newBooking();
        } else if (requestType === 'convSubmitted') {
            alert ('Sikeres foglalás, hamarosan válaszolunk!');
        }
        else {
            handleTabChange('conversations');
        }
    }

});