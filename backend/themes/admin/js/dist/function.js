// Copyright (c) 2015, Fujana Solutions - Moritz Maleck. All rights reserved.
// For licensing, see LICENSE.md

// Open image modal
function showImage(imgSrc, imgStyle) {
    $("#imageFSimg").attr('src', imgSrc);
    $("#imageFSimg").attr('style', 'max-width:' + imgStyle + 'px');

    $("#imageFullSreen").show();
    $("#background").slideDown(250, "swing");

    $("#imgActionUse").attr("onclick","useImage('" + imgSrc + "')");
    $("#imgActionDownload").attr("href", imgSrc);

}
function showUseBar(element) {
$('.'+$(element).attr('class')).children("span").css('bottom','-47px');
    $(element).children( "span" ).css( "bottom", "0" );
}
// Open editbar
function showEditBar(imgSrc, imgStyle, imgID, imgName) {
    var imgSrc = imgSrc;
    var imgStyle = imgStyle;
    var imgID = imgID;
    var imgName = imgName;

    $("#editbar").slideUp(100);
    $("#editbar").slideDown(100);
    
    $(".fileDiv,.fullWidthFileDiv").removeClass( "selected" );
    $("div[data-imgid='" + imgID +"']").addClass( "selected" );
    
    $("#updates").css("visibility", "hidden"); 
    $("#updates").slideUp(150);
    
    $("#editbarDelete").attr("onclick","deleteImg('" + imgName + "', '" + imgID + "');");
    $("#editbarUse").attr("onclick","useImage('" + imgSrc + "')");
    $("#editbarView").attr("onclick","showImage('" + imgSrc + "','" + imgStyle + "')");
    $("#editbarDownload").attr("href", imgSrc);
}

// hide editbar if user clicks outside of element
$(document).mouseup(function (e) {
    var container = $(".fileDiv,.fullWidthFileDiv,#editbar");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        hideEditBar();
    }
});

// hide editbar function
function hideEditBar() {
    $("#editbar").slideUp(100);
    
    $(".fileDiv,.fullWidthFileDiv").removeClass( "selected" );
    

}

// Use image and overgive image src to ckeditor
function useImage(imgSrc) {
    function getUrlParam( paramName ) {
        var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' ) ;
        var match = window.location.search.match(reParam) ;

        return ( match && match.length > 1 ) ? match[ 1 ] : null ;
    }
    var funcNum = getUrlParam( 'CKEditorFuncNum' );
    var imgSrc = imgSrc;
    var fileUrl = imgSrc;
    window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
    window.close();
}

// open upload image modal
function uploadImg() {

    $("#uploadImgDiv").show();
    $("#background2").slideDown(250, "swing");

}

// open settings modal
function pluginSettings() {

    $("#settingsDiv").show();
    $("#background3").slideDown(250, "swing");

}

// check if new version is available


// call jquery lazy load
$(function() {
    $("img.lazy").lazyload();
}); 

$( document ).ready(function() {
    var elem = '#uploadpathEditable';
    var text = '.saveUploadPathP';
    var btn = '.saveUploadPathA';
    var btnCancel = '#pathCancel';
    $( elem ).attr('contenteditable','true');
    $( elem ).click(function() {
        $( this ).addClass("editableActive");
        $( btn ).fadeIn();
        $( text ).show();
        $( '.pathHistory' ).fadeIn();
    });
    $( btnCancel ).click(function() {
        $( elem ).removeClass('editableActive');
        $( btn ).hide();
        $( text ).hide();
        $( '.pathHistory' ).hide();
    });
});

function updateImagePath(){
    var name = $("#uploadpathEditable").text();
    $.ajax({
      method: "POST",
      url: "pluginconfig.php",
      data: { newpath: name, }
    }).done(function( msg ) {
        $('#settingsDiv').hide();
        $('#background3').slideUp(250, 'swing');

        setTimeout(function(){
            location.reload();
        }, 250);
    });
}

// open pluginconfig.php to change the extension settings
function extensionSettings(setting){
    var setting = setting;
    $.ajax({
      method: "POST",
      url: "pluginconfig.php",
      data: { 
          extension: setting,
      }
    }).done(function( msg ) {
        $('#settingsDiv').hide();
        $('#background3').slideUp(250, 'swing');

        setTimeout(function(){
            location.reload();
        }, 250);
    });
}

// check if a file to upload is selected
function checkUpload(){
    if( document.getElementById("upload").files.length == 0 ){
        alert("Please select a file to upload.");
        return false;
    }
}




// delete image
function deleteImg(src, imgid) {
    $.ajax({
       method: "GET",
        url: "imgdelete.php",
        data: {
            img: src,
        }
    }).done(function() {
        var imgDiv = $( "div[data-imgid='" + imgid +"']" );
        if(Cookies.get('file_style') == "block"){
            imgDiv.addClass("deleteAnimationBlock");
        } else {
            imgDiv.slideUp(250, "swing");
        }
        setTimeout(function(){
            imgDiv.hide();
            hideEditBar();
            reloadImages();
        }, 320);
    });
}







