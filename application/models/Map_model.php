<?php

class Map_model extends CI_Model
{
    public function poi($searchString)
    {
     $searchString=   str_replace(" ","%20",$searchString);
    $apiKEY1= 'kD-7pX98T5XIlSYGpYhVleFiwDgv9r0uSjvZkqu9g2I';
// $apiKEY2= '0TczT1jpmulvqKM_5BoSKdvwT5nt-F_jGHj4igNnnIg';
  $apiKEY3= '0jIGreZDZPSXyn2aCUUociIlhy_PyX2OcHZY6LaqhhQ';
        if ($searchString != "") {
             $poi = $this->search($searchString, $apiKEY1);
            if(isset(json_decode($poi)->error)){
                 $poi = $this->search($searchString, $apiKEY3);
            }
            $this->simpanPoi(json_decode($poi)->items);
             return json_decode($poi);
             }else{
                   return "error" ;
             }
    }
    public function cari($searchString)
    {
        $datasql=[];
            $datapoi = $this->datapoi($searchString);
             foreach ($datapoi as $contact)
        {
           $datasql[] = array(
                     'title' => $contact['title'],
                'id' => $contact['id'],
                'language' => $contact['language'],
                'ontologyId' => $contact['ontologyId'],
                'resultType' => $contact['resultType'],
                'address' => json_decode($contact['address'], true),
                 'position' => json_decode($contact['position'], true),
                  'access' => json_decode($contact['access']),
                 'distance' => $contact['distance'],
                  'categories' => json_decode($contact['categories']),
                 'references' => json_decode($contact['references']),
                 'contacts' => json_decode($contact['contacts']),
                );
        }
        $result = new \stdClass();
        $result->items = $datasql;
        return $result;
    }
    public function datapoi($searchString)
    {
        $this->db->select('*');
        $this->db->limit(50);    
        $this->db->like('poi.title', $searchString);  
        
        return  $this->db->get('poi')->result_array();
    }
     public function rute($lat1,$lon1,$lat2,$lon2)
    {
       $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.tomtom.com/routing/1/calculateRoute/$lat1,$lon1:$lat2,$lon2/json?key=A3mftzhTKVbdQxDaYL7PBI9aqrUSefPM&routeType=shortest&travelMode=car",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        return  json_decode($response);
    }
  
    function search($searchString, $key)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://discover.search.hereapi.com/v1/discover?at=-6.123493,106.652051&in=countryCode:IDN&q=$searchString&limit=100&r=10&apiKey=$key",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

       $response = curl_exec($curl);
        return  $response;
    }
    function simpanPoi($data)
    {
        foreach ($data as $contact)
        {
            $datasql[] = array(
                     'title' => $contact->title,
                'id' => $contact->id,
                'language' => $contact->language,
                'resultType' => $contact->resultType,
                'address' => json_encode($contact->address),
                 'position' => json_encode($contact->position),
                 'distance' => $contact->distance,
                );
        }

        $this->db->insert_batch('poi', $datasql); 

        if ($this->db->affected_rows() > 0)
        {
            return TRUE;
        }
        return FALSE;
    }
}
