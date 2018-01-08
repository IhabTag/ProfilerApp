$(function () {
   
        'use strict';
    
    // Hide placeholder on form focus
    $('[placeholder]').focus(function (){
      
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
        
        }).blur(function (){
        
        $(this).attr('placeholder', $(this).attr('data-text'));
        });
        
    
    // Add Asterisk to Required fields
    $('input').each(function(){
        
        if ($(this).attr('required') === 'required') {
            
            $(this).after('<span class="asterisk">*<?span>');
        }
        
    });
    
    $('select').each(function(){
        
        if ($(this).attr('required') === 'required') {
            
            $(this).after('<span class="asterisk">*<?span>');
        }
        
    });
    
    
    //Convert Password field to Text Field
    
    $('.show-pass').hover(function() {
        
        $('.password').attr('type', 'text');
        
    }, function () {
        
        $('.password').attr('type', 'password');
    });
    
    
    //Confirmation Message on Button Click
    
    $('.confirm').click(function () {
        return confirm('Are you sure?');
    });
    
    // Assign contact id to the edit button in the contacts page
        $('input[name=contactID]').change(function(){
            var desiredID = $(this).attr('value');
            $('#editBtn').attr('href', '?do=Edit&id=' + desiredID);
        });
    
    $('.clickableRow').click(function() {
        window.document.location = $(this).data("href");
    });
    
    // Confirmation message on delete contact
    
    $('a[name=delete]').click(function() {
       var conf = confirm('Are you sure you want to delete this?');
       if (conf === true) {
           return true;
       }else{
           return false;
       }
    });
    
    
    // New Password Validation
    
    var newPass = $('input[name="newPass"]');
    var cNewPass = $('input[name="cNewPass"]');
    
    newPass.keyup(function () {
       if ($(this).val().length === 0) {
           $('#passCheck02').hide();
           $('#passCheck01').hide();
       }else if ($(this).val().length < 6 && $(this).val().length > 0){
           $('#passCheck02').show();
           $('#passCheck01').hide();
       }else{
           $('#passCheck02').hide();
           $('#passCheck01').show();
       }
       
       if (cNewPass.val().length === 0 && $(this).val().length === 0) {
           $('#passCheck04').hide();
           $('#passCheck03').hide();
       }
    });
    
    cNewPass.keyup(function () {
       if (cNewPass.val().length === 0 && newPass.val().length === 0) {
           $('#passCheck04').hide();
           $('#passCheck03').hide();
       }else if (newPass.val() !== cNewPass.val()){
           $('#passCheck04').show();
           $('#passCheck03').hide();
       }else{
           $('#passCheck04').hide();
           $('#passCheck03').show();
       } 
    });
    

});
