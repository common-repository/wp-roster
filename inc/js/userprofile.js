jQuery(document).ready(function ($) {    
    
        
    //makes image upload field 
   $('#wpwrap').on("click",".wp_roster_custom_user_profile_image", function(event){
        event.preventDefault();
       
        //console.log('I was clicked');
        
        var previousInput = $(this).prev(); 
       
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            
            previousInput.val(image_url);
            
            
            //update user profile image with new image
            
            $('#wpRosterImagePreview').attr('src',image_url);
            

        });
    });
    
    
    //remove rosters from allocation field when checkboxes are checked and unchecked
    $('#wpwrap').on("click",".roster-allocation-checkbox", function(event){

        var existingValue = $('#wp-roster-allocation').val();
        var existingValueExploded = existingValue.split('||');
        var thisValue = $(this).val();

        if($(this).prop('checked')==true){
            console.log('I was checked');
            existingValueExploded.push(thisValue);
        } else {
            console.log('I was unchecked');
            var indexOfCurrentElement = existingValueExploded.indexOf(thisValue);
            existingValueExploded.splice(indexOfCurrentElement,1);
        }



        //update input
        var existingValueImploded = existingValueExploded.join('||');
        $('#wp-roster-allocation').val(existingValueImploded);

        
    });    
    

    //enable date picker
    $(".user-profile-date-selection").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        allowInput: true,
    });
    
    
    
    
});    