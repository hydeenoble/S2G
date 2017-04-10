$(document).ready(function(){
	urlParameters = getParameter(window.location.href);
	$.ajax({
		url : "http://localhost/s2g/test.php?from="+urlParameters.from+"&to="+urlParameters.to,
		type : "GET",
		success : function(data){
			var dataOBJ = JSON.parse(data)
			// console.log();
            // dataOBJ.credit_rating = 39;
			if (dataOBJ.credit_rating < 40 ){
                $('#credit-rating').append(Math.floor(dataOBJ.credit_rating) + '% <span class="label label-danger">bad</span>');
            }else if(dataOBJ.credit_rating > 40 && dataOBJ.credit_rating < 70){
                $('#credit-rating').append(Math.floor(dataOBJ.credit_rating) + '% <span class="label label-warning">fair</span>');
            }else{
                $('#credit-rating').append(Math.floor(dataOBJ.credit_rating) + '% <span class="label label-success">good</span>');
            }
			$('#total-credit').append("$ " + Math.floor(dataOBJ.total_credit));
			$('#total-debit').append("$ " + Math.floor(dataOBJ.total_debit));
			var creditDate = [];
			var creditAmount = [];

            dataOBJ.credit.forEach(function (datum) {
            	creditDate.push(datum.transc_date);
            	creditAmount.push(datum.amount);
				// console.log(datum);
            })

			var chartdata = {
				labels: creditDate,
				datasets: [
					{
						label: "credit",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgb2a(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: creditAmount
					}
				]
			};

			var ctx = $("#credit-canvas");

			var LineGraph = new Chart(ctx, {
				type: 'line',
				data: chartdata
			});
		},
		error : function(data) {

		}
	});




    $.ajax({
        url : "http://localhost/s2g/test.php?from="+urlParameters.from+"&to="+urlParameters.to,
        type : "GET",
        success : function(data){
            var dataOBJ = JSON.parse(data)
            // console.log();

            var debitDate = [];
            var debitAmount = [];

            dataOBJ.debit.forEach(function (datum) {
                debitDate.push(datum.transc_date);
                debitAmount.push(datum.amount);
            })

            var chartdataDebit = {
                labels: debitDate,
                datasets: [
                    {
                        label: "debit",
                        fill: false,
                        lineTension: 0.1,
                        backgroundColor: "rgba(59, 89, 152, 0.75)",
                        borderColor: "rgba(59, 89, 152, 1)",
                        pointHoverBackgroundColor: "rgb2a(59, 89, 152, 1)",
                        pointHoverBorderColor: "rgba(59, 89, 152, 1)",
                        data: debitAmount
                    }
                ]
            };

            var ctx = $("#debit-canvas");

            var LineGraph = new Chart(ctx, {
                type: 'line',
                data: chartdataDebit
            });
        },
        error : function(data) {

        }
    });
});

function getParameter(url) {
    params = [];
	var tempParams = url.split('?')[1].split('&');
	params['from'] = tempParams[0].split('=')[1];
	params['to'] = tempParams[1].split('=')[1];
	return params;
}