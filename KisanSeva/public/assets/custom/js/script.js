/*
* File    : script.js
* Purpose : Contains all jquery codes to have farmer functionality
* Created : 25-mar-2017
* Author  : Satyapriya Baral
*/

$(document).ready(function(){

  /**
  * Ajax call to display crops according to category
  *
  * @param Null
  * @return Null
  */
  $("#category").on("change",function(){
    var cat_id = $(this).val();
    //sets the div where crops to be displayed.
    var div=$(this).parent().parent();
    var op=" ";
    $.ajax({
      type:'get',
      url: url ,
      data:{'id':cat_id},
      success:function(data){
        op+='<option value="0" selected disabled> Choose Crop </option>';
        for( var i=0 ; i < data.length ; i++ ) {
          op+='<option value="'+data[i][1]+'">'+data[i][0]+'</option>';
        }
        div.find('.cropName').html(" ");
        div.find('.cropName').append(op);
      }
    })
  });

      //errors are hidden and will show when error occurs.
     $("#nameError").hide();
     $("#contactError").hide();
     $("#quantityError").hide();
     $("#cropError").hide();
     $("#basepriceError").hide();
     $("#expirytimeError").hide();
     $("#categoryError").hide();
     $("#bidError").hide();

     errorName = false;
     errorContact = false;
     errorQuantity = false;
     errorCrop = false;
     errorBasePrice = false;
     errorExpiryTime = false;
     errorCategory = false;
     errorBid = false;

     $("#inputName").focusout(function(){
          checkName();
     });

     $("#bid").focusout(function(){
          checkBid();
     });

     $("#inputContact").focusout(function(){
          checkContact();
     });

     $("#category").focusout(function(){
          checkCategory();
     });

     $("#crop").focusout(function(){
          checkCrop();
     });

     $("#quantity").focusout(function(){
          checkQuantity();
     });

     $("#price").focusout(function(){
          checkPrice();
     });

     $("#ExpiryTime").focusout(function(){
          checkExpiryTime();
     });

     /**
     * Function to validate name Field
     *
     * @param null
     * @return boolian value for true or false
     */
     function checkName(){
          var name = $("#inputName").val().length;
          if(name < 5)
          {
               $("#nameError").html("Name should be of 5 charecters atleast");
               $("#nameError").show();
               errorName = true;
          }
          else
          {
               $("#nameError").hide();
          }
     }

    /**
     * Function to validate Contact
     *
     * @param null
     * @return boolian value for true or false
     */
     function checkContact(){
          var contact = $("#inputContact").val().length;
          if(contact < 10 || contact >10)
          {
               $("#contactError").html("Contact should be of 10 digits");
               $("#contactError").show();
               errorContact = true;
          }
          else
          {
               $("#contactError").hide();
          }
     }

     /**
     * Function to validate category
     *
     * @param null
     * @return boolian value for true or false
     */
     function checkCategory(){
          if($("#category").val() === null)
          {
               $("#categoryError").html("Insert Category");
               $("#categoryError").show();
               errorCategory = true;
          }
          else
          {
               $("#categoryError").hide();
          }
     }

     /**
     * Function to validate crop field
     *
     * @param null
     * @return boolian value for true or false
     */
     function checkCrop(){
          if($("#crop").val() === null)
          {
               $("#cropError").html("Insert Crop");
               $("#cropError").show();
               errorCrop = true;
          }
          else
          {
               $("#cropError").hide();
          }
     }

     /**
     * Function to validate quantity field
     *
     * @param null
     * @return boolian value for true or false
     */
     function checkQuantity(){
          var quantity = $("#quantity").val().length;
          if(quantity < 1)
          {
               $("#quantityError").html("Insert Quantity");
               $("#quantityError").show();
               errorQuantity = true;
          }
          else
          {
               $("#quantityError").hide();
          }
     }

     /**
     * Function to validate price field
     *
     * @param null
     * @return boolian value for true or false
     */
     function checkPrice(){
          var price = $("#price").val().length;
          if(price < 1)
          {
               $("#basepriceError").html("Insert Base Price");
               $("#basepriceError").show();
               errorBasePrice = true;
          }
          else
          {
               $("#basepriceError").hide();
          }
     }

     /**
     * Function to validate expiry time field
     *
     * @param null
     * @return boolian value for true or false
     */
     function checkExpiryTime(){
          if($("#ExpiryTime").val() === "")
          {
               $("#expirytimeError").html("Insert Expiry Time");
               $("#expirytimeError").show();
               errorExpiryTime = true;
          }
          else
          {
               $("#expirytimeError").hide();
          }
     }

     /**
     * Function to check Bid Field
     *
     * @param null
     * @return boolian value for true or false
     */
     function checkBid(){
          if($("#bid").val() === "")
          {
               $("#bidError").html("Please Insert Bid");
               $("#bidError").show();
               errorBid = true;
          }
          else if(parseInt($("#bid").val()) < parseInt($("#basePrice").val()))
          {
               $("#bidError").html("Bid cannot be smaller than Base Price");
               $("#bidError").show();
               errorBid = true;
          }
          else
          {
               $("#bidError").hide();
          }
     }

     var shouldRun = false;

    /**
     * Function to check all fields after he submit post button is clicked.
     *
     * @param null
     * @return boolian value for true or false
     */
     $("#submitBid").on('click' , function(e){

        if (shouldRun === true) {
          shouldRun = false;
          return;
        }
        e.preventDefault();

        errorBid = false;

        checkBid();

        if(errorBid === false)
        {
               shouldRun = true;
               $(this).trigger('click');
        }
    });
     /**
     * Function to check after the submit button is clicked on edit profile.
     *
     * @param null
     * @return boolian value for true or false
     */
     $("#editSubmit").on('click' , function(e){

        if (shouldRun === true) {
          shouldRun = false;
          return;
        }
        e.preventDefault();

        errorName = false;
        errorContact = false;

        checkName();
        checkContact();

        if(errorName === false && errorContact === false)
        {
               shouldRun = true;
               $(this).trigger('click');
        }
    });

     /**
     * Function to check all fields after he submit post button is clicked.
     *
     * @param null
     * @return boolian value for true or false
     */
     $("#submitPost").on('click' , function(e){

        if (shouldRun === true) {
          shouldRun = false;
          return;
        }
        e.preventDefault();

        errorQuantity = false;
        errorCrop = false;
        errorBasePrice = false;
        errorExpiryTime = false;
        errorCategory = false;

        checkCategory();
        checkCrop();
        checkQuantity();
        checkPrice();
        checkExpiryTime();

        if(errorQuantity === false && errorCrop === false && errorBasePrice === false && errorExpiryTime === false && errorCategory === false)
        {
               shouldRun = true;
               $(this).trigger('click');
        }
    });
})