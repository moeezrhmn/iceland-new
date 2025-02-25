<?php

use App\Facades\CustomHelper;
use Illuminate\Support\Facades\Config;

if ( !function_exists( 'sitename' ) ) {
    function sitename()
    {
        return Config::get( 'app.name' );
    }
}

if ( !function_exists( 'siteurl' ) ) {
    function siteurl()
    {
        return CustomHelper::mainurl();
    }
}

if ( !function_exists( 'adminurl' ) ) {
    function adminurl()
    {
        return CustomHelper::admin_url();
    }
}

if ( !function_exists( 'helper' ) ) {
    /**
     * @return \App\Custom\Helpers\CustomHelper|mixed
     */
    function helper()
    {
        return app( \App\Custom\Helpers\CustomHelper::class );
    }
}

if ( !function_exists( 'form' ) ) {
    /**
     * @return \App\Custom\Helpers\CustomForm|mixed
     */
    function form()
    {
        return app( \App\Custom\Helpers\CustomForm::class );
    }
}

if ( !function_exists( 'convert_elequent_to_sql_query' ) ) {
    function convert_eloquent_to_sql_query( $eloquent )
    {

        $query  = $eloquent->toSql();
        $biding = $eloquent->getBindings();
        if ( count( $biding ) > 0 ) {
            foreach ( $biding as $oneBind ) {
                $from  = '/' . preg_quote( '?', '/' ) . '/';
                $to    = "'" . $oneBind . "'";
                $query = preg_replace( $from, $to, $query, 1 );
            }
        }

        return $query;
    }
}

if ( !function_exists( 'custom_flash' ) ) {
    function custom_flash( $message, $level, $keep = 0 )
    {
        $flashMessages   = request()->session()->has( 'custom_flash_notification' ) ? request()->session()->get( 'custom_flash_notification' ) : [];
        $flashMessages[] = [
            'message' => $message,
            'level'   => $level,
            'keep'    => $keep,
        ];
        request()->session()->put( 'custom_flash_notification', $flashMessages );
    }
}

if ( !function_exists( 'get_custom_flash' ) ) {
    function get_custom_flash( $key )
    {
        if ( !session()->has( $key ) && empty( session()->get( $key ) ) ) {
            return false;
        }
        $flashMessages = session( $key );
        foreach ( $flashMessages as $skey => $flash ) {
            if ( $flash[ 'keep' ] < 2 ) {
                session()->forget( $key . '.' . $skey );
            }
            else {
                $flash[ 'keep' ]--;
                request()->session()->flash( $key . '.' . $skey, $flash );
            }
        }

        return $flashMessages;
    }
}

if ( !function_exists( 'is_registration_enabled' ) ) {
    function is_registration_enabled()
    {
        return env( 'DISABLE_REGISTRATION', true ) === true;
    }
}

if ( !function_exists( 'get_app_city_id' ) ) {
    function get_app_city_id()
    {
        // TODO - Will manage this later
        $currentUser = auth()->user();
        $appCityId   = $currentUser->id !== 1 ? $currentUser->role->app_city_id : 1;
        $appCity     = \App\AppCity::find( $appCityId );

        return $appCity->id;
    }
}

if ( !function_exists( 'getPageUrl' ) ) {
    function getPageUrl( $page, $args = [] )
    {

        return helper()->getPageUrl( $page, $args );
    }
}

if ( !function_exists( 'te_titles' ) ) {
    function te_titles()
    {
        $titles                           = [];
        $titles[ 'mr.' ]                  = 'Mr.';
        $titles[ 'ms.' ]                  = 'Ms.';
        $titles[ 'mrs.' ]                 = 'Mrs.';
        $titles[ 'deewan' ]               = 'Deewan';
        $titles[ 'maj._retd.' ]           = 'Maj. Retd.';
        $titles[ 'ayub' ]                 = 'Ayub';
        $titles[ 'mian' ]                 = 'Mian';
        $titles[ 'rai' ]                  = 'Rai';
        $titles[ 'lt.col._(retd.)' ]      = 'Lt.col. (retd.)';
        $titles[ 'peer' ]                 = 'Peer';
        $titles[ 'retd.' ]                = 'Retd.';
        $titles[ 'lt.(gen.)' ]            = 'Lt.(gen.)';
        $titles[ 'khawaja' ]              = 'Khawaja';
        $titles[ 'hafiz' ]                = 'Hafiz';
        $titles[ 'hakeem' ]               = 'Hakeem';
        $titles[ 'birg.' ]                = 'Birg.';
        $titles[ 'brg.' ]                 = 'Brg.';
        $titles[ 'syed.' ]                = 'Syed.';
        $titles[ 'mailk' ]                = 'Mailk';
        $titles[ 'saith_' ]               = 'Saith';
        $titles[ 'prof.' ]                = 'Prof.';
        $titles[ 'col' ]                  = 'Col';
        $titles[ 'chaudry' ]              = 'Chaudry';
        $titles[ 'khalifa' ]              = 'Khalifa';
        $titles[ 'butt' ]                 = 'Butt';
        $titles[ 'miss' ]                 = 'Miss';
        $titles[ 'madam' ]                = 'Madam';
        $titles[ 'lt.col_retd.' ]         = 'Lt.col Retd.';
        $titles[ 'lt._col.' ]             = 'Lt. Col.';
        $titles[ 'syed' ]                 = 'Syed';
        $titles[ 'hadi' ]                 = 'Hadi';
        $titles[ 'kazi' ]                 = 'Kazi';
        $titles[ 'captain' ]              = 'Captain';
        $titles[ 'dr._agha' ]             = 'Dr. Agha';
        $titles[ 'sheikh' ]               = 'Sheikh';
        $titles[ 'baigum' ]               = 'Baigum';
        $titles[ 'capt._(retd.)' ]        = 'Capt. (retd.)';
        $titles[ 'chaudhry' ]             = 'Chaudhry';
        $titles[ 'pirzada' ]              = 'Pirzada';
        $titles[ 'syeda' ]                = 'Syeda';
        $titles[ 'maj' ]                  = 'Maj';
        $titles[ 'capt.(retd.)' ]         = 'Capt.(retd.)';
        $titles[ 'kh.' ]                  = 'Kh.';
        $titles[ 'ch.' ]                  = 'Ch.';
        $titles[ 'muhammad_' ]            = 'Muhammad';
        $titles[ 'col.' ]                 = 'Col.';
        $titles[ 'lt._col._(rtd.)' ]      = 'Lt. Col. (rtd.)';
        $titles[ 'maj._(retd.)' ]         = 'Maj. (retd.)';
        $titles[ 'raja' ]                 = 'Raja';
        $titles[ 'mam' ]                  = 'Mam';
        $titles[ 'malik' ]                = 'Malik';
        $titles[ 'rao' ]                  = 'Rao';
        $titles[ 'maj._gen._(retd.)' ]    = 'Maj. Gen. (retd.)';
        $titles[ 'justice_(retd.)' ]      = 'Justice (retd.)';
        $titles[ 'agha_' ]                = 'Agha';
        $titles[ 'sh.' ]                  = 'Sh.';
        $titles[ 'ghazi_' ]               = 'Ghazi';
        $titles[ 'khwaja' ]               = 'Khwaja';
        $titles[ 'mirza' ]                = 'Mirza';
        $titles[ 'sardar' ]               = 'Sardar';
        $titles[ 'engr.' ]                = 'Engr.';
        $titles[ 'main' ]                 = 'Main';
        $titles[ 'lt._col._(retd.)' ]     = 'Lt. Col. (Retd.)';
        $titles[ 'chaudhary_' ]           = 'Chaudhary';
        $titles[ 'prof._dr.' ]            = 'Prof. Dr.';
        $titles[ 'capt.' ]                = 'Capt.';
        $titles[ 'maj.' ]                 = 'Maj.';
        $titles[ 'eng' ]                  = 'Eng';
        $titles[ 'begum' ]                = 'Begum';
        $titles[ 'lt.' ]                  = 'Lt.';
        $titles[ 'chaudhry.' ]            = 'Chaudhry.';
        $titles[ 'justice_syed' ]         = 'Justice Syed';
        $titles[ 'khan' ]                 = 'Khan';
        $titles[ 'maher' ]                = 'Maher';
        $titles[ 'shiekh_' ]              = 'Shiekh';
        $titles[ 'qazi_' ]                = 'Qazi';
        $titles[ 'chaudary' ]             = 'Chaudary';
        $titles[ 'maj.(retd.)' ]          = 'Maj.(retd.)';
        $titles[ 'co.l.' ]                = 'Co.l.';
        $titles[ 'sayed' ]                = 'Sayed';
        $titles[ 'hakim' ]                = 'Hakim';
        $titles[ 'shah' ]                 = 'Shah';
        $titles[ 'justice' ]              = 'Justice';
        $titles[ 'rana' ]                 = 'Rana';
        $titles[ 'lft._col._dr.' ]        = 'Lft. Col. Dr.';
        $titles[ 'mir.' ]                 = 'Mir.';
        $titles[ 'sayeda' ]               = 'Sayeda';
        $titles[ 'nawab' ]                = 'Nawab';
        $titles[ 'nawabzada' ]            = 'Nawabzada';
        $titles[ 'khawja' ]               = 'Khawja';
        $titles[ 'gen.' ]                 = 'Gen.';
        $titles[ 'pir' ]                  = 'Pir';
        $titles[ 'brig' ]                 = 'Brig';
        $titles[ 'col.(retd.)' ]          = 'Col.(retd.)';
        $titles[ 'maj.(gen.)' ]           = 'Maj.(gen.)';
        $titles[ 'dr._mirza' ]            = 'Dr. Mirza';
        $titles[ 'mir' ]                  = 'Mir';
        $titles[ 'eng._mian' ]            = 'Eng. Mian';
        $titles[ 'dr._sahibzada' ]        = 'Dr. Sahibzada';
        $titles[ 'qari_' ]                = 'Qari';
        $titles[ 'justice_(retd.)_mian' ] = 'Justice (Retd.) Mian';
        $titles[ 'haji' ]                 = 'Haji';
        $titles[ 'col._(retd.)' ]         = 'Col. (retd.)';
        $titles[ 'brig.(retd.)' ]         = 'Brig.(retd.)';
        $titles[ 'sufi' ]                 = 'Sufi';
        $titles[ 'lt._col._(r)' ]         = 'Lt. Col. (r)';
        $titles[ 'eng.' ]                 = 'Eng.';
        $titles[ 'brig._(r)' ]            = 'Brig. (r)';
        $titles[ 'brig._retd.' ]          = 'Brig. Retd.';
        $titles[ 'm.' ]                   = 'M.';
        $titles[ 'lt.(col.)' ]            = 'Lt.(col.)';
        $titles[ 'lt._col._(retd)_dr.' ]  = 'Lt. Col. (retd) Dr.';
        $titles[ 'mrs.' ]                 = 'Mrs.';
        $titles[ 'dr.' ]                  = 'Dr.';
        $titles[ 'mughal' ]               = 'Mughal';
        $titles[ 'lt.col.(retd.)' ]       = 'Lt.col.(retd.)';
        $titles[ 'col._syed' ]            = 'Col. Syed';
        $titles[ 'mahar_' ]               = 'Mahar';
        $titles[ 'dr' ]                   = 'Dr';
        $titles[ 'mian.' ]                = 'Mian.';
        $titles[ 'major' ]                = 'Major';
        $titles[ 'al-haj' ]               = 'Al-Haj';
        $titles[ 'maj_(retd.)' ]          = 'Maj (retd.)';
        $titles[ 'major_(retd.)' ]        = 'Major (Retd.)';
        $titles[ 'maj._gen.' ]            = 'Maj. Gen.';
        $titles[ 'cap.' ]                 = 'Cap.';
        $titles[ 'lft._col._(retd.)' ]    = 'Lft. Col. (retd.)';
        $titles[ 'major.' ]               = 'Major.';
        $titles[ 'al_haaj' ]              = 'Al Haaj';
        $titles[ 'sqn._ldr.' ]            = 'Sqn. Ldr.';
        $titles[ 'brig._(retd.)' ]        = 'Brig. (Retd.)';
        $titles[ 'barrister' ]            = 'Barrister';
        $titles[ 'khuwaja' ]              = 'Khuwaja';
        $titles[ 'brig.' ]                = 'Brig.';
        $titles[ 'choudhry' ]             = 'Choudhry';

        return $titles;

    }
}

if ( !function_exists( 'getCityCodesArray' ) ) {
    function getCityCodesArray( $args = [] )
    {
        $locations      = \App\AppCity::select( 'id', 'city_code' )->get();
        $locationsArray = [];
        foreach ( $locations as $index => $name ) {
            $locationsArray += [
                $name[ 'id' ] => $name[ 'city_code' ],
            ];
        }

        return $locationsArray;
    }
}
if ( !function_exists( 'getHosApprovedDispatchDatesArray' ) ) {
    function getHosApprovedDispatchDatesArray( $args = [] )
    {
        $dispatchDatesArray  = [];
        $closedDispatchLists = \App\SalesStaff\DispatchList::select( "dispatchdate_id", DB::raw( 'count(*) as total_users' ) )->groupBy( 'dispatchdate_id' )->where( 'status', 6 )->with( 'suggestedDonors', 'dispatchDate' )->get();

        foreach ( $closedDispatchLists as &$dispatchList ) {
            $dispatchList->dispatch_date = $dispatchList->dispatchDate->dispatch_date;
        }
        foreach ( $closedDispatchLists as $index => $name ) {
            $dispatchDatesArray += [
                $name[ 'dispatchdate_id' ] => $name->dispatch_date,
            ];
        }

        return array_unique( $dispatchDatesArray );

    }
}
if ( !function_exists( 'getClientsByHosApprovedDates' ) ) {
    function getClientsByHosApprovedDates( $args = [] )
    {
        $clientsArray        = [];
        $closedDispatchLists = \App\SalesStaff\DispatchList::where( 'status', 6 )->with( 'suggestedDonors' )->get();
        foreach ( $closedDispatchLists as &$dispatchList ) {
            $dispatchList->dispatch_date = $dispatchList->dispatchDate->dispatch_date;
        }
        foreach ( $closedDispatchLists as $index => $name ) {
            $suggestedDonors = $name->suggestedDonors()->groupBy( 'campaign_id' )->get();
            foreach ( $suggestedDonors as $suggestedDonor ) {
                $campaign     = $suggestedDonor->campaign;
                $client       = $campaign->client;
                $clientsArray += [
                    $client[ 'id' ] => $client->name,
                ];
            }

        }

        return $clientsArray;
    }
}

if ( !function_exists( 'getAreasArray' ) ) {
    function getAreasArray( $args = [] )
    {
        $areas      = \App\Configuration\Area::select( 'id', 'name' )->get();
        $areasArray = [];
        foreach ( $areas as $index => $name ) {
            $areasArray += [
                $name[ 'id' ] => $name[ 'name' ],
            ];
        }

        return $areasArray;
    }
}

if ( !function_exists( 'getDesignationsArray' ) ) {
    function getDesignationsArray( $args = [] )
    {
        $areas      = \App\Configuration\Designation::select( 'id', 'name' )->get();
        $areasArray = [
            '' => 'Please select designation',
        ];
        foreach ( $areas as $index => $name ) {
            $areasArray += [
                $name[ 'id' ] => $name[ 'name' ],
            ];
        }
        return $areasArray;
    }
}

if ( !function_exists( 'getLocationsArray' ) ) {
    function getLocationsArray( $args = [] )
    {
        $areas      = \App\Configuration\Location::select( 'id', 'name' )->get();
        $areasArray = [];
        foreach ( $areas as $index => $name ) {
            $areasArray += [
                $name[ 'id' ] => $name[ 'name' ],
            ];
        }

        return $areasArray;
    }
}
if ( !function_exists( 'getClientsArray' ) ) {
    function getClientsArray( $args = [] )
    {
        $areas      = \App\Configuration\Client::select( 'id', 'name' )->get();
        $areasArray = [];
        foreach ( $areas as $index => $name ) {
            $areasArray += [
                $name[ 'id' ] => $name[ 'name' ],
            ];
        }

        return $areasArray;
    }
}
if ( !function_exists( 'getOrganizationTypessArray' ) ) {
    function getOrganizationTypessArray( $args = [] )
    {
        $areas      = \App\Configuration\OrganizationType::select( 'id', 'name' )->get();
        $areasArray = [];
        foreach ( $areas as $index => $name ) {
            $areasArray += [
                $name[ 'id' ] => $name[ 'name' ],
            ];
        }

        return $areasArray;
    }
}
if ( !function_exists( 'getletterTypesArray' ) ) {
    function getletterTypesArray( $args = [] )
    {
        $areas      = \App\Configuration\LetterType::select( 'id', 'name' )->get();
        $areasArray = [];
        foreach ( $areas as $index => $name ) {
            $areasArray += [
                $name[ 'id' ] => $name[ 'name' ],
            ];
        }

        return $areasArray;
    }
}

if ( !function_exists( 'getUserCitiesArray' ) ) {
    function getUserCitiesArray( $args = [] )
    {
        $cities     = \App\Configuration\City::select( 'id', 'name' )->get();
        $areasArray = [];

        foreach ( $cities as $index => $name ) {
            $areasArray += [
                $name[ 'id' ] => $name[ 'name' ],
            ];
        }

        return $areasArray;
    }
}

if ( !function_exists( 'getParsedEachSearchInputName' ) ) {
    function getParsedEachSearchInputName( $attr, $name )
    {
        $slug = '';
        if ( $attr == $name . '_id' ) {
            $slug = $name;
        }
        else {
            $slug = $attr;
        }

        return $slug;
    }
}
if ( !function_exists( 'getdropdownKeyValueSame' ) ) {
    function getdropdownKeyValueSame( $arr )
    {

        $res = [];

        foreach ( $arr as $key => $val ) {
            $res += [ $key => $val ];
        }
        return $res;
    }
}


if ( !function_exists( 'getTitlesArray' ) ) {
    function getTitlesArray( $args = [] )
    {
        $titles      = \App\Configuration\Title::select( 'id', 'name' )->get();
        $titlesArray = [];

        foreach ( $titles as $index => $name ) {
            $titlesArray += [
                $name[ 'id' ] => $name[ 'name' ],
            ];
        }

        return $titlesArray;
    }
}

if ( !function_exists( 'getOrganizationsArray' ) ) {
    function getOrganizationsArray( $args = [] )
    {
        $organizations      = \App\Configuration\Organization::select( 'id', 'name' )->get();
        $organizationsArray = [ 'Please Select Organization...' ];

        foreach ( $organizations as $index => $name ) {
            $organizationsArray += [
                $name[ 'id' ] => $name[ 'name' ],
            ];
        }

        return $organizationsArray;
    }
}
if ( !function_exists( 'getCampaignsArray' ) ) {
    function getCampaignsArray( $args = [] )
    {
        $campaigns      = \App\Configuration\Campaign::select( 'id', 'name' )->get();
        $campaignsArray = [];
        foreach ( $campaigns as $index => $name ) {
            $campaignsArray += [
                $name[ 'id' ] => $name[ 'name' ],
            ];
        }
        return $campaignsArray;
    }
}

if ( !function_exists( 'getAppCities' ) ) {
    function getAppCities( $args = [] )
    {
        $appCitiess      = \App\AppCity::select( 'id', 'city' )->get();
        $appCitiessArray = [];
        foreach ( $appCitiess as $index => $name ) {
            $appCitiessArray += [
                $name[ 'id' ] => $name[ 'city' ],
            ];
        }
        return $appCitiessArray;
    }
}
if ( !function_exists( 'checkAppCity' ) ) {
    function checkAppCity( $entityId, $model )
    {
        $entityAppCityId = $model::whereId( $entityId )->first()->app_city_id;
        $currentUser     = auth()->user();

        if ( $currentUser->id === 1 || $currentUser->role->app_city_id == $entityAppCityId ) {
            return true;
        }

        return false;
    }

}
