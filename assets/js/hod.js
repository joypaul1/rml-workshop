$(function () {
  "use strict";

  // chart 1

  var options = {
    chart: {
      height: 350,
      type: "area",
      foreColor: "#a6a7a7",
      toolbar: {
        show: false,
      },
    },
    stroke: {
      width: 2.5,
      curve: "smooth",
    },
    dataLabels: {
      enabled: false,
    },
    series: [
      {
        name: "Sales",
        data: [44, 55, 31, 47, 31, 43, 26, 41, 31, 47, 33],
      },
      {
        name: "Visits",
        data: [55, 69, 45, 61, 43, 54, 37, 52, 44, 61, 43],
      },
    ],
    fill: {
      type: "gradient",
      gradient: {
        shade: "light",
        gradientToColors: ["#e100ff", "#00c8ff"],
        shadeIntensity: 1,
        type: "vertical",
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 80, 100],
      },
    },
    grid: {
      show: true,
      borderColor: "rgba(66, 59, 116, 0.15)",
    },
    colors: ["#ff6258", "#0072ff"],
    labels: [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep ",
      "Oct",
      "Nov",
      "Dec",
    ],
    markers: {
      size: 0,
    },
    tooltip: {
      enabled: true,
      theme: "dark",
    },
  };

  var chart = new ApexCharts(document.querySelector("#chart1"), options);

  chart.render();

  // chart 2

  var options = {
    chart: {
      height: 350,
      foreColor: "#a6a7a7",
      type: "bar",
      toolbar: {
        show: false,
      },
    },
    plotOptions: {
      bar: {
        columnWidth: "60%",
        endingShape: "rounded",
        distributed: true,
        //horizontal: false,
        dataLabels: {
          position: "center", // top, center,
        },
      },
    },
    dataLabels: {
      enabled: true,
      formatter: function (val) {
        return val + "";
      },
      offsetY: -20,
      style: {
        fontSize: "12px",
        colors: ["#fff"],
      },
    },
    stroke: {
      width: 1,
    },
    series: [
      {
        name: "Orders",
        data: [15, 20, 30, 40, 30, 20, 15],
      },
    ],
    tooltip: {
      enabled: true,
      theme: "dark",
    },
    grid: {
      show: true,
      borderColor: "rgba(66, 59, 116, 0.15)",
    },
    legend: {
      show: false,
    },
    xaxis: {
      categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
      position: "bottom",
      labels: {
        offsetY: 0,
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    fill: {
      type: "gradient",
      gradient: {
        shade: "light",
        gradientToColors: [
          "#8f50ff",
          "#0072ff",
          "#f1076f",
          "#08a50e",
          "#f7971e",
          "#fc00ff",
          "#000428",
        ],
        shadeIntensity: 1,
        type: "vertical",
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100, 100, 100],
      },
    },
    colors: [
      "#d13adf",
      "#00c8ff",
      "#ff5447",
      "#cddc35",
      "#ffd200",
      "#00dbde",
      "#004e92",
    ],
    yaxis: {
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      labels: {
        show: false,
        formatter: function (val) {
          return val + "%";
        },
      },
    },
  };

  var chart = new ApexCharts(document.querySelector("#chart2"), options);

  chart.render();

  // chart 3

  var options = {
    chart: {
      height: 290,
      type: "radialBar",
      toolbar: {
        show: false,
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
            //color: 'rgba(246, 181, 49, 0.65)',
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
            //color: 'rgba(246, 181, 49, 0.65)',
            opacity: 0.12,
          },
        },

        dataLabels: {
          showOn: "always",
          name: {
            offsetY: -20,
            show: true,
            color: "#000",
            fontSize: "15px",
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
        gradientToColors: ["#f7b733"],
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100],
      },
    },
    colors: ["#fc4a1a"],
    series: [64],
    stroke: {
      //lineCap: 'round',
      dashArray: 4,
    },
    labels: ["Monthly Revenue"],
  };

  var chart = new ApexCharts(document.querySelector("#chart3"), options);

  chart.render();

  // chart 4

  var options = {
    chart: {
      height: 290,
      type: "radialBar",
      toolbar: {
        show: false,
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
            fontSize: "15px",
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
    series: [68],
    stroke: {
      //lineCap: 'round',
      dashArray: 4,
    },
    labels: ["Weekly Revenue"],
  };

  var chart = new ApexCharts(document.querySelector("#chart4"), options);

  chart.render();

  // chart 5

  var options = {
    chart: {
      height: 290,
      type: "radialBar",
      toolbar: {
        show: false,
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
            //color: 'rgba(8, 165, 14, 0.65)',
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
            //color: 'rgba(8, 165, 14, 0.65)',
            opacity: 0.12,
          },
        },

        dataLabels: {
          showOn: "always",
          name: {
            offsetY: -20,
            show: true,
            color: "#000",
            fontSize: "15px",
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
        gradientToColors: ["#08a50e"],
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100],
      },
    },
    colors: ["#cddc35"],
    series: [74],
    stroke: {
      //lineCap: 'round',
      dashArray: 4,
    },
    labels: ["Daily Revenue"],
  };

  var chart = new ApexCharts(document.querySelector("#chart5"), options);

  chart.render();

});
