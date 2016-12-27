/*
    THIS code is just for demo purpose. 
    NO support will be provided for this code.
    Do NOT use this for production purporse. 
*/

$(document).ready(function() {
    function randValue() {
        return (Math.floor(Math.random() * (1 + 50 - 20))) + 10;
    }

    

    var chart = c3.generate({
        bindto: '#donut-example',
        data: {
            columns: [
                ['data1', 30],
                ['data2', 50]
            ],
            type:'donut'
        },
    });

});