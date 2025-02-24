var currencies = [

    "USD",

    "ISK",

    "AUD",

    "CAD",

    "CHF",

    "DKK",

    "EUR",

    "GBP",

    "HKD",

    "JPY",

    "KRW",

    "NOK",

    "PLN",

    "RUB",

    "SEK",

    "SGD"

];

var option = "";

$.each(currencies, function () {

    option += "<option value='" + this + "'>" + this + "</option>";

})

var previous = "";

$('.selectpicker').attr("previous", "USD");



//$( window ).load(function() {

//  // Run code

//});







$('.selectpicker').change(function () {

    previous = $(this).attr('previous').trim();
    //alert('previous' + previous);
    var this_val = $(this);

    var new_val = $.trim(this_val.val());
  //  console.log(this_val.parent().parent().find('strong').text(), ' here comes prev ', previous, ' here comes new val ', this_val.val());



    function letsdoit() {

//        console.log("Current",'diff',previous);

        var rate = fx(this_val.parent().parent().find('strong').text()).from(previous).to(new_val)

        var price =Math.round(rate);

        this_val.parent().parent().find('strong').text(price.toLocaleString());

        //  this_val.parent().parent().find('strong').text(rate.toFixed(2));

    }



    fetch('https://api.exchangeratesapi.io/latest?base=PHP')

        .then((resp) => resp.json())

        .then((data) => fx.rates = data.rates).then(letsdoit)



    $(this).attr('previous', $.trim($(this).val()));





});





// console.log('before ',$('#saas').get()[0].outerHTML)

// setTimeout(function(){

// 	console.log('at start ',$('#saas').get()[0].outerHTML)

// 	$('#saas option').detach();

// 	$('#saas').append(option)

// 	console.log(" at end ",$('#saas').get()[0].outerHTML);

// },5000)



