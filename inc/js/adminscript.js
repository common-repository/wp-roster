jQuery(document).ready(function ($) {
    
    
    
    //make cloning remember select values
    (function (original) {
        jQuery.fn.clone = function () {
          var result           = original.apply(this, arguments),
              my_textareas     = this.find('textarea').add(this.filter('textarea')),
              result_textareas = result.find('textarea').add(result.filter('textarea')),
              my_selects       = this.find('select').add(this.filter('select')),
              result_selects   = result.find('select').add(result.filter('select'));
      
          for (var i = 0, l = my_textareas.length; i < l; ++i) $(result_textareas[i]).val($(my_textareas[i]).val());
          for (var i = 0, l = my_selects.length;   i < l; ++i) {
            for (var j = 0, m = my_selects[i].options.length; j < m; ++j) {
              if (my_selects[i].options[j].selected === true) {
                result_selects[i].options[j].selected = true;
              }
            }
          }
          return result;
        };
      }) (jQuery.fn.clone);


    
    
    // //selectively hide and show integrations depending on selection
    //  $('#idea_push_integration_service :selected').each(function () {
    //     var selectValue = $(this).val();
    //     $("#integrations .integration-setting").hide();
    //     $("."+selectValue).show();
    // });
    
    
    // $('#idea_push_integration_service').change(function () {
    //     var selectValue = $(this).val();
    //     $("#integrations .integration-setting").hide();
    //     $("."+selectValue).show();  
    // });
    
    
    

    
    //make tabs tabs
    $( "#tabs" ).tabs();
    
    
    //make the accordion an accordion
    $("#accordion").accordion({
        collapsible: true,
        autoHeight: false,
        heightStyle: "content",
        active: false,
        speed: "fast"
    });
    
    
    //make links go to particular tabs
    $('.wrap').on("click",".open-tab", function(){
        var tab = $(this).attr('href');
        var index = $(tab).index()-1;        
        $('#tabs').tabs({active: index});
        $('#wp_roster_tab_memory').val(tab);
    });
    
    
    //add link to hidden link setting when a tab is clicked
    $('.wrap').on("click", ".nav-tab", function () {
        var tab = $(this).attr('href');
        $('#wp_roster_tab_memory').val(tab);
    });
    
    
    
    //load previous tab when opening settings page
    if($('#wp_roster_tab_memory').length) {
        if($('#wp_roster_tab_memory').val().length > 1) {

        var tab = $('#wp_roster_tab_memory').val();  

        var index = $(tab).index() - 1;
        $('#tabs').tabs({
            active: index
        });
        }
    }
    
    
    
    

    
    

    //hides and then shows on click help tooltips
    $(".hidden").hide();
    
    
    $('#wp_roster_settings_form').on("click", ".wp_roster_settings_row i", function (event) {
//        console.log('I was clicked');        
        event.preventDefault();
        $(this).next(".hidden").slideToggle();
    });

    //instantiates the Wordpress colour picker
    $('.my-color-field').wpColorPicker();

    
    

    //roster save routine
    function runRosterSaveRoutine(){
        
        //console.log('I was ran');

        var data = '';
        
        //cycle through rosters
        $('#roster-settings li').each(function () {
            
            var id = $(this).attr('data');
            var name = $(this).find('.roster-name').val();
            var logo = $(this).find('.roster-logo').val();
            var home = $(this).find('.roster-home').val();
            var teamName = $(this).find('.roster-team-name').val();
            var notificationGroupName = $(this).find('.roster-notification-group-name').val();
            var color = $(this).find('.roster-color').val();

            var rosterView = $(this).find('.roster-view').val();
            var rosterEdit = $(this).find('.roster-edit').val();
            var dateViewEdit = $(this).find('.date-view-edit').val();
            var teamViewEdit = $(this).find('.team-view-edit').val();
            var historyViewEdit = $(this).find('.history-view-edit').val();
            var unavailableEdit = $(this).find('.unavailable-edit').val();
            var notificationsViewEdit = $(this).find('.notifications-view-edit').val();
            var runSheetViewEdit = $(this).find('.run-sheet-view-edit').val();
            var attendanceViewEdit = $(this).find('.attendance-view-edit').val();
            var unavailableRows = $(this).find('.unavailable-rows').val();

            //if the value is nothing at least make it a space so the separators still work ok
            if(name.length <1){
                name = ' ';
            }
            if(logo.length <1){
                logo = ' ';
            }
            if(home.length <1){
                home = ' ';
            }
            if(teamName.length <1){
                teamName = ' ';
            }
            if(notificationGroupName.length <1){
                notificationGroupName = ' ';
            }
            if(color.length <1){
                color = ' ';
            }
            if(rosterView.length <1){
                rosterView = ' ';
            }
            if(rosterEdit.length <1){
                rosterEdit = ' ';
            }
            if(dateViewEdit.length <1){
                dateViewEdit = ' ';
            }
            if(teamViewEdit.length <1){
                teamViewEdit = ' ';
            }
            if(historyViewEdit.length <1){
                historyViewEdit = ' ';
            }

            //start or pro settings
            if(typeof unavailableEdit == 'undefined' || unavailableEdit.length <1){
                unavailableEdit = ' ';
            }
            if(typeof notificationsViewEdit == 'undefined' || notificationsViewEdit.length <1){
                notificationsViewEdit = ' ';
            }
            if(typeof runSheetViewEdit == 'undefined' || runSheetViewEdit.length <1){
                runSheetViewEdit = ' ';
            }
            if(typeof attendanceViewEdit == 'undefined' || attendanceViewEdit.length <1){
                attendanceViewEdit = ' ';
            }
            if(typeof unavailableRows == 'undefined' || unavailableRows.length <1){
                unavailableRows = ' ';
            }



            
            //lets construct a setting string
            var singleRosterSetting = '||'+id+'|'+name+'|'+logo+'|'+home+'|'+teamName+'|'+color+'|'+rosterView+'|'+rosterEdit+'|'+dateViewEdit+'|'+teamViewEdit+'|'+historyViewEdit+'|'+unavailableEdit+'|'+notificationsViewEdit+'|'+runSheetViewEdit+'|'+notificationGroupName+'|'+attendanceViewEdit+'|'+unavailableRows;

            //add string to initial variable
            data += singleRosterSetting;
            
        });
        
        //lets add the data to the setting
        $('#wp_roster_roster_settings').val(data);  
          
    }
















    //save settings using ajax    
    $('#wp_roster_settings_form').submit(function(event) {
        
        event.preventDefault();
        //we need to check whether the boards tab is active and if it is we are going to do some magic first
        
        var activeTab = $('.ui-tabs-active a').text();
        
        if(activeTab == "Rosters "){
            runRosterSaveRoutine();
        }

        if(activeTab == "WP Roster Custom Fields "){


            //before we allow the save, make sure all fields have unique names
            var customFieldNames = [];
            $('.custom-field-listing li').each(function () {

                //name
                var name = $(this).find('.custom-field-name').val();
                customFieldNames.push(name);

            });    

            function hasDuplicates(array) {
                return (new Set(array)).size !== array.length;
            }

            if(hasDuplicates(customFieldNames)){
                alertify.alert('Please ensure all custom fields have a unique name.');
                return false;
            }

            runCustomFieldSaveRoutine();
        }

        // if(activeTab == "Idea Form "){

        //     //first lets check if all the names are unique before we do anything
        //     //lets store an array which contains all the titles
        //     var allTitles = [];
        //     var duplicateFound = false;

        //     $('#form-settings-container > li').each(function () {
        //         //get title
        //         var title = $(this).find('.form-setting-name').val();
        //         // console.log(title);

        //         if($.inArray(title, allTitles) !== -1 ){
        //             duplicateFound = true; 
        //             return false;  
        //         } else {
        //             allTitles.push(title);
        //         }

        //     }); 
            
        //     if(duplicateFound == true){

        //         //hide existing dialog
        //         $('.ui-dialog').hide();
                        
        //         function myalert(title, text) {
        //         var div = $('<div>').html(text).dialog({
        //             title: title,
        //             closeOnEscape: true,
        //             modal: true,
        //             close: function() {
        //                 $(this).dialog('destroy').remove();
        //             },

        //             buttons: [{
        //                 text: "Close",
        //                 click: function() {
        //                     $(this).dialog('destroy').remove();
        //                 }}   
        //                 ]
        //             })
        //         };

        //         myalert($('#dialog-duplicate-form-setting-found').attr('data'), '');


        //         return false; 
        //     } else {
        //         runFormSaveRoutine();    
        //     }

 
        // }
          
        
        $('<div class="notice notice-warning is-dismissible settings-loading-message"><p><i class="fa fa-spinner" aria-hidden="true"></i> Please wait while we save the settings...</p></div>').insertAfter('.wp-roster-save-all-settings-button');

        //tinyMCE.triggerSave();

        $(this).ajaxSubmit({
            success: function(){

                $('.settings-loading-message').remove();

                $('<div class="notice notice-success is-dismissible settings-saved-message"><p>The settings have been saved.</p></div>').insertAfter('.wp-roster-save-all-settings-button');

                setTimeout(function() {
                    $('.settings-saved-message').slideUp();
                }, 3000);
                
                //if the page is the integrations tab refresh the page so that we can see the connector finalisation button
                // if(activeTab == "Integrations " || activeTab == "Idea Form "){
                //     location.reload();
                // }

                

            }
        });

        return false; 

        $('.settings-loading-message').remove();

    });

    
    

    
    
    
    
    
    
    
    
   
    

    
    
    
    
    
    //clipboard function
//     new ClipboardJS('.copy-board-shortcode');
//     $('.wrap').on("click",".copy-board-shortcode",function(event) {
//         event.preventDefault(); 
        
//         var shortcodeData = $(this).attr('data-clipboard-text');
        
// //        alert("The shortcode has now been copied to your clipboard. Or you can copy the following shortcode: "+shortcodeData+". Now just put this shortcode into any post or page. It is strongly recommended that you put this in a post or page which is full width and doesn't have a sidebar.");
        
        
//         function myalert(title, text) {
//             var div = $('<div>').html(text).dialog({
//                 title: title,
//                 closeOnEscape: true,
//                 modal: true,
//                 close: function() {
//                     $(this).dialog('destroy').remove();
//                 },
//                 buttons: [{
//                     text: "CLOSE",
//                     click: function() {
//                         $(this).dialog("close");
//                     }}]
//                 })
//             };

//         myalert("Shortcode Copied!", 'The shortcode has now been copied to your clipboard. Or you can copy the following shortcode: <code style="font-weight: bold;">"'+shortcodeData+'</code>. Now just put this shortcode onto any post or page (page recommended). It is recommended that you put this onto a page which is full width and doesn\'t have a sidebar.');

//     });

    
    
    



    
    
    
    
    
    
    
    
    
    //adds shortcode button text to tinymce area  
    $('.wp_roster_append_buttons_advanced').click(function () {
        
        var attributeValue = $(this).attr('value');
                
        var id = $(this).attr('data');
        
        var attributeValueWrapped = '<p>'+attributeValue+'</p>';
        
        $('#'+id+'_ifr').contents().find("#tinymce p").html( $('#'+id+'_ifr').contents().find("#tinymce p").html() + attributeValueWrapped);
        
        $('#'+id+'-editor-container').find("textarea").html( $('#'+id+'-editor-container').find("textarea").html() + attributeValueWrapped);
        
 
    });
    
    
    if($('.datepicker').length){    
        $('.datepicker').datepicker({  
        dateFormat:"yy-mm-dd",    
        });   
    }

    
    
    
    
    
    
    
    //permanently hide notice
    $('.wrap').on("click",".wp-roster-welcome .notice-dismiss", function(event){
        
        event.preventDefault();
        
        
        //check the checkbox
        $('#wp_roster_hide_admin_notice').prop('checked',true);
        
        //save the settings
        $('#wp_roster_settings_form').ajaxSubmit({
            success: function(){
                console.log('Settings saved');
            }
        });
         
    });
    
    
    

    
    



    //makes image upload work for roster logo
    $('#wpwrap').on("click",".roster-logo-upload", function(event){
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
            
            

        });
    });


    // make rosters sortable
    $( "#roster-settings" ).sortable();







    //deletes a roster
    $('.wrap').on("click",".delete-roster",function(event) {

        var thisRoster = $(this).parent().parent().parent().parent().parent();
        var rosterID = thisRoster.attr('data');

        event.preventDefault();
        var deleteRosterButton = $(this);
        
        //we are going to prompt the user twice because doing this can have really serious consequences
        alertify.confirm("Are you sure you want to delete this roster?", function () {
            // user clicked "ok"

            alertify.confirm("Are you absolutely sure you want to delete this roster? This action can't be undone and all data associated with the roster will be deleted.", function () {
                

                //remove the roster from the ui
                thisRoster.remove();

                //remove the data in the backend
                
                var data = {
                    'action': 'delete_roster',
                    'rosterID': rosterID,
                };
        
                jQuery.post(ajaxurl, data, function (response) {
                    console.log('I was deleted');
                });    

                //run the save routine
                runRosterSaveRoutine();
                //save the settings
                $('#wp_roster_settings_form').ajaxSubmit({
                    success: function(){
                        console.log('Settings saved');
                    }
                });






    
            }, function() {
                // user clicked "cancel"
            });

        }, function() {
            // user clicked "cancel"
        });
        

        
    });





    //clipboard function
    new ClipboardJS('.copy-roster-shortcode');

    $('.wrap').on("click",".copy-roster-shortcode",function(event) {

        event.preventDefault(); 
        
        var shortcodeData = $(this).attr('data-clipboard-text');
        
        alertify.alert('The shortcode has now been copied to your clipboard. Or you can copy the following shortcode: <code>'+shortcodeData+'</code>. Now just put this shortcode onto any page on your website. It is strongly recommended that you select the page template "WP Roster" for the page you add the shortcode onto as the plugin has been designed to use the full window of the browser.');
        

    });


    //add new roster
    $('.wrap').on("click","#wp_roster_create_roster_button",function(event) {

        event.preventDefault(); 

        var rosterName = $('#wp_roster_create_roster').val();

        //lets first check that the roster has a name if not show an error
        if(rosterName.length<1){
            alertify.alert('Please enter a value.');
            return;
        }

        //lets also check to see if the name is unique
        //lets create a holding array
        var existingRosterNames = [];

        //lets cycle through the existing names
        //cycle through rosters
        $('#roster-settings li').each(function () {   
            var name = $(this).find('.roster-name').val();
            //add name to array
            existingRosterNames.push(name);
        });    

        if(existingRosterNames.indexOf(rosterName) > -1){
            alertify.alert('Please enter a unique value.');
            return;
        }

        //ok lets proceed
        var data = {
            'action': 'add_roster',
            'rosterName': rosterName,
            'rosterCount': existingRosterNames.length,
        };

        jQuery.post(ajaxurl, data, function (response) {
            
            if(response == 'NOT PRO'){
                alertify.alert('Please upgrade to <a href="https://northernbeacheswebsites.com.au/wp-roster-pro/">Pro</a> to enjoy unlimited rosters!');
                return;
            }

            if(response == 'PRO ISSUE'){
                alertify.alert('Please ensure your licence information is added to the <strong>WP Roster Pro</strong> tab.');
                return;
            }


            $('#roster-settings').append(response);
            $('.my-color-field').wpColorPicker();

            //run the save routine
            runRosterSaveRoutine();
            //save the settings
            $('#wp_roster_settings_form').ajaxSubmit({
                success: function(){
                    console.log('Settings saved');
                }
            });

            alertify.alert('The roster has now been added, please feel free to change the settings.');


        });    


    });    





    //add new roster
    $('.wrap').on("click",".duplicate-roster",function(event) {

        event.preventDefault(); 

        var thisRoster = $(this).parent().parent().parent().parent().parent();

        

        //get inputs of roster
        var rosterId = thisRoster.attr('data');
        var rosterName = thisRoster.find('.roster-name').val();
        var rosterLogo = thisRoster.find('.roster-logo').val();
        var homeUrl = thisRoster.find('.roster-home').val();
        var teamName = thisRoster.find('.roster-team-name').val();
        var notificationGroupName = thisRoster.find('.roster-notification-group-name').val();
        var themeColor = thisRoster.find('.roster-color').val();

        var rosterView = thisRoster.find('.roster-view').val();
        var rosterEdit = thisRoster.find('.roster-edit').val();
        var dateViewEdit = thisRoster.find('.date-view-edit').val();
        var teamViewEdit = thisRoster.find('.team-view-edit').val();
        var historyViewEdit = thisRoster.find('.history-view-edit').val();
        var unavailableEdit = thisRoster.find('.unavailable-edit').val();
        var notificationsViewEdit = thisRoster.find('.notifications-view-edit').val();
        var runSheetViewEdit = thisRoster.find('.run-sheet-view-edit').val();
        var attendanceViewEdit = thisRoster.find('.attendance-view-edit').val();
        var unavailableRows = thisRoster.find('.unavailable-rows').val();

        if(unavailableEdit.length < 1){
            unavailableEdit = ' ';
        }

        if(notificationsViewEdit.length < 1){
            notificationsViewEdit = ' ';
        }

        if(runSheetViewEdit.length < 1){
            runSheetViewEdit = ' ';
        }

        if(attendanceViewEdit.length < 1){
            attendanceViewEdit = ' ';
        }



        //lets also check to see if the name is unique
        //lets create a holding array
        var existingRosterNames = [];

        //lets cycle through the existing names
        //cycle through rosters
        $('#roster-settings li').each(function () {   
            var name = $(this).find('.roster-name').val();
            //add name to array
            existingRosterNames.push(name);
        });  

        //ok lets proceed
        var data = {
            'action': 'duplicate_roster',
            'rosterId': rosterId,
            'rosterCount': existingRosterNames.length,
            'rosterName': rosterName,
            'rosterLogo': rosterLogo,
            'homeUrl': homeUrl,
            'teamName': teamName,
            'themeColor': themeColor,
            'rosterView': rosterView,
            'rosterEdit': rosterEdit,
            'dateViewEdit': dateViewEdit,
            'teamViewEdit': teamViewEdit,
            'historyViewEdit': historyViewEdit,
            'unavailableEdit': unavailableEdit,
            'notificationsViewEdit': notificationsViewEdit,
            'runSheetViewEdit': runSheetViewEdit,
            'notificationGroupName': notificationGroupName,
            'attendanceViewEdit': attendanceViewEdit,
            'unavailableRows': unavailableRows,

        };

        jQuery.post(ajaxurl, data, function (response) {
            
            if(response == 'NOT PRO'){
                alertify.alert('Please upgrade to <a href="https://northernbeacheswebsites.com.au/wp-roster-pro/">Pro</a> to enjoy unlimited rosters!');
                return;
            }

            if(response == 'PRO ISSUE'){
                alertify.alert('Please ensure your licence information is added to the <strong>WP Roster Pro</strong> tab.');
                return;
            }

            // console.log(response);

            $('#roster-settings').append(response);
            $('.my-color-field').wpColorPicker();

            //run the save routine
            runRosterSaveRoutine();
            //save the settings
            $('#wp_roster_settings_form').ajaxSubmit({
                success: function(){
                    // console.log('Settings saved');
                }
            });

            alertify.alert('The roster has now been duplicated, please feel free to change the settings.');

        });    


    });    





    //makes image upload field 
   $('#wpwrap').on("click","#wp_roster_upload_users_button", function(event){
        event.preventDefault();
    
        
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

        });
    });

    //send url to php
   $('#wpwrap').on("click","#wp-roster-send-csv-file", function(event){

        event.preventDefault();

        var url = $('#upload_user_data').val();
        var rosterId = $('.roster-selection').val();


        if(url.length < 1){

            alertify.alert('Please upload a CSV file first.');

        } else {


            Papa.parse(url, {
                download: true,
                complete: function(results) {

                    // console.log(results);

                    var data = JSON.stringify(results.data);

                    //ok lets proceed
                    var data = {
                        'action': 'add_users_from_csv',
                        'rosterId': rosterId,
                        'data': data,
                    };

                    jQuery.post(ajaxurl, data, function (response) {

                        // console.log(response);

                        var dataSplit = response.split('|||');

                        alertify.alert('The member update routine has been completed. There were '+dataSplit[0]+' errors. '+dataSplit[1]+' new members were added and '+dataSplit[2]+' members were updated.');

                        //clear out url field
                        $('#upload_user_data').val('');

                    });


                }
            });

    
        }




    });


    //close custom field builder item
    $('#wpwrap').on("click",".builder-icons .icon-plus", function(event){

        //getthe line item
        var thisLineItem = $(this).parent().parent().parent();

        //duplicate line item
        thisLineItem.clone().insertAfter(thisLineItem);

        //lets set the data attribute to nothing and also add copy to the field as we can't have duplicate field names
        var newFieldName = thisLineItem.next().find('.custom-field-name').val();

        thisLineItem.next().find('.custom-field-name').val(newFieldName+' (Copy)');
        thisLineItem.next().attr('data','');


        //make list sortable again
        $( ".custom-field-listing" ).sortable({
            axis: "y"
        });

    }); 





    

    //remove line item
    $('#wpwrap').on("click",".builder-icons .icon-minus", function(event){

        //getthe line item
        var thisLineItem = $(this).parent().parent().parent();

        //prompt before removing
        alertify.confirm("Are you absolutely sure you want to delete this custom field? By deleting the custom field all data associated with the field will be lost.", function () {
            thisLineItem.remove();        
        }, function() {
            // user clicked "cancel"
        });


        //make list sortable again
        $( ".custom-field-listing" ).sortable({
            axis: "y"
        });

    }); 
    
    //make list sortable by default
    if($('.custom-field-listing').length){
        $( ".custom-field-listing" ).sortable({
            axis: "y"
        });

        //lets also selectively hide and show the options fields
        hideAndShowOptionsField();
    }

    //run on change as well
    $('#wpwrap').on("change",".custom-field-type", function(event){
        hideAndShowOptionsField();    
    });


    function hideAndShowOptionsField(){

        //cycle through rosters
        $('.custom-field-listing li').each(function () {
           
            //type
            var type = $(this).find('.custom-field-type').val();

            if(type == 'select'){
                $(this).find('.custom-field-options-span').show();
                $(this).find('.custom-field-segmentation-span').show();
            } else {
                $(this).find('.custom-field-options-span').hide(); 
                $(this).find('.custom-field-segmentation-span').hide();   
            }


        });
    }
    





    //run custom field save routine
    //roster save routine
    function runCustomFieldSaveRoutine(){
        
        // console.log('I was ran');


        var maxId = 0;
        //we need to do a preroutine which finds out the next id
        $('.custom-field-listing li').each(function () {

            var thisId = $(this).attr('data');

            if (typeof thisId !== typeof undefined && thisId !== false) {
                if(parseInt(thisId)>maxId){
                    maxId = parseInt(thisId);
                }
            }
        });    







        var data = '';
        
        //cycle through rosters
        $('.custom-field-listing li').each(function () {

            //id
            var id = $(this).attr('data');


            if(id == ''){
                id = maxId+1;
                maxId++;
            }


            //name
            var name = $(this).find('.custom-field-name').val();

            //type
            var type = $(this).find('.custom-field-type').val();

            //options
            var options = $(this).find('.custom-field-options').val();

            //report segmentation
            if( $(this).find('.custom-field-reporting').is(":checked") ){
                var segmentation = true;
            } else {
                var segmentation = false;
            }

            //report segmentation
            if( $(this).find('.custom-field-frontend-display').is(":checked") ){
                var frontendDisplay = true;
            } else {
                var frontendDisplay = false;
            }

            data += '|||'+name+'^^'+type+'^^'+options+'^^'+segmentation+'^^'+frontendDisplay+'^^'+id;

            console.log(data);

        });


        //add data to the input
        $('#wp_roster_custom_fields_data').val(data);

    }




  
    
});