(function($) {

    "use strict"; // Start of use strict

    var SufeeAdmin = {

        lineFlot: function() {
            var sin = [],
                cos = [];

            for (var i = 0; i < 10; i += 0.1) {
                sin.push([i, Math.sin(i)]);
                cos.push([i, Math.cos(i)]);
            }

            var plot = $.plot("#flot-line", [
                {
                    data: sin,
                    label: "sin(x)"
                },
                {
                    data: cos,
                    label: "cos(x)"
                }
            ], {
                series: {
                    lines: {
                        show: true
                    },
                    points: {
                        show: true
                    }
                },
                yaxis: {
                    min: -1.2,
                    max: 1.2
                },
                colors: ["#00c292", "#F44336"],
                grid: {
                    color: "#fff",
                    hoverable: true,
                    borderWidth: 0,
                    backgroundColor: 'transparent'
                },
                tooltip: true,
                tooltipOpts: {
                    content: "'%s' of %x.1 is %y.4",
                    shifts: {
                        x: -65,
                        y: 25
                    }
                }
            });
        },

        pieFlot: function() {
            var data = [
                {
                    label: " Data 1",
                    data: 2,
                    color: "#8fc9fb"
                },
                {
                    label: " Data 2",
                    data: 4,
                    color: "#007BFF"
                },
                {
                    label: " Data 3",
                    data: 7,
                    color: "#00c292"
                },
                {
                    label: " Data 4",
                    data: 15,
                    color: "#F44336"
                },
                {
                    label: " Data 5",
                    data: 10,
                    color: "#32c39f"
                }
            ];

            var plotObj = $.plot($("#flot-pie"), data, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        label: {
                            show: false,
                        }
                    }
                },
                grid: {
                    hoverable: true
                },
                tooltip: {
                    show: true,
                    content: "%p.0%, %s, n=%n", // show percentages, rounding to 2 decimal places
                    shifts: {
                        x: 20,
                        y: 0
                    },
                    defaultTheme: false
                }
            });
        },

        line2Flot: function() {
            // First chart
            var chart1Options = {
                series: {
                    lines: {
                        show: true
                    },
                    points: {
                        show: true
                    }
                },
                xaxis: {
                    mode: "time",
                    timeformat: "%m/%d",
                    minTickSize: [1, "day"]
                },
                grid: {
                    hoverable: true
                },
                legend: {
                    show: false
                },
                grid: {
                    color: "#fff",
                    hoverable: true,
                    borderWidth: 0,
                    backgroundColor: 'transparent'
                },
                tooltip: {
                    show: true,
                    content: "y: %y"
                }
            };
            var chart1Data = {
                label: "chart1",
                color: "#007BFF",
                data: [
                    [1354521600000, 6322],
                    [1354840000000, 6340],
                    [1355223600000, 6368],
                    [1355306400000, 6374],
                    [1355487300000, 6388],
                    [1355571900000, 6400]
                ]
            };
            $.plot($("#chart1"), [chart1Data], chart1Options);
        },
        barFlot: function(){
            // Prepare data for plotting
            var flotBarData = {
                label: "Attendance Rate",
                color: "#007BFF",
                data: attendanceData.map(function(item, index) {
                    return [index + 1, item.attendance_rate]; // x = session number (1, 2, 3, etc.)
                })
            };
        
            // Chart options
            var flotBarOptions = {
                series: {
                    bars: {
                        show: true,
                        barWidth: 0.6, // Set to a value less than 1 for centering effect
                        align: "center" // Center the bars
                    }
                },
                xaxis: {
                    tickLength: 0,   // Remove tick lines
                    tickDecimals: 0, // No decimal points
                    ticks: attendanceData.map(function(item, index) {
                        // Keep the session number as x-axis ticks (1, 2, 3, etc.)
                        return [index + 1, "Session " + (index + 1)];
                    }),
                    tickFormatter: function (val, axis) {
                        return "Session " + val;
                    },
                    // Rotate labels vertically
                    rotateTicks: 90 // Rotate tick labels by 90 degrees
                },
                grid: {
                    hoverable: true,
                    color: "#fff",
                    borderWidth: 0,
                    backgroundColor: 'transparent'
                },
                tooltip: true,
                tooltipOpts: {
                    content: "Session: %x, Attendance Rate: %y%", // Tooltip content with session number and attendance rate
                    shifts: {
                        x: -60,
                        y: 25
                    },
                    defaultTheme: false
                },
                legend: {
                    show: false
                }
            };
        
            // Plotting the data
            $.plot($("#flotBar"), [flotBarData], flotBarOptions);
        }
        
        
        
,        
        
        
        
        plotting: function() {
            var d1 = [[20, 20], [30, 34], [42, 60], [54, 20], [80, 90]];

            // Flot options
            var options = {
                legend: {
                    show: false
                },
                series: {
                    label: "Curved Lines Test",
                    curvedLines: {
                        active: true,
                        nrSplinePoints: 20
                    }
                },

                grid: {
                    color: "#fff",
                    hoverable: true,
                    borderWidth: 0,
                    backgroundColor: 'transparent'
                },
                tooltip: {
                    show: true,
                    content: "%s | x: %x; y: %y"
                },
                yaxes: [{
                    min: 10,
                    max: 90
                }, {
                    position: 'right'
                }]
            };

            // Plotting
            $.plot($("#flotCurve"), [
                {
                    data: d1,
                    lines: {
                        show: true,
                        fill: true,
                        fillColor: "rgba(0,123,255,.15)",
                        lineWidth: 3
                    },
                    // Curve the line  (old pre 1.0.0 plotting function)
                    curvedLines: {
                        apply: true,
                        show: true,
                        fill: true,
                        fillColor: "rgba(0,123,255,.15)",
                    }
                }, {
                    data: d1,
                    points: {
                        show: true,
                        fill: true,
                        fillColor: "rgba(0,123,255,.15)",
                    }
                }
            ], options);
        }
    };

    $(document).ready(function() {
    //    SufeeAdmin.pieFlot();
       // SufeeAdmin.line2Flot();
        SufeeAdmin.barFlot(); 
      /*  SufeeAdmin.plotting();*/
    });

})(jQuery);
