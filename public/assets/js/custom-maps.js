// jQuery
$.getScript('https://cdnjs.cloudflare.com/ajax/libs/echarts/4.8.0/echarts.min.js', function()
{

function renderstatemap(title, subtitle, mapdata, max) {
	var dom = document.getElementById("usastatemap");
	window.myChart = echarts.init(dom);
	var app = {};
	option = null;
	myChart.showLoading();

	$.get(usa, function (usaJson) {
	    myChart.hideLoading();

	    echarts.registerMap('USA', usaJson, {
	        Alaska: {              // 把阿拉斯加移到美国主大陆左下方
	            left: -131,
	            top: 25,
	            width: 15
	        },
	        Hawaii: {
	            left: -110,        // 夏威夷
	            top: 28,
	            width: 5
	        },
	        'Puerto Rico': {       // 波多黎各
	            left: -76,
	            top: 26,
	            width: 2
	        }
	    });
	    option = {
	        title: {
	            text: title,
	            subtext: subtitle,
	            left: 'right'
	        },
	        tooltip: {
	            trigger: 'item',
	            showDelay: 0,
	            transitionDuration: 0.2,
	            formatter: function (params) {
	                var value = (params.value + '').split('.');
	                value = value[0].replace(/(\d{1,3})(?=(?:\d{3})+(?!\d))/g, '$1,');
	                return params.seriesName + '<br/>' + params.name + ': ' + value;
	            }
	        },
	        visualMap: {
	            left: 'right',
	            min: 0,
	            max: max,
	            inRange: {
	                color: ['#DBE6F0', '#B3CCE6', '#85B2E0', '#5299E0', '#5299E0', '#5299E0', '#004C99']
	            },
	            text: ['High', 'Low'],           // 文本，默认为数值文本
	            calculable: true
	        },
	        toolbox: {
	            show: true,
                     left: 'left',
	            top: 'top',
  feature: {
      mark: { show: true },
      magicType: { show: true
    },
    saveAsImage: { show: true, title: "Save as Image" }
  }
	        },
	        series: [
	            {
	                name: 'Total',
	                type: 'map',
	                roam: true,
	                map: 'USA',
	                emphasis: {
	                    label: {
	                        show: true
	                    }
	                },
	                // 文本位置修正
	                textFixed: {
	                    Alaska: [20, -20]
	                },
	                data: mapdata
	            }
	        ]
	    };

	    myChart.setOption(option);
	});;
	if (option && typeof option === "object") {
	    myChart.setOption(option, true);
	}
}
var base_url = window.location.origin;
 var usa = base_url+"/public/assets/js/usa.json";
  $(function () {

        $.get(
                base_url+"/state/map/data",
        {view:$('#customstatemap').data("view")},
                function (data) {
                    var res=jQuery.parseJSON(data)                 
                     renderstatemap(res.title,res.subtitle, res.data, res.max );                
                }
        );
});;
});