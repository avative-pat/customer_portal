$(document).ready(function(){
    var stripe = Stripe('pk_test_TYooMQauvdEDq54NiTphI7jx');
    console.log('end my suffering', stripe);
    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    var cardholderName = document.getElementById('name');
    var cardContainer = document.getElementById('stripe_container');
    var clientSecret = cardContainer.dataset.secret;

    $('#createPaymentMethodForm').submit(async function() {
        console.log(cardholderName, cardContainer, clientSecret);

        return await stripe.confirmCardSetup(
            clientSecret,
            {
            payment_method: {
                card: cardElement,
                    billing_details: {
                    name: cardholderName.value,
                },
            },
            }
        ).then(function(result) {
            if (result.error) {
                // Display error.message in your UI.
                console.error(result.error);
                $('#stripe_errors').text(result.error.message);
                return false;
            } else {
                // The setup has succeeded. Display a success message.
                alert('king status');
                return true;
            }
        });

        
    });


    // ccNumberField.payment('formatCardNumber');
    // expirationField.payment('formatCardExpiry');

    // updatePaymentForm();

    // $("#country").change(function(){
    //     updateSubdivisions();
    // });

    // ccNumberField.keyup(function (e){
    //     var cardType = $.payment.cardType($("#cc-number").val());
    //     ccIcon.removeClass();
    //     switch (cardType) {
    //         case "visa":
    //         case "visaelectron":
    //             ccIcon.addClass("fa fa-cc-visa");
    //             break;
    //         case "mastercard":
    //             ccIcon.addClass("fa fa-cc-mastercard");
    //             break;
    //         case "amex":
    //             ccIcon.addClass("fa fa-cc-amex");
    //             break;
    //         case "dinersclub":
    //             ccIcon.addClass("fa fa-cc-diners-club");
    //             break;
    //         case "discover":
    //             ccIcon.addClass("fa fa-cc-discover");
    //             break;
    //         case "jcb":
    //             ccIcon.addClass("fa fa-cc-jcb");
    //             break;
    //         default:
    //             ccIcon.addClass("fa fa-cc");
    //             break;
    //     }
    // });

    // makeAuto.change(function(){
    //     if (makeAuto.is(":checked")) {
    //         $("#autoPayDescription").show();
    //     }
    //     else {
    //         $("#autoPayDescription").hide();
    //     }
    // });

    // $("#payment_method").change(function(){
    //     updatePaymentForm();
    // });

    // $("#paymentForm").submit(function () {
    //     var selectedPaymentMethod = $("#payment_method").val();
    //     switch (selectedPaymentMethod) {
    //         case "new_card":
    //             $(".new_card").show();
    //             $(".non_paypal").show();
    //             $(".paypal").remove();
    //             break;
    //         case "paypal":
    //             $(".new_card").remove();
    //             $(".non_paypal").remove();
    //             $(".paypal").show();
    //             break;
    //         default:
    //             //Existing card
    //             $(".new_card").remove();
    //             $(".non_paypal").show();
    //             $(".paypal").remove();
    //             break;
    //     }


    //     var allClear = true;
    //     var elements = document.querySelectorAll("#paymentForm input");
    //     for (var i = 0, element; element = elements[i++];) {
    //         if (element.value === "") {
    //             allClear = false;
    //             break;
    //         }
    //     }
    //     $("#submit").prop('disabled', allClear);
    // });

});

// function updateSubdivisions()
// {
//     var country = $("#country").val();
//     $("#state").prop('disabled',true);
//     var jqxhr = $.get("/portal/billing/subdivisions/" + country, function(data) {
//         $("#state").empty();
//         var show = false;
//         $.each(data.subdivisions, function (index, value) {
//             show = true;
//            $("#state").append("<option value='" + index + "'>" + value + "</option>");
//         });
//         if (show === true) {
//             $("#stateWrapper").show();
//         }
//         else {
//             $("#stateWrapper").hide();
//         }
//     })
//     .fail(function() {
//         swal({
//             title: Lang.get("headers.error"),
//             text: Lang.get("errors.failedToLookupSubdivision"),
//             type: "error",
//             showCancelButton: false
//         },
//         function(isConfirm) {
//             if (isConfirm) {
//                 window.location.reload();
//             }
//         });
//     })
//     .always(function() {
//         $("#state").prop('disabled',false);
//     });
// }

// function updatePaymentForm()
// {
//     var selectedPaymentMethod = $("#payment_method").val();
//     switch (selectedPaymentMethod) {
//         case "new_card":
//             $(".new_card").show();
//             $(".non_paypal").show();
//             $(".paypal").hide();
//             break;
//         case "paypal":
//             $(".new_card").hide();
//             $(".non_paypal").hide();
//             $(".paypal").show();
//             break;
//         default:
//             //Existing card
//             $(".new_card").hide();
//             $(".non_paypal").show();
//             $(".paypal").hide();
//             break;
//     }
// }