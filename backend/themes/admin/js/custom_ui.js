/**
 * Created by Gurwinder on 1/14/2016.
 */
$(function() {
    $( "#sortable" ).sortable({
            stop: function( event, ui ) {

                var sortedIDs = $( "#sortable" ).sortable( "toArray" );
                $.post(baseurl + "/dropdown-values/sort-values",{'sort_ids': sortedIDs}, function(data){

                    //$("#result").append(data.result); //append received data into the element
                    //$('.animation_image').hide(); //hide loading image

                }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?

                    alert(thrownError); //alert with HTTP error
                    $('.animation_image').hide(); //hide loading image
                    loading = false;

                });
            }
    });
    $( "#sortable" ).disableSelection();
	$( "#sortable1" ).sortable({
            stop: function( event, ui ) {
				var cat_id = $( "#sortable1" ).attr('data-id');
                var sortedIDs = $( "#sortable1" ).sortable( "toArray" );
                $.post(baseurl + "/type/sort-general-attrs",{'sort_ids': sortedIDs, 'cat_id':cat_id}, function(data){

                    //$("#result").append(data.result); //append received data into the element
                    //$('.animation_image').hide(); //hide loading image

                }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?

                    alert(thrownError); //alert with HTTP error
                    $('.animation_image').hide(); //hide loading image
                    loading = false;

                });
            }
    });
    $( "#sortable1" ).disableSelection();
	$( "#sortable2" ).sortable({
            stop: function( event, ui ) {
				var cat_id = $( "#sortable1" ).attr('data-id');
                var sortedIDs = $( "#sortable2" ).sortable( "toArray" );
                $.post(baseurl + "/type/sort-slider-attrs",{'sort_ids': sortedIDs, 'cat_id':cat_id}, function(data){

                    //$("#result").append(data.result); //append received data into the element
                    //$('.animation_image').hide(); //hide loading image

                }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?

                    alert(thrownError); //alert with HTTP error
                    $('.animation_image').hide(); //hide loading image
                    loading = false;

                });
            }
    });
    $( "#sortable2" ).disableSelection();
});