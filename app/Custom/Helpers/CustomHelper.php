<?php

namespace App\Custom\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Custom\Helpers\CustomAdminHelper;
use Illuminate\Support\Facades\URL;

class CustomHelper
{

	use CustomAdminHelper;

	// this contains variables to be used every where like Post slug
	private $global;
	private $http_protocol = '';
	private $main_url      = '';

	function __construct() {
		$this->global        = [];
		$this->http_protocol = ! isset( $_SERVER['SERVER_PROTOCOL'] ) ? 'http://' : ( stripos( $_SERVER['SERVER_PROTOCOL'], 'https' ) === true ? 'https://' : 'http://' );
		$this->main_url      = Config::get( 'app.url' ) . '/';
	}

	function getProtocol() {
		return $this->http_protocol;
	}

	function mainurl() {
		return $this->main_url;
	}

	public function get_menus( $menu = false ) {
		$menubars = [
			'main'   => [],
			'admin'  => [],
			'active' => ( isset( $this->getPathActions()['as'] ) ) ? $this->getPathActions()['as'] : '',
		];
		if ( $menu ) {
			$menubars = isset( $menubars[ $menu ] ) ? $menubars[ $menu ] : false;
		}

		return $menubars;
	}

	public function get_frontend_menu_html( $menu = 'main', $listClass = '' ) {
		return $this->generate_navigation( $this->get_menus()[ $menu ], 1, $listClass );
	}

	public function getPathActions() {
		if ( is_null( Route::getCurrentRoute() ) ) {
			return NULL;
		}

		return Route::getCurrentRoute()->getAction();
	}

	public function getPreviousLink() {
		$url = URL::previous();
		if ( strpos( $url, 'register' ) === false || strpos( $url, 'login' ) === false ) {
			$url = ( $this->is_admin() ) ? $this->getPageUrl( 'admin::dashboard.index' ) : '/';
		}

		return $url;
	}

	public function getPageUrl( $page, $args = [] ) {
		if ( is_int( strpos( $page, '|' ) ) ) {
			$args = explode( '|', $page );
			$page = $args[0];
			unset( $args[0] );
		}

		if ( is_int( strpos( $page, '.' ) ) ) {
			$url = route( $page, $args );
		}
		else if ( is_int( strpos( $page, '@' ) ) ) {
			$url = action( $page, $args );
		}
		else if ( $page == '/' ) {
			$url = url( $page, $args, request()->isSecure() );
		}
		else {
			$url = url( ( is_int( strpos( $page, '/' ) ) ? '' : '/' ) . $page, $args, request()->isSecure() );
		}

		return $url;
	}

	public function get_current_page( $returnArray = false ) {
		$page = isset( CustomHelper::getPathActions()['as'] ) ? CustomHelper::getPathActions()['as'] : '';

		return $returnArray ? explode( "::", $page ) : $page;
	}

	public function get_asset_path( $dir ) {
		return public_path( 'assets/' . $dir . '/' );
	}

	/**
	 * @return array
	 */
	public function getGlobal( $key ) {
		return $this->global[ $key ];
	}

	/**
	 * @param      $key
	 * @param null $value
	 *
	 * @internal param array $global
	 */
	public function convert_path_to_url( $path, $cutFolder = 'public' ) {
		return url( str_replace( [ base_path(), $cutFolder, "\\", "//" ], [ '', '', '/', '/' ], $path ) );
	}
    public static function validator($request, $rules)
    {
        return $validator = Validator::make($request, $rules);
    }
    public static function json_error($error = false)
    {
        return response()->json(array('status' => false, 'message' => $error));
    }
    public static function json_success($msg = false, $data = false)
    {
        return response()->json(array('status' => true, 'date' => date('Y-m-d'), 'message' => $msg, 'data' => $data));
    }
    static function curlRequest($xml)
    {
        $xml_object = '
<GetStaticDataResult>
  <Products>
    <Product>
      <ProjectCode>Test Product</ProjectCode>
      <Description>Test Travel</Description>
      <Cost1>0</Cost1>
      <Cost2>0</Cost2>
      <Cost3>0</Cost3>
      <StartDate>19 Nov 2008</StartDate>
      <EndDate>31 Dec 2020</EndDate>
      <DaysBeforeDeparture>56</DaysBeforeDeparture>
      <BalanceDueDate>01 Jan 1900</BalanceDueDate>
      <PMCode/>
      <CTGProfile/>
      <SuppressAirlines>
        <AirlineCode>AS</AirlineCode>
        <AirlineCode>da</AirlineCode>
      </SuppressAirlines>
    </Product>
  </Products>
  <MasterProducts>
    <MasterProduct>
      <PMCode>TESTKEVIN</PMCode>
      <Description>Test Master Product Kevin</Description>
    </MasterProduct>
    <MasterProduct>
      <PMCode>LRA</PMCode>
      <Description>LRW Test master product A</Description>
      <Languages>
        <Language>
          <LanguageId>1</LanguageId>
          <LanguageCode>EN</LanguageCode>
          <LanguageDescription>English</LanguageDescription>
          <IsDefault>false</IsDefault>
        </Language>
        <Language>
          <LanguageId>2</LanguageId>
          <LanguageCode>FR</LanguageCode>
          <LanguageDescription>French</LanguageDescription>
          <IsDefault>false</IsDefault>
        </Language>
      </Languages>
    </MasterProduct>
    <MasterProduct>
      <PMCode>TESTB</PMCode>
      <Description>Test B</Description>
      <Languages>
        <Language>
          <LanguageId>1</LanguageId>
          <LanguageCode>EN</LanguageCode>
          <LanguageDescription>English</LanguageDescription>
          <IsDefault>false</IsDefault>
        </Language>
      </Languages>
      <Currencies>
        <Currency>
          <CurrencyId>2</CurrencyId>
          <CurrencyCode>EUR</CurrencyCode>
          <CurrencyDescription>Euro</CurrencyDescription>
          <IsDefault>false</IsDefault>
        </Currency>
        <Currency>
          <CurrencyId>1</CurrencyId>
          <CurrencyCode>GBP</CurrencyCode>
          <CurrencyDescription>Sterling</CurrencyDescription>
          <IsDefault>true</IsDefault>
        </Currency>
      </Currencies>
    </MasterProduct>
  </MasterProducts>
  <Airports>
    <Airport>
      <AirportCode>LON</AirportCode>
      <Name>London Airports</Name>
      <Type>Departure</Type>
      <Domestic>OverSeas</Domestic>
      <PortType>Airport</PortType>
      <Latitude/>
      <Longitude/>
      <RegionName/>
      <RegionCode/>
    </Airport>
    <Airport>
      <AirportCode>LGW</AirportCode>
      <Name>London, Gatwick</Name>
      <Type>Departure</Type>
      <Domestic>UK</Domestic>
      <PortType>Airport</PortType>
      <Latitude>62.46670000</Latitude>
      <Longitude>6.16670000</Longitude>
      <RegionName>London Airports</RegionName>
      <RegionCode>LON</RegionCode>
    </Airport>
  </Airports>
  <Locations>
    <Location>
      <location>Test Location</location>
      <resort/>
    </Location>
  </Locations>
  <Resorts>
    <Resort>
      <resort>Abu Dhabi</resort>
      <Region>Abu Dhabi</Region>
      <country>UAE</country>
      <SubRegion/>
      <CTGGuid>{FB7E397C-4C4E-4242-8E45-0CED341F1E8A}</CTGGuid>
      <Latitude>24.470000</Latitude>
      <Longitude>54.38000000</Longitude>
    </Resort>
  </Resorts>
  <CarHireResorts>
    <location>Test Location</location>
    <resort>Test Resort</resort>
  </CarHireResorts>
  <ResortGateways>
    <Gateway>
      <AirportName>AUH</AirportName>
      <Resorts>
        <Resort>Abu Dhabi</Resort>
      </Resorts>
    </Gateway>
    <Gateway>
      <AirportName>BGI</AirportName>
      <Resorts>
        <Resort>Barbados</Resort>
        <Resort>South Coast</Resort>
        <Resort>West Coast</Resort>
      </Resorts>
    </Gateway>
  </ResortGateways>
  <AccomGateways>
    <Gateway>
      <AirportName>AUH</AirportName>
      <Resorts>
        <Resort>
          <Name>Abu Dhabi</Name>
          <Accoms>
            <Accom HCode="HOT0000881">Beach Rotana Hotel and Towers</Accom>
            <Accom HCode="HOT0000874">Hilton Abu Dhabi</Accom>
            <Accom HCode="HOT0000876">Intercontinental Abu Dhabi</Accom>
            <Accom HCode="HOT0000894">Shangri La Hotel Qaryat Al Beri</Accom>
            <Accom HCode="HOT0000906">Sheraton Abu Dhabi</Accom>
          </Accoms>
        </Resort>
      </Resorts>
    </Gateway>
  </AccomGateways>
  <Accommodation>
    <Hotel>
      <Name>The Villas at Grand Cypress Elliot</Name>
      <Hcode>HOT0000818</Hcode>
      <Type>Villa</Type>
      <Rating>4 Star</Rating>
      <MitSiteCode/>
      <ContactDetails/>
      <ContactDetails2/>
      <ContactDetails3/>
      <ContactDetails4/>
      <ContactDetails5/>
      <ContactDetails6/>
      <ContactPostCode/>
      <ContactTelephone/>
      <ContactFax/>
      <ContactEmail/>
      <ContactResort/>
      <ContactCountry/>
      <Room>
        <Hucode>HOT0000818000006</Hucode>
        <RoomType>Club Suite</RoomType>
        <MaxOccupancy>4</MaxOccupancy>
        <RoomFacilities/>
        <BoardBasisItems>
	<BoardBasis>
	   <Code>HB</Code>
	   <Description>Half Board</Description>
	   <MappedCodes>HB</MappedCodes >
	</BoardBasis>
        </BoardBasisItems>
      </Room>
      <AccommodationFacilities/>
    </Hotel>
    <Hotel>
      <Name>The Villas of Grand Cypress Angela</Name>
      <Hcode>HOT0000808</Hcode>
      <Type>Villa</Type>
      <Rating>4</Rating>
      <MitSiteCode>MCOVGH</MitSiteCode>
      <ContactDetails/>
      <ContactDetails2/>
      <ContactDetails3/>
      <ContactDetails4/>
      <ContactDetails5/>
      <ContactDetails6/>
      <ContactPostCode/>
      <ContactTelephone/>
      <ContactFax/>
      <ContactEmail/>
      <ContactResort/>
      <ContactCountry/>
      <Room>
        <Hucode>HOT0000808000001</Hucode>
        <RoomType>Club Suite</RoomType>
        <MaxOccupancy>4</MaxOccupancy>
        <RoomFacilities/>
      </Room>
      <Room>
        <Hucode>HOT0000808000003</Hucode>
        <RoomType>One Bedroom Villa</RoomType>
        <MaxOccupancy>4</MaxOccupancy>
        <RoomFacilities/>
      </Room>
      <AccommodationFacilities/>
    </Hotel>
  </Accommodation>
  <AccommodationFacilities>
    <AccommodationFacility>
      <Category>adults only</Category>
      <Description>Toga Party</Description>
      <FieldName>TogaParty_17</FieldName>
      <ControlType>Checkbox</ControlType>
      <ControlName>chkAF_TogaParty_17</ControlName>
      <CheckBoxValue>134217728</CheckBoxValue>
      <BooleanField>1</BooleanField>
    </AccommodationFacility>
    <AccommodationFacility>
      <Category>Amenities</Category>
      <Description>Double Sink</Description>
      <FieldName>DoubleSink_16</FieldName>
      <ControlType>Checkbox</ControlType>
      <ControlName>chkAF_DoubleSink_16</ControlName>
      <CheckBoxValue>4194304</CheckBoxValue>
      <BooleanField>1</BooleanField>
    </AccommodationFacility>
  </AccommodationFacilities>
  <Airlines>
    <Airline>
      <AirlineName>Aer Lingus</AirlineName>
      <Refcode>EI    </Refcode>
      <OpName/>
      <Inboundrule>0</Inboundrule>
      <Comments/>
      <TicketingCode/>
      <AirlineType/>
      <Classes>
        <Class>
          <ClassCode>A</ClassCode>
          <ClassDescription>This is an airline class</ClassDescription>
        </Class>
      </Classes>
    </Airline>
  </Airlines>
  <Routes xmlns="">
    <Route>
      <Departure>ABZ</Departure>
      <Arrival>ABJ</Arrival>
    </Route>
  </Routes>
  <Vehicles>
    <Vehicle>
      <Description>Test Vehicle</Description>
      <VehicleID>1</VehicleID>
      <Type>1</Type>
      <Length>0</Length>
      <Height>0</Height>
    </Vehicle>
  </Vehicles>
  <Extras>
    <Type>ADMIN FEE</Type>
    <Type>Airport Tax</Type>
    <Type>BOARD</Type>
    <Type>Cancellation Charge</Type>
    <Type>CarHireMod</Type>
    <Type>Credit Card Charges</Type>
    <Type>Flight Cancellation Charge</Type>
    <Type>Insurance</Type>
    <Type>OCCUPANCY</Type>
    <Type>OFFER</Type>
    <Type>SUPPLEMENT</Type>
    <Type>TAX</Type>
  </Extras>
  <Categories>
    <Category>
      <ID>33</ID>
      <Code>Brochure</Code>
      <Value>Test Brochure</Value>
      <Status>Available</Status>
    </Category>
  </Categories>
  <Tours xmlns="">
    <Tour pk_ToursMaster_Id="3" TMcode="14" TourCode="FPTCAP" TourName="FP TCAP Tour" SeasonName="" SeasonId="0"/>
    <Tour pk_ToursMaster_Id="2" TMcode="13" TourCode="FPTT" TourName="FP Test Tour" SeasonName="" SeasonId="0"/>
    <Tour pk_ToursMaster_Id="1" TMcode="12" TourCode="MERC1" TourName="Mercedes Group" SeasonName="" SeasonId="0"/>
    <Tour pk_ToursMaster_Id="5" TMcode="16" TourCode="tour 1" TourName="Nairobi Tour" SeasonName="" SeasonId="0"/>
    <Tour pk_ToursMaster_Id="6" TMcode="17" TourCode="RAW2" TourName="RAW" SeasonName="" SeasonId="0"/>
    <Tour pk_ToursMaster_Id="4" TMcode="15" TourCode="TS1" TourName="Test Shikha Tour" SeasonName="" SeasonId="0"/>
</Tours>
<BoardBasisDescriptions>
  		<BoardBasisDescription TravelinkCode="HB" Description="Half Board"/>
     <BoardBasisDescription TravelinkCode="FB" Description="Full Board"/>
     <BoardBasisDescription TravelinkCode="AI" Description="All Inclusive"/>
     <BoardBasisDescription TravelinkCode="BB" Description="Bed and Breakfast"/>
     <BoardBasisDescription TravelinkCode="SC" Description="Self Catered"/>
     <BoardBasisDescription TravelinkCode="RO" Description="Room Only"/>
     <BoardBasisDescription TravelinkCode="FO" Description="Flights Only"/>
     <BoardBasisDescription TravelinkCode="CA" Description="Catered"/>
   </BoardBasisDescriptions>
	<PickupPoints>
      <PickupPoint>
          <PickupPoint>Ashton Under Lyne</PickupPoint>
          <PickupPointId>105</PickupPointId>
          <AreaId>88</AreaId>
          <PickupArea>Super Test Area</PickupArea>
      </PickupPoint>
      <PickupPoint>
          <PickupPoint>Beverley</PickupPoint>
          <PickupPointId>61</PickupPointId>
          <AreaId>58</AreaId>
          <PickupArea>Yorkshire</PickupArea>
      </PickupPoint>
      <PickupPoint>
          <PickupPoint>Blue 1</PickupPoint>
          <PickupPointId>7</PickupPointId>
          <AreaId>53</AreaId>
          <PickupArea>Blue Route</PickupArea>
      </PickupPoint>
      <PickupPoint>
          <PickupPoint>Blue 2</PickupPoint>
          <PickupPointId>8</PickupPointId>
          <AreaId>53</AreaId>
          <PickupArea>Blue Route</PickupArea>
      </PickupPoint>
   </PickupPoints>
</GetStaticDataResult>';
        $url = 'https://xmltravel.com/FindAndBook';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_object);
        $xmldata = curl_exec($ch);
        curl_close($ch);
        return $xml = simplexml_load_string($xmldata);
    }
}
