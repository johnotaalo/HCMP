<style>
	#myModal .modal-dialog {
		width: 70%;
	}
</style>
<script type="text/javascript" charset="utf-8">
			/* Define two custom functions (asc and desc) for string sorting */
			jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
				return ((x < y) ? -1 : ((x > y) ?  1 : 0));
			};
			
			jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
				return ((x < y) ?  1 : ((x > y) ? -1 : 0));
			};
			
			$(document).ready(function() {
				/* Build the DataTable with third column using our custom sort functions */
				$('#datalist').dataTable( {
			 "bSort": false,
					"bJQueryUI": true,
                   "bPaginate": true,
                  "sDom": '<"H"Tfr>t<"F"ip>',
					"oTableTools": {
			"sSwfPath": "<?php echo base_url(); ?>DataTables-1.9.3/extras/TableTools-2.0.0/media/swf/copy_cvs_xls_pdf.swf"
		}
				} );
			} );
		</script>
<div id="dialog"></div>
	<!--<div class="alert alert-info" >
		  <b>Below is the project status in the county</b>
		</div>-->
	 <div id="temp"></div>
	<?php echo @$data; ?>
	<hr/>
	<!--Filter row for the system usage breakdown-->
	<div class="filter row">
		<form class="form-inline" role="form">
			<select id="district_filter" class="form-control col-md-2">
			<option selected="selected" value="NULL">Select Sub-county</option>
			<?php
			
				foreach($district_data as $district_):
						$district_id=$district_->id;
						$district_name=$district_->district;	
						echo "<option value='$district_id'>$district_name</option>";
						//echo "<option value='$district_id'>$district_name</option>";
				endforeach;
			?>
			</select>

			<div class="col-md-3">
			<button class="btn btn-sm btn-small btn-success filter"><span class="glyphicon glyphicon-filter"></span>Filter</button>
			</div> 

		</form>
	</div>
	<div>
		
	</div> 
	<div style="padding-top: 25px;">
	<b>System Usage Breakdown</b>
	<hr />
	
	<div id="facility_monitoring" >
	</div>
	
	</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Facilities Rolled out to</h4>
      </div>
      <div class="modal-body">
      	
        <table  class="table table-hover table-bordered table-update" id="datalist"  >
				<thead style="background-color: white">
				<tr>
				<th>District Name</th>
				<th>MFL No</th>
				<th>Facility Name</th>
				<th>Level</th>
				<th>Type</th>
				<th>Owner</th>
				<th>Date Activated</th>
				</tr>
				</thead>
		<tbody>			   	    
		<?php	foreach($get_facility_data as $detail):
			     $facility_district = $detail['district'];
				 $facility_code = $detail['facility_code'];							
				 $facility_name = $detail['facility_name'];
				 $level= $detail['level'];
				 $type= $detail['type'];
				 $owner = $detail['owner'];
				 $facility_activation_date = $detail['date'] ;?>
				 <tr><td><?php echo $facility_district ;?></td>
				 <td><?php echo $facility_code ;?></td>
				 <td><?php echo $facility_name ;?></td>
				 <td><?php echo $level ;?></td>
				 <td><?php echo $type ;?></td>
				 <td><?php echo $owner;?></td>
				 <td><?php echo $facility_activation_date ;?></td>
				 </td></tr><?php endforeach;?>
				 </tbody></table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
	ajax_request_replace_div_content('reports/monitoring',"#facility_monitoring");
	$(".ajax_call2").click(function(){
		var url = "<?php echo base_url().'reports/get_district_drill_down_detail'?>";
		// this is the data from the function
		var id  = $(this).attr("id"); 				
        var date1=$(this).attr("date"); 
        var  date=encodeURI(date1);
      
	    ajax_special_(url+"/"+id+"/"+date, date1);	
	    
	    });

    function ajax_special_(url,date){
	var url = url;
	 $.ajax({
          type: "POST",
          url: url,
          success: function(msg) {
          	$('.modal-dialog').addClass("modal-lg");
          	var body_content = msg;
          	dialog_box(body_content,'<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
           	 $('#communication_dialog').on('hidden.bs.modal', function (e) {  $('.modal-dialog').removeClass("modal-lg");
   			 $('.modal-body').html(''); })
         
          }
        }); 
	}
	
       
	$( "#district_filter" ).change(function() {
  		$(".filter").click(function(){
		var url = "reports/filter_monitoring/"+$("#district_filter").val();
        	ajax_request_replace_div_content(url,'#facility_monitoring');
        	return
          });
	});
		
		
 	});
</script>
