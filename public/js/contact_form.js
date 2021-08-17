var focus="";
$( document ).ready(function() {

    var verifEml=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]{2,}[.][a-zA-Z]{2,5}$/

    $('form[name="contact_form"]').submit(function() {
        focus="";
        $('.invalid-feedback').remove();
        $('*').removeClass('is-invalid');
        if($('#contact_form_email').val()==""){
            $('#contact_form_email').addClass('is-invalid');
            $('#contact_form_email').prev('label').append(msg);
            if(focus=="") focus='#contact_form_email';
        }
        if($('#contact_form_email').val()!="" && verifEml.exec($('#contact_form_email').val()) == null){
            $('#contact_form_email').addClass('is-invalid');
            $('#contact_form_email').prev('label').append(msg_email_novalid);
            if(focus=="") focus='#contact_form_email';
        }
        if($('#contact_form_firstName').val()==""){
            $('#contact_form_firstName').addClass('is-invalid');
            $('#contact_form_firstName').prev('label').append(msg);
            if(focus=="") focus='#contact_form_firstName';
        }
        if($('#contact_form_lastName').val()==""){
            $('#contact_form_lastName').addClass('is-invalid');
            $('#contact_form_lastName').prev('label').append(msg);
            if(focus=="") focus='#contact_form_lastName';
        }


        if(focus!=''){
            $(focus).focus();
            return false;
        }
        return true;
    });
});