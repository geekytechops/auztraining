        <script>

            var checkPhone=0;
            function PhoneCheck(number){

                return new Promise(function (resolve, reject) {

                    var check_update=$('#check_update').val();
                    var oldenquiryFor='<?php echo $queryRes['st_enquiry_for']; ?>';
                    var oldNumber='<?php echo $queryRes['st_phno']; ?>';

                    var memberName=$('#member_name').val();     
                    var enquiryFor=$('#enquiry_for').val();                

                $.ajax({
                    type:'post',
                    data:{number:number,formName:'phoneNumberCheck',oldNumber:oldNumber,memberName:memberName,enquiryFor:enquiryFor,check_update:check_update,oldenquiryFor:oldenquiryFor},
                    url:'includes/datacontrol.php',
                    success:function(datas){
                        resolve(datas);
                    },
                    error: function (xhr, status, error) {
                        reject(new Error(status + ': ' + error));
                    }

                })

            });

            }

                        // Usage with async/await
            async function getData(number) {
            try {
                const data = await PhoneCheck(number);
                return data;

                // You can perform further operations with 'data' here
            } catch (error) {
                console.error(error);
            }
            }

            $(document).ready(function(){            

                $('.refered').on("change",function(){
                    var value=$(this).val();
                    if( value==0 || value==2 ){
                        $('.refered_field').hide();
                    }else{
                        $('.refered_field').show();
                    }                 
                })
                $('.rpl_parent').on("change",function(){
                    var value=$(this).val();
                    if( value==0 || value==2 ){
                        $('.rpl_child').hide();
                    }else{
                        $('.rpl_child').show();
                    }                 
                })
                $('#visa_condition').on("change",function(){
                    var value=$(this).val();
                    if( value==7 ){
                        $('.visa_note').show();
                    }else{
                        $('.visa_note').hide();
                    }                 
                })
              /*  $('#hear_about').on("change",function(){
                    var value=$(this).val();                    
                    if( value.includes('9') ){
                        $('.hear_about_child').show();
                    }else{
                        $('.hear_about_child').hide();
                    }                 
                }) */

                $('#course_type').on("change",function(){
                    var value=$(this).val();
                    if( value==1 ){
                        $('#rpl_form').show();
                        $('#short_grp_form').hide();
                        $('#regular_grp_form').hide();
                    }else if(value==5 || value==4){       
                        $('#rpl_form').hide();
                        $('#short_grp_form').show(); 
                        $('#regular_grp_form').hide();
                    }else if(value==3){                        
                        $('#rpl_form').hide();
                        $('#short_grp_form').hide();
                        $('#regular_grp_form').show();
                    }else{
                        $('#rpl_form').hide();
                        $('#short_grp_form').hide();
                        $('#regular_grp_form').hide();
                    }
                })
                $('.rpl_prev_parent').on("change",function(){
                    var value=$(this).val();
                    if( value==2 || value==0){
                        $('.rpl_prev_child').hide();
                    }else{                                            
                        $('.rpl_prev_child').show();
                    }
                })
                $('#appointment_booked').on("change",function(){
                    var value=$(this).val();
                    if( value==1){
                        $('#appointment_form').show();
                    }else{
                        $('#appointment_form').hide();
                    }
                })

                $('#enquiry_for').on('change',function(){
                    var value=$(this).val();
                    if( value==1){
                        $('#member_name').val($('#student_name').val());
                        $('#member_name').prop('readonly',true);
                    }else{
                        $('#member_name').prop('readonly',false);
                        $('#member_name').val('');
                    }
                })

                $('#student_name').keyup(function(){
                    if($('#enquiry_for').val()==1){
                        $('#member_name').val($('#student_name').val());
                    }
                })
            })

            $(document).on('click','#enquiry_form',async() =>{
                var studentName=$('#student_name').val().trim();
                var contactName=$('#contact_num').val().trim();
                var emailAddress=$('#email_address').val().trim();
                var enquiryDate=$('#enquiry_date').val();

                var surname=$('#surname').val();
                var suburb=$('#suburb').val();
                var stuState=$('#stu_state').val() == 0 ? '' : $('#stu_state').val();
                var postCode=$('#post_code').val();
                var visit_before=$('#visit_before').val()==0 ? '' :$('#visit_before').val();
                var hear_about=$('#hear_about').val();
                // var hearedby=$('#hearedby').val();
                var hearedby=0;
                var plan_to_start_date=$('#plan_to_start_date').val();
                var refer_select=$('#refer_select').val();
                var referer_name=$('#referer_name').val();
                var refer_alumni=$('#refer_alumni').val();
                var shore=$('#shore').val();
                var comments=$('#comments').val();
                var remarks=[];
                var appointment_booked=$('#appointment_booked').val();

                $('.remarks_check:checkbox:checked').each(function() {
                    remarks.push(this.value);
                });           
                     
                var streetDetails=$('#street_no').val();
                var ethnicity=$('#ethnicity').val();                
                var prefComment=$('#pref_comment').val();                
                var enquiryFor=$('#enquiry_for').val()==0 ? '' : $('#enquiry_for').val();
                var courseType=$('#course_type').val();

                var emailregexp = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                // var courses=$('#courses').val()==0 ? '' : $('#courses').val();
                var courses=[];

                $('.courses_check:checkbox:checked').each(function() {
                    courses.push(this.value);
                });

                var payment=$('#payment_fee').val().trim();
                var memberName=$('#member_name').val().trim();
                var visaStatus=$('#visa_condition').val();
                var visaNote=$('#visa_note').val();
                var visaCondition=$('.visa_status').val();

                var reg_grp_names=$('#reg_grp_names').val();

                if(visaStatus==7 && visaNote=='' ){
                    visaNoteStatus=1;
                }else{
                    visaNoteStatus=0;
                }

                if(refer_select==0){
                    refer_select_error=0;
                }else if(refer_select==1){

                    if(refer_alumni==0){
                        refer_select_error=0;
                    }else{
                        refer_select_error=1;
                    }

                }else{
                    refer_select_error=1;
                }

                // if(hear_about.length==0){
                //     hear_about_error=0;
                // }else if(hear_about.includes('9')){

                //     if(hearedby==''){
                //         hear_about_error=0;
                //     }else{
                //         hear_about_error=1;
                //     }

                // }else{
                //     hear_about_error=1;
                // }

                if(hear_about==''){
                    hear_about_error=0;
                }else{
                    hear_about_error=1;
                }
                
                // checkPhone=0;            
                // var error_ph=await getData(contactName).split('||')[0];
                var enquiryIdRec=await getData(contactName);                
                if(enquiryIdRec.split('||')[0]==1 || ( contactName=='' || contactName.length!=10 ) ){
                    var phoneChecks=1;
                }else{
                    var phoneChecks=0;
                }

                if(studentName==''|| phoneChecks==1 ||emailAddress==''|| (emailAddress!='' && !emailAddress.match(emailregexp)==true ) ||courses.length==0||payment=='' || enquiryDate=='' || refer_select_error==0 || hear_about_error==0 || surname=='' || enquiryFor==''|| postCode=='' || visit_before=='' || memberName=='' || visaNoteStatus==1 ){

                    if(refer_select_error==0){
                        if(refer_select==0){
                            $('#refer_select').addClass('invalid-div');
                            $('#refer_select').removeClass('valid-div');
                            $('#refer_select').closest('div').find('.error-feedback').show();
                        }else if(refer_select==1){

                            if(refer_alumni==0){
                                $('#refer_alumni').addClass('invalid-div');
                                $('#refer_alumni').removeClass('valid-div');
                                $('#refer_alumni').closest('div').find('.error-feedback').show();
                            }else{
                                $('#refer_alumni').addClass('valid-div');
                                $('#refer_alumni').removeClass('invalid-div');
                                $('#refer_alumni').closest('div').find('.error-feedback').hide();
                            }

                        }else{
                            $('#refer_select').addClass('valid-div');
                            $('#refer_select').removeClass('invalid-div');
                            $('#refer_select').closest('div').find('.error-feedback').hide();
                        }
                    }

                    if(hear_about_error==0){
                        if(hear_about.length==0){
                            $('#hear_about').addClass('invalid-div');
                            $('#hear_about').removeClass('valid-div');
                            $('#hear_about').closest('div').find('.error-feedback').show();
                        }else if(hear_about.includes('9')){

                            if(hearedby==''){
                                $('#hearedby').addClass('invalid-div');
                                $('#hearedby').removeClass('valid-div');
                                $('#hearedby').closest('div').find('.error-feedback').show();
                            }else{
                                $('#hearedby').addClass('valid-div');
                                $('#hearedby').removeClass('invalid-div');
                                $('#hearedby').closest('div').find('.error-feedback').hide();
                            }

                        }else{
                            $('#hear_about').addClass('valid-div');
                            $('#hear_about').removeClass('invalid-div');
                            $('#hear_about').closest('div').find('.error-feedback').hide();
                        }   
                    }                 


                    if(studentName==''){
                        $('#student_name').addClass('invalid-div');
                        $('#student_name').removeClass('valid-div');
                        $('#student_name').closest('div').find('.error-feedback').show();
                    }else{
                        $('#student_name').addClass('valid-div');
                        $('#student_name').removeClass('invalid-div');
                        $('#student_name').closest('div').find('.error-feedback').hide();
                    }

                    
                    if(contactName=='' || contactName.length!=10 ){
                        $('#contact_num').addClass('invalid-div');
                        $('#contact_num').removeClass('valid-div');
                        $('#contact_num').closest('div').find('.error-feedback').show();
                    }else if(enquiryIdRec.split('||')[0]==1){
                        $('#contact_num').addClass('invalid-div');
                        $('#contact_num').removeClass('valid-div');                        
                        $('#contact_num').closest('div').find('.error-feedback').hide();     
                        $('#contact_num').closest('div').find('.phone_error').show();
                        $('#contact_num').closest('div').find('#phone_err_id').html(enquiryIdRec.split('||')[1]);
                    }else{
                        $('#contact_num').addClass('valid-div');
                        $('#contact_num').removeClass('invalid-div');
                        $('#contact_num').closest('div').find('.error-feedback').hide();
                        $('#contact_num').closest('div').find('.phone_error').hide();
                    }
                    if(memberName=='' ){
                        $('#member_name').addClass('invalid-div');
                        $('#member_name').removeClass('valid-div');
                        $('#member_name').closest('div').find('.error-feedback').show();
                    }else{
                        $('#member_name').addClass('valid-div');
                        $('#member_name').removeClass('invalid-div');
                        $('#member_name').closest('div').find('.error-feedback').hide();
                    }
                    if(emailAddress=='' || (emailAddress!='' && (!emailAddress.match(emailregexp)==true))){
                        $('#email_address').addClass('invalid-div');
                        $('#email_address').removeClass('valid-div');
                        $('#email_address').closest('div').find('.error-feedback').show();
                    }else{
                        $('#email_address').addClass('valid-div');
                        $('#email_address').removeClass('invalid-div');
                        $('#email_address').closest('div').find('.error-feedback').hide();
                    }
                    if(courses.length==0){
                        // $('#courses').addClass('invalid-div');
                        // $('#courses').removeClass('valid-div');
                        $('.courses_error').show();
                    }else{
                        // $('#courses').addClass('valid-div');
                        // $('#courses').removeClass('invalid-div');
                        $('.courses_error').hide();
                    }
                    if(visaNoteStatus==1){
                        $('#visa_note').addClass('invalid-div');
                        $('#visa_note').removeClass('valid-div');
                        $('#visa_note').closest('div').find('.error-feedback').show();
                    }else{
                        $('#visa_note').addClass('valid-div');
                        $('#visa_note').removeClass('invalid-div');
                        $('#visa_note').closest('div').find('.error-feedback').hide();
                    }
                    if(payment==''){
                        $('#payment_fee').addClass('invalid-div');
                        $('#payment_fee').removeClass('valid-div');
                        $('#payment_fee').closest('div').find('.error-feedback').show();
                    }else{
                        $('#payment_fee').addClass('valid-div');
                        $('#payment_fee').removeClass('invalid-div');
                        $('#payment_fee').closest('div').find('.error-feedback').hide();
                    }

                    if(enquiryDate==''){
                        $('#enquiry_date').addClass('invalid-div');
                        $('#enquiry_date').removeClass('valid-div');
                        $('#enquiry_date').closest('div').find('.error-feedback').show();
                    }else{
                        $('#enquiry_date').addClass('valid-div');
                        $('#enquiry_date').removeClass('invalid-div');
                        $('#enquiry_date').closest('div').find('.error-feedback').hide();
                    }

                    if(surname==''){
                        $('#surname').addClass('invalid-div');
                        $('#surname').removeClass('valid-div');
                        $('#surname').closest('div').find('.error-feedback').show();
                    }else{
                        $('#surname').addClass('valid-div');
                        $('#surname').removeClass('invalid-div');
                        $('#surname').closest('div').find('.error-feedback').hide();
                    }

                    if(enquiryFor==''){
                        $('#enquiry_for').addClass('invalid-div');
                        $('#enquiry_for').removeClass('valid-div');
                        $('#enquiry_for').closest('div').find('.error-feedback').show();
                    }else{
                        $('#enquiry_for').addClass('valid-div');
                        $('#enquiry_for').removeClass('invalid-div');
                        $('#enquiry_for').closest('div').find('.error-feedback').hide();
                    }

                    if(postCode==''){
                        $('#post_code').addClass('invalid-div');
                        $('#post_code').removeClass('valid-div');
                        $('#post_code').closest('div').find('.error-feedback').show();
                    }else{
                        $('#post_code').addClass('valid-div');
                        $('#post_code').removeClass('invalid-div');
                        $('#post_code').closest('div').find('.error-feedback').hide();
                    }

                    if(visit_before==''){
                        $('#visit_before').addClass('invalid-div');
                        $('#visit_before').removeClass('valid-div');
                        $('#visit_before').closest('div').find('.error-feedback').show();
                    }else{
                        $('#visit_before').addClass('valid-div');
                        $('#visit_before').removeClass('invalid-div');
                        $('#visit_before').closest('div').find('.error-feedback').hide();
                    }

                    // console.log($('.error-feedback:visible'));
                    // $('.collapse').collapse();

                    $('.error-feedback:visible').parent('.accordion-button').trigger('click');
                    // if($('.error-feedback:visible').css('display')!='none'){

                    // }

                }else{
                    var checkId=$("#check_update").val();
                    var forms=true;
                    var appointForm=true;

                    if(courseType==1){
                        forms= submitRpl();
                    }else if(courseType==5 || courseType==4){
                        forms= submitShortGroup();
                    }else if(courseType==3){
                        if(reg_grp_names==''){
                            $('#reg_grp_names').addClass('invalid-div');
                             $('#reg_grp_names').removeClass('valid-div');
                            return false;
                        }else{
                            $('#reg_grp_names').addClass('valid-div');
                             $('#reg_grp_names').removeClass('invalid-div');
                        }
                    }

                    if(appointment_booked==1){
                        appointForm= submitSlot();
                    }

                    if(forms && appointForm ){

                    $('#loader-container').css('display','flex');
                    $('#student_enquiry_form').css('opacity','0.1');

                    courses=courses.filter(item => item !== '0');
                    remarks=remarks.filter(item => item !== '0');
                    
                    details={formName:'student_enquiry',studentName:studentName,contactName:contactName,emailAddress:emailAddress,courses:courses,payment:payment,checkId:checkId,visaStatus:visaStatus,surname:surname,enquiryDate:enquiryDate,suburb:suburb,stuState:stuState,postCode:postCode,visit_before:visit_before,hear_about:hear_about,hearedby:hearedby,memberName:memberName,plan_to_start_date:plan_to_start_date,refer_select:refer_select,referer_name:referer_name,refer_alumni:refer_alumni,visaNote:visaNote,prefComment:prefComment,comments:comments,appointment_booked:appointment_booked,visaCondition:visaCondition,remarks:remarks,reg_grp_names:reg_grp_names,streetDetails:streetDetails,enquiryFor:enquiryFor,courseType:courseType,shore:shore,ethnicity:ethnicity,enquiry_source:$('#enquiry_source').val()||0,location:($('#location').val()||'').trim(),enquiry_college:($('#enquiry_college').length ? $('#enquiry_college').val() : 0)||0,rpl_arrays:JSON.stringify(rpl_array),short_grps:JSON.stringify(short_grp),slot_books:JSON.stringify(slot_book),admin_id:"<?php echo $_SESSION['user_id']; ?>",formId:<?php echo $form_id; ?>,rpl_status:'<?php echo $rpl_status; ?>',short_grp_status:'<?php echo $short_grp_status; ?>',reg_grp_status:'<?php echo $reg_grp_status; ?>',slot_book_status:'<?php echo $slot_book_status; ?>'};
                    $.ajax({
                        type:'post',
                        url:'includes/datacontrol.php',
                        data:details,
                        success:function(data){
                            if(data==0){
                                $('.toast-text2').html('Cannot add record. Please try again later');
                                $('#borderedToast2Btn').trigger('click');
                            }else if(data==2){
                                // $( "#student_enquiry_form_parent" ).load(window.location.href + " #student_enquiry_form" );
                                document.getElementById('student_enquiry_form').reset();
                                $('#toast-text').html('Record Updated Successfully');
                                $('#borderedToast1Btn').trigger('click');
                                // $('#jelly_loader').hide();
                                $('#loader-container').hide();
                                $('#student_enquiry_form').css('opacity','');
                                setTimeout(() => {location.reload();}, 500); 
                                // window.location.href="dashboard.php";
                            }else{
                                // $( "#student_enquiry_form_parent" ).load(window.location.href + " #student_enquiry_form" );
                                document.getElementById('student_enquiry_form').reset();
                                $('#toast-text').html('New Enquiry Added');
                                $('#borderedToast1Btn').trigger('click');

                                $('#myModalLabel').html('Enquiry ID Created:');
                                $('.modal-body').html(data);
                                $('#model_trigger').trigger('click');
                                $('#loader-container').hide();
                                // $('#jelly_loader').hide();
                                $('#student_enquiry_form').css('opacity','');
                                setTimeout(() => {location.reload();}, 500); 
                            }
                        }
                    })
                    }
                }

            })


            function genQR(){                

                // $.ajax({
                //     url:'includes/datacontrol.php',
                //     data:{admin_id:"<?php echo $_SESSION['user_id']; ?>",formName:'create_qr'},
                //     type:'post',
                //     success:function(data){
                        
                        var qrcodeContainer = document.getElementById('qrcode');
                        var updatedURL = removeLastSegmentFromURL(window.location.href)+'/common_enquiry.php';
