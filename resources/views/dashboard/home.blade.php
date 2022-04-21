@extends('crm.layouts.template')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<style>
    .mdi-drag {
        cursor: move;
        font-size: 18px
    }
    #sortable .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding:  5px 10px !important
    }
    #sortable .card-header .header-title {
        margin: 0 !important
    }
    #sortable li {
        list-style: none !important;
        padding: !important
    }
    .bar-select {
       border: 1px solid lightgray  !important;
       outline: none !important;
       margin-right: 10px
    }

    .task-pane {
        height: 323px;
        overflow: auto;
    }

        /* width */
    .task-pane::-webkit-scrollbar {
        width: 3px;
    }

    /* Track */
    .task-pane::-webkit-scrollbar-track {
        background: #f1f1f1; 
    }
    
    /* Handle */
    .task-pane::-webkit-scrollbar-thumb {
    background: rgb(89, 198, 202); 
    }

    /* Handle on hover */
    .task-pane::-webkit-scrollbar-thumb:hover {
    background: #555; 
    }
</style>
<div class="container-fluid">
                        
    <!-- start page title --> 
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Phoenix</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">CRM</li>
                    </ol>
                </div>
                <h4 class="page-title">CRM</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    {{-- <button class="btn btn-primary" type="submit">.ripple</button> --}}

    <div class="row">
        <div class="col-md-6 px-1 col-xl-3">
            <div class="card shadow-sm" style="background:linear-gradient(-30deg, #6AD5E6,#B1ECEC)">
                <div class="card-body p-2 d-flex flex-x"> 
                    <div>
                        <h3 class="mt-0">{{ $open_task ?? 0 }}</h3> 
                        <h5 class="m-0 text-dark" title="Total Tasks">Open Tasks</h5>
                    </div>
                    <div>
                        <i class="mdi-clipboard-check-multiple mdi text-white fa-2x float-end"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 px-1 col-xl-3">
            <div class="card shadow-sm" style="background:linear-gradient(-30deg, #6AD5E6,#B1ECEC)">
                <div class="card-body p-2 d-flex flex-x"> 
                    <div>
                        <h3 class="mt-0">{{ $today_count ?? 0 }}</h3> 
                        <h5 class="m-0 text-dark" title="Total Tasks">Today Tasks</h5>
                    </div>
                    <div>
                        <i class="mdi-clipboard-check-multiple mdi text-white fa-2x float-end"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 px-1 col-xl-3">
            <div class="card shadow-sm" style="background:linear-gradient(-30deg, #6AD5E6,#B1ECEC)">
                <div class="card-body p-2 d-flex flex-x"> 
                    <div>
                        <h3 class="mt-0">{{ $closed_count ?? '' }}</h3> 
                        <h5 class="m-0 text-dark" title="Total Tasks">Closed Tasks</h5>
                    </div>
                    <div>
                        <i class="mdi-clipboard-check-multiple mdi text-white fa-2x float-end"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 px-1 col-xl-3">
            <div class="card shadow-sm" style="background:linear-gradient(-30deg, #6AD5E6,#B1ECEC)">
                <div class="card-body p-2 d-flex flex-x"> 
                    <div>
                        <h3 class="mt-0">{{ $planned_count ?? 0 }}</h3> 
                        <h5 class="m-0 text-dark" title="Total Tasks">Planed Tasks</h5>
                    </div>
                    <div>
                        <i class="mdi-clipboard-check-multiple mdi text-white fa-2x float-end"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row --> 
    <!-- end row-->
    @include('dashboard.drag._dragula')
    
</div> 
@php
    $enc = json_encode($close_week);
    $done = json_encode($planned_done);
@endphp
@endsection

@section('add_on_script')
    <script src="{{ asset('assets/js/vendor/dragula.min.js') }}"></script>
    <script src="{{ asset('assets/js/ui/component.dragula.js') }}"></script>

    <!-- third party:js -->
    <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
    <!-- third party end -->
    <!-- demo:js -->
    <script>
        var cweek = '<?= $enc ?>';
        var cdone = '<?= $done ?>';
        cweek = JSON.parse(cweek);
        cdone = JSON.parse(cdone);
        var colors=["#727cf5","#0acf97","#fa5c7c"],dataColors=$("#basic-column").data("colors");
        dataColors&&(colors=dataColors.split(","));
        var options={
            chart:{height:250,type:"bar",toolbar:{show:!1}},
            plotOptions:{bar:{horizontal:!1,endingShape:"rounded",columnWidth:"55%"}},
            dataLabels:{enabled:!1},
            stroke:{show:!0,width:2,colors:["transparent"]},
            colors:colors,
            series:[
                {name:"Tasks",data:cweek.task},
                {name:"Leads",data:cweek.lead},
                {name:"Deals",data:cweek.deal}
            ],
            xaxis:{
                categories:cweek.month
            },
            legend:{offsetY:7},
            yaxis:{title:{text:"Count"}},
            fill:{opacity:1},
            grid:{
                row:{
                    colors:["transparent","transparent"],opacity:.2
                },
                borderColor:"#f1f3fa",padding:{bottom:5}
            },
            tooltip:{
                y:{formatter:function(o){return"$ "+o+" thousands"}}
            }
        },
        chart=new ApexCharts(document.querySelector("#basic-column"),options);
        chart.render();
        // 
        $('#close_week_type').change(function(){
            var close_week_type = $('#close_week_type').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('get-closeweek-data') }}",
                method:'POST',
                data: { close_week_type:close_week_type},
                success:function(response){
                    console.log( response.lead );
                    chart.updateSeries([{
                        name: 'Tasks',
                        data: response.task
                    },{
                        name: 'Leads',
                        data: response.lead
                    },{
                        name: 'Deals',
                        data: response.deal
                    } 
                ])
                }      
            });
        });

    

        $('#from_type').change(function(){
            var from_type = $('#from_type').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('get-planned-data') }}",
                method:'POST',
                data: { from_type:from_type},
                success:function(response){
                    $('#planned_done').html(response);
                }      
            });
        });

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        function allowDrop(ev) {
            ev.preventDefault();
        }
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
     
        $( function() {
            $("#sortable").sortable({
                update: function(event, ui) {
                    let $lis = $(this).children('li');
                    let sortableOrder = [];
                    let columnClass = [];
                    $lis.each(function() {
                        var $li = $(this).attr('id');
                        var $class = ($(this).hasClass('col-12')) ? "col-12" : "col-6";
                        sortableOrder.push($li);
                        columnClass.push($class)
                    });
                    $.post('{{route("save.dashboard_position")}}',{data: [sortableOrder, columnClass]})
                }
            });
        });
        function change_view_length(prams) {
            $(`#${prams}`).toggleClass("col-12")
        } 
    </script>
    <script>
        //   Deals Started
        var xValues = ["0", "1", "2", "3", "4"];
        var yValues = [55, 49, 44, 24, 15];
        var barColors = ["#10B9F1", "lightgray","#10B9F1","lightgray","#10B9F1"];
    
        //  Deals Wond
        var DWxValues = [
            "JAN",
            "FEB",
            "MAR",
            "APRL",
            "MAY",
            "JUN",
            "JUL",
            "AUG",
            "SEP",
            "OCT",
            "NOV",
            "DEC"
        ];
        var DWyValues = [22,45,87,22,44,99,44,35,15,99,20,70];
        var DWbarColors = ["#10B9F1", "lightgray","#10B9F1","lightgray","#10B9F1", "lightgray","#10B9F1","lightgray","#10B9F1", "lightgray","#10B9F1","lightgray"];
        
        new Chart("myChart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
            backgroundColor: barColors,
            data: yValues
            }]
        },
        options: {
            legend: {display: false}, 
        }
        });

        new Chart("myChart-deals-won", {
        type: "bar",
        data: {
            labels: DWxValues,
            datasets: [{
            backgroundColor: DWbarColors,
            data: DWyValues
            }]
        },
        options: {
            legend: {display: false}, 
        }
        });


        new Chart("myChart-deals-progress", {
        type: "bar",
        data: {
            labels: DWxValues,
            datasets: [{
            backgroundColor: DWbarColors,
            data: DWyValues
            }]
        },
        options: {
            legend: {display: false}, 
        }
        });

        new Chart("myChart-deals-conversion", {
            type: "bar",
            data: {
                labels: DWxValues,
                datasets: [{
                backgroundColor: DWbarColors,
                data: DWyValues
                }]
            },
            options: {
                legend: {display: false}, 
            }
        });
    </script>
    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        
        function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Contry', 'Mhl'],
        ['Italy',54.8],
        ['France',48.6],
        ['Spain',44.4],
        ['USA',23.9],
        ['Argentina',14.5]
        ]); 
        
        var chart = new google.visualization.PieChart(document.getElementById('myChart-pie'));
        chart.draw(data);
        }
    </script>
@endsection