<?php include("common_pages/internal_header.php");?>

<body>
		<div id="background">
        
        <?php 
        if($this->session->userdata['user_data']['u_type'] == 3)
        {
            include("common_pages/left_pannel_usr.php");
        }
        else 
        {
            include("common_pages/left_pannel.php");
        }
        ?>
        
	<div class="right_panel">
            <div class="message"><?php echo $this->session->flashdata('err_msg');?></div>
            <div class="err_msg"><?php echo $this->session->flashdata('msg');?></div>
            <h2>Schedule Interview</h2>
            
            <input type="hidden" value="<?php echo $app_id; ?>" id="application_id"/>
            
            <div style="float:left; width: 160px;">
            <div id="nav"></div>
            </div>
            <div style="margin-left: 160px;">
             <div id="dp"></div>
            </div>
            <div class="clearfix"></div>
            <a href="<?php echo $url.'jobs/emp_application_details/'.$page.'/'.$job_id?>"><input type="button" value="Go Back"/></a>
	</div>
	
</div>


<?php include("common_pages/inetrnal_footer.php");?>
<script>
    stt = '<?php echo base_url() . 'jobs/list_states/'; ?>';
    cty = '<?php echo base_url() . 'jobs/list_cities/'; ?>';
    create_eve = '<?php echo base_url() . 'jobs/add_appointment/'; ?>';
    added_eve = '<?php echo base_url() . 'jobs/get_appointments/'; ?>';
    update_eve = '<?php echo base_url() . 'jobs/update_appointment/'; ?>';
    ck_veri = '<?php echo $chhck?>';
    
    
    $(document).ready(function() {
    
        var app_id = $('#application_id').val();
        
        var nav = new DayPilot.Navigator("nav");
                nav.showMonths = 3;
                nav.skipMonths = 3;
                nav.selectMode = "week";
                nav.onTimeRangeSelected = function(args) {
                    dp.startDate = args.day;
                    dp.update();
                    loadEvents();
                };
                nav.init();
                
                
                var dp = new DayPilot.Calendar("dp");
                dp.viewType = "Week";
                dp.theme = "calendar_transparent";
                dp.onEventMoved = function (args) {
                    if(ck_veri == 1){
                        intrv_id = args.e.id();
                    }else{
                        intrv_id = app_id;
                    }
                $.post(update_eve, 
                            {
                                id: intrv_id,
                                newStart: args.newStart.toString(),
                                newEnd: args.newEnd.toString()
                            }, 
                            function() {
                                console.log("Moved.");
                            });
                };

                dp.onEventResized = function (args) {
                    if(ck_veri == 1){
                        intrv_id = args.e.id();
                    }else{
                        intrv_id = app_id;
                    }
                    $.post(update_eve, 
                            {
                                id: intrv_id,
                                newStart: args.newStart.toString(),
                                newEnd: args.newEnd.toString()
                            }, 
                            function() {
                                console.log("Resized.");
                            });
                };

                // event creating
                dp.onTimeRangeSelected = function (args) {
                    var name = prompt("New event name:", "Event");
                    dp.clearSelection();
                    if (!name) return;
                    var e = new DayPilot.Event({
                        start: args.start,
                        end: args.end,
                        id: DayPilot.guid(),
                        resource: args.resource,
                        text: name
                    });
                    dp.events.add(e);

                    $.post(create_eve, 
                            {
                                start: args.start.toString(),
                                end: args.end.toString(),
                                name: name,
                                id: app_id
                            }, 
                            function() {
                                console.log("Created.");
                            });

                };

                dp.onEventClick = function(args) {
                    //console.log(args.e.start.tostring());
                    var name = prompt("New event name:", args.e.text());
                    dp.clearSelection();
                    if(ck_veri == 1){
                        intrv_id = args.e.id();
                    }else{
                        intrv_id = app_id;
                    }
                    
                    

                    if (!name) return;
                    $.post(update_eve, 
                            {
                                id: intrv_id,
                                text: name
                            }, 
                            function() {
                                loadEvents();
                                console.log("Renamed.");
                            });
                };

                dp.init();

                loadEvents();

                function loadEvents() {
                    var start = dp.visibleStart();
                    var end = dp.visibleEnd();

                    $.post(added_eve, 
                    {
                        start: start.toString(),
                        end: end.toString()
                    }, 
                    function(data) {
                        //console.log(data);
                        dp.events.list = data;
                        dp.update();
                    });
                }
                
            
 });
</script>