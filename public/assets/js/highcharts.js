function showStockChart(elementMarker, titre, series){
    $(elementMarker).highcharts('StockChart', {
        title : {
            text : titre
        },

        rangeSelector : {
            selected    : 5,
            inputEnabled: $(elementMarker).width() > 480
        },

        series : series
    });
}

Highcharts.setOptions({
    lang: {
        months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',  'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        shortMonths: [ "Jan" , "Feb" , "Mar" , "Avr" , "Mai" , "Juin" , "Juil" , "Aou" , "Sep" , "Oct" , "Nov" , "Dec"]
    }
});

function HighchartsGraph(target, series, titre, xTitre, yTitre) {

    var chartoptions = {
        global: { 
            useUTC: false
        },
        chart: {
            renderTo: target,
            //margin: [0, 10, 25, 10],
            borderRadius: 0,
            //backgroundColor: '#ffffff'
        },
        title: {
            text: titre
        },
        //colors: ['#0088cc', '#339900'],
        credits: {
            enabled: false
        },
        legend: {
            enabled: true
        },
        plotOptions: {
            area: {
                lineWidth: 2.5,
                fillOpacity: .1,
                marker: {
                    //lineColor: '#fff',
                    lineWidth: 1,
                    radius: 3.5,
                    symbol: 'circle'
                },
                shadow: false
            },
            column: {
                lineWidth: 16,
                shadow: false,
                borderWidth: 0,
                groupPadding: .05
            }
        },
        xAxis: {
            type: 'datetime',
            title: {
                text: xTitre
            },
            tickmarkPlacement: 'on',
            dateTimeLabelFormats: {
                day: '%b %e'
            },
            //gridLineColor: '#eeeeee',
            //gridLineWidth: .5,
            /*labels: {
                style: {
                    //color: '#999999'
                }
            }*/
        },
        yAxis: [
            {
                //offset: -30,
                //showFirstLabel: true,
                //showLastLabel: false,
                title: {
                    text: yTitre
                },
                //gridLineColor: '#eeeeee',
                //gridLineWidth: .5,
                //zIndex: 2,
                /*labels: {
                    align: 'left',
                    style: {
                        //color: '#999999'
                    }
                }*/
            }
        ],
        tooltip: {
            shadow: false,
            borderRadius: 3,
            shared: true,
            /*formatter: function() {
                var line1 = '<span style="font-size: 10px">' + moment(this.x).format('dddd, MMM D, YYYY') + '</span>';
                var line2 = '<span style="color: #08c">People:</span>  <b>' + this.points[0].y + '</b>';
                var line3 = '<span style="color: #390">Conversions:</span>  <b>' + this.points[1].y + '</b>';
                return line1 + '<br />' + line2 + '<br />' + line3;
            }*/
        },
        series: []
    };

    var currentChartIndex = 0;
    for(var i in series){
        if(series[i].data.length > 0){
            chartoptions.series[currentChartIndex] = series[i].header;
            chartoptions.series[currentChartIndex].data = series[i].data;
            currentChartIndex++;
        }
    }
    
    chartoptions.chart.renderTo = $('#' + target)[0];
    
    var graph = new Highcharts.Chart(chartoptions);

}

function getGraph(target, metrics, start, end, titre, xTitre, yTitre) {

    $('#' . target).html('<div style="padding: 40px 0 0 0; text-align: center; font-size: 18px"><i class="fa fa-spinner fa fa-spin"></i></div>');
    
    var jsonurl = 'api/graph?1=1';

    if(metrics.length <= 0){
        return;
    }

    for (var i = 0; i < metrics.length; i++) {
        jsonurl += '&metrics[]=' + metrics[i];
    }

    if (typeof location.search == 'string' && location.search.length > 0)
            jsonurl += '&' + location.search.substring(1);

    if (typeof start != 'undefined' && typeof end != 'undefined' && start != null & end != null)
        jsonurl += '&start=' + encodeURIComponent(start) + '&end=' + encodeURIComponent(end);

    $.getJSON(jsonurl, function(data) {

        if (data.length == 0) {
            $('#' . target).html(nodata.html());
        } else {
            var series = [];
            for (var i in data.graph) {
                var row = data.graph[i];
                var header = data.header[i];
                series[i] = {'data' : [], 'header' : header};
                for(var j in row){
                    series[i].data.push([moment(row[j][0]).valueOf(), parseFloat(row[j][1])]);
                }
            }
            HighchartsGraph(target, series, titre, xTitre, yTitre);

        }

    });

}