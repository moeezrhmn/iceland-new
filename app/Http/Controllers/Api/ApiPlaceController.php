<?php

namespace App\Http\Controllers\Api;

use App\Custom\Helpers\CustomHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiPlaceController extends Controller
{
    public function places()
    {
        $xml_object = '<FAB_AccomAvailRQ xmlns="http://www.xmltravel.com/fab/2002/09" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Target="test" Version="2002A" xsi:type="FAB_AccomAvailRQ">
 <SyndicatorInfo SyndicatorId="Digicom_TEST" SyndicatorPassword="NL4M0b8aj3"/>
  <SessionInfo CreateNewSession="true"/>
   <AccommodationSearchRequest ResponseTimeoutSecs="120" ShowDescriptions="true" ShowImages="true">
    <ResultSetPreferences SortCode="cost" MaxItems="200"/>
     <InitialViewInfo Offset="0" Length="200"/> 
     <SearchCriteria NumberOfNights="5" ResortName="Majorca" NumberOfAdults="2" NumberOfKids="0" NumberOfRoomsRequired="1" NumberOfInfants="0"> 
     <StartDateRange StartDate="20180426" EndDate="20180426"/>
      <Suppliers> <Supplier>GA2</Supplier> </Suppliers>
       </SearchCriteria> 
       </AccommodationSearchRequest> 
       </FAB_AccomAvailRQ>';
        $result = CustomHelper::curlRequest($xml_object);
        echo '<pre>';
        print_r($result);
        exit;
        $result = Functions::xml2array($result);
    }
}
