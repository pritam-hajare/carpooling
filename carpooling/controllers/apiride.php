<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Apiride extends REST_Controller
{	
	function __construct() {
		parent::__construct();
        $this->load->model('trip_model');
        $this->load->model('App_notification_model');
    }

	function get_ride_for_noti_post() {
		$postData = json_decode(file_get_contents("php://input"), true);
		$param['trip_id'] = $postData['tp_id'];
		
		$data=$this->trip_model->get_trip_for_noti($param['trip_id']);	
		if($data!=false){
			$data['state']="A";
			$this->response($data);	
		}
		else{
			$this->response(array('state'=>'NA'));
		}
	}



	function get_trip_full_det_post(){
		$data['error'] = "";
        $data['staus'] = "";
        $data['islogin'] = false;
		$data['user']='';
        $data['tripdetails'] = $this->trip_model->get_tripdetail($id);
		
		if(!empty($data['tripdetails'])){
			
			if (!empty($this->user['user_id'])) 
			{
				$data['islogin'] = true;
				$data['user']=$this->user;
				$data['status'] = $this->check_enquiry($this->user['user_id'], $data['tripdetails']['trip_id']);
			}

			$map = $this->trip_model->getmap_details($data['tripdetails']['trip_id']);
			$this->load->library('googlemaps');
			$config['center'] = $map['origin'];
			$config['zoom'] = 'auto';
			$config['directions'] = TRUE;
			$config['directionsStart'] = $map['origin'];
			$config['directionsEnd'] = $map['destination'];
			$config['directionsWaypointArray'] = $map['route'];
			$config['map_height'] = '230px';
			$config['draggable'] = FALSE;
			$config['scrollwheel'] = FALSE;

			$this->googlemaps->initialize($config);
		
			$data['map'] = $this->googlemaps->create_map();
			
	
			$this->load->view('trip_detail', $data);
		}
		else
		{
			show_error('Not found trip details');
		}
	}

	function get_user_trips_post(){
		$postData = json_decode(file_get_contents("php://input"), true);
		$param['user_id'] = $postData['u_id'];
		
		if(!empty($param['user_id']))
		{
			$data=$this->trip_model->get_trips($param['user_id']);	
			if(sizeof($data["trip_details"])>0){
				$data['state']="A";
				$this->response($data);	
			}
			else{
				$this->response(array('state'=>'NA'));
			}
		}
		else{
			$this->response(array('state'=>'err'));
		}	
	}

	function cancel_trip_post(){
		$trip_det=array();
		$postData = json_decode(file_get_contents("php://input"), true);
		$param['trip_id'] = $postData['tp_id'];
		$param['dr_name'] = $postData['dr_name'];
		$param['user_id'] = $postData['u_id'];
		
		if(!empty($param['user_id']) && !empty($param['trip_id']))
		{	
			//Retrieve trip det for notification
			$trip_det=$this->trip_model->get_trip_for_noti($param['trip_id']);

			if($this->trip_model->cancel_trip($param['trip_id'])){

				$this->db->select('user_id');
        		$this->db->from('tbl_booked_passenger');
        		$this->db->where('tbl_booked_passenger.trip_id',$param['trip_id']);
        		
        		$result = $this->db->get();
        		$result = $result->result_array();

       			$user_id=array();
       			$i=0;
       			//Get user_id of user to send notification
			    foreach($result as $row)
			    {
			        $user_id[$i] = $row['user_id'];
			        $i++;
			    }

			    //Adding driver user id in notification
			    $message['u_id']=$param['user_id'];
			    $message['src']=$trip_det[0]['src'];
			    $message['dest']=$trip_det[0]['dest'];
			    $message['time']=$trip_det[0]['time'];
			    $message['date']=$trip_det[0]['date'];
			    $message['dr_name']=$param['dr_name'];
			    $message['header']='CR';

       			$this->App_notification_model->send_notification($param['user_id'],$message);
				$this->response(array('state'=>'success'));
			}
			else{
				$this->response(array('state'=>'fail'));
			}
		}
		else{
			$this->response(array('state'=>'err'));
		}	
	}

	function offertrip_post() {
		//hi, Git Hub Testing
		$this->load->model('vechicle_model');
		$this->load->model('Travel_model');
		$this->load->model('Trip_model');
		$this->load->model('Enquiry_model');
		$this->load->helper('url');
		
		//Get post data
		$postData = json_decode(file_get_contents("php://input"), true);
		//var_dump($postData);die();
		$this->user_id = $postData['user_id'];
		$user = $this->Travel_model->get_traveller($this->user_id);
		//var_dump($user);die();
		$this->trip_id = $postData['trip_id'];
	
		if ($trip_id) {
			$trip = $this->Trip_model->get_trip($trip_id);
	
			if (!$trip) {
				$this->session->set_flashdata('error', lang('error_not_found'));
				//redirect('addtrip/form');
			}
	
			$route_lanlat = explode('~,', $trip->trip_routes_lat_lan);
			array_shift($route_lanlat);
			array_pop($route_lanlat);
			$latlan = array();
			foreach ($route_lanlat as $route) {
	
				$latlan[] = $route . '~';
			}
			$route_lanlat = implode(',', $latlan);
			$trip_route_ids = explode('~', $trip->trip_routes);
			array_shift($trip_route_ids);
			array_pop($trip_route_ids);
	
			$data['tripid'] = $trip_id;
			$data['vechicletype'] = $trip->trip_vehicle_id;
			$data['txtsource'] = $trip->source;
			$data['txtdestination'] = $trip->destination;
			$data['source_ids'] = $trip->trip_from_latlan;
			$data['destination_ids'] = $trip->trip_to_latlan;
			$trip_route_ids = implode('~', $trip_route_ids);
			$data['jquerytagboxtext'] = $trip_route_ids;
			$data['route_lanlat'] = $route_lanlat;
			$data['return'] = $trip->trip_return;
			$data['depature_time'] = date("g:i a", strtotime($trip->trip_depature_time));
			$data['arrival_time'] = date("g:i a", strtotime($trip->trip_return_time));
			$data['frequency_ids'] = $trip->trip_frequncy;
			$data['avail_seats'] = $trip->trip_avilable_seat;
			$data['number'] = $trip->contact_person_number;
			$data['hour'] = $trip->trip_journey_hours;
			$data['vehnum'] = $trip->vechicle_number;
			$data['comments'] = $trip->trip_comments;
			$fresult = explode(' ', $data['depature_time']);
			$ftime = explode(':', $fresult[0]);
			$tresult = explode(' ', $data['arrival_time']);
			$ttime = explode(':', $tresult[0]);
			$data['fhh'] = $ftime[0];
			$data['thh'] = $ttime[0];
			$data['fmm'] = $ftime[1];
			$data['fzone'] = $fresult[1];
			$data['tmm'] = $ttime[1];
			$data['tzone'] = $tresult[1];
			$save['trip_casual_date'] = $postData['date'];
			$data['frequency_values'] = json_encode(explode(',', str_replace('~', '', $trip->trip_frequncy)));
			$data['passenger_type_id'] = $trip->passenger_type;
			$data['routesdata'] = $trip->route_full_data;
			/*if ($trip->trip_casual_date == '') {
				$rpt_from_date = '';
			} else {
				$rpt_from_date = date('d/m/Y', strtotime(str_replace("/", "-", $trip->trip_casual_date)));
			}*/
			$data['rpt_from_date'] = $rpt_from_date;
			//echo $trip->trip_casual_date;
			//            echo '<pre>';print_r($data);echo'</pre>';
			//            die;
	
		}
	
		$data['vechicletype'] = $postData['vechicletype'];
		$data['txtsource'] = $postData['src'];
		$data['txtdestination'] = $postData['dest'];
		$data['source_ids'] = $postData['source_ids'];
		$data['destination_ids'] = $postData['destination_ids'];
		$data['jquerytagboxtext'] = $postData['jquerytagboxtext'];
		$data['route_lanlat'] = $postData['stopover_point'];
		$data['return'] = $postData['return'];
		$data['departure_time'] = $postData['time'];
		$data['return_time'] = $postData['return_time'];
		$data['frequency_ids'] = $postData['frequency_ids'];
		$data['avail_seats'] = $postData['seats'];
		$data['number'] = $postData['number'];
		$data['comments'] = $postData['comments'];
		$data['routes'] = $postData['stopover'];
		$data['rpt_from_date'] = $postData['date'];
		$data['passenger_type'] = $postData['passenger_type'];
		//$data['tripid'] = $this->trip_id;
		$data['fhh'] = $postData['fhh'];
		$data['thh'] = $postData['thh'];
		$data['fmm'] = $postData['fmm'];
		$data['fzone'] = $postData['fzone'];
		$data['tmm'] = $postData['tmm'];
		$data['tzone'] = $postData['tzone'];
		$data['vehnum'] = $postData['vehnum'];
		$data['routesdata'] = $postData['routesdata'];
		//new
		$data['trip_rate_details'] = $postData['rate'];
		$data['frequency_values'] = json_encode(explode(',', str_replace('~', '', $postData['frequency_ids'])));
		
		if($postData['tripid'] != ''){
			$oldTripId = $postData['tripid'];
			$this->Trip_model->delete_trip_by_edit($oldTripId);
		}
	
	
			$source = $postData['src'];
			$destination = $postData['dest'];
	
			$trip_routes = $source . '~' . $postData['jquerytagboxtext'] . '~' . $destination;
	
	
			$save['trip_id'] = $this->trip_id;
			$save['trip_vehicle_id'] = $postData['vechicle_id'];
			$save['trip_from_latlan'] = $postData['source_ids'];
			$save['trip_to_latlan'] = $postData['destination_ids'];
			$save['trip_routes_lat_lan'] = $postData['source_ids'] . ',' . $postData['stopover_point'] . ',' . $postData['destination_ids'];
	
			$save['trip_routes'] = $trip_routes;
			$save['trip_return'] = $postData['return'];
			$save['source'] = $postData['src'];
			$save['destination'] = $postData['dest'];
			$save['route'] = $postData['stopover'];
			$trip_depature_time = $postData['fhh'] . ':' . $postData['fmm'] . ' ' . $postData['fzone'];
			$save['trip_depature_time'] = date("H:i:s", strtotime($trip_depature_time));
			$save['trip_frequncy'] = $postData['frequency_ids'];
			$save['trip_avilable_seat'] = $postData['seats'];
			$save['trip_comments'] = $postData['comments'];
			$save['trip_user_id'] = $this->user_id;
			$save['trip_casual_date'] = $postData['date'];
			$save['trip_rate_details'] = $postData['rate'];
			$save['passenger_type'] = $postData['passenger_type'];
			$save['contact_person_number'] = $postData['number'];
	
	
			$trip_id = $this->Trip_model->save($save);
	
			if ($postData['return'] == 'yes') {
				$return_destination = $postData['src'];
				$return_source = $postData['txtdestination'];
	
				$return_trip_routes = $postData['jquerytagboxtext'];
				$return_trip_routes = explode('~', $return_trip_routes);
				$return_temp = array();
				for ($i = sizeof($return_trip_routes) - 1; $i >= 0; $i--) {
	
					$return_temp[] = $return_trip_routes[$i];
				}
				$return_trip_routes = $return_temp;
				$return_trip_routes = implode('~', $return_trip_routes);
				$return_trip_routes = $return_source . '~' . $return_trip_routes . '~' . $return_destination;
	
	
				$return_trip_lat_lng = $postData['stopover_point'];
				$return_trip_lat_lng = explode('~', $return_trip_lat_lng);
				$return_temp = array();
				for ($i = sizeof($return_trip_lat_lng) - 1; $i >= 0; $i--) {
	
					$return_temp[] = $return_trip_lat_lng[$i];
				}
				$return_trip_lat_lng = $return_temp;
				$return_trip_lat_lng = implode('~', $return_trip_lat_lng);
	
				$return_route = $postData['stopover'];
				$return_route = explode(',', $return_route);
				$return_temp = array();
				for ($i = sizeof($return_route) - 1; $i >= 0; $i--) {
	
					$return_temp[] = $return_route[$i];
				}
				$return_route = $return_temp;
				$return_route = implode(',', $return_route);

				$param['trip_id'] = $this->trip_id;
				$param['trip_vehicle_id'] = $postData['vechicle_id'];
				$param['trip_from_latlan'] = $postData['destination_ids'];
				$param['trip_to_latlan'] = $postData['source_ids'];
				$param['trip_routes_lat_lan'] = $postData['destination_ids'] . ',' . $return_trip_lat_lng . ',' . $postData['source_ids'];
	
				$param['trip_routes'] = $return_trip_routes;
				$param['trip_return'] = $postData['return'];
				$param['source'] = $postData['dest'];
				$param['destination'] = $postData['src'];
				$param['route'] = $return_route;
				$return_trip_depature_time = $postData['thh'] . ':' . $postData['tmm'] . ' ' . $postData['tzone'];
				$param['trip_depature_time'] = date("H:i", strtotime($return_trip_depature_time));
				$param['trip_frequncy'] = $postData['frequency_ids'];
				$param['trip_avilable_seat'] = $postData['seats'];
				$param['trip_comments'] = $postData['comments'];
				$param['trip_user_id'] = $this->user_id;
				$param['passenger_type'] = $postData['passenger_type'];
				$param['contact_person_number'] = $postData['number'];
				$return_trip_id = $this->Trip_model->save($param);
			}
			//------------------------------------ trip leg concept ------------------------------------------------------------------------
			if (!empty($trip_id)) {
	
				$route_lat = $postData['source_ids'] . ',' . $postData['stopover_point'] . ',' . $postData['destination_ids'];
	
	
	
				$route_lat = rtrim($route_lat, '~');
				$route_lat = explode('~,', $route_lat);
	
				$routes = explode('~', $trip_routes);
				$route_leg_array = array();
				for ($i = 0; $i < sizeof($routes); $i++) {
					$single_route_latlng = ltrim($route_lat[$i], '~');
					$single_route_latlng = explode(',', $single_route_latlng);
					$route_leg_array[$i] = array('point' => $routes[$i], 'latitude' => $single_route_latlng[0], 'longitude' => $single_route_latlng[1]);
				}
	
	
				$trip_time[0] = $trip_depature_time;
				for ($i = 0; $i < sizeof($route_leg_array); $i++) {
					if ($i != sizeof($route_leg_array) - 1) {
						$trip_time[$i + 1] = $this->calculating_time($route_leg_array[$i]['latitude'], $route_leg_array[$i]['longitude'], $route_leg_array[$i + 1]['latitude'], $route_leg_array[$i + 1]['longitude'], $trip_time[$i]);
					}
				}
	
				if ($trip_time[sizeof($trip_time) - 1]) {
					$return_time = array();
					$return_time['trip_id'] = $trip_id;
					$return_time['trip_return_time'] = date("H:i:s", strtotime(end($trip_time)));
					$this->Trip_model->save($return_time);
				}
	
	
				// insert route  leg data onr by one
				$i = 0;
				$j = 0;
				for ($i = 0; $i < sizeof($route_leg_array); $i++) {
					for ($j = $i; $j < sizeof($route_leg_array); $j++) {
						if ($route_leg_array[$i] != $route_leg_array[$j]) {
							$legdata['trip_led_id'] = false;
							$legdata['source_leg'] = $route_leg_array[$i]['point'];
							$legdata['source_latitude'] = $route_leg_array[$i]['latitude'];
							$legdata['source_longitude'] = $route_leg_array[$i]['longitude'];
							$legdata['expected_time'] = $trip_time[$i];
							$legdata['destination_leg'] = $route_leg_array[$j]['point'];
							$legdata['destination_latitude'] = $route_leg_array[$j]['latitude'];
							$legdata['destination_longitude'] = $route_leg_array[$j]['longitude'];
							$legdata['trip_return'] = 0;
							$legdata['trip_id'] = $trip_id;
							$this->Trip_model->save_tripleg($legdata);
						}
					}
				}
			}
	
			if ($postData['return'] == 'yes' && !empty($return_trip_id)) {
	
				$return_route_lat = $postData['destination_ids'] . ',' . $return_trip_lat_lng . ',' . $postData['source_ids'];
	
				$return_route_lat = rtrim($return_route_lat, '~');
				$return_route_lat = explode('~,', $return_route_lat);
	
				$return_routes = explode('~', $return_trip_routes);
				$return_route_leg_array = array();
				for ($i = 0; $i < sizeof($return_routes); $i++) {
					$return_single_route_latlng = ltrim($return_route_lat[$i], '~');
					$return_single_route_latlng = explode(',', $return_single_route_latlng);
					$return_route_leg_array[$i] = array('point' => $return_routes[$i], 'latitude' => $return_single_route_latlng[0], 'longitude' => $return_single_route_latlng[1]);
				}
	
	
				$return_trip_time = array();
				$return_trip_time[0] = $return_trip_depature_time;
	
				for ($i = 0; $i < sizeof($return_route_leg_array); $i++) {
					if ($i != sizeof($return_route_leg_array) - 1) {
						$return_trip_time[$i + 1] = $this->calculating_time($return_route_leg_array[$i]['latitude'], $return_route_leg_array[$i]['longitude'], $return_route_leg_array[$i + 1]['latitude'], $return_route_leg_array[$i + 1]['longitude'], $return_trip_time[$i]);
					}
				}
	
	
				if ($return_trip_time[sizeof($return_trip_time) - 1]) {
					$return_time = array();
					$return_time['trip_id'] = $return_trip_id;
					$return_time['trip_return_time'] = date("H:i", strtotime(end($return_trip_time)));
					$this->Trip_model->save($return_time);
				}
	
				$i = 0;
				$j = 0;
				for ($i = 0; $i < sizeof($return_route_leg_array); $i++) {
					for ($j = $i; $j < sizeof($return_route_leg_array); $j++) {
						if ($return_route_leg_array[$i] != $return_route_leg_array[$j]) {
							$legdata['trip_led_id'] = false;
							$legdata['source_leg'] = $return_route_leg_array[$i]['point'];
							$legdata['source_latitude'] = $return_route_leg_array[$i]['latitude'];
							$legdata['source_longitude'] = $return_route_leg_array[$i]['longitude'];
							$legdata['expected_time'] = $return_trip_time[$i];
							$legdata['destination_leg'] = $return_route_leg_array[$j]['point'];
							$legdata['destination_latitude'] = $return_route_leg_array[$j]['latitude'];
							$legdata['destination_longitude'] = $return_route_leg_array[$j]['longitude'];
							$legdata['trip_return'] = 1;
							$legdata['trip_id'] = $return_trip_id;
							$this->Trip_model->save_tripleg($legdata);
						}
					}
				}
			}
			$this->response(array('state'=>'success'));
	}
	
	function findride_post(){
		$this->load->model('search_model');
		$this->load->model('vechicle_model');
		$this->load->model('category_model');
		$this->load->model('trip_model');
		//Get post data
		$postData = json_decode(file_get_contents("php://input"), true);
		$param = array('SOURCE' => $postData["src"], 'DESTINATION' => $postData['dest'], 'fromlatlng' => $postData['formlatlng'], 'tolatlng' => $postData['tolatlng'], 'frequency' => date('w', strtotime(str_replace("/", "-",$postData['date']))), 'date' => $postData['date'], 'vechiclecategory' => $postData['VECHICATEGORY_FILTER'], 'vechicletype' => $postData['VECHITYPE_FILTER'], 'filter' => $postData['FILTER'], 'amenities' => $postData['AMENITIES_FILTER'], 'traveltype' => $postData['TRAVELTYPE_FILTER'], 'frquencytype' => $postData['FREQUENCY_FILTER'], 'allowtype' => $postData['TRAVELALLOW_FILTER'], 'return' => $postData['Return_Type']);
		
		$offset = $postData['offset'];
		
		if (!empty($param['fromlatlng']) && !empty($param['tolatlng']) && !empty($param['date']))
		{
			$data = $this->search_model->getSearchResults($param, $offset, $data);
			$data = $this->search_model->SearchResults_count($param, $data);
		}
		else
		{
			$data['count'] = '';
			$data['search_results'] = '';
		}
		
		$data['filter'] = $param['filter'];
		
		if (!empty($this->travel))
		{
			$data['travel'] = $this->travel;
		}
		
		$this->response($data);
	}
	
	function calculating_time($source_lat, $source_lng, $destination_lat, $destination_lng, $last_time) {
		$speed = 80;
		$distance = $this->distance($source_lat, $source_lng, $destination_lat, $destination_lng, "K");
	
		$time = $distance / $speed;
	
		$travel_time = $time * 60;
		$startTime = strtotime($last_time);
		$endTime = date("H:i a", strtotime("+" . round($travel_time) . "minutes", $startTime));
		return $endTime;
	}
	
	function distance($lat1, $lon1, $lat2, $lon2, $unit) {
	
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);
	
		if ($unit == "K") {
			$distance = round(($miles * 1.609344));
	
			if ((string) $distance == "NAN") {
				$distance = 0;
			}
			return $distance;
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}
	

}
?>