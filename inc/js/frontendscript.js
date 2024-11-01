jQuery(document).ready(function ($) {


    //make clone remember select values
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

    
    //if no access show alert and redirect user to login
    if($('#no-roster-access').length){
        
        var loginLink = $('#no-roster-access').attr('data');
        var currentPage = window.location.href;

        alertify
        .okBtn("Login")
        .confirm("You don't have permission to view this page. Please login to view this page.", function (ev) {

            ev.preventDefault();
            window.location.href = loginLink+currentPage;

        });


    }


    //save the settings
    $('body').on("click",".save-settings",function(event) {

        event.preventDefault(); 
        var allClearOfErrors = true;

        //change the class to load
        $(this).find('i').removeClass('icon-check').addClass('icon-refresh');

        //get variables used for logging
        var rosterId = $('.roster-header').attr('data');
        // var userId = $('.user-profile-image').attr('data');
        var module = $('.roster-main-menu .active').attr('data');

        if(module == 'run-sheet'){

            var editor = new Quill('#wp-roster-editor', {
                modules: { toolbar: '#wp-roster-toolbar' },
                theme: 'snow'
            });

            var data = editor.root.innerHTML;

            console.log(data);
        }

        //lets get the applicable data based on the module
        if(module == 'dates'){


            var data = '';

            var duplicateCheckArray = [];

            //lets loop through each list item and get the data
            $( ".dates-listing li" ).each(function( index ) {

                var dateTime = $(this).find('.date-time-input').val();

                //check if item is in array
                if($.inArray(dateTime, duplicateCheckArray) == -1){
                    duplicateCheckArray.push(dateTime);        
                } else {
                    $('.save-settings').find('i').removeClass('icon-refresh').addClass('icon-check');
                    alertify.alert("You have a date and time that is identical: <strong>"+dateTime+"</strong> so we could not save the settings.");
                    allClearOfErrors = false;
                    return false;
                }


                var dateId = $(this).attr('data');
                var description = $(this).find('.description-input').val();

                //lets construct a string
                var lineItem = '||'+dateId+'^^'+dateTime+'^^'+description;

                data += lineItem;

            });

        } 


        if(module == 'teams'){

            var data = '';

            var duplicateCheckArray = [];

            $( ".team-listing > li" ).each(function() {

                var teamId = $(this).attr('data');
                var teamName = $(this).find('.team-name').text();

                // console.log(teamName);
                // console.log(duplicateCheckArray);

                //check if item is in array
                if($.inArray(teamName, duplicateCheckArray) == -1){
                    duplicateCheckArray.push(teamName);        
                } else {

                    $('.save-settings').find('i').removeClass('icon-refresh').addClass('icon-check');

                    alertify.alert("You have team names that are identical: <strong>"+teamName+"</strong> so we could not save the settings.");

                    allClearOfErrors = false;
                    return false;
                }


                //check that team has a name
                if(teamName.length < 1){

                    $('.save-settings').find('i').removeClass('icon-refresh').addClass('icon-check');

                    alertify.alert("Make sure that sure that all your teams have a name.");

                    allClearOfErrors = false;
                    return false;

                }


                //get variables
                var allocations = $(this).find('.allocation-input').val();
                var type = $(this).find('.type-select').val();

                // console.log(type);
                
                //now get each item in the list
                var builderItems = '';

                if(type == 'members'){
                    
                    $(this).find('.member-section li').each(function( index ) {
                        var memberId = $(this).find('.member-field').val();
                        //add value to holding item
                        builderItems += memberId+'|||';
                    });

                    //remove last 3 characters from string
                    builderItems = builderItems.slice(0,-3);

                } else if (type == 'list'){

                    $(this).find('.list-section li').each(function( index ) {
                        var listItem = $(this).find('.list-field').val();
                        var listItemToolTip = $(this).find('.list-field-tooltip').val();

                        //lets replace double quotes with single ones...
                        // listItemToolTip.replace(/"/g, "'");

                        //add value to holding item
                        builderItems += listItem+'^^'+listItemToolTip+'|||';

                        // console.log(listItemToolTip);

                    });

                    //remove last 3 characters from string
                    builderItems = builderItems.slice(0,-3);

                } else {
                    builderItems += '^^';    
                }

                // 99||||Team Awesome||||1||||list||||Item 1||tooltip|||Item 2||tooltip|||item 3||tooltip
                // 128||||Team Hot||||1||||members||||19|||21|||18
                // 77||||Team Super||||1||||text||||

                //lets construct a string
                var lineItem = '|||||'+teamId+'||||'+teamName+'||||'+allocations+'||||'+type+'||||'+builderItems;

                data += lineItem;

            });   
            
            
            data += '||||||';

            var duplicateNotificationGroupCheckArray = [];

            $( ".notification-group-listing > li" ).each(function() {

                var teamId = $(this).attr('data');
                var teamName = $(this).find('.team-name').text();

                // console.log(teamName);
                // console.log(duplicateCheckArray);

                //check if item is in array
                if($.inArray(teamName, duplicateNotificationGroupCheckArray) == -1){
                    duplicateNotificationGroupCheckArray.push(teamName);        
                } else {

                    $('.save-settings').find('i').removeClass('icon-refresh').addClass('icon-check');

                    alertify.alert("You have notification group names that are identical: <strong>"+teamName+"</strong> so we could not save the settings.");

                    allClearOfErrors = false;
                    return false;
                }


                //check that team has a name
                if(teamName.length < 1){

                    $('.save-settings').find('i').removeClass('icon-refresh').addClass('icon-check');

                    alertify.alert("Make sure that sure that all your notification groups have a name.");

                    allClearOfErrors = false;
                    return false;

                }


        

                // console.log(type);
                
                //now get each item in the list
                var builderItems = '';
                    
                $(this).find('.member-section .member-section li').each(function( index ) {
                    var memberId = $(this).find('.member-field').val();
                    //add value to holding item
                    builderItems += memberId+'|||';
                });

                //remove last 3 characters from string
                builderItems = builderItems.slice(0,-3);

                // console.log(builderItems);





                //now get each item in the list
                var builderItemsLeader = '';

                $(this).find('.member-section-leader .member-section li').each(function( index ) {
                    var memberId = $(this).find('.member-field').val();
                    //add value to holding item
                    builderItemsLeader += memberId+'|||';
                });

                //remove last 3 characters from string
                builderItemsLeader = builderItemsLeader.slice(0,-3);

                // console.log(builderItemsLeader);
            

                //lets construct a string
                var lineItem = '|||||'+teamId+'||||'+teamName+'||||'+builderItems+'||||'+builderItemsLeader;

                data += lineItem;

            });




        }






        //if module is roster
        if(module == 'roster'){

            var data = '';

            //now lets simply loop through all editable elements
            $( ".roster-data-input" ).each(function() {

                var thisAllocation = $(this).attr('data-allocation');
                var thisTeam = $(this).attr('data-team');
                var thisDate = $(this).attr('data-date');
                var thisValue = $(this).val();

                var lineItem = '|||||'+thisAllocation+'^^'+thisTeam+'^^'+thisDate+'^^'+thisValue;

                // console.log(lineItem);

                data += lineItem;
            });    

        }    



        //if module is notifications
        if(module == 'notifications'){

            var data = '';

            //loop through each notification and check if any fields are missing
            $( ".notification-listing > li" ).each(function() {

                //get variables
                var id = $(this).attr('data');
                var name = $(this).find('.automated-name-input-edit').val();
                var days = $(this).find('.automated-days-before-input-edit').val();
                var time = $(this).find('.automated-time-edit-select').val();
                var subject = $(this).find('.automated-subject-edit-input').val();
                var message = $(this).find('.automated-message-edit-input').val();

                //do error check here
                if( name.length < 1 || days < 0 || subject.length < 1 || message.length < 1 ){
                    allClearOfErrors = false;
                }

                //start creating output
                var lineItem = '||||||'+id+'||||'+name+'||||'+days+'||||'+time+'||||'+subject+'||||'+message+'||||';

                //now lets add filters


                if(  $(this).find('.automated-notification-filters-list-edit').css('display').toLowerCase() == 'none'  ){
                    lineItem += 'NOFILTER';
                } else {

                    $(this).find('.automated-notification-filters-list-edit li').each(function() {
    
                        var isIsNot = $(this).find('.isIsNot').val();
                        // var teamMember = $(this).find('.teamMember').val();
                        var team = $(this).find('.team').val();
                        // var member = $(this).find('.member').val();
                        // var andOr = $(this).find('.andOr').val();
    
                        // lineItem += isIsNot+'||'+teamMember+'||'+team+'||'+member+'^^';   
                        // lineItem += isIsNot+'||'+team+'||'+andOr+'^^';    
                        lineItem += isIsNot+'||'+team+'^^';    
    
                    }); 
                }

                data += lineItem;

            });   
            

            if(allClearOfErrors == false){
                alertify.alert("Make sure that sure that you have entered data into all fields.");
            }


        }    




        //if the module is attendance we need to do something unique which is savr the data to a unique setting so it will have its own ajax
        if(module == 'attendance'){

            //get variables
            //key identifiers
            var groupId = $('.attendance-header').attr('data-group');
            var dateId = $('.attendance-header').attr('data-date');
            var date = $('.date-time-input-attendance').val();
            //statistics
            var attended = $('.attended-members').val();
            var didNotAttend = $('.did-not-attend-members').val();
            var notSure = $('.not-sure-members').val();
            var otherAttended = $('.other').val();
            var totalAttended = $('.total-attendees').val();
            


            var data = groupId+'-'+dateId+'|||'+groupId+'|||'+dateId+'|||'+date+'|||'+attended+'|||'+didNotAttend+'|||'+notSure+'|||'+otherAttended+'|||'+totalAttended+'|||';


            //add individuals
            $( ".user-attendance-edit > li" ).each(function() {

                var userId = $(this).attr('data');
                var attendanceStatus = $(this).find('.active').attr('data');

                if(attendanceStatus == null){
                    attendanceStatus = 'not-defined';
                }
                var lineItem = userId+'|'+attendanceStatus+'||';

                //lets add this data to our main data
                data += lineItem;

            });    

            var data = {
                'action': 'save_settings_attendance',
                'rosterId': rosterId,
                'newData': data,
            }; 
    
            jQuery.ajax({
            url: save_settings.ajaxurl,
            type: "POST",
            data: data,
            context: this,    
            })
            .done(function(data, textStatus, jqXHR) {
                console.log(data); 
                alertify.success("Data saved!");
                
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            })
            .always(function() {
                $('.save-settings').find('i').removeClass('icon-refresh').addClass('icon-check');
            });



        }    








        //console.log(data);
        // console.log(module);

        if(module != 'attendance'){
            if(allClearOfErrors == false){
                $('.save-settings').find('i').removeClass('icon-refresh').addClass('icon-check');
                return false;
            }

            var data = {
                'action': 'save_settings',
                'rosterId': rosterId,
                // 'userId': userId,
                'module': module,
                'newData': data,
            }; 

            jQuery.ajax({
            url: save_settings.ajaxurl,
            type: "POST",
            data: data,
            context: this,    
            })
            .done(function(data, textStatus, jqXHR) {
                // console.log(data); 
                
                
                alertify.success("Settings saved!");
                
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            })
            .always(function() {
                $('.save-settings').find('i').removeClass('icon-refresh').addClass('icon-check');
            });

        }
      
            
        

    });








    //restore settings
    $('body').on("click",".restore-settings",function(event) {

        event.preventDefault(); 

        //get timestamp
        var dataId = $(this).attr('data');
        var rosterId = $('.roster-header').attr('data');
        // var userId = $('.user-profile-image').attr('data');
        var module = $('.roster-main-menu .active').attr('data');
        

        alertify.confirm("Are you sure you want to restore this data?", function () {
            
            var data = {
                'action': 'restore_settings',
                'rosterId': rosterId,
                'dataId': dataId,
                // 'userId': userId,
                'module': module,
            }; 
    
            jQuery.ajax({
            url: restore_settings.ajaxurl,
            type: "POST",
            data: data,
            context: this,    
            })
            .done(function(data, textStatus, jqXHR) {

                console.log(data); 
                
                //now lets prepend the data
                $('.list-header').after(data);

                //let remove the last item
                if($('.save-history li').length >20){
                    $('.save-history li:last-child').remove();    
                }
                
                alertify.success("Settings restored!");
                
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            })
            .always(function() {
 
            });


        }, function() {
            // user clicked "cancel"
        });
        


    });    




    //remove list item
    $('body').on("click",".delete-date",function(event) {

        event.preventDefault(); 

        var thisLineItem = $(this).parent().parent();

        alertify.confirm("Are you sure you want to delete this date?", function () {
            
            thisLineItem.slideUp("fast", function() { $(this).remove(); } );

        }, function() {
            // user clicked "cancel"
        });

    });    



    //add a date
    $('body').on("click",".add-a-date-button",function(event) {

        event.preventDefault(); 

        //lets check if there's a date and time before doing anything
        var dateTimeInput = $('.date-time-input').val();

        //get count of items
        var countOfDates = $('.dates-listing li').length;

        if(dateTimeInput.length < 1){

            //show popup
            alertify.alert("Please enter a date and time.");

        } else if(+countOfDates + 1 > 365){

            alertify.alert("To ensure performance we currently cap the maximum amount of dates to 365 dates.");
            
        } else {

            //get description input should it exist
            var description = $('.description-input').val();

            //now lets send this data to php to get the html code and append it to the list
            var data = {
                'action': 'add_date',
                'dateTimeInput': dateTimeInput,
                'description': description,
            }; 
    
            jQuery.ajax({
            url: add_date.ajaxurl,
            type: "POST",
            data: data,
            context: this,    
            })
            .done(function(data, textStatus, jqXHR) {

                // console.log(data); 
                //split the data
                var data = data.split('|');

                //now lets prepend the data
                $('.dates-listing').prepend(data[1]);

                alertify.success("Date added!");

                $(".date-time-input-"+data[0]).flatpickr({
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                });
                
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            })
            .always(function() {
 
            });


        }



    });    





    $(".date-time-input:not(.readonly)").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });



    //do scroll reveal

    if($('.roster-header').length){

        window.sr = ScrollReveal(); 

    }

    if($('.save-history').length){
        sr.reveal('.save-history li');
    }

    // if($('.dates-listing').length){
    //     sr.reveal('.dates-listing li');
    // }

    // if($('.user-listing').length){
    //     sr.reveal('.user-listing li');
    // }

    // if($('.notification-log').length){
    //     sr.reveal('.notification-log li');
    // }

    if($('.notification-listing').length){
        sr.reveal('.notification-listing > li');
    }



    //toggle add team/member
    $('body').on("click",".expandable-section-activate",function(event) {

        $(this).next().slideToggle();

        var icon = $(this).find('i');

        if(icon.hasClass('icon-plus')){
            icon.removeClass('icon-plus').addClass('icon-minus');
        } else {
            icon.removeClass('icon-minus').addClass('icon-plus');
        }

    });    










    //add a member
    $('body').on("click",".add-a-member-button",function(event) {

        event.preventDefault(); 

        //get values
        var firstName = $('.first-name-input').val();
        var lastName = $('.last-name-input').val();
    

        //lets do a preliminary check to see if the user first and last already exists and prompt the user if they want to continue
        //create holding array
        var existingUsersInList = [];

        $( ".user-listing li" ).each(function( index ) {
            var usersName = $(this).find('.full-name').text().toLowerCase();
            existingUsersInList.push(usersName);
        });

        var enteredName = firstName+' '+lastName;

        if(jQuery.inArray(enteredName.toLowerCase() , existingUsersInList) != -1) {

            alertify
            .okBtn("Continue")
            .cancelBtn("Cancel")
            .confirm("We found someone on your list already with the same name, are you sure you want to add this member?", function (ev) {
                ev.preventDefault();
                continueToAddUser();  

            }, function(ev) {
                ev.preventDefault();
                return false;

            });

        } else {
            continueToAddUser();   
        }



        function continueToAddUser(){

            //get values
            var firstName = $('.first-name-input').val();
            var lastName = $('.last-name-input').val();
            var email = $('.email-input').val();
            var phone = $('.phone-input').val();
            var preference = $('.preference-select').val();
            var rosterId = $('.roster-header').attr('data');

            if(phone == null){
                phone = '';
                preference = 'none';
            }

            // console.log(phone);

            //lets get custom fields should they be available
            if( $('.custom-field-add').length ){

                var customFields = '';

                //cycle through each field
                $('.custom-field-add').each(function () {
                    
                    var customFieldName = $(this).attr('name');
                    var customFieldValue = $(this).val();

                    customFields += '|||'+customFieldName+'^^'+customFieldValue;

                });    
            } else {
                var customFields = '';
            }

            //lets send the data
            var data = {
                'action': 'add_member',
                'rosterId': rosterId,
                'firstName': firstName,
                'lastName': lastName,
                'email': email,
                'phone': phone,
                'preference': preference,
                'customFields': customFields,
            }; 
    
            // console.log(data);
    
            jQuery.ajax({
            url: add_member.ajaxurl,
            type: "POST",
            data: data,
            context: this,    
            })
            .done(function(data, textStatus, jqXHR) {
                
                console.log(data);

                if(data == 'ERROR'){
                    alertify.alert("Please ensure you enter valid data and complete all necessary fields.");
                } else if(data == 'EXISTING MEMBER'){
                    //lets ask the user if they want to use the existing details
                    //or update details
                    alertify
                        .okBtn("Add existing member")
                        .cancelBtn("Try a different email")
                        .confirm("We found an existing member in the system with the same email. Do you want to try again with a different email or do you want to add this existing member?", function (ev) {
    
                            
                            ev.preventDefault();
                            alertify
                            .okBtn("Use existing details")
                            .cancelBtn("Update details")
                            .confirm("Ok do you want to use the members existing details or do you want to update the member with your recently entered information?", function (ev) {
    
                                ev.preventDefault();
                                //the user has prompted to use the existing details
                                //so we need to send the email and roster id
                                //then we need to get the current user and add the roster id to their custom meta
                                //and then return the list item

                                var data = {
                                    'action': 'use_existing_member',
                                    'rosterId': rosterId,
                                    'email': email,
                                }; 
                        
                                jQuery.ajax({
                                url: use_existing_member.ajaxurl,
                                type: "POST",
                                data: data,
                                context: this,    
                                })
                                .done(function(data, textStatus, jqXHR) {
                    
                                    $('.user-listing').prepend(data);
    
                                    //clear out values
                                    $('.first-name-input').val('');
                                    $('.last-name-input').val('');
                                    $('.email-input').val('');
                                    $('.phone-input').val('');
                                    $('.custom-field-add').val('');
                    
                                    alertify.success("Member added!");  
                                    
                                    //repopulate selects
                                    repopulateMemberSelects();
                                    
                                })
                                .fail(function(jqXHR, textStatus, errorThrown) {
                                })
                                .always(function() {
                                });

                            }, function(ev) {
    
                                ev.preventDefault();
                                //the user has prompted to update the existing details
                                //so we need to send all the data again
                                //then we need to get the current user and update their details and add the roster id to their custom meta
                                //and then return the list item

                                var data = {
                                    'action': 'update_existing_member',
                                    'rosterId': rosterId,
                                    'email': email,
                                    'firstName': firstName,
                                    'lastName': lastName,
                                    'phone': phone,
                                    'preference': preference,
                                    'customFields': customFields,
                                }; 
                        
                                jQuery.ajax({
                                url: update_existing_member.ajaxurl,
                                type: "POST",
                                data: data,
                                context: this,    
                                })
                                .done(function(data, textStatus, jqXHR) {
                    
                                    $('.user-listing').prepend(data);
    
                                    //clear out values
                                    $('.first-name-input').val('');
                                    $('.last-name-input').val('');
                                    $('.email-input').val('');
                                    $('.phone-input').val('');
                                    $('.custom-field-add').val('');
                    
                                    alertify.success("Member added and updated!"); 
                                    
                                    //repopulate selects
                                    repopulateMemberSelects();
                                    
                                })
                                .fail(function(jqXHR, textStatus, errorThrown) {
                                })
                                .always(function() {
                                });


    
                            });
    
                        }, function(ev) {
    
                            ev.preventDefault();
                            //the user opted to try again with new details
                        });
    
    
                } else {
                    //this was a normal successful ad!
                    //console.log(data); 
    
                    $('.user-listing').prepend(data);
    
                    //clear out values
                    $('.first-name-input').val('');
                    $('.last-name-input').val('');
                    $('.email-input').val('');
                    $('.phone-input').val('');
                    $('.custom-field-add').val('');


                    alertify.success("Member added!");

                    //repopulate selects
                    repopulateMemberSelects();
    
                }
                
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            })
            .always(function() {
    
            });

            

        }
    });  
    
    



    //delete/remove a member
    $('body').on("click",".delete-user",function(event) {

        var userId = $(this).attr('data');
        var thisListitem = $(this).parent().parent();

        alertify.confirm("Are you sure you want to delete this user? Note if the user is on another roster the user will not be deleted entirely and instead they will just be deallocated from this roster.", function () {
            // user clicked "ok"

            //get the roster id
            var rosterId = $('.roster-header').attr('data');

            // console.log(userId);
            // console.log(rosterId);
            var data = {
                'action': 'delete_existing_member',
                'rosterId': rosterId,
                'userId': userId,
            }; 
    
            jQuery.ajax({
            url: delete_existing_member.ajaxurl,
            type: "POST",
            data: data,
            context: this,    
            })
            .done(function(data, textStatus, jqXHR) {

                //console.log(data);

                thisListitem.slideUp("fast", function() { $(this).remove(); } );
                alertify.success("Member deleted!");  

                //repopulate selects
                repopulateMemberSelects();  
                
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            })
            .always(function() {
            });

        }, function() {
            // user clicked "cancel"
            //do nothing
        });


    });    



    //edit a member
    $('body').on("click",".edit-user",function(event) {

        // console.log('I was clicked');

        //this list item
        var thisListitem = $(this).parent().parent();

        //if the form already exists hide it
        // if(thisListitem.find('.user-edit-form').length){

            // thisListitem.find('.user-edit-form').slideUp("fast", function() { $(this).remove(); } );
            thisListitem.find('.user-edit-form').slideToggle("fast");
            // return false;

        // }


        // var userId = $(this).attr('data');
        // var thisListitem = $(this).parent().parent();

        // //first we need to get existing data
        // //this includes the first name, last name, email, phone (pro), preference (pro)
        // var data = {
        //     'action': 'update_member_information',
        //     'userId': userId,
        // }; 

        // jQuery.ajax({
        // url: update_member_information.ajaxurl,
        // type: "POST",
        // data: data,
        // context: this,    
        // })
        // .done(function(data, textStatus, jqXHR) {

        //     // console.log(data);

        //     //and then we need to inject that into the list item with a submit and cancel button
        //     thisListitem.append(data);

            
        // })
        // .fail(function(jqXHR, textStatus, errorThrown) {
        // })
        // .always(function() {
        // });


        
        //upon pressing submit the data is sent to php to update the user (this is done a in a separate request)


    });  



    //on cancel edit
    $('body').on("click",".cancel-update-user-information",function(event) {

        $(this).parent().parent().slideUp("fast", function() { $(this).remove(); });

    });    


    //on update
    $('body').on("click",".update-user-information",function(event) {

        var thisListItem = $(this).parent().parent().parent();

        var userId = $(this).attr('data');
        var firstName = thisListItem.find('.user-edit-form-first-name').val();
        var lastName = thisListItem.find('.user-edit-form-last-name').val();
        var email = thisListItem.find('.user-edit-form-email').val();
        var phone = thisListItem.find('.user-edit-form-phone').val();
        var preference = thisListItem.find('.user-edit-form-preference').val();

        if(phone == null){
            phone = '';
            preference = 'none';
        }



        //lets get custom fields should they be available
        if( $('.custom-field-add').length ){

            var customFields = '';

            //cycle through each field

            thisListItem.find('.custom-field-edit').each(function () {
                
                var customFieldName = $(this).attr('name');
                var customFieldValue = $(this).val();

                customFields += '|||'+customFieldName+'^^'+customFieldValue;

            });    
        } else {
            var customFields = '';
        }



        console.log(phone);
        console.log(preference);


        //lets send the data to be updated
        var data = {
            'action': 'update_member_information_update_data',
            'userId': userId,
            'firstName': firstName,
            'lastName': lastName,
            'email': email,
            'phone': phone,
            'preference': preference,
            'customFields': customFields,
        }; 

        jQuery.ajax({
        url: update_member_information_update_data.ajaxurl,
        type: "POST",
        data: data,
        context: this,    
        })
        .done(function(data, textStatus, jqXHR) {

            // console.log(data);


            thisListItem.find('.user-edit-form').slideToggle("fast");

            //lets also update the users name!
            // thisListItem.find('.full-name').text(firstName+' '+lastName);

            alertify.success("Member information updated!"); 

            
            
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
        })
        .always(function() {
        });


        



    });    



    //duplicate builder field items
    $('body').on("click",".list-section .builder-action-buttons .icon-plus",function(event) {

        var lineItem = $(this).parent().parent();
        // var lineHolder = $(this).parent().parent().parent();

        //duplicate line item
        lineItem.clone().insertAfter(lineItem);

        //make list sortable again
        $( "ul.list-section" ).sortable({
            axis: "y"
          });

    }); 

    //remove builder field items
    $('body').on("click",".list-section .builder-action-buttons .icon-minus",function(event) {

        var lineItem = $(this).parent().parent();

        lineItem.slideUp("fast", function() { $(this).remove(); } );
        // var lineHolder = $(this).parent().parent().parent();

    }); 

    //make list items sortable
    if($('.list-section').length){
        $( "ul.list-section" ).sortable({
            axis: "y"
          });
    }




    //duplicate builder field items
    $('body').on("click",".member-section .builder-action-buttons .icon-plus",function(event) {

        var lineItem = $(this).parent().parent();
        // var lineHolder = $(this).parent().parent().parent();

        //duplicate line item
        lineItem.clone().insertAfter(lineItem);

        //make list sortable again
        $( "ul.member-section" ).sortable({
            axis: "y"
        });

    }); 

    //make list items sortable
    if($('.member-section').length){
        $( "ul.member-section" ).sortable({
            axis: "y"
          });
    }

    //remove builder field items
    $('body').on("click",".member-section .builder-action-buttons .icon-minus",function(event) {

        var lineItem = $(this).parent().parent();

        lineItem.slideUp("fast", function() { $(this).remove(); } );
        // var lineHolder = $(this).parent().parent().parent();

    }); 

    




    //lets selectively hide and show the builders depending on the value of the select
    $('body').on('change', '.feature-box .type-select',function(e){

        var thisValue = $(this).val();
        //console.log(thisValue);

        if(thisValue == 'text' || thisValue == 'file'){
            $('.feature-box .list-section').slideUp('fast');   
            $('.feature-box .member-section').slideUp('fast');    
        } else if(thisValue == 'list'){
            $('.feature-box .list-section').slideDown('fast'); 
            $('.feature-box .member-section').slideUp('fast');    
        } else {
            //members section
            $('.feature-box .list-section').slideUp('fast'); 
            $('.feature-box .member-section').slideDown('fast'); 
            repopulateMemberSelects();
        }
    }); 
    
    //lets selectively hide and show the builders depending on the value of the select
    $('body').on('change', '.team-data-edit .type-select',function(e){

        var thisValue = $(this).val();
        var thisDataArea = $(this).parent().parent();

        // console.log(thisValue);

        if(thisValue == 'text' || thisValue == 'file'){
            thisDataArea.find('.list-section').slideUp('fast');   
            thisDataArea.find('.member-section').slideUp('fast');     
        } else if(thisValue == 'list'){

            thisDataArea.find('.list-section').slideDown('fast');   
            thisDataArea.find('.member-section').slideUp('fast'); 

        } else {
            //members section
            thisDataArea.find('.list-section').slideUp('fast');   
            thisDataArea.find('.member-section').slideDown('fast'); 

            repopulateMemberSelects();
        }
    }); 
    
    
    //run initially as well
    //but only for the add team part
    if($('.feature-box .member-section').length){
        $('.feature-box .list-section').slideDown('fast'); 
        $('.teams-section .feature-box .member-section').slideUp('fast');   
    }





    
    //function to repopulate selects
    function repopulateMemberSelects(){
        //lets get all names currently in the list
        var selectOptions = '';
        var selectOptionsWithNotificationGroups = '';

        $(".user-listing li").each(function( index ) {

            var optionValue = '<option value="'+$(this).attr('data')+'">'+$(this).find('.full-name').text()+'</option>'
            selectOptions += optionValue;   
            selectOptionsWithNotificationGroups += optionValue;    
        });    

        $(".notification-group-listing > li").each(function( index ) {
            var optionValue = '<option value="'+$(this).attr('data')+'">'+$(this).find('.team-name').text()+'</option>'
            selectOptionsWithNotificationGroups += optionValue;    
        });    



        //lets populate the selects
        $(".notification-groups-section .member-field").each(function( index ) {
            //get the initial value
            var initialValue = $(this).val();

            $(this).empty();
            $(this).append(selectOptions);
            $(this).val(initialValue);
        });


        $(".teams-section .member-field").each(function( index ) {
            //get the initial value
            var initialValue = $(this).val();

            $(this).empty();
            $(this).append(selectOptionsWithNotificationGroups);
            $(this).val(initialValue);
        });

    }





    //run on load as well
    if($(".member-field").length){
        repopulateMemberSelects();
    }
    




    //toggle the display of the menu
    $('body').on("click",".icon-menu",function(event) {

        console.log('clicked');

        // $('.roster-header-left').slideToggle();
        $('.roster-header-left').show("slide", { direction: "right" }, 10);

    });

    
    //toggle the display of the menu
    $('body').on("click",".mobile-only i",function(event) {

        console.log('clicked');

        // $('.roster-header-left').slideToggle();
        $('.roster-header-left').hide("slide", { direction: "left" }, 10);

    });


    //make team and notification groups listing sortable
    if($( '.team-listing' ).length){
        $( ".team-listing" ).sortable();
    }
    if($( ".notification-group-listing" ).length){
        $( ".notification-group-listing" ).sortable();
    }
    //edit a team
    $('body').on("click",".edit-team",function(event) {

        //this list item
        var thisListitem = $(this).parent().parent();

        thisListitem.find('.team-data-edit').slideToggle("fast"); 

        //if the form already exists delete it
        // if(thisListitem.find('.team-data-edit').css('display') == 'none'){
        //     thisListitem.find('.team-data-edit').slideDown(20);
            
        //     //we also need to hide and show the data where appropriate 
        //     //get select value
            var typeValue = thisListitem.find('.type-select').val();

            if(typeValue == 'text' || typeValue == 'file'){
                thisListitem.find('.list-section').hide();
                thisListitem.find('.member-section').hide();
            } else if (typeValue == 'members'){
                thisListitem.find('.list-section').hide();
            } else {
                thisListitem.find('.member-section').hide();
            }
            


        // } else {
        //     thisListitem.find('.team-data-edit').slideUp("fast"); 
        // }
        

    }); 
    
    

    //edit a team
    $('body').on("click",".edit-notification-group",function(event) {

        //this list item
        var thisListitem = $(this).parent().parent();

        //if the form already exists delete it
        // if(thisListitem.find('.notification-group-data-edit').css('display') == 'none'){
        //     thisListitem.find('.notification-group-data-edit').slideDown(20);
        // } else {
        //     thisListitem.find('.notification-group-data-edit').slideUp("fast"); 
        // }

        thisListitem.find('.notification-group-data-edit').slideToggle("fast"); 



    }); 

    
    //delete a team
    $('body').on("click",".delete-team",function(event) {

        //this list item
        var thisListitem = $(this).parent().parent();

        alertify.confirm("Are you sure you want to delete this team?", function () {
            
            thisListitem.slideUp("fast", function() { $(this).remove(); } );

        }, function() {
            // user clicked "cancel"
        });

    });
    
    
    //delete notification group
    $('body').on("click",".delete-notification-group",function(event) {

        //this list item
        var thisListitem = $(this).parent().parent();

        alertify.confirm("Are you sure you want to delete this notification group?", function () {
            
            thisListitem.slideUp("fast", function() { $(this).remove(); } );

        }, function() {
            // user clicked "cancel"
        });

    });

    //hide team data section initially because some reason if trying through css it is causing bugs
    // $('.team-data-edit').hide();

    $(".team-name-input, .notification-group-name-input").on("change paste keyup", function() {

        var thisValue = $(this).val();

        $(this).parent().parent().prev().prev().text(thisValue);

     });






     //add team item
     $('body').on("click",".add-a-team-button",function(event) {

        event.preventDefault();

        var errors = 0;


        //get variables
        var teamName = $('.feature-box .team-name-input').val();
        var allocations = $('.feature-box .allocation-input').val();
        var type = $('.feature-box .type-select').val();
        var rosterId = $('.roster-header').attr('data');


        //first that the team has a name
        if(teamName.length < 1){
            errors++;
        }



        //now get each item in the list
        var builderItems = '';

        if(type == 'members'){

            $( ".teams-section .feature-box .member-section li" ).each(function( index ) {
                var memberId = $(this).find('.member-field').val();
                //add value to holding item
                builderItems += memberId+'|||';

                if(memberId.length < 1){
                    errors++;
                }

            });

            //remove last 3 characters from string
            builderItems = builderItems.slice(0,-3);

        } else if (type == 'list'){

            $( ".feature-box .list-section li" ).each(function( index ) {
                var listItem = $(this).find('.list-field').val();
                var listItemToolTip = $(this).find('.list-field-tooltip').val();

                // console.log(listItemToolTip);

                if(listItem.length < 1){
                    errors++;
                }

                //add value to holding item
                builderItems += listItem+'^^'+listItemToolTip+'|||';
            });

            //remove last 3 characters from string
            builderItems = builderItems.slice(0,-3);

        } else {
            builderItems += ' ';    
        }

        if(errors >0){


            alertify.alert("There was an issue with the data you have entered. Please ensure your team has a name and there are no blank fields.");


        } else {
            //send the data to create list item
            //lets send the data to be updated
            var data = {
                'action': 'add_team',
                'teamName': teamName,
                'allocations': allocations,
                'type': type,
                'builderItems': builderItems,
                'rosterId': rosterId,
            }; 

            jQuery.ajax({
            url: add_team.ajaxurl,
            type: "POST",
            data: data,
            context: this,    
            })
            .done(function(data, textStatus, jqXHR) {

                // console.log(data);

                //add the data to the list
                $('.team-listing').prepend(data);

                $( "ul.member-section" ).sortable({
                    axis: "y"
                });

                $( "ul.list-section" ).sortable({
                    axis: "y"
                });

                $(".team-name-input").on("change paste keyup", function() {

                    var thisValue = $(this).val();
            
                    $(this).parent().parent().prev().prev().text(thisValue);
            
                });

                repopulateMemberSelects(); 
    

                alertify.success("Team added!"); 

                
                
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            })
            .always(function() {
            });

        }
            


        // 99||||Team Awesome||||1||||list||||Item 1||tooltip|||Item 2||tooltip|||item 3||tooltip
        // 128||||Team Hot||||1||||members||||19|||21|||18
        // 77||||Team Super||||1||||text|||| 


        

     });  
     
     

     //set the height of the roster 
     if($('#roster-container').length){
        var windowHeight = window.innerHeight - 80;

        // console.log(windowHeight);

        $('#roster-container').css("max-height",windowHeight+'px');
        $('#roster-container').css("min-height",windowHeight+'px');

     }

     //also do this on window resize
     window.addEventListener('resize', function(event){

        var windowHeight = window.innerHeight - 80;

        // console.log(windowHeight);

        $('#roster-container').css("max-height",windowHeight+'px');
        $('#roster-container').css("min-height",windowHeight+'px');
    
    });






     //scroll to now on click of now icon

    

     $('body').on("click",".now-icon",function(event) {

        $('#roster-container').scrollTo('.now',750,{
            offset: {left: -195,top: -9999}
        });

     });   

     //scroll to now date initially
     if($('.icon-exclamation').length ){

        $('#roster-container').scrollTo('.now',0,{
            offset: -195,
        });
     }

   

     




      


    
     
    //add tooltips to dates
    tippy('.date-label-tooltip', {
        placement: 'top',
        delay: 100,
        arrow: true,
        // arrowType: 'default',
        animation: 'perspective',
        allowTitleHTML: true,
    });

    //add tooltips to items in top right menu
    tippy('.roster-right-menu i, .roster-right-menu img', {
        placement: 'top',
        delay: 100,
        arrow: true,
        // arrowType: 'default',
        animation: 'perspective',
        allowTitleHTML: true,
    });

    //add tooltips for list select items
    //this did not work out unfortunately
    tippy('.list-item-tooltip', {
        placement: 'top',
        delay: 100,
        arrow: true,
        dynamicTitle: true,
        animation: 'perspective',
        allowTitleHTML: true,
        interactive: true,
        multiple: false,
    });

    tippy('.now-icon, .zoom-to-now', {
        placement: 'top',
        delay: 100,
        arrow: true,
        // arrowType: 'default',
        animation: 'perspective',
        allowTitleHTML: true,
    });

    //use event delegation
    
    
    tippy('.notification-log li', {
        placement: 'top',
        delay: 100,
        arrow: true,
        // arrowType: 'default',
        animation: 'perspective',
        allowTitleHTML: true,
        target: '.log-message'
    });

    tippy('.field-explainer', {
        placement: 'top',
        delay: 100,
        arrow: true,
        // arrowType: 'default',
        animation: 'perspective',
        allowTitleHTML: true,
        interactive: true,
    });

    tippy('.feature-box .shortcode', {
        placement: 'top',
        delay: 100,
        arrow: true,
        // arrowType: 'default',
        animation: 'perspective',
        allowTitleHTML: true,
    });

    tippy('.notification-listing li', {
        placement: 'top',
        delay: 100,
        arrow: true,
        // arrowType: 'default',
        animation: 'perspective',
        allowTitleHTML: true,
        target: '.shortcode'
    });


    tippy('.teams-menu-navigation li i', {
        placement: 'top',
        delay: 100,
        arrow: true,
        // arrowType: 'default',
        animation: 'perspective',
        allowTitleHTML: true,
    });

    










    //check for duplicates on change
    //we also need to figure out how to unremove duplicates
    $('body').on('change', '.roster-data-input.members, .roster-data-input.unavailable',function(e){

        // console.log('hey something happened');

        //get current team and date of changed item
        // var changedItemTeam = $(this).attr('data-team');
        var changedItemDate = $(this).attr('data-date');

        //holding arrays
        var currentDateItems = []; 
        var duplicateItems = [];
        var clashItems = [];




        //first we will check for duplicates
        //we will cycle through all select member and unavailable rows (if they should exist)

        $(".roster-data-input.members" ).each(function() {

            var memberId = $(this).val();
            var selectItemDate = $(this).attr('data-date');


            if(changedItemDate == selectItemDate){

                //check whether the item is in the array or not
                //if it is not add it
                if($.inArray(memberId, currentDateItems) == -1){
                    currentDateItems.push(memberId);
                } else {
                    //otherwise add it to a duplicate item
                    //but only if unique
                    if($.inArray(memberId, duplicateItems) == -1){
                        duplicateItems.push(memberId);
                    }

                }

            }
        }); //end duplicate check


        $(".roster-data-input.unavailable" ).each(function() {

            var memberId = $(this).val();
            var selectItemDate = $(this).attr('data-date');

            if(changedItemDate == selectItemDate){

                //check whether the item is in the array or not
                //if it is not add it
                if($.inArray(memberId, currentDateItems) == -1){
                    
                } else {
                    clashItems.push(memberId);
                }
            }
        });    


        //now lets loop through all the items again
        $(".roster-data-input.members, .roster-data-input.unavailable" ).each(function() {

            var memberId = $(this).val();
            var selectItemDate = $(this).attr('data-date');

            if(changedItemDate == selectItemDate){

                //lets remove any current duplicate class
                $(this).removeClass('duplicate-item');
                $(this).removeClass('clash-item');

                //if the item is in the duplicate list add class
                if($.inArray(memberId, duplicateItems) != -1 && memberId != ''){
                    $(this).addClass('duplicate-item');       
                } 
                if($.inArray(memberId, clashItems) != -1 && memberId != ''){
                    $(this).addClass('clash-item');   
                } 
            }    

        });


        //if there is a clash show a log message
        //lets implode the array into a string and then check the length of the string
        var implodedClashItems = clashItems.join('');

        // console.log(implodedClashItems.length);



        if( implodedClashItems.length > 0 ){
            alertify.error("There is a clash - someone is both unavailable and assigned to a team.");
        }

    });   
    
    








    //we want to run the duplicte check procedure initially
    if($('#roster-container').length){
        $(".date" ).not('.past-date').each(function() {

            var changedItemDate = $(this).attr('data');
            var currentDateItems = []; 
            var duplicateItems = [];  
            var clashItems = [];
            
            
            $(".roster-data-input.members" ).each(function() {

                var memberId = $(this).val();
                var selectItemDate = $(this).attr('data-date');
    
                if(changedItemDate == selectItemDate){
    
                    //check whether the item is in the array or not
                    //if it is not add it
                    if($.inArray(memberId, currentDateItems) == -1){
                        currentDateItems.push(memberId);
                    } else {
                        //otherwise add it to a duplicate item
                        //but only if unique
                        if($.inArray(memberId, duplicateItems) == -1){
                            duplicateItems.push(memberId);
                        }
    
                    }
    
                }
            }); //end duplicate check


            $(".roster-data-input.unavailable" ).each(function() {

                var memberId = $(this).val();
                var selectItemDate = $(this).attr('data-date');
    
                if(changedItemDate == selectItemDate){
    
                    //check whether the item is in the array or not
                    //if it is not add it
                    if($.inArray(memberId, currentDateItems) == -1){
                        
                    } else {
                        clashItems.push(memberId);
                    }
                }
            });  








            //now lets loop through all the items again
            $(".roster-data-input.members, .roster-data-input.unavailable" ).each(function() {

                var memberId = $(this).val();
                var selectItemDate = $(this).attr('data-date');

                if(changedItemDate == selectItemDate){

                    //lets remove any current duplicate class
                    $(this).removeClass('duplicate-item');
                    $(this).removeClass('clash-item');

                    //if the item is in the duplicate list add class
                    if($.inArray(memberId, duplicateItems) != -1 && memberId != ''){
                        $(this).addClass('duplicate-item');       
                    } 
                    if($.inArray(memberId, clashItems) != -1 && memberId != ''){
                        $(this).addClass('clash-item');       
                    } 
                }    

            });
            
        });    

    }

    







    //we also want to update the select title on change
    $('body').on('change', '.roster-data-input.list',function(e){

        var thisTitle = $(this).find("option:selected").attr("title"); 
        
        // console.log(thisTitle);
        
        //now set the title to this value
        $(this).parent().attr('title',thisTitle);

        $(this).parent().attr('data-original-title',thisTitle);

    });   
    
  


    //change the menu items on the members page
    $('body').on("click",".teams-menu-navigation li",function(event) {

        

        //remove all existing active classes
        $('.teams-menu-navigation li').removeClass('active');

        //add the class to our clicked item
        $(this).addClass('active');

        //hide and show the appropriate content
        var thisItem = $(this).attr('data');

        //hide all existing items
        $('.members-section').hide();
        $('.teams-section').hide();
        $('.notification-groups-section').hide();

        //show our current item
        $('.'+thisItem+'-section').show();

    });









    //add team item
    $('body').on("click",".add-a-notification-group-button",function(event) {

        event.preventDefault();

        var rosterId = $('.roster-header').attr('data');

        var errors = 0;


        //get variables
        var teamName = $('.notification-group-name-input').val();

        //first that the team has a name
        if(teamName.length < 1){
            errors++;
        }




        //now get leaders of the notification group
        var builderItemsLeader = '';

        $( ".notification-leader-section .member-section li" ).each(function( index ) {
            var memberId = $(this).find('.member-field').val();
            //add value to holding item
            builderItemsLeader += memberId+'|||';

            if(memberId.length < 1){
                errors++;
            }

        });

        //remove last 3 characters from string
        builderItemsLeader = builderItemsLeader.slice(0,-3);





        //now get each item in the list
        var builderItems = '';

        $( ".notification-member-section .member-section li" ).each(function( index ) {
            var memberId = $(this).find('.member-field').val();
            //add value to holding item
            builderItems += memberId+'|||';

            if(memberId.length < 1){
                errors++;
            }

        });

        //remove last 3 characters from string
        builderItems = builderItems.slice(0,-3);

       

        if(errors >0){

            alertify.alert("There was an issue with the data you have entered. Please ensure your team has a name and there are no blank fields.");

        } else {
            //send the data to create list item
            //lets send the data to be updated
            var data = {
                'action': 'add_notification_group',
                'teamName': teamName,
                'builderItems': builderItems,
                'builderItemsLeader': builderItemsLeader,
                'rosterId': rosterId,
            }; 

            jQuery.ajax({
            url: add_team.ajaxurl,
            type: "POST",
            data: data,
            context: this,    
            })
            .done(function(data, textStatus, jqXHR) {

                // console.log(data);

                //add the data to the list
                $('.notification-group-listing').prepend(data);

                $( "ul.member-section" ).sortable({
                    axis: "y"
                });


                $(".notification-group-listing .notification-group-name-input").on("change paste keyup", function() {

                    var thisValue = $(this).val();
            
                    $(this).parent().parent().prev().prev().text(thisValue);
            
                });

                repopulateMemberSelects(); 

                alertify.success("Notification group added!"); 
                
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
            })
            .always(function() {
            });

        }

     });  


     //download pdf
     $('body').on("click",".download-pdf",function(event) {

        // console.log('I was clicked');
        //lets get the title which will be used in the PDF and as the filename

        var title = $('.menu-item-roster a').text()+' Roster';

        var teamName = $('.team-heading').text();

        var amountOfDateColumns = 6;
        



        //columns
        var columns = [
            {title: teamName, dataKey: "teamName"},
        ];


        $( "table thead .date.now, table thead .date.future" ).each(function( index, element ) {
            if(index < amountOfDateColumns){
                var date = $(element).find('.date-detail').text();
                columns.push({title: date, dataKey: "date"+index});
            }
        });

        //rows
        var rows = [];


        $( "table tbody tr:not(.unavailable-rows)" ).each(function( index, element ) {

            var tableRow = {"teamName": $(element).find('th').text()}

            //{"id": 1, "name": "Shaw", "country": "Tanzania"}  

            $(element).find('td:not(.past-date)').each(function( index, element ) {

                if(index < amountOfDateColumns){

                    if( $(element).find('input').length ){
                        //its an input element
                        tableRow['date'+index] = $(element).find('input').val();   
                    } else {
                        //its a select element
                        tableRow['date'+index] = $(element).find('select option:selected').text();  
                    }
                }
            });

            rows.push(tableRow);

        });    



   
        
        // Only pt supported (not mm or in)
        var doc = new jsPDF('landscape');
        
        doc.autoTable(columns, rows, {
            headerStyles: {fillColor: [0, 0, 0],textColor: [255, 255, 255], lineColor: [255, 255, 255],lineWidth: .5},
            styles: {fillColor: [255, 255, 255],textColor: [0, 0, 0],lineColor: [255, 255, 255],lineWidth: .5},
            columnStyles: {
                teamName: {fillColor: [0, 0, 0],textColor: [255, 255, 255]}
            },
            margin: {top: 15,left:5, right:5,bottom:5},
            addPageContent: function(data) {
                doc.text(title, 5, 10);
            },
            showHeader: 'firstPage',
            pageBreak: 'avoid', 
            
        });
        doc.save(title+'.pdf');

     }); 







     $('body').on("click",".search-icon",function(event) {

        //clear out previous value if class is close
        //also show all items
        if($(this).hasClass('icon-close')){
            $(this).prev().val('');
            $(this).removeClass('icon-close').addClass('icon-magnifier');
        }

        var listItems = $(this).next();
        listItems.find('li').show();

     });   


     $(".item-filter-teams").on("change paste keyup", function() {

        var filterInputValue = $(this).val().toLowerCase();

        var itemsToFilter = $(this).attr('data');

        var listItems = $(this).next().next();

        if(filterInputValue.length > 0){

            $(this).next().removeClass('icon-magnifier').addClass('icon-close');

            //then start filtering items
            //loop through the items
            $( '.'+itemsToFilter+' > li' ).each(function( index ) {

                //get the name
                var listFilterName = $(this).find('.filter-name').text().toLowerCase();
                var thisLineItem = $(this);

                if (listFilterName.indexOf(filterInputValue) !=-1) {
                    //the item was found
                    thisLineItem.show();
                } else {
                    thisLineItem.hide();
                } 


            });    
        
        } else {
            listItems.find('li').show();
            $(this).next().removeClass('icon-close').addClass('icon-magnifier');
        }   
     });

     
     //do click to zoom for dates
     $('body').on("click",".zoom-to-now",function(event) {
        $('body').scrollTo('.future-date',750,{
            offset: {top: -90},    
            axis: 'y',
        });
     });   


    //do filter for dates
    $(".item-filter-dates").on("change paste keyup", function() {

        var filterInputValue = $(this).val().toLowerCase();

        var listItems = $(this).next().next();

        if(filterInputValue.length > 0){

            $(this).next().removeClass('icon-magnifier').addClass('icon-close');

            //then start filtering items
            //loop through the items

            $( '.dates-listing > li' ).each(function( index ) {

                var date = $(this).find('.date-time-input').val().toLowerCase();
                var description = $(this).find('.description-input').val().toLowerCase();
                var thisLineItem = $(this);




                if (date.indexOf(filterInputValue) !=-1 || description.indexOf(filterInputValue) !=-1) {
                    //the item was found
                    thisLineItem.show();
                } else {
                    thisLineItem.hide();
                } 


            }); 
           
        
        } else {
            listItems.find('li').show();
            $(this).next().removeClass('icon-close').addClass('icon-magnifier');
        }   
     });




    //enable date selection for custom fields
    $(".user-profile-date-selection").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d",
        allowInput: true,
    });


    //download a file on click
    $('body').on("click",".file-download",function(event) {

        // event.preventDefault();

        var url = $(this).prev().val();

        if(url.length > 0){
            window.open(url,'_blank');
        } else {
            console.log('no file');
        }

    });  


    //upload a file on click
    $('body').on("click",".file-upload",function(event) {

        // event.preventDefault();
        var uploadIcon = $(this);
        var thisInput = uploadIcon.prev().prev();

        alertify
                .okBtn("Upload")
                .cancelBtn("Cancel")
                .confirm('<h3 style="text-align: left;">Upload a file</h3></br><input class="file-upload-input-wp-roster" type="file" name="fileToUploadWpRoster" id="fileToUploadWpRoster"><label></label><label class="wp-roster-file-upload-label" for="fileToUploadWpRoster"><i class="icon-picture"></i> Drop file</label>', function (ev) {

                    
                        
                
                    if($('.file-upload-input-wp-roster').length){
                        var attachment = $('.file-upload-input-wp-roster').prop("files")[0];    
                    }
            

                    var form_data = new FormData();
                    form_data.append("action", 'add_file_to_roster');
          
                    //only send the attachment if it exists
                    if($('.file-upload-input-wp-roster').length){
                        form_data.append("attachment", attachment);
                    }
            
                    //do query
                    jQuery.ajax({
                    url: add_file_to_roster.ajaxurl,
                    type: "POST",
                    data: form_data,     
                    context: this,
                    processData: false,
                    contentType: false,
                    cache: false,
                    }).done(function(data, textStatus, jqXHR) {

                        thisInput.val(data);
                        console.log(data);
                        
                    });
                

                }, function(ev) {
                    //they clicked cancel

                });

        

    });  

    //indicate that the attachment has a file
    $('body').on('change', '.file-upload-input-wp-roster',function(e){
        
        var fileName = e.target.value.split( '\\' ).pop();
        
//        console.log(fileName);
        
        $('.wp-roster-file-upload-label').html('<i class="icon-picture"></i> '+fileName);
        
//        console.log($(this).val());
    });
    
    


});