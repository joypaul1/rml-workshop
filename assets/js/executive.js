$(function () {
  "use strict";

  // chart 4

  var options = {
    chart: {
      height: 200,
      type: "radialBar",
      toolbar: {
        show: true,
      },
    },
    plotOptions: {
      radialBar: {
        //startAngle: -135,
        //endAngle: 225,
        hollow: {
          margin: 0,
          size: "85%",
          background: "transparent",
          image: undefined,
          imageOffsetX: 0,
          imageOffsetY: 0,
          position: "front",
          dropShadow: {
            enabled: true,
            top: 3,
            left: 0,
            blur: 4,
            //color: 'rgba(209, 58, 223, 0.65)',
            opacity: 0.12,
          },
        },
        track: {
          background: "#fff",
          strokeWidth: "30%",
          margin: 0, // margin is in pixels
          dropShadow: {
            enabled: true,
            top: -3,
            left: 0,
            blur: 4,
            //color: 'rgba(209, 58, 223, 0.65)',
            opacity: 0.12,
          },
        },

        dataLabels: {
          showOn: "always",
          name: {
            offsetY: -20,
            show: true,
            color: "#000",
            fontSize: "12px",
          },
          value: {
            formatter: function (val) {
              return val + "%";
            },
            color: "#000",
            fontSize: "40px",
            show: true,
            offsetY: 10,
          },
        },
      },
    },
    fill: {
      type: "gradient",
      gradient: {
        shade: "light",
        type: "horizontal",
        shadeIntensity: 0.5,
        gradientToColors: ["#00dbde"],
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100],
      },
    },
    colors: ["#fc00ff"],
    series: [48],
    stroke: {
      // lineCap: 'round',
      dashArray: 4,
    },
    labels: [new Date().toLocaleDateString("en-US", { month: "long" })],
  };
  var chart = new ApexCharts(document.querySelector("#chart4"), options);

  chart.render();
});
