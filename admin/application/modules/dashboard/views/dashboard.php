<!-- page content -->
<div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row">

        <?php if (!empty($google_analytics_data)) :?>

        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <i class="fa fa-users"></i>
                        Total Users                        
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="count" style="text-align: center;">
                        <span class="chart" data-percent="<?php echo $total_users;?>">
                            <span class="percent"></span>
                        </span>
                    </div>
                    <small>From - <?php echo $from_date;?> To - <?php echo date('Y-m-d');?> </small>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <i class="fa fa-user"></i>
                        New Users                        
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="count" style="text-align: center;">
                        <span class="chart" data-percent="<?php echo $user_details[0][0];?>">
                            <span class="percent"></span>
                        </span>
                    </div>
                    <small>From - <?php echo $from_date;?> To - <?php echo date('Y-m-d');?> </small>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <i class="fa fa-clock-o"></i>
                        Session                        
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="count" style="text-align: center;">
                        <span class="chart" data-percent="<?php echo $sessions[0][0] ;?>">
                            <span class="percent"></span>
                        </span>
                    </div>
                    <small>From - <?php echo $from_date;?> To - <?php echo date('Y-m-d');?> </small>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <i class="fa fa-heartbeat"></i>
                        Bounce Rate                        
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="count" style="text-align: center;">
                        <span class="chart" data-percent="<?php echo $sessions[0][1] ;?>">
                            <span class="percent"></span>
                        </span>
                    </div>
                    <small>From - <?php echo $from_date;?> To - <?php echo date('Y-m-d');?> </small>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Analytic Reports</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div id="echart_line" style="height:350px;"></div>

                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        Device Usage
                        <small>From - <?php echo $from_date;?> To - <?php echo date('Y-m-d');?> </small>
                    </h2>
                    
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div id="echart_pie" style="height:350px;"></div>

                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        Browser Usage
                        <small>From - <?php echo $from_date;?> To - <?php echo date('Y-m-d');?> </small>
                    </h2>

                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div id="echart_pie1" style="height:350px;"></div>

                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">

                    <h2>
                        Source
                        <small>From - <?php echo $from_date;?> To - <?php echo date('Y-m-d');?> </small>
                    </h2>

                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div id="echart_donut" style="height:350px;"></div>

                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">


                    <?php
                        // Heading - 2
                        echo heading(
                            "User Type <small>From - $from_date To - ".date('Y-m-d')." </small>",
                            '2'
                        );

                        $user_type_ul_attributes = array(
                            'class' => 'nav navbar-right panel_toolbox'
                        );

                        $list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');

                        // Ul
                        echo ul($list, $user_type_ul_attributes);
                    ?>

                    <div class="clearfix"></div>

                </div>

                <div class="x_content">
                    <div class="dashboard-widget-content">
                        <div class="col-md-12">

                            <table class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
                                id="datatable-checkbox">
                                <thead>
                                    <tr>
                                        <th>Page URL</th>
                                        <th>Visitors</th>
                                        <th>Page views</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($user_types as $user_type) :?>
                                    <tr>
                                        <td>
                                            <?php echo ($user_type[0] == '/') ? 'Home Page' : $user_type[0]; ?>
                                        </td>
                                        <td>
                                            <?php echo $user_type[1]; ?>
                                        </td>
                                        <td>
                                            <?php echo $user_type[2]; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(!empty($page_not_found_urls)) :?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">


                        <?php
                            // Heading - 2
                            echo heading(
                                "Page Not Found Url",
                                '2'
                            );

                            $user_type_ul_attributes = array(
                                'class' => 'nav navbar-right panel_toolbox'
                            );

                            $list = array('<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>');

                            // Ul
                            echo ul($list, $user_type_ul_attributes);
                        ?>

                        <div class="clearfix"></div>

                    </div>

                    <div class="x_content">
                        <div class="dashboard-widget-content">
                            <div class="col-md-12">

                                <table class="table table-striped table-bordered dt-responsive nowrap jambo_table bulk_action"
                                    id="datatable">
                                    <thead>
                                        <tr>
                                            <th>Page URL</th>
                                            <th>Search Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($page_not_found_urls as $page_not_found_url) : ?>
                                        <tr>
                                            <td>
                                                <?php echo $page_not_found_url->url;?>
                                            </td>
                                            <td>                                            
                                                <?php echo date("m-d-Y", strtotime($page_not_found_url->created_at));?>
                                            </td>                                            
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;?>

        <?php else :?>
                            
            <p style="text-align:center">No Records Found</p>

        <?php endif;?>


    </div>
    <!-- /page content -->

    <?php $this->load->view('dashboard/script'); ?>

<?php if (!empty($google_analytics_data)) : ?>

<?php
$device_usage = '';
$i = 0;
foreach($os as $os_label) :
    $device_usage .= "{ value: $oscount[$i], name: '$os_label' },";
    $i++;
endforeach;

$browser_usage = '';
    $j = 0;

foreach($browser_names as $browser_name) :
    $browser_usage .= "{ value: $browser_users[$j], name: '$browser_name' },";
    $j++;
endforeach;

$source = '';
    $k = 0;

foreach($source_paths as $source_path) :
    $source .= "{ value: $source_count[$k], name: '$source_path' },";
    $k++;
endforeach;

$graph_date = array();
$graph_sessions = array();
$graph_users = array();
$graph_page_views = array();
foreach($graph as $graph_report) :
    $graph_date[] = $graph_report['date'];
    $graph_sessions[] = $graph_report['sessions'];
    $graph_users[] = $graph_report['users'];
    $graph_page_views[] = $graph_report['pageviews'];
endforeach;


?>

    <script>
        function init_chart_doughnut() {
            if ("undefined" != typeof Chart && ($(".canvasDoughnut").length)) {
                var a = {
                    type: "doughnut",
                    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
                    data: {
                        labels: [<?php echo '"' . implode('", "', $os) .'"';?>],
                        datasets: [{
                            data: [<?php echo implode(', ', $oscount);?>],
                            backgroundColor: ["#BDC3C7", "#9B59B6", "#E74C3C", "#26B99A", "#3498DB"],
                            hoverBackgroundColor: ["#CFD4D8", "#B370CF", "#E95E4F", "#36CAAB", "#49A9EA"]
                        }]
                    },
                    options: {
                        legend: !1,
                        responsive: !1
                    }
                };
                $(".canvasDoughnut").each(function () {
                    var b = $(this);
                    new Chart(b, a)
                })
            }
        }

        function init_echarts() {
            if ("undefined" != typeof echarts) {
                console.log("init_echarts");
                var a = {
                    color: ["#26B99A", "#34495E", "#BDC3C7", "#3498DB", "#9B59B6", "#8abb6f", "#759c6a", "#bfd3b7"],
                    title: {
                        itemGap: 8,
                        textStyle: {
                            fontWeight: "normal",
                            color: "#408829"
                        }
                    },
                    dataRange: {
                        color: ["#1f610a", "#97b58d"]
                    },
                    toolbox: {
                        color: ["#408829", "#408829", "#408829", "#408829"]
                    },
                    tooltip: {
                        backgroundColor: "rgba(0,0,0,0.5)",
                        axisPointer: {
                            type: "line",
                            lineStyle: {
                                color: "#408829",
                                type: "dashed"
                            },
                            crossStyle: {
                                color: "#408829"
                            },
                            shadowStyle: {
                                color: "rgba(200,200,200,0.3)"
                            }
                        }
                    },
                    dataZoom: {
                        dataBackgroundColor: "#eee",
                        fillerColor: "rgba(64,136,41,0.2)",
                        handleColor: "#408829"
                    },
                    grid: {
                        borderWidth: 0
                    },
                    categoryAxis: {
                        axisLine: {
                            lineStyle: {
                                color: "#408829"
                            }
                        },
                        splitLine: {
                            lineStyle: {
                                color: ["#eee"]
                            }
                        }
                    },
                    valueAxis: {
                        axisLine: {
                            lineStyle: {
                                color: "#408829"
                            }
                        },
                        splitArea: {
                            show: !0,
                            areaStyle: {
                                color: ["rgba(250,250,250,0.1)", "rgba(200,200,200,0.1)"]
                            }
                        },
                        splitLine: {
                            lineStyle: {
                                color: ["#eee"]
                            }
                        }
                    },
                    timeline: {
                        lineStyle: {
                            color: "#408829"
                        },
                        controlStyle: {
                            normal: {
                                color: "#408829"
                            },
                            emphasis: {
                                color: "#408829"
                            }
                        }
                    },
                    k: {
                        itemStyle: {
                            normal: {
                                color: "#68a54a",
                                color0: "#a9cba2",
                                lineStyle: {
                                    width: 1,
                                    color: "#408829",
                                    color0: "#86b379"
                                }
                            }
                        }
                    },
                    map: {
                        itemStyle: {
                            normal: {
                                areaStyle: {
                                    color: "#ddd"
                                },
                                label: {
                                    textStyle: {
                                        color: "#c12e34"
                                    }
                                }
                            },
                            emphasis: {
                                areaStyle: {
                                    color: "#99d2dd"
                                },
                                label: {
                                    textStyle: {
                                        color: "#c12e34"
                                    }
                                }
                            }
                        }
                    },
                    force: {
                        itemStyle: {
                            normal: {
                                linkStyle: {
                                    strokeColor: "#408829"
                                }
                            }
                        }
                    },
                    chord: {
                        padding: 4,
                        itemStyle: {
                            normal: {
                                lineStyle: {
                                    width: 1,
                                    color: "rgba(128, 128, 128, 0.5)"
                                },
                                chordStyle: {
                                    lineStyle: {
                                        width: 1,
                                        color: "rgba(128, 128, 128, 0.5)"
                                    }
                                }
                            },
                            emphasis: {
                                lineStyle: {
                                    width: 1,
                                    color: "rgba(128, 128, 128, 0.5)"
                                },
                                chordStyle: {
                                    lineStyle: {
                                        width: 1,
                                        color: "rgba(128, 128, 128, 0.5)"
                                    }
                                }
                            }
                        }
                    },
                    gauge: {
                        startAngle: 225,
                        endAngle: -45,
                        axisLine: {
                            show: !0,
                            lineStyle: {
                                color: [
                                    [.2, "#86b379"],
                                    [.8, "#68a54a"],
                                    [1, "#408829"]
                                ],
                                width: 8
                            }
                        },
                        axisTick: {
                            splitNumber: 10,
                            length: 12,
                            lineStyle: {
                                color: "auto"
                            }
                        },
                        axisLabel: {
                            textStyle: {
                                color: "auto"
                            }
                        },
                        splitLine: {
                            length: 18,
                            lineStyle: {
                                color: "auto"
                            }
                        },
                        pointer: {
                            length: "90%",
                            color: "auto"
                        },
                        title: {
                            textStyle: {
                                color: "#333"
                            }
                        },
                        detail: {
                            textStyle: {
                                color: "auto"
                            }
                        }
                    },
                    textStyle: {
                        fontFamily: "Arial, Verdana, sans-serif"
                    }
                };

                if ($("#echart_pie").length) {
                    var h = echarts.init(document.getElementById("echart_pie"), a);
                    h.setOption({
                        tooltip: {
                            trigger: "item",
                            formatter: "{a} <br/>{b} : {c} ({d}%)"
                        },
                        legend: {
                            x: "center",
                            y: "bottom",
                            data: [<?php echo '"' . implode('", "', $os) .'"';?>]
                        },
                        toolbox: {
                            show: !0,
                            feature: {
                                magicType: {
                                    show: !0,
                                    type: ["pie", "funnel"]
                                },
                                saveAsImage: {
                                    show: !0,
                                    title: "Save Image"
                                }
                            }
                        },
                        calculable: !0,
                        series: [{
                            //name: "Area Mode",
                            type: "pie",
                            radius: [25, 90],
                            center: ["50%", 170],
                            roseType: "area",
                            x: "50%",
                            max: 40,
                            sort: "ascending",
                            data: [<?php echo $device_usage;?>]
                        }]
                    })
                }

                if ($("#echart_pie1").length) {
                    var j = echarts.init(document.getElementById("echart_pie1"), a);
                    j.setOption({
                        tooltip: {
                            trigger: "item",
                            formatter: "{a} <br/>{b} : {c} ({d}%)"
                        },
                        legend: {
                            x: "center",
                            y: "bottom",
                            data: [<?php echo '"' . implode('", "', $browser_names) .'"';?>]
                        },
                        toolbox: {
                            show: !0,
                            feature: {
                                magicType: {
                                    show: !0,
                                    type: ["pie", "funnel"],
                                    option: {
                                        funnel: {
                                            x: "25%",
                                            width: "50%",
                                            funnelAlign: "left",
                                            max: 1548
                                        }
                                    }
                                },
                                saveAsImage: {
                                    show: !0,
                                    title: "Save Image"
                                }
                            }
                        },
                        calculable: !0,
                        series: [{
                            type: "pie",
                            radius: "55%",
                            center: ["50%", "48%"],
                            data: [<?php echo $browser_usage; ?>]
                        }]
                    });
                    var k = {
                            normal: {
                                label: {
                                    show: !1
                                },
                                labelLine: {
                                    show: !1
                                }
                            }
                        },
                        l = {
                            normal: {
                                color: "rgba(0,0,0,0)",
                                label: {
                                    show: !1
                                },
                                labelLine: {
                                    show: !1
                                }
                            },
                            emphasis: {
                                color: "rgba(0,0,0,0)"
                            }
                        }
                }

                if ($("#echart_donut").length) {
                    var i = echarts.init(document.getElementById("echart_donut"), a);
                    i.setOption({
                        tooltip: {
                            trigger: "item",
                            formatter: "{a} <br/>{b} : {c} ({d}%)"
                        },
                        calculable: !0,
                        legend: {
                            x: "center",
                            y: "bottom",
                            data: [<?php echo '"' . implode('", "', $source_paths) .'"';?>]
                        },
                        toolbox: {
                            show: !0,
                            feature: {
                                magicType: {
                                    show: !0,
                                    type: ["pie", "funnel"],
                                    option: {
                                        funnel: {
                                            x: "25%",
                                            width: "50%",
                                            funnelAlign: "center",
                                            max: 1548
                                        }
                                    }
                                },
                                saveAsImage: {
                                    show: !0,
                                    title: "Save Image"
                                }
                            }
                        },
                        series: [{
                            name: "Access to the resource",
                            type: "pie",
                            radius: ["35%", "55%"],
                            itemStyle: {
                                normal: {
                                    label: {
                                        show: !0
                                    },
                                    labelLine: {
                                        show: !0
                                    }
                                },
                                emphasis: {
                                    label: {
                                        show: !0,
                                        position: "center",
                                        textStyle: {
                                            fontSize: "14",
                                            fontWeight: "normal"
                                        }
                                    }
                                }
                            },
                            data: [<?php echo $source;?>]
                        }]
                    })
                }

                if ($("#echart_line").length) {
                    var f = echarts.init(document.getElementById("echart_line"), a);
                    f.setOption({
                        tooltip: {
                            trigger: "axis"
                        },
                        legend: {
                            x: 220,
                            y: 40,
                            data: ["Sessions", "Users", "Page Views"]
                        },
                        toolbox: {
                            show: !0,
                            feature: {
                                magicType: {
                                    show: !0,
                                    title: {
                                        line: "Line",
                                        bar: "Bar",
                                        stack: "Stack",
                                        tiled: "Tiled"
                                    },
                                    type: ["line", "bar", "stack", "tiled"]
                                },
                                saveAsImage: {
                                    show: !0,
                                    title: "Save Image"
                                }
                            }
                        },
                        calculable: !0,
                        xAxis: [{
                            type: "category",
                            boundaryGap: !1,
                            data: [<?php echo '"' . implode('", "', $graph_date) .'"';?>]
                        }],
                        yAxis: [{
                            type: "value"
                        }],
                        series: [{
                            name: "Sessions",
                            type: "line",
                            smooth: !0,
                            itemStyle: {
                                normal: {
                                    areaStyle: {
                                        type: "default"
                                    }
                                }
                            },
                            data: [<?php echo implode(', ', $graph_sessions);?>]
                        }, {
                            name: "Users",
                            type: "line",
                            smooth: !0,
                            itemStyle: {
                                normal: {
                                    areaStyle: {
                                        type: "default"
                                    }
                                }
                            },
                            data: [<?php echo implode(', ', $graph_users);?>]
                        }, {
                            name: "Page Views",
                            type: "line",
                            smooth: !0,
                            itemStyle: {
                                normal: {
                                    areaStyle: {
                                        type: "default"
                                    }
                                }
                            },
                            data: [<?php echo implode(', ', $graph_page_views);?>]
                        }]
                    })
                }
            }
        }

        $(document).ready(function () {
            init_chart_doughnut();
            init_echarts();
        });
    </script>

    <?php endif;?>